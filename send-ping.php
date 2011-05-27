<?php
add_action( 'pushpress_scheduled_ping', 'pushpress_send_ping', 10, 4 );
if ( !function_exists( 'pushpress_send_ping' ) ) {
	function pushpress_send_ping( $callback, $post_id, $feed_type, $secret ) {
		global $pushpress, $current_user;

		// Do all WP_Query calcs and send feeds as logged-out user.
		$old_user_id = $current_user->ID;
		wp_set_current_user( 0 );

		// Need to make sure that the PuSHPress options are initialized
		$pushpress->init( );

		do_action( 'pushpress_send_ping' );

		$remote_opt = array(
			'headers'		=> array(
				'format'	=> $feed_type
			),
			'sslverify'		=> FALSE,
			'timeout'		=> $pushpress->http_timeout,
			'user-agent'	=> $pushpress->http_user_agent
		);

		$post = get_post( $post_id );
		$post_status_obj = get_post_status_object( $post->post_status );
		if ( !$post_status_obj->public ) {
			do_action( 'pushpress_nonpublic_post', $post_id );
			wp_set_current_user( $old_user_id );
			return false;
		}
		do_enclose( $post->post_content, $post_id );
		update_postmeta_cache( array( $post_id ) );

		// make sure the channel title stays consistent
		// without this it would append the post title as well
		add_filter( 'wp_title', '__return_false', 999 );

		query_posts( "p={$post_id}" );
		ob_start( );

		$feed_url = FALSE;
		if ( $feed_type == 'rss2' ) {
			do_action( 'pushpress_send_ping_rss2' );
			$feed_url = get_bloginfo( 'rss2_url' );

			$remote_opt['headers']['Content-Type'] = 'application/rss+xml';
			$remote_opt['headers']['Content-Type'] .= '; charset=' . get_option( 'blog_charset' );

			@load_template( ABSPATH . WPINC . '/feed-rss2.php' );
		} elseif ( $feed_type == 'atom' ) {
			do_action( 'pushpress_send_ping_atom' );
			$feed_url = get_bloginfo( 'atom_url' );

			$remote_opt['headers']['Content-Type'] = 'application/atom+xml';
			$remote_opt['headers']['Content-Type'] .= '; charset=' . get_option( 'blog_charset' );

			@load_template( ABSPATH . WPINC . '/feed-atom.php' );
		}

		$remote_opt['body'] = ob_get_contents( );
		ob_end_clean( );

		// Figure out the signatur header if we have a secret on
		// on file for this callback
		if ( !empty( $secret ) ) {
			$remote_opt['headers']['X-Hub-Signature'] = 'sha1=' . hash_hmac(
				'sha1', $remote_opt['body'], $secret
			);
		}

		$response = wp_remote_post( $callback, $remote_opt );

		// look for failures
		if ( is_wp_error( $response ) ) {
			do_action( 'pushpress_ping_wp_error' );
			wp_set_current_user( $old_user_id );
			return FALSE;
		}

		if ( isset( $response->errors['http_request_failed'][0] ) ) {
			do_action( 'pushpress_ping_http_failure' );
			wp_set_current_user( $old_user_id );
			return FALSE;
		}

		$status_code = (int) $response['response']['code'];
		if ( $status_code < 200 || $status_code > 299 ) {
			do_action( 'pushpress_ping_not_2xx_failure' );
			$pushpress->unsubscribe_callback( $feed_url, $callback );
			wp_set_current_user( $old_user_id );
			return FALSE;
		}

		wp_set_current_user( $old_user_id );
	} // function send_ping
} // if !function_exists 
