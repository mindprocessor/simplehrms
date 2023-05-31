<?php ob_start() //content ?>
<div class="container py-3">
    <?php view('components/projects_nav.php');?>

    <div class="row mt-3">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Budget | <?php echo $project['name']; ?>
                    <a href="<?php echo base_url("projects.php?a=view&id={$project['id']}");?>" class="float-end">[back]</a>
                </div>
                <div class="card-body">
                    <form method="post" id="form-budget">
                        <?php csrf_field(); ?>
                        <input type="hidden" name="project_id" value="<?php echo $project['id'];?>"/>
                        <?php foreach($budget_list as $bkey=>$bval): ?>
                            <?php $budget_rec_key = array_search($bkey, array_column($budgets, 'name') ); ?>
                            <div class="mt-3">
                                <label><?php echo $bval; ?></label>
                                <input 
                                    type="number" step="0.01" 
                                    name="<?php echo $bkey?>" 
                                    value="<?php echo $budgets[$budget_rec_key]['allocation'] ?? null;?>" 
                                    class="form-control"/>
                            </div>
                        <?php endforeach; ?>
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
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
    $('#form-budget').on('submit', function(e){
        e.preventDefault();
        $('.loader').fadeIn();
        let url = "<?php echo base_url('ajax.php?a=editbudget');?>";
        let form_data = $(this).serialize();
        $.post(url, form_data).then(function(data){
            $('#form-budget').append(data);
        }).fail(function(){
            alert('ERROR connecting to server!');
        }).always(function(){
            $('.loader').fadeOut();
        });
    });
</script>
<?php $scripts = ob_get_clean(); ?>

<?php include layout('layouts/main.php');?>