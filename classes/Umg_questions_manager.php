<?php

class Umg_questions_manager {

    private $table;
    private $itemsCount;

    function Umg_questions_manager($table) {
        $this->table = $table;
        $this->itemsCount = $table->getNumberOfRows();
    }

    public function getMarkup() {
        $questions = $this->constructQuestions();
        ob_start();
        require(plugin_dir_path( __FILE__ )."../films_template.php");
        $ret = ob_get_contents();
        ob_end_clean();
        return $ret;
    }

    public function constructQuestions() {
        $questions = $this->getQuestions();
        $questions = $this->addAnswersToQuestions($questions);
        $questions = $this->addSecrecy($questions);
        return $questions;
    }

    public function addSecrecy($questions) {
        foreach ($questions as $key => $question) {
            //add hash
            $questions[$key]->hash = sha1($questions[$key]->name);
            //add name to answers
            array_push($questions[$key]->answers, $questions[$key]->name);
            //mix answers
            shuffle($questions[$key]->answers);
            //remote id and name properties
            unset($questions[$key]->id);
            unset($questions[$key]->name);
        }
        return $questions;
    }

    public function addAnswersToQuestions($questions) {
        foreach ($questions as $key => $question) {
            $id = $question->id;
            $answers = $this->fetchAnswersData($id);
            $questions[$key]->answers = $answers;
        }
        return $questions;
    }

    public function fetchAnswersData($db_id) {
        $variant_ids = $this->getRandomAnswersIds($db_id);
        $results = array();
        foreach ($variant_ids as $variant_id) {
            $item = $this->table->getItem($variant_id);
            array_push($results, $item->name);
        }
        return $results;
    }

    public function getRandomAnswersIds($db_id) {
        $helperArray = array_pad(array(), $this->itemsCount, 0);
        $indexesArray = array_rand($helperArray, 3);
        //if same id recursive call again
        if (in_array($db_id-1, $indexesArray)) {
            return $this->getRandomAnswersIds($db_id);
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
        $questions = $this->splitListItems($questions);
        return $questions;
    }

    public function splitListItems($questions) {
        foreach($questions as $key=>$question) {
            $questions[$key]->value = explode( ";", $questions[$key]->value);
        }
        return $questions;
    }

    public function getQuestionsRandomIndexes() {
        $helperArray = array_pad(array(), $this->itemsCount, 0);
        $indexesArray = array_rand($helperArray, 10);
        return $indexesArray;
    }

}