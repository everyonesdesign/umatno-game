var YaShareInstance;

if (location.protocol!="file:") {
    YaShareInstance = new Ya.share({
        element: 'umg_soc-inner',
        elementStyle: {
            type: "icon",
            quickServices: ["vkontakte","facebook","twitter","odnoklassniki","moimir","evernote"]
        }
    });
}

var game = angular.module("game", ["ngAnimate"]);

game.value("data", umg_data);
game.value("resultsPhrases", [
    "Попробуйте сыграть еще раз, в следующий раз получится лучше", //0
    "Не повезло - попробуйте еще раз", //1
    "Попробуйте сыграть еще раз", //2
    "Посмотрите еще несколько фильмов - и все получится", //3
    "Все впереди - попробуйте еще раз", //4
    "Неплохой результат, но вы способны на большее", //5
    "Вы обладаете неплохими знаниями фильмов. Может, в следующий раз получится лучше?", //6
    "Достойный результат: вы хорошо знаете актеров и фильмы", //7
    "Прекрасно - вы знаете очень многое о кино", //8
    "Великолепный результат - вы знаете о кино почти все", //9
    "Поздравляем! Вы - настоящий знаток фильмов" //10
]);

game.controller("gameController", ["$scope", "data", "correctFilter", function($scope, data, correctFilter) {

game.controller("gameController", ["$scope", "data", "correctFilter", "resultsPhrases", function($scope, data, correctFilter, resultsPhrases) {

    var $this = this;
    $this.questionNumber = 0;
    $this.questions = data.questions;
    $this.results = {};
    $this.resultsPhrases = resultsPhrases;

    $this.nextStep = function() {
        if ($this.questions[$this.questionNumber].userAnswer==undefined) {
            return;
        }
        $this.questionNumber+=1;
    };

    $this.countResults = function() {
        var correctCount,
            socialTitle;

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
        correctCount = correctFilter($this.questions).length;
        socialTitle = document.title + ". Мой результат игры - " + correctCount + " из " + $this.questions.length + " вопросов";
        try {
            YaShareInstance.updateShareLink(document.URL, socialTitle);
        } catch(e) {
            console.warn("Social networks are not initialized");
        }
        $this.finished = true;
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
        return result;
    }
});

game.filter("join", function() {
    return function(input, sign) {
        return input.join(sign);
    }
});

game.filter("first", function () {
    return function(input, number) {
        var result = [];
        for (var i= 0; i<number; i++) {
            if (input[i]) result.push(input[i]);
        }
        return result;
    }
});



