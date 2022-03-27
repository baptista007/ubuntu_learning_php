<?php
$comp_model = new SharedController;
$db = $comp_model->GetModel();

$start = (property_exists($this, 'start') ? $this->start : date('Y-m', strtotime('-6months')));
$stop = (property_exists($this, 'start') ? $this->stop : date('Y-m'));

$end_date = DateTime::createFromFormat('Y-m', $stop);
$prog = DateTime::createFromFormat('Y-m', $start);

//Houses under construction per month
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
$graphs['under-construction'] = array(
    'title' => 'Houses under construction',
    'xaxis' => $x_construction,
    'series' => array(array(
        'name' => 'Houses under construction',
        'data' => $y_construction
    ))
);

//Houses construction by ERF type

$zones = array(
    Zoning::sectional_title => 'ST',
    Zoning::residential => 'SR'
);

$series = array();
foreach ($zones as $key => $value) {
    $prog = DateTime::createFromFormat('Y-m', $start);
    
    $types_series = array();
    
    while ($prog <= $end_date) {
        $query = "SELECT 
            count(*) as count,
            z.name as zoning
        FROM tbl_construction c
            INNER JOIN tbl_erf e ON e.id = c.erf_id
            INNER JOIN tbl_zoning z ON e.zoning_id = z.id
        WHERE EXTRACT(YEAR_MONTH FROM c.created) = EXTRACT(YEAR_MONTH FROM '{$prog->format('Y-m-d')}')
        AND z.enum_id = $key";

        $results = $db->rawQueryOne($query);
        $types_series[] = $results['count'];
        $prog = $prog->add(new DateInterval('P1M'));
    }
    
    $series[] = array(
        'name' => 'Houses under construction - ' . $value,
        'data' => $types_series
    );
}

$graphs['under-construction-type'] = array(
    'title' => 'House Construction by Erf Type',
    'xaxis' => $x_construction,
    'series' => $series
);
?>
<section class="page">
    <?= $this->render_view('shared/datepicker.php') ?>
    <div  class="">
        <?php $this :: display_page_errors(); ?>
        <div id="feedback"></div>

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
</section>
<script type="text/javascript">
    $(function () {
<?php foreach ($graphs as $key => $graph) { ?>

            Highcharts.chart('<?= $key ?>', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '<?= $graph['title'] ?>'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: JSON.parse('<?= json_encode($graph['xaxis']) ?>'),
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
                series: JSON.parse('<?= json_encode($graph['series'], JSON_NUMERIC_CHECK) ?>')
            });
<?php } ?>
    });
</script>