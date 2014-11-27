<?php
/**
 * Plugin Name: Umatno game
 * Description: A game for umatno.ru website
 * Version: 1.0.0
 * Author: everyonesdesign
 * License: A short license name. Example: GPL2
 */

defined('ABSPATH') or die("Only WP plugin");

global $wpdb;
global $plugin_path;
$plugin_path = plugin_dir_path( __FILE__ );

require_once($plugin_path."Umg_db_manager.php");
require_once($plugin_path."Umg_file_parser.php");

//guess film by actors list
global $films_table_name;
global $films_file;
$films_table_name = $wpdb->prefix.'umg_films';
$films_file = $plugin_path.'data/films-data.txt';

//creating a db table if there's no
function umg_install() {
    global $films_table_name;
    Umg_db_manager::createTable($films_table_name);
}
register_activation_hook( __FILE__, 'umg_install' );

//parse file and push it's data to the database
function umg_parse_data() {
    global $films_table_name;
    global $films_file;
    Umg_db_manager::resetTable($films_table_name);
    Umg_file_parser::parse($films_file, $films_table_name);
}
register_activation_hook( __FILE__, 'umg_parse_data' );






