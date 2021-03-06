<?php

class Umg_file_parser {

    private $filename;

    function Umg_file_parser($filename) {
        $this->filename = $filename;
    }

    public function parse($table) {
        $file_content = file($this->filename);
        $line_type = 0;

        //default values
        $name="";
        $value="";

        foreach($file_content as $line) {
            if ($line_type == 0) {
                $name = str_replace("@@-@@", "", $line);
                $name = str_replace(";?\n", "", $name);
                $line_type++;
            } elseif ($line_type == 1) {
                $value = str_replace("@@-@@", "", $line);
                $value = str_replace(";?\n", "", $value);
                $line_type++;
            } elseif ($line_type == 2) {
                $table->setItem($name, $value);
                $line_type=0;
            }
        }

    }

}
