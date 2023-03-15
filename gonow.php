<?php
/**
 * Go Now Card WordPress Plugin
 *
 * @package GoNow
 *
 * Plugin Name: Go Now Card
 * Description: Output different href link according to different client browsers
 * Plugin URI:
 * Version:     1.0.0
 * Author:      Ricky Song
 * Author URI:  https://ricky.zone
 * Text Domain: go-now
 */

define( 'GONOW', __FILE__ );

/**
 * Include the Go_now class.
 */
require plugin_dir_path( GONOW ) . 'class-gonow.php';
