<?php
/*
Plugin Name: PuSHPress
Plugin URI:
Description: WebSub/PubSubHubbub plugin for WordPress that includes the hub
Version: 0.1.9
Author: Joseph Scott & Automattic
Author URI:
License: GPLv2
Network: true
 */
require_once dirname( __FILE__ ) . '/class-pushpress.php';
require_once dirname( __FILE__ ) . '/send-ping.php';

define( 'PUSHPRESS_VERSION', '0.1.9' );

if ( !defined( 'PUSHPRESS_CLASS' ) )
	define( 'PUSHPRESS_CLASS', 'PuSHPress' );

$pushpress_class = PUSHPRESS_CLASS;
$pushpress = new $pushpress_class( );
$pushpress->init( );
