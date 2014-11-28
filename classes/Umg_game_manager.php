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
        $questions = $this->getQuestions();
        $questions_with_variants = $this->addVariantsToQuestions($questions);
        return var_dump($questions_with_variants);
    }

    public function generateQuestionsEntities() {

    }

    public function addVariantsToQuestions($questions) {

        foreach ($questions as $key => $question) {
            $id = $question[0]->id;
            $variants = $this->fetchVariantsData($id);
            $questions[$key][0]->variants = $variants;
        }
        return $questions[0];
    }

    public function fetchVariantsData($id) {
        $variant_ids = $this->getRandomVariantsIds($id);
        $results = array();
        foreach ($variant_ids as $variant_id) {
            $item = $this->table->getItem($variant_id+1);
            array_push($results, $item);
        }
        return $results;
    }

    public function getRandomVariantsIds($id) {
        $helperArray = array_pad(array(), $this->itemsCount, 0);
        $indexesArray = array_rand($helperArray, 3);
        //if same id recursive call again
        if (in_array($id, $indexesArray)) {
            return $this->getRandomVariantsIds($id);
        } else {
            return $indexesArray;
        }
    }

    public function getQuestions() {
        $indexes = $this->getQuestionsRandomIndexes();
        $questions = array();
        foreach ($indexes as $index) {
            $item = $this->table->getItem($index+1);
            array_push($questions, $item);
        }
        return $questions;
    }

    public function getQuestionsRandomIndexes() {
        $helperArray = array_pad(array(), $this->itemsCount, 0);
        $indexesArray = array_rand($helperArray, 10);
        return $indexesArray;
    }

}