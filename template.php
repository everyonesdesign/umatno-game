<script src="<?php echo plugins_url( 'front-end/js/vendors.js', __FILE__ );?>"></script>
<script>
    var umg_data = {
        questions: <?php echo json_encode($questions);?>
    };
</script>
<script src="<?php echo plugins_url( 'front-end/js/scripts.js', __FILE__ );?>"></script>

<div class="umg_container container" ng-app="game" ng-controller="gameController as gc">

    <div class="umg_progress" ng-show="!gc.finished">
        <div class="umg_progress-caption">Вопрос {{gc.questionNumber+1}} из {{gc.questions.length}}</div>
        <div class="umg_progress-bar">
            <div class="umg_progress-barInner" ng-style="{width: (gc.questionNumber+1)/gc.questions.length*100+'%'}"></div>
        </div>
    </div>

    <div class="umg_body" ng-repeat="question in gc.questions" ng-show="!gc.finished && gc.questionNumber==$index">
        <ul class="umg_body-list">
            <li class="umg_body-listLi" ng-repeat="actor in (question.value|first:10)" title="{{actor}}">{{actor}}</li>
        </ul>
        <div class="umg_body-answer">
            <div class="umg_body-answerCaption">— это актерский состав фильма...</div>
            <form class="umg_body-answerList">
                <label class="umg_body-answerItem" ng-repeat="answer in question.answers" >
                    <input name="answer" type="radio" ng-value="{{$index}}" ng-model="gc.questions[gc.questionNumber].userAnswer">
                    <span class="radio-view"></span>
                    {{answer}}
                </label>
            </form>
            <div class="umg_body-controls">
                <div class="umg_button umg_button--back umg_button--secondary"
                     ng-class="{'umg_hidden': !gc.questionNumber}"
                     ng-click="gc.questionNumber=gc.questionNumber-1">← Назад</div>
                <div class="umg_button umg_button--front"
                     ng-class="{'umg_button--disabled': gc.questions[gc.questionNumber].userAnswer==undefined}"
                     ng-hide="gc.questionNumber+1==gc.questions.length"
                     ng-click="gc.nextStep()">Далее →</div>
                <div class="umg_button umg_button--front"
                     ng-class="{'umg_button--disabled': gc.questions[gc.questionNumber].userAnswer==undefined}"
                     ng-show="gc.questionNumber+1==gc.questions.length"
                     ng-click="gc.countResults()">Завершить</div>
            </div>
        </div>
    </div>

    <div class="umg_results" ng-show="gc.finished">
        <div class="umg_results-title">Вы ответили правильно на {{(gc.questions|correct).length}} из {{gc.questions.length}} вопросов</div>
        <div class="umg_results-caption"></div>
        <div class="umg_results-toggle">
            <div class="umg_button" onclick="location.reload()">Сыграть еще раз</div>
            <a ng-click="gc.showResults=true" ng-hide="gc.showResults">Показать подробные результаты</a>
            <a ng-click="gc.showResults=false" ng-show="gc.showResults">Скрыть подробные результаты</a>
        </div>
        <table class="umg_results-table" ng-show="gc.showResults">
            <tr>
                <th>Актеры</th>
                <th>Вы ответили</th>
                <th>Правильный ответ</th>
            </tr>
            <tr class="umg_results-tableAnswerRow" ng-repeat="question in gc.questions" ng-class="{correct: question.correct==question.userAnswer}">
                <td>{{question.value|first:5|join:", "}}...</td>
                <td>{{question.answers[question.userAnswer]}}</td>
                <td>{{question.answers[question.correct]}}</td>
            </tr>
        </table>
        <div class="umg_soc">
            <div class="umg_soc-title">Поделиться с друзьями:</div>
            <div class="umg_soc-inner" id="umg_soc-inner"></div>
        </div>
    </div>

</div>