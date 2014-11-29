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

game.controller("gameController", ["$scope", "data", "correctFilter", function($scope, data, correctFilter) {

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
            result.push(input[i]);
        }
        return result;
    }
});



