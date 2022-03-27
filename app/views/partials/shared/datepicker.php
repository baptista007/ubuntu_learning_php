<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$start = (property_exists($this, 'start') ? $this->start : date('Y-m', strtotime('-6months')));
$stop = (property_exists($this, 'start') ? $this->stop : date('Y-m'));
?>
<section class="mb-4">
    <form class="form-inline" action="">
        <div class="form-group">
            <label>
                Start:&nbsp;
            </label>
            <input type="month" name="start" id="start" class="form-control" value="<?= $start ?>" />
        </div>
        &nbsp;&nbsp;-&nbsp;&nbsp;
        <div class="form-group">
            <label>
                Stop:&nbsp;
            </label>
            <input type="month" name="stop" id="stop" class="form-control" value="<?= $stop ?>" />
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" class="btn btn-info" value="Filter" />
    </form>
</section>