<?php
/**
* Plugin Name:       Remove WordPress version
* Plugin URI:        https://github.com/kaminoweb
* Description:       Removes WordPress version in HTML pages
* Version:           0.1
* Requires at least: 5.5
* Author:            Kaminoweb Inc
* Author URI:        https://kaminoweb.com/
* License:           GPLv2
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function kaminoweb_remove_version() {
         return '';
}

add_filter('the_generator', 'kaminoweb_remove_version', 10, 3);

