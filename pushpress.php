<?php
/*
 * Plugin Name: PuSHPress
 * Plugin URI: https://automattic.com
 * Description: WebSub/PubSubHubbub plugin for WordPress that includes the hub
 * Version: 0.1.10
 * Author: Joseph Scott & Automattic
 * Author URI: https://automattic.com
 * License: GPLv2 or later.
 * Network: true
 */
require_once dirname( __FILE__ ) . '/class-pushpress.php';
require_once dirname( __FILE__ ) . '/send-ping.php';

define( 'PUSHPRESS_VERSION', '0.1.10' );

if ( !defined( 'PUSHPRESS_CLASS' ) )
	define( 'PUSHPRESS_CLASS', 'PuSHPress' );

$pushpress_class = PUSHPRESS_CLASS;
$pushpress = new $pushpress_class( );
$pushpress->init( );
