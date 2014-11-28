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
//        $questions_with_variants = $this->addVariantsToQuestions($questions);
        return var_dump($questions);
    }

    public function generateQuestionsEntities() {

    }

    public function addVariantsToQuestions($questions) {

        foreach ($questions as $question) {
            $id = $question[0]["id"];

            $variants = getRandomVariants($id);

            $question["variants"] = $variants;

            function getRandomVariants($id) {
                $helperArray = array_pad(array(), $this->itemsCount, 0);
                $indexesArray = array_rand($helperArray, 3);
                //if same id recursive call again
                if (in_array($id, $indexesArray)) {
                    getRandomVariants($id);
                } else {
                    return $indexesArray;
                }
            }

        }

        return $questions;

    }

    public function getQuestions() {
        $indexes = $this->getQuestionsRandomIndexes();
        $questions = array();
        foreach ($indexes as $index) {
            $id = $index+1;
            $item = $this->table->getItem($id);
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