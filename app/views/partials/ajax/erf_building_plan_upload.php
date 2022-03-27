<?php
$comp_model = new SharedController;
$page_id = Router::$page_id;
?>

<form enctype="multipart/form-data" class="form form-horizontal ajax" action="<?php print_link("ajax/erf_plans_upload" . (!empty($page_id) ? "/" . $page_id : "")) ?>" method="post" data-feedback-div="upload-feedback">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Files - Erf: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="upload-feedback"></div>
                <div class="form-group required">
                    <label>
                        Concept House Plans
                    </label>
                    <div>
                        <?= $comp_model->addFileInput('concept_house_plans'); ?>
                    </div>
                </div>
                <div class="form-group required">
                    <label>
                        Three Dimensional Drawings
                    </label>
                    <div>
                        <?= $comp_model->addFileInput('three_dimensional_drawings'); ?>
                    </div>
                </div>
                <div class="form-group required">
                    <label>
                        Proposed Finishing Schedule and Color scheme with color cards
                    </label>
                    <div>
                        <?= $comp_model->addFileInput('finish_and_color_scheme'); ?>
                    </div>
                </div>
                <div class="form-group required">
                    <label>
                        Pricing Model
                    </label>
                    <div>
                        <?= $comp_model->addFileInput('pricing_model'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        Quality Control Plan
                    </label>
                    <div>
                        <?= $comp_model->addFileInput('qa_plan'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        Sectional Title/Body Corporate Registration Method Statement
                        <small class="text-muted">(Specific to General Residential Erven)</small>
                    </label>
                    <div>
                        <?= $comp_model->addFileInput('reg_method'); ?>
                    </div>
                </div>

                <div class="form-group">

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Upload</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</form>