
<?php ob_start() //content ?>
<div class="container py-3">
    <?php view('components/projects_nav.php');?>

    <div class="row mt-2 g-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Project Details 
                    <a href="<?php echo base_url("projects.php?a=edit&id={$project['id']}");?>" class="float-end">[edit]</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width:170px;">Name</th>
                                <td><?php echo $project['name']; ?></td>
                            </tr>
                            <tr>
                                <th>Client</th>
                                <td><?php echo $project['client']; ?></td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td><?php echo $project['location']; ?></td>
                            </tr>
                            <tr>
                                <th>Details</th>
                                <td><?php echo $project['details']; ?></td>
                            </tr>
                            <tr>
                                <th>Contract</th>
                                <td><?php echo number_format($project['contract'], 2); ?></td>
                            </tr>
                            <tr>
                                <th>Budget Allocated</th>
                                <td><?php echo $total_budget ? number_format($total_budget, 2) : null; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Budget Overview 
                    <a href="<?php echo base_url("projects.php?a=editbudget&pid={$project['id']}");?>" class="float-end">[edit]</a>
                </div>
                <div class="card-body">
                    <table class="table table-fixed table-hover">
                        <thead>
                            <th></th>
                            <th>Budget</th>
                            <th>Cost</th>
                            <th>Balance</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php foreach($budget_list as $bkey=>$bval): ?>
                                <?php $budget_rec_key = array_search($bkey, array_column($budgets, 'name') ); ?>
                                <?php $total_allocation = 0.00; ?>
                                <?php $total_statement = 0.00; ?>
                                <tr>
                                    <th><?php echo $bval; ?></th>
                                    
                                    <td>
                                        <?php 
                                            //get budget allocation value with the budget_key array key
                                            if(!empty($budgets[$budget_rec_key]['allocation'])){
                                                echo number_format($budgets[$budget_rec_key]['allocation'], 2);
                                                $total_allocation = $budgets[$budget_rec_key]['allocation'];
                                            }else{
                                                echo null;
                                            }    
                                        ?>
                                    </td>
                                    
                                    <td>
                                        <?php //sum the total of statement group by particular field
                                            foreach($statements as $skey=>$sval){
                                                if($sval['budget_key'] == $bkey){
                                                    $total_statement += $sval['cost'];
                                                }
                                            }
                                            echo number_format($total_statement, 2);
                                        ?>
                                    </td>
                                        
                                    <td>
                                        <?php echo number_format(($total_allocation - $total_statement), 2) ?>
                                    </td>
                                    
                                    <td class="text-end">
                                        <a href="<?php echo base_url("statements.php?pid={$project['id']}&bkey={$bkey}"); ?>">view</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php ob_start(); //scripts?>
<script>
    $('#form-add-project').on('submit', function(e){
        e.preventDefault();
        $('.loader').fadeIn();
        let url = "<?php echo base_url('ajax.php?a=addproject');?>";
        let form_data = $(this).serialize();
        $.post(url, form_data).then(function(data){
            $('#form-add-project').append(data);
        }).fail(function(){
            alert('ERROR connecting to server!');
        }).always(function(){
            $('.loader').fadeOut();
        });
    });
</script>
<?php $scripts = ob_get_clean(); ?>

<?php include layout('layouts/main.php');?>