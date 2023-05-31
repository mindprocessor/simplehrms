<?php echo $this->render('blocks/header_admin.php'); ?>

<main>

<div class="p-1 text-center bg-dark text-light">
    Employee Profile
</div>

<?php echo $this->render('blocks/employee_nav.php'); ?>

<div class="container py-3">
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card mb-3 border-dark">
                <div class="card-header d-flex justify-content-between">
                    Employee details <a href="<?php echo base_url('admin/employee/editprofile/'.$profile["id"]);?>">[edit]</a>
                </div>
                <div class="card-body">
                    <table class="table table-fixed">
                        <tr>
                            <td class="text-muted">Employee Number</td>
                            <td><?php echo $profile['emp_id'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">First Name</td>
                            <td><?php echo $profile['first_name'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Last Name</td>
                            <td><?php echo $profile['first_name'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Account Status</td>
                            <td><?php echo $profile['status'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Date of birth</td>
                            <td><?php echo $profile['date_of_birth'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Gender</td>
                            <td><?php echo $profile['gender'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Civil Status</td>
                            <td><?php echo $profile['civil_status'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Pay Rate ( per hour )</td>
                            <td><?php echo $profile['rate'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">User level</td>
                            <td><?php echo $profile['level'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Added on</td>
                            <td><?php echo readable_date($profile['created_at']) ?? null; ?></td>
                        <tr>
                    </table>
                </div>
            </div>

            <div class="card mb-3 border-dark">
                <div class="card-header d-flex justify-content-between">
                    Employment Details <a href="<?php echo base_url('admin/employee/editemployment/'.$profile["id"]);?>">[edit]</a>
                </div>
                <div class="card-body">
                    <table class="table table-fixed">
                        <tr>
                            <td class="text-muted">Department</td>
                            <td><?php echo $employment['department'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Position</td>
                            <td><?php echo $employment['position'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Hire date</td>
                            <td><?php echo $employment['hire_date'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Training date</td>
                            <td><?php echo $employment['training_date'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Probationary date</td>
                            <td><?php echo $employment['probationary_date'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Rularization date</td>
                            <td><?php echo $employment['regularization_date'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Forecasted regularization date</td>
                            <td><?php echo $employment['forecasted_regularization'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Wave</td>
                            <td><?php echo $employment['wave'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Employment Status</td>
                            <td><?php echo $employment['employment_status'] ?? null; ?></td>
                        <tr>
                    </table>
                </div>
            </div>
            
        </div>
        <div class="col-md-6">

            <div class="card mb-3 border-dark">
                <div class="card-header d-flex justify-content-between">
                    Government numbers <a href="<?php echo base_url('admin/employee/editgovernment/'.$profile['id']);?>">[edit]</a>
                </div>
                <div class="card-body">
                    <table class="table table-fixed">
                        <tr>
                            <td class="text-muted">SSS</td>
                            <td><?php echo $government['sss'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">PhilHealth</td>
                            <td><?php echo $government['philhealth'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Pag-Ibig</td>
                            <td><?php echo $government['pagibig'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">TIN</td>
                            <td><?php echo $government['tin'] ?? null; ?></td>
                        <tr>
                    </table>
                </div>
            </div>

            <div class="card mb-3 border-dark">
                <div class="card-header d-flex justify-content-between">
                    Contact Info <a href="<?=base_url('admin/employee/editcontactinfo/'.$profile['id']);?>">[edit]</a>
                </div>
                <div class="card-body">
                    <table class="table table-fixed">
                        <tr>
                            <td class="text-muted">Email address</td>
                            <td><?php echo $contactinfo['email'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Contact number</td>
                            <td><?php echo $contactinfo['contact_number'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Current address</td>
                            <td><?php echo $contactinfo['current_address'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Home address</td>
                            <td><?php echo $contactinfo['home_address'] ?? null; ?></td>
                        <tr>
                    </table>
                    <h6 class="fw-normal">Contact Person</h6>
                    <table class="table table-fixed">
                        <tr>
                            <td class="text-muted">Name</td>
                            <td><?php echo $contactinfo['contact_person'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Phone number</td>
                            <td><?php echo $contactinfo['contact_person_number'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Address</td>
                            <td><?php echo $contactinfo['contact_person_address'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Relation</td>
                            <td><?php echo $contactinfo['contact_person_relation'] ?? null; ?></td>
                        <tr>
                    </table>
                </div>
            </div>
            
            <div class="card mb-3 border-dark">
                <div class="card-header d-flex justify-content-between">
                    Login Credentials <a href="<?=base_url('admin/employee/editlogin/'.$profile['id']);?>">[edit]</a>
                </div>
                <div class="card-body">
                    <table class="table table-fixed">
                        <tr>
                            <td class="text-muted">Username</td>
                            <td><?php echo $profile['username'] ?? null; ?></td>
                        <tr>
                        <tr>
                            <td class="text-muted">Password</td>
                            <td>************</td>
                        <tr>
                    </table>
                </div>
            </div>
            
        </div>
    </div>

</div>

</main>

<?php echo $this->render('blocks/footer.php'); ?>