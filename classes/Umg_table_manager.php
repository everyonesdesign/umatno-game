<?php

class Umg_table_manager {

    private $table_name, $parser;

    function Umg_table_manager($table_name, $filename) {
        $this->table_name = $table_name;
        $this->parser = new Umg_file_parser($filename);
    }

    public function createTable() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE ".$this->table_name." (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          name text NOT NULL,
          value text NOT NULL,
          UNIQUE KEY id (id)
        )"." $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }

    public function resetTable() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "TRUNCATE TABLE ".$this->table_name;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $wpdb->query($sql);
    }

    public function setItem($name, $value) {
        global $wpdb;
        $wpdb->insert(
            $this->table_name,
            array(
                'name' => $name,
                'value' => $value
            )
        );
    }

    public function getItem($id) {
        global $wpdb;
        $results = $wpdb->get_results(
            "SELECT * FROM ".$this->table_name." WHERE id = $id;",
            OBJECT
        );
        return $results[0];
    }

    public function getNumberOfRows() {
        global $wpdb;
        $result = $wpdb->get_results("SELECT COUNT(*) FROM ".$this->table_name.";", ARRAY_N);
        return $result[0][0];
    }

    public function parseFile() {
        $this->parser->parse($this);
    }

}