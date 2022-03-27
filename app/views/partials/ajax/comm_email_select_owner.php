<?php
$comp_model = new SharedController;

//Page Data From Controller
$view_data = $this->view_data;
$records = $view_data->records;
$title = (property_exists($view_data, 'title') ? $view_data->title : null);
$checked  = (property_exists($view_data, 'selected') ? $view_data->selected : array());
?>
<div class="modal-dialog modal-lg" role="document" id="select-owner-email-modal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                <?= (!empty($title) ? $title : 'Select Home Owners') ?>
            </h4>
        </div>
        <div class="modal-body">
            <div id="select-owner-email-feedback"></div>
            <?php
            if (!$records) {
                $this->addNoDataFoundMsg("No erven records found.");
                return;
            }
            ?>
            <table class="table table-striped datatable" id="select-owner-email-datatable">
                <thead>
                    <tr>
                        <th class="td-sno td-checkbox"><input class="toggle-check-all" type="checkbox" /></th>
                        <th>
                            Extension
                        </th>
                        <th>
                            ERF Number
                        </th>
                        <th>
                            Street Address
                        </th>
                        <th>
                            Owner Name
                        </th>
                        <th>
                            Owner Contact
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 0;
                    foreach ($records as $data) {
                        $counter++;
                        ?>
                        <tr>
                            <td>
                                <label>
                                    <input 
                                        type="checkbox"
                                        class="optioncheck" 
                                        name="optioncheck[]" 
                                        value="<?= $data['id'] ?>" 
                                        data-id="<?= $data['id'] ?>" 
                                        data-no="<?= $data['erf_number'] ?>" 
                                        data-size="<?= $data['erf_size'] ?>" 
                                        data-street="<?= $data['street_address'] ?>" 
                                        data-extension="<?= $data['extension'] ?>"
                                        data-name="<?= $data['first_name'] ?>"
                                        data-surname="<?= $data['last_name'] ?>"
                                        data-emails="<?= $data['email_addresses'] ?>"
                                        <?= (is_array($checked) && in_array($data['id'], $checked) ? "checked" : "") ?>
                                    />
                                </label>
                            </td>
                            <td> <?php echo $data['extension'] ?> </td>
                            <td> <?php echo $data['erf_number'] ?> </td>
                            <td> <?php echo $data['street_address'] ?> </td>
                            <td> <?php echo $data['first_name'], ' ', $data['last_name'] ?> </td>
                            <td> <?php echo str_replace(",", "<br />", $data['email_addresses']) ?> </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <script type="text/javascript">
                $(function () {
                    $('table.datatable').DataTable({
                        fixedHeader: false,
                        dom: 'Bfrtip',
                        buttons: [],
                        'pageLength': 20,
                        'searching': true
                    });
                });
            </script>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <?php
            if ($records) {
                ?>
                <button type="button" class="btn btn-primary " id="select-owner-email-add-btn">Add Selected</button>
                <?php
            }
            ?>
        </div>
    </div>
</div>
