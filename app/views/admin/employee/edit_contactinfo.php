<?php echo $this->render('blocks/header_admin.php'); ?>

<main>

<div class="p-1 bg-dark text-light text-center">
    Edit Employee Contact Information
</div>

<?php echo $this->render('blocks/employee_nav.php'); ?>


<div class="container py-3">

    <div class="row">
        <div class="col text-center">
            <h6><?php echo strtoupper(sprintf('%s %s %s', $profile['first_name'], $profile['middle_name'], $profile['last_name']));  ?></h6>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
    
        <div class="col-sm-6">
            
            <div id="d-employee-form">
                <?php echo $this->raw($msg); ?>
                <?php echo flash_get('msg'); ?>
                <form method="post" id="form-edit">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label>Email address</label>
                        <input type="text" 
                            name="email" 
                            class="form-control" 
                            value="<?php echo $contactinfo['email'] ?? null; ?>">
                    </div>
                    <div class="mt-3">
                        <label>Contact number</label>
                        <input type="text" 
                            name="contact_number" 
                            class="form-control" 
                            value="<?php echo $contactinfo['contact_number'] ?? null; ?>">
                    </div>
                    <div class="mt-3">
                        <label>Current address</label>
                        <input type="text" 
                            name="current_address" 
                            class="form-control"
                            value="<?php echo $contactinfo['current_address'] ?? null; ?>">
                    </div>
                    <div class="mt-3">
                        <label>Home address</label>
                        <input type="text" 
                            name="home_address" 
                            class="form-control"
                            value="<?php echo $contactinfo['home_address'] ?? null; ?>">
                    </div>
                    
                    
                    <div class="mt-3">
                        <label>Contact person</label>
                        <input type="text" 
                            name="contact_person" 
                            class="form-control"
                            value="<?php echo $contactinfo['contact_person'] ?? null; ?>">
                    </div>
                    
                    <div class="mt-3">
                        <label>Contact person number</label>
                        <input type="text" 
                            name="contact_person_number" 
                            class="form-control"
                            value="<?php echo $contactinfo['contact_person_number'] ?? null; ?>">
                    </div>
                    
                    <div class="mt-3">
                        <label>Contact person address</label>
                        <input type="text" 
                            name="contact_person_address" 
                            class="form-control"
                            value="<?php echo $contactinfo['contact_person_address'] ?? null; ?>">
                    </div>
                    
                    <div class="mt-3">
                        <label>Contact person relation</label>
                        <input type="text" 
                            name="contact_person_relation" 
                            class="form-control"
                            value="<?php echo $contactinfo['contact_person_relation'] ?? null; ?>">
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