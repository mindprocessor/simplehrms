<?php echo $this->render('blocks/header_admin.php'); ?>

<main>

<div class="p-1 bg-dark text-light text-center">
    Edit Employee Login Credentials
</div>

<?php echo $this->render('blocks/employee_nav.php'); ?>


<div class="container py-3">

    <div class="row">
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
                        <label>Username</label>
                        <input type="text" 
                            name="username" 
                            class="form-control" 
                            value="<?php echo $profile['username'] ?? null; ?>">
                    </div>
                    <div class="mt-3">
                        <label>Password <em><small>( leave blank to not change it )</small></em></label>
                        <input type="password" 
                            name="password" 
                            class="form-control" 
                            value="">
                    </div>
                    <div class="mt-3">
                        <label>Your password</label>
                        <input type="password" 
                            name="your_password" 
                            class="form-control"
                            value="">
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