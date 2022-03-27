<?php
$comp_model = new SharedController;
$db = $comp_model->GetModel();

$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
$page_id = Router::$page_id;

$data = $this->view_data;

$url = SITE_ADDR . 'index/quiz/' . $page_id;

if ($data) {
    $url .= '/' . $data['id'];
}

$url .= '?csrf_token=' . Csrf::$token;

?>
<div class="" ng-app="007App" ng-controller="quizCtrl">
    <form name="quizCreateForm" ng-submit="saveQuiz('<?= $url ?>')">
        <div id="feedback"></div>
        <div class="form-group ">
            <div class="row">
                <div class="col-sm-4">
                    <label class="control-label" for="name">Title
                        <span class="text-danger">*</span></label>
                </div>
                <div class="col-sm-8">
                    <div class="">
                        <input type="text" name="title" ng-init="title = '<?= ($data ? $data['title'] : '') ?>'" ng-model="title" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $comp_model->addInput([
            'name' => 'grade',
            'type' => InputType::select,
            'label' => 'Grade',
            'options' => Getters::$grades,
            'required' => true,
            'default_label' => '--select grade--',
            'value' => ($data ? $data['grade'] : '')
        ]);
        ?>

        <div class="form-group ">
            <div class="row">
                <div class="col-sm-4">
                    <label class="control-label" for="email">
                        Duration <span class="text-danger">*</span>
                    </label>
                </div>
                <div class="col-sm-8">
                    <div class="">
                        <input type="number" name="duration" ng-init="duration = '<?= ($data ? $data['duration'] : '') ?>'" ng-model="duration" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>
                Questions <span class="text-danger">*</span>
            </label>
            <div class="alert alert-info" ng-show="questions.length < 1">Click on the button below to add questions.</div>
            <div class="form-group card border-info" ng-repeat="(qIndex, item) in questions">
                <div class="card-header">Question {{qIndex + 1}}</div>
                <div class="card-body">
                    <div class="form-group">
                        <label>
                            Question
                        </label>
                        <div>
                            <input type="text" ng-model="item.question" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Answers</label>
                        <div class="alert alert-info" ng-show="item.options.length < 1">Click on the button below to add answers for this question.</div>
                        <div class="card mb-3" ng-repeat="(oIndex, option) in item.options">
                            <div class="card-header">Answer {{oIndex + 1}}</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Value</label>
                                    <input type="text" ng-model="option.value" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label>Error notes</label>
                                    <input type="text" ng-model="option.error_note" class="form-control"/>
                                    <small class="form-text text-muted">We'll display this information if the student selects this answer and it's not correct.</small>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-warning" ng-click="removeOption(qIndex, oIndex)">Delete answer</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary" ng-click="addOption(qIndex)">Add answer</button>
                    </div>
                    <div class="form-group" ng-show="item.options.length > 0">
                        <label>
                            Correct Answer
                        </label>
                        <select class="form-control" name="answer_{{qIndex}}" ng-model="item.correct_option" ng-options="o.value for o in item.options track by o.value">
                            <option value="{{opt.value}}" ng-repeat="(opt) in questions">{{opt.value}}</option>
                        </select>
                        <small class="form-text text-muted">Select which one of the added answers is the correct answer</small>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-warning" ng-click="removeQuestion(qIndex)">Delete question</button>
                </div>
            </div>
            <div class="">
                <button type="button" class="btn btn-secondary" ng-click="add()">Add question</button>
            </div>
        </div>

        <div class="form-group form-submit-btn-holder text-center">
            <button type="submit" id="btn-submit" class="btn btn-primary" ng-click="">Save</button>
        </div>
    </form>
</div>
<?php
if ($data) {
    ?>
    <script type="text/javascript">
        var questions = JSON.parse('<?= json_encode($data['questions']) ?>');
        console.log(questions);
    </script>
    <?php
}
