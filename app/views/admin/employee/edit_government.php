<?php echo $this->render('blocks/header_admin.php'); ?>

<main>

<div class="p-1 bg-dark text-light text-center">
    Edit Employee Government Numbers
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
                        <label>SSS</label>
                        <input type="text" 
                            name="sss" 
                            class="form-control" 
                            value="<?php echo $government['sss'] ?? null; ?>">
                    </div>
                    <div class="mt-3">
                        <label>PhilHealth</label>
                        <input type="text" 
                            name="philhealth" 
                            class="form-control" 
                            value="<?php echo $government['philhealth'] ?? null; ?>">
                    </div>
                    <div class="mt-3">
                        <label>PagIbig</label>
                        <input type="text" 
                            name="pagibig" 
                            class="form-control"
                            value="<?php echo $government['pagibig'] ?? null; ?>">
                    </div>
                    <div class="mt-3">
                        <label>TIN</label>
                        <input type="text" 
                            name="tin" 
                            class="form-control"
                            value="<?php echo $government['tin'] ?? null; ?>">
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