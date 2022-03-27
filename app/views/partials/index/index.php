<?php
$comp_model =  new SharedController();
$db = $comp_model->GetModel();


$schools = count($db->get(SqlTables::tbl_schools));
$learners = count($db->get(SqlTables::tbl_learners));
$subjects = count($db->get(SqlTables::tbl_subjects));
$quizzes = count($db->get(SqlTables::tbl_subject_quizzes));
$notes = count($db->get(SqlTables::tbl_subject_notes));
?>
<section>
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?= $schools ?></h3>
          <p>Registered Schools</p>
        </div>
        <div class="icon">
          <i class="fa fa-building"></i>
        </div>
        <a href="<?= SITE_ADDR?>schools" class="small-box-footer">More info
          <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?= $learners ?></h3>
          <p>Registered Learners</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
        <a href="<?= SITE_ADDR?>learners" class="small-box-footer">More info
          <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?= $schools ?></h3>
          <p>Registerd Teachers</p>
        </div>
        <div class="icon">
          <i class="fa fa-graduation-cap"></i>
        </div>
        <a href="<?= SITE_ADDR?>teachers" class="small-box-footer">More info
          <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3><?= $notes ?></h3>
          <p>Developed short notes</p>
        </div>
        <div class="icon">
          <i class="fa fa-sticky-note"></i>
        </div>
        <a href="" class="small-box-footer">More info
          <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

  <div class="mt-4 mb-2">
    <div id="calendar" style="width: 100%"></div>
  </div>
</section>
