$(function() {
//   $(".umg_body-answerItem input").styler();
});

var game = angular.module("game", []);

game.value("data", umg_data);

game.controller("gameController", ["data", function(data) {
    this.questionNumber = 0;
    this.questions = data.questions;
}]);