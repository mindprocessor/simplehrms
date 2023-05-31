<?php echo $this->render('blocks/header_admin.php'); ?>

<main>

<div class="p-1 bg-dark text-light text-center">
    Edit Employee Profile
</div>

<?php echo $this->render('blocks/employee_nav.php'); ?>


<div class="container py-3">

    <div class="row d-flex">
        <div class="col text-center">
            <h6 class="text-center"><?php echo strtoupper(sprintf('%s %s %s', $profile['first_name'], $profile['middle_name'], $profile['last_name']));  ?></h6>
        </div>
    </div> 

    <div class="row d-flex justify-content-center">
    
        <div class="col-sm-6">
            
            <div id="d-employee-form">
                <?php echo $this->raw($msg); ?>
                <?php echo flash_get('msg'); ?>
                <form method="post" id="form-edit">
                    <?php echo csrf_field();?>
                    <div>
                        <label>Employee ID</label>
                        <input type="text" 
                            name="emp_id" 
                            class="form-control" 
                            value="<?php echo $profile['emp_id']; ?>">
                    </div>
                    <div class="mt-3">
                        <label>First Name</label>
                        <input type="text" 
                            name="first_name" 
                            class="form-control" 
                            value="<?php echo $profile['first_name']; ?>">
                    </div>
                    <div class="mt-3">
                        <label>Middle Name</label>
                        <input type="text" 
                            name="middle_name" 
                            class="form-control"
                            value="<?php echo $profile['middle_name']; ?>">
                    </div>
                    <div class="mt-3">
                        <label>Last Name</label>
                        <input type="text" 
                            name="last_name" 
                            class="form-control"
                            value="<?php echo $profile['last_name']; ?>">
                    </div>

                    <div class="mt-3">
                        <label>Date of Birth</label>
                        <input type="date" 
                            name="date_of_birth" 
                            class="form-control"
                            value="<?php echo $profile['date_of_birth']; ?>">
                    </div>

                    <div class="mt-3">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option><?php echo $profile['gender'] ?? null; ?></option>
                            <optgroup label="choices">
                                <option>male</option>
                                <option>female</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Civil Status</label>
                        <select name="civil_status" class="form-control">
                            <option><?php echo $profile['civil_status'] ?? null; ?></option>
                            <optgroup label="choices">
                                <option>single</option>
                                <option>married</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Pay Rate ( per hour )</label>
                        <input type="number"
                            step="0.01"
                            min="0" 
                            name="rate" 
                            class="form-control"
                            value="<?php echo $profile['rate']; ?>">
                    </div>
                    
                    <div class="mt-3 text-end">
                        <a href="<?php echo base_url('admin/employee/view/'.$profile['id']);?>" class="btn btn-secondary">back</a>
                        <button type="submit" class="btn btn-success px-5 show-loader">Save</button>
                    </div>
                </form>
 
            </div>
        
        </div>
        
    </div>
    
</div>

</main>

<script>
    $('#form-edit').on('submit', function(){
        $('.loader').show();
    })
</script>


<?php echo $this->render('blocks/footer.php'); ?>