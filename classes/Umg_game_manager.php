<?php

class Umg_game_manager {

    private $table;
    private $itemsCount;

    function Umg_game_manager($table) {
        $this->table = $table;
        $this->itemsCount = $table->getNumberOfRows();
    }

    public function getMarkup() {

        //FIXME: for test
        return $this->itemsCount;
    }

    public function addVariantsToQuestion() {

    }

    public function getQuestionItems() {
        $indexes = $this->getRandomIndexes();
        $items = array();

        foreach ($indexes as $index) {
            $id = $index+1;
            $item = $this->table->getItem($id);
            array_push($items, $item);
        }

        return $items;
    }

    public function getRandomIndexes() {
        $helperArray = array_pad(array(), $this->itemsCount, 0);
        $indexesArray = array_rand($helperArray, 10);
        return $indexesArray;
    }


}