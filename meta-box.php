<?php
/**
 * Plugin Name: Meta Box
 * Plugin URI: https://metabox.io
 * Description: Create custom meta boxes and custom fields in WordPress.
 * Version: 4.13.1
 * Author: MetaBox.io
 * Author URI: https://metabox.io
 * License: GPL2+
 * Text Domain: meta-box
 * Domain Path: /languages/
 *
 * @package Meta Box
 */

if ( defined( 'ABSPATH' ) && ! defined( 'RWMB_VER' ) ) {
	require 'vendor/autoload.php';

	$loader = new MetaBox\Loader();
	$loader->init();
}
