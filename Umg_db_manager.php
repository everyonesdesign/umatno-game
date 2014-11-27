<?php

class Umg_db_manager {

    public static function createTable($table_name) {

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          name text NOT NULL,
          value text NOT NULL,
          UNIQUE KEY id (id)
        )"." $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }

    public static function resetTable($table_name) {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "TRUNCATE TABLE $table_name";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $wpdb->query($sql);
    }

    public static function setItem($table_name, $name, $value) {
        global $wpdb;
        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'value' => $value
            )
        );
    }

    public static function getItem($table_name, $id) {
        global $wpdb;
        $results = $wpdb->get_results(
            "SELECT * FROM $table_name WHERE id = $id",
            OBJECT
        );
        return $results;
    }

}