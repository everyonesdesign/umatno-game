<?php

class Umg_file_parser {


    public static function parse($filename, $table_name) {
        global $plugin_path;

        $file_content = file($filename);
        $line_type = 0;

        //default values
        $name="";
        $value="";

        foreach($file_content as $line) {
            if ($line_type == 0) {
                $name = str_replace("@@-@@", "", $line);
                $line_type++;
            } elseif ($line_type == 1) {
                $value = str_replace("@@-@@", "", $line);
                $line_type++;
            } elseif ($line_type == 2) {
                Umg_db_manager::setItem($table_name, $name, $value);
                $line_type=0;
            }
        }

    }

}
