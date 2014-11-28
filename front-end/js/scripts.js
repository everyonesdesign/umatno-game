$(function() {
//   $(".umg_body-answerItem input").styler();
});

var game = angular.module("game", []);

game.value("data", umg_data);

game.controller("gameController", ["$scope", "data", function($scope, data) {

    var $this = this;
    $this.questionNumber = 0;
    $this.questions = data.questions;
    $this.results = {};

    $this.nextStep = function() {
        if ($this.questions[$this.questionNumber].userAnswer==undefined) {
            return;
        }
        $this.questionNumber+=1;
    };

    $this.countResults = function() {
        if ($this.questions[$this.questionNumber].userAnswer==undefined) {
            return;
        }
        for (var i=0; i<$this.questions.length; i++) {
            for (var j=0; j<$this.questions[i].answers.length; j++) {
                if (""+CryptoJS.SHA1($this.questions[i].answers[j]) == $this.questions[i].hash) {
                    $this.questions[i].correct = j;
                }
            }
        }
    };

}]);

game.filter("correct", function() {
    return function(input) {
        var result = [];
        for (var i=0; i<input.length; i++) {
            if (input[i].correct === input[i].userAnswer) {
                result.push(input[i]);
            }
        }
        console.dir(result);
        return result;
    }
});

game.filter("join", function() {
    return function(input) {
        return input.join(", ");
    }
});