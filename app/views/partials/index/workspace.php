
<?php
$comp_model = new SharedController;
$db = $comp_model->GetModel();

$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
$page_id = Router::$page_id;

$data_array = $this->view_data;
$subject = $data_array->record;
$notes = $data_array->notes;
$quizzes = $data_array->quizzes;
?>
<section class="page">
    <div  class="">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Short Notes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="quizzes-tab" data-toggle="tab" href="#quizzes" role="tab" aria-controls="home" aria-selected="true">Quizzes</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">

            <!-- Course Notes -->
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="pull-right mt-2">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#add-note-modal">New Notes</button>
                </div>
                <div class="clearfix mb-2"></div>

                <?php
                if ($notes) {
                    $count = 1;

                    echo '<div class="row">';

                    foreach ($notes as $note) {
                        ?>
                        <div class="col-lg-3 col-sm-6 col-xs-12 mb-3">
                            <div class="card">
                                <div class="card-header">
                                    Grade <?= $note['grade'] ?>: <?= $note['chapter'] ?>
                                </div>
                                <div class="card-body">
                                    <blockquote class="blockquote mb-0">
                                        <p>
                                            <?= $note['summary'] ?>
                                        </p>
                                        <footer class="blockquote-footer">
                                            Last modified <cite title="Source Title"><?= human_datetime($note['modified']) ?></cite>
                                        </footer>
                                    </blockquote>
                                </div>
                                <div class="card-footer">
                                    <a href="/index/note/<?= $note['id'] ?>" class="btn btn-primary">Dashboard</a>
                                </div>
                            </div>
                        </div>

                        <?php
                    }

                    echo '</div>';
                } else {
                    ?>
                    <div class="alert alert-danger">
                        There are currently no notes.
                    </div>
                <?php } ?>
            </div>

            <!-- Quizzes -->
            <div class="tab-pane fade" id="quizzes" role="tabpanel" aria-labelledby="quizzes-tab">
                <div class="pull-right mt-2">
                    <a href="<?= SITE_ADDR ?>index/quiz/<?= $subject['id'] ?>" class="btn btn-primary">New Quiz</a>
                </div>
                <div class="clearfix mb-2"></div>
                <?php if ($quizzes) { ?>
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Grade</th>
                                    <th>Chapter/Title</th>
                                    <th class="text-right">Duration</th>
                                    <th class="text-right">Number of questions</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($quizzes as $quiz) { ?>
                                    <tr>
                                        <td><?= $quiz['grade'] ?></td>
                                        <td><?= $quiz['title'] ?></td>
                                        <td class="text-right"><?= $quiz['duration'] ?></td>
                                        <td class="text-right"><?= $quiz['duration'] ?></td>
                                        <td class="text-right">
                                            <a class="btn btn-primary" href="/index/trial/<?= $quiz['id'] ?>">
                                                Attempt
                                            </a>
                                            <a class="btn btn-primary" href="<?= SITE_ADDR ?>index/quiz/<?= $subject['id'] ?>/<?= $quiz['id'] ?>">
                                                edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger">
                        There are currently no quizzes.
                    </div>
                <?php } ?>
            </div>
        </div>
</section>

<!-- Document Upload Modal -->
<div class="modal" id="add-note-modal" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="<?= SITE_ADDR ?>index/save_notes/<?= $subject['id'] ?>?csrf_token=<?= Csrf::$token ?>" enctype="multipart/form-data" class="ajax" data-feedback-div="define-note-feedback">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="eval-doc-upload-modal-title">Add Notes</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div id="define-note-feedback"></div>
                    <?php
                    $fields = array();

                    $fields[] = array(
                        'name' => 'date',
                        'type' => InputType::date,
                        'label' => 'Date',
                        'required' => true
                    );

                    $fields[] = array(
                        'name' => 'grade',
                        'type' => InputType::select,
                        'label' => 'Grade',
                        'options' => Getters::$grades,
                        'required' => true,
                        'default_label' => '--select grade--'
                    );

                    $fields[] = array(
                        'name' => 'chapter',
                        'type' => InputType::text,
                        'label' => 'Chapter',
                        'required' => true
                    );

                    $fields[] = array(
                        'name' => 'summary',
                        'type' => InputType::textarea,
                        'label' => 'Summary',
                        'required' => true
                    );

                    foreach ($fields as $field) {
                        $comp_model->addInput($field);
                    }
                    ?>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="save-note" name="save_note"><i class="fa fa-check"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>