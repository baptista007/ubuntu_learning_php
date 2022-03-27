<?php
$comp_model = new SharedController;

//Page Data Information from Controller
$data_array = $this->view_data;

if ($data_array) {
    $data = $data_array->main_record;
    $owners = $data_array->owners;
    $contacts = $data_array->contacts;
} else {
    $data = null;
    $owners = null;
    $contacts = null;
}

$page_id = Router::$page_id; //Page id from url
?>
<section class="page">
    <div class="row ">

        <div class="col-md-12 comp-grid">

            <?php $this :: display_page_errors(); ?>

            <div  class="animated fadeIn pt-2">
                <?php
                if (!empty($data)) {
                    ?>
                    <div class="page-records ">
                        <div class="row mb-2">
                            <div class="col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        Company Details
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover table-borderless table-striped">
                                            <!-- Table Body Start -->
                                            <tbody>

                                                <tr>
                                                    <th class="title"> Name:</th>
                                                    <td class="value"> <?= $data['name']; ?> </td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> Registration Number:</th>
                                                    <td class="value"> <?= $data['registration_number']; ?> </td>
                                                </tr>

                                            </tbody>
                                            <!-- Table Body End -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-2">
                            <div class="col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        Owners
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover table-borderless table-striped">
                                            <thead class="table-header bg-light">
                                                <tr>
                                                    <th class="td-sno">First Name</th>
                                                    <th > Last Name </th>
                                                    <th > Cellphone </th>
                                                    <th > Email Address </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                foreach ($owners as $owner) {
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $owner['firstname']; ?> </td>
                                                        <td> <?php echo $owner['lastname']; ?> </td>
                                                        <td> <?php echo $owner['phone']; ?> </td>
                                                        <td> <?php echo $owner['email']; ?> </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        Other Contacts
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            if ($contacts) {
                                        ?>
                                        <table class="table table-hover table-borderless table-striped">
                                            <thead class="table-header bg-light">
                                                <tr>
                                                    <th class="td-sno">First Name</th>
                                                    <th > Last Name </th>
                                                    <th > Cellphone </th>
                                                    <th > Email Address </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                 <?php
                                                foreach ($contacts as $contact) {
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $contact['firstname']; ?> </td>
                                                        <td> <?php echo $contact['lastname']; ?> </td>
                                                        <td> <?php echo $contact['phone']; ?> </td>
                                                        <td> <?php echo $contact['email']; ?> </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                            } else {
                                                $this->addNoDataFoundMsg("No other contacts.", "text-muted animated bounce");
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                

                    <div class="p-3">
                        <a class="btn btn-sm btn-info"  href="<?php print_link("erven/manage_developer/{$data['id']}"); ?>">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                        <a class="btn btn-sm btn-danger recordDeletePromptAction"  href="<?php print_link("erven/delete_developer/$data[id]"); ?>" >
                            <i class="fa fa-times"></i> Delete
                        </a>

                        <a class="btn btn-sm btn-warning" href="javascript:void(0)" onclick="javascript:history.go(-1)">
                            <i class="fas fa-reply"></i> Close
                        </a>
                    </div>
                    <?php
                } else {
                    $this->addNoDataFoundMsg("Record not found.", "text-muted animated bounce");
                }
                ?>
            </div>

        </div>

    </div>
</section>
