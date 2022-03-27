<?php
$comp_model = new SharedController;
$db = $comp_model->GetModel();

$start = (property_exists($this, 'start') ? $this->start : date('Y-m', strtotime('-6months')));
$stop = (property_exists($this, 'start') ? $this->stop : date('Y-m'));

$start_date = DateTime::createFromFormat('Y-m', $start);
$end_date = DateTime::createFromFormat('Y-m', $stop);
$prog = $start_date;

$months = "";

while ($prog <= $end_date) {
    $months .= (!empty($months) ? " UNION " : "") . "SELECT '{$prog->format('Y-m-d')}' AS my";
    $prog = $prog->add(new DateInterval('P1M'));
}

$months = "($months)";
$query = "SELECT
            DATE_FORMAT(m.my, '%b %Y') as month_year,
            (SELECT COUNT(*) FROM tbl_construction WHERE EXTRACT(YEAR_MONTH FROM created) = EXTRACT(YEAR_MONTH FROM m.my)) as houses
        FROM $months AS m";
$results = $db->rawQuery($query);

$y_construction = array();
$x_construction = array();
foreach ($results as $row) {
    $y_construction[] = $row['houses'];
    $x_construction[] = $row['month_year'];
}


$graphs = array();
$graphs['under-construction'] = array($x_construction, $y_construction, 'Houses under Construction');
?>
<section class="page">
    <?= $this->render_view('shared/datepicker.php') ?>
    <div  class="">
        <?php $this :: display_page_errors(); ?>
        <div id="feedback"></div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#construction">Construction Statistics</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#completion">Statistics of Completed Houses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#transfers">Statistics of Transfers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#occupation">Completed Houses vs. Occupied Houses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#developments">Developers Signed Agreements vs. Active Developments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#builders">Active Builders vs. Active Developments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#transfers">Growth Analysis</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="construction">
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <h5>Houses under construction</h5>
                        <div id="under-construction"></div>
                    </div>
                    <div class="col-lg-6 col-xs-12">
                        <h5>House Construction by Erf Type</h5>
                        <div id="under-construction-type"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane active" id="completion">

            </div>
            <div class="tab-pane active" id="transfers">

            </div>
            <div class="tab-pane active" id="occupation">

            </div>
            <div class="tab-pane active" id="developments">

            </div>
            <div class="tab-pane active" id="builders">

            </div>
            <div class="tab-pane active" id="transfers">

            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(function () {
<?php foreach ($graphs as $key => $graph) { ?>

            Highcharts.chart('<?= $key ?>', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '<?= $graph[2] ?>'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: JSON.parse('<?= json_encode($graph[0]) ?>'),
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                series: [{
                        name: 'Houses under construction',
                        data: JSON.parse('<?= json_encode($graph[1], JSON_NUMERIC_CHECK) ?>')
                    }]
            });
<?php } ?>
    });
</script>