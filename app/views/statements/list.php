<?php ob_start(); // content ?>
<div class="container py-3">
    <?php echo view('components/projects_nav.php'); ?>

    <div class="row mt-1 g-3">
        <div class="col">
            <div class="p-2 border">
                <div class="row">
                    <div class="col">
                        <small class="text-muted">Project name:</small>
                        <h5><?php echo $project['name']; ?></h5>
                    </div>
                    <div class="col">
                        <small class="text-muted">Statement:</small>
                        <h5><?php echo $budget_label; ?></h5>
                    </div>
                    <div class="col">
                        <small class="text-muted">Allocation:</small>
                        <h5><?php echo number_format($budget_detail['allocation'] ?? 0, 2);?></h5>
                    </div>
                    <div class="col">
                        <small class="text-muted">Total Cost:</small>
                        <h5><?php echo number_format($statements_total, 2);?></h5>
                    </div>
                    <div class="col">
                        <small class="text-muted">Balance:</small>
                        <h5><?php echo number_format($balance, 2);?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col" id="table-statement">
            <div class="table-responsive">
                <table class="table table-bordered" style="min-width:800px;">
                    <thead>
                        <th>ID</th>
                        <th>Particular</th>
                        <th>Cost</th>
                        <th>Added on</th>
                        <th class="text-end">
                            <button id="open-form-add-statement" class="btn btn-success">&plus; add</button>
                        </th>
                    </thead>
                    <tbody>
                        <?php foreach($statements as $statement): ?>
                            <tr>
                                <td><?php echo $statement['id']; ?></td>
                                <td><?php echo $statement['particular']; ?></td>
                                <td><?php echo $statement['cost']; ?></td>
                                <td><?php echo readable_date($statement['created_at']); ?></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-5 no-display" id="div-form-statement">
            <div class="card">
                <div class="card-header">
                    <strong>New Statement</strong>
                    <a href="" class="float-end">[back]</a>
                </div>
                <div class="card-body">
                    <form method="post" id="form-statement">
                        <?php echo csrf_field();?>
                        <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>"/>
                        <input type="hidden" name="budget_key" value="<?php echo $budget_key; ?>"/>
                        <div class="mt-3">
                            <label>Particular</label>
                            <input type="text" name="particular" class="form-control"/>
                        </div>

                        <div class="mt-3">
                            <label>Cost</label>
                            <input type="number" step="0.01" name="cost" class="form-control"/>
                        </div>

                        <div class="my-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        <div id="statement-add-response"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $content = ob_get_clean(); ?>


<?php ob_start(); ?>
<script>
    console.log(<?php echo json_encode($statements); ?>)
    $('#project-nav').append(
        `<a class="btn btn-light border" 
            href="<?php echo base_url("projects.php?a=view&id={$project['id']}"); ?>">
            &larr; Back to Project details
            </a>`);

    $('#open-form-add-statement').on('click', function(){
        $('#table-statement').hide();
        $('#div-form-statement').show();
    });

    $('#form-statement').on('submit', function(e){
        e.preventDefault();
        const url = "<?php echo base_url('ajax.php?a=addstatement'); ?>";
        let form_data = $(this).serialize();
        $('.loader').fadeIn();
        $.post(url, form_data).then(function(data){
            $('#statement-add-response').html(data);
        }).fail(function(){
            alert('Error processing your request');
        }).always(function(){
            $('.loader').fadeOut();
        });
    });
</script>
<?php $scripts = ob_get_clean(); ?>

<?php include layout('layouts/main.php');?>