<?php echo $this->render('blocks/header_admin.php'); ?>

<main>

<div class="p-1 bg-dark text-light text-center">
    Edit Employment Details
</div>

<?php echo $this->render('blocks/employee_nav.php'); ?>


<div class="container py-3">

    <div class="row d-flex justify-content-center">
    
        <div class="col-sm-6">
            <h6 class="text-center"><?php echo strtoupper(sprintf('%s %s %s', $profile['first_name'], $profile['middle_name'], $profile['last_name']));  ?></h6>
            <div id="d-employee-form">
                <?php echo $this->raw($msg); ?>
                <?php echo flash_get('msg'); ?>
                <form method="post" id="form-edit">
                    <?php echo csrf_field();?>
                    <div>
                        <label>Department</label>
                        <input type="text" 
                            name="department" 
                            class="form-control" 
                            value="<?php echo $employment['department'] ?? null; ?>">
                    </div>
                    
                    <div class="mt-3">
                        <label>Position</label>
                        <input type="text" 
                            name="position" 
                            class="form-control" 
                            value="<?php echo $employment['position'] ?? null; ?>">
                    </div>
                    
                    <div class="mt-3">
                        <label>Hire date</label>
                        <input type="date" 
                            name="hire_date" 
                            class="form-control" 
                            value="<?php echo $employment['hire_date'] ?? null; ?>">
                    </div>
                    
                    <div class="mt-3">
                        <label>Training date</label>
                        <input type="date" 
                            name="training_date" 
                            class="form-control" 
                            value="<?php echo $employment['training_date'] ?? null; ?>">
                    </div>
                    
                    <div class="mt-3">
                        <label>Probationary date</label>
                        <input type="date" 
                            name="probationary_date" 
                            class="form-control" 
                            value="<?php echo $employment['probationary_date'] ?? null; ?>">
                    </div>
                    
                    <div class="mt-3">
                        <label>Regularization date</label>
                        <input type="date" 
                            name="regularization_date" 
                            class="form-control" 
                            value="<?php echo $employment['regularization_date'] ?? null; ?>">
                    </div>
                    
                    <div class="mt-3">
                        <label>Forecasted regularization</label>
                        <input type="date" 
                            name="forecasted_regularization" 
                            class="form-control" 
                            value="<?php echo $employment['forecasted_regularization'] ?? null; ?>">
                    </div>
                    
                    <div class="mt-3">
                        <label>Wave #</label>
                        <input type="text" 
                            name="wave" 
                            class="form-control" 
                            value="<?php echo $employment['wave'] ?? null; ?>">
                    </div>
                    
                    <div class="mt-3">
                        <label>Employment status</label>
                        <input type="text" 
                            name="employment_status" 
                            class="form-control" 
                            value="<?php echo $employment['employment_status'] ?? null; ?>">
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
    });
</script>

<?php echo $this->render('blocks/footer.php'); ?>
