<?php ob_start() //content ?>
<div class="container py-3">
    <?php view('components/projects_nav.php');?>

    <div class="row mt-3">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Edit Project
                    <a href="<?php echo base_url("projects.php?a=view&id={$project['id']}");?>" class="float-end">[back]</a>
                </div>
                <div class="card-body">
                    <form method="post" id="form-edit-project">
                        <?php csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo $project['id'];?>"/>
                        <div>
                            <label>Name</label>
                            <input type="text" name="product_name" class="form-control" value="<?php echo $project['name'];?>">
                        </div>
                        <div class="mt-3">
                            <label>Client</label>
                            <input type="text" name="client" class="form-control" value="<?php echo $project['client'];?>">
                        </div>
                        <div class="mt-3">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control" value="<?php echo $project['location'];?>">
                        </div>
                        <div class="mt-3">
                            <label>Details</label>
                            <textarea name="details" class="form-control"><?php echo $project['details'];?></textarea>
                        </div>
                        <div class="mt-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <?php 
                                    foreach($project_status as $pkey=>$pval){
                                        if($project['status'] == $pkey){
                                            echo "<option selected value='{$pkey}'>{$pval}</option>";
                                        }else{
                                            echo "<option value='{$pkey}'>{$pval}</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label>Contract</label>
                            <input type="number" step="0.01" name="contract" class="form-control" value="<?php echo $project['contract'];?>">
                        </div>
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php ob_start(); //scripts?>
<script>
    $('#form-edit-project').on('submit', function(e){
        e.preventDefault();
        $('.loader').fadeIn();
        let url = "<?php echo base_url('ajax.php?a=editproject');?>";
        let form_data = $(this).serialize();
        $.post(url, form_data).then(function(data){
            $('#form-edit-project').append(data);
        }).fail(function(){
            alert('ERROR connecting to server!');
        }).always(function(){
            $('.loader').fadeOut();
        });
    });
</script>
<?php $scripts = ob_get_clean(); ?>

<?php include layout('layouts/main.php');?>