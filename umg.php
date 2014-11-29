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

//loading classes
require_once(plugin_dir_path( __FILE__ )."classes/Umg_table_manager.php");
require_once(plugin_dir_path( __FILE__ )."classes/Umg_file_parser.php");
require_once(plugin_dir_path( __FILE__ )."classes/Umg_questions_manager.php");

//creating instance of table for game 'guess film by actors list'
$films_table_name = $wpdb->prefix.'umg_films';
$films_file = plugin_dir_path( __FILE__ ).'data/films-data.txt';
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
 * SCRIPTS AND STYLES INCLUDES
 *
 */

function umg_enqueue_files() {
    wp_enqueue_script( 'yandex_share','http://yastatic.net/share/share.js');
    wp_enqueue_style( 'umg_main_style', plugins_url( 'front-end/css/main.css', __FILE__ ));
}
add_action('wp_enqueue_scripts', 'umg_enqueue_files');

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







