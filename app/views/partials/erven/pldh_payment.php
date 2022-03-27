<?php
$comp_model = new SharedController;
//Page Data Information from Controller
$view_data = $this->view_data;

if (empty($view_data)) {
    $comp_model->AlertDiv('Missing data', 'danger');
    return;
}

$linked_erven = $view_data->linked_erven;
$id = $view_data->sales_contract_id;
?>
<form enctype="multipart/form-data" class="form form-horizontal ajax" action="<?php print_link("erven/add_payment_pldh/" . $id) ?>" method="post" data-feedback-div="payment-feedback">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Register Payment
                </h4>
            </div>
            <div class="modal-body">
                <div id="payment-feedback"></div>
                <table class="table table-striped">
                    <thead>
                        <tr class="valign-top">
                            <th>
                                ERF Number
                            </th>
                            <th>
                                Sale Amount
                            </th>
                            <th>
                                Total Paid
                            </th>
                            <th>
                                Last Payment Date
                            </th>
                            <th>
                                Outstanding
                            </th>
                            <th>
                                Payment Date
                            </th>
                            <th>
                                Payment Amount
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($linked_erven as $key => $erf) {
                                echo '<tr>';
                                echo '<td>';
                                echo $erf['erf_number'];
                                echo '</td>';
                                echo '<td>';
                                echo number_display($erf['sale_amount']);
                                echo '</td>';
                                echo '<td>';
                                echo $erf['payment'];
                                echo '</td>';
                                echo '<td>';
                                echo $erf['payment_date'];
                                echo '</td>';
                                echo '<td>';
                                echo number_display($erf['sale_amount'] - $erf['payment']);
                                echo '</td>';
                                echo '<td>';
                                echo '<input type="date" name="payment_date[]" class="form-control" />';
                                echo '</td>';
                                echo '<td>';
                                echo '<input type="hidden" name="payment_erf[]" value="' . $erf['id'] . '" />';
                                echo '<input type="text" name="payment_amount[]" class="form-control currency" />';
                                echo '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table> 
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</form>