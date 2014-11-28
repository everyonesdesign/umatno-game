<?php
/**
 * Plugin Name: Umatno game
 * Description: A game for umatno.ru website
 * Version: 1.0.0
 * Author: everyonesdesign
 * License: A short license name. Example: GPL2
 */

defined('ABSPATH') or die("Only WP plugin");

//adding globals
global $wpdb;
global $plugin_path;
$plugin_path = plugin_dir_path( __FILE__ );

//loading classes
require_once($plugin_path."classes/Umg_table_manager.php");
require_once($plugin_path."classes/Umg_file_parser.php");
require_once($plugin_path."classes/Umg_questions_manager.php");

//creating instance of table for game 'guess film by actors list'
$films_table_name = $wpdb->prefix.'umg_films';
$films_file = $plugin_path.'data/films-data.txt';
global $films_table;
$films_table = new Umg_table_manager($films_table_name, $films_file);


/*
 *
 * ACTIVATION HOOKS
 *
 */

//creating a db table if there's no
function umg_install() {
    global $films_table;
    $films_table->createTable();
}
register_activation_hook( __FILE__, 'umg_install' );

//parse file and push it's data to the database
function umg_parse_data() {
    global $films_table;
    $films_table->resetTable();
    $films_table->parseFile();
}
register_activation_hook( __FILE__, 'umg_parse_data' );

/*
 *
 * SHORTCODES
 *
 */

function umg_activate_game($attrs) {
    if ($attrs['name'] == "films") {
        global $films_table;
        $game = new Umg_questions_manager($films_table);
    } elseif ($attrs['name'] == "actors") {
        //TODO: write this
    }
    $markup = $game->getMarkup();
    return $markup;
}
add_shortcode('game', 'umg_activate_game');






