<?php echo $this->render('blocks/header.php'); ?>

<main>

<div class="p-1 text-light bg-dark text-center">
    Leave Records
</div>

<div class="container py-3">
    
    <div class="row">
        <div class="col">
            <?php echo flash_get('msg'); ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="p-2 border">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <a href="<?php echo BASE_URL.'portal/leave-plot';?>" class="btn btn-primary">Plot Leave</a>
                    </div>
                    <div class="col text-end">
                        Leave credits  [ <?php echo $leave_plotted;?> / <?php echo $leave_credit_total;?> ]
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div clas="col">
            <div id="plot-leaves" class="no-display">
                <table class="table border">
                    <thead>
                        <th width="150">Chosen Date</th>
                        <th width="150">Type</th>
                        <th>Reason</th>
                        <th width="100">Approve</th>
                        <th width="100">Option</th>
                    </thead>
                    <tbody>
                        <?php foreach($leaves as $lv): ?>
                            <?php
                                $tb_bg = "";
                                if($lv['approve'] == "pending"){
                                    $tb_bg = 'bg-warning bg-opacity-10';
                                }
                                if($lv['approve'] == 'yes'){
                                    $tb_bg = 'bg-success bg-opacity-10';
                                }
                            ?>
                            <tr class="<?=$tb_bg;?>">
                                <td><?php echo $lv['chosen_date'];?></td>
                                <td><?php echo $lv['leave_type'];?></td>
                                <td><?php echo $lv['reason'];?></td>
                                <td><?php echo $lv['approve'];?></td>
                                <td>
                                    <?php if($lv['approve'] == 'pending'): ?>
                                    <a 
                                        href="<?php echo base_url('portal/leave-cancel/'.$lv['id']);?>" 
                                        class="text-danger text-decoration-none">
                                        [ cancel ]
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</main>

<script>
    $(document).ready(function(){
        $('#plot-leaves').fadeIn();
    });
</script>


<?php echo $this->render('blocks/footer.php'); ?>