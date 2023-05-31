<?php echo $this->render('blocks/header_admin.php'); ?>

<main>

<div class="p-1 bg-dark text-light text-center">
    Leave Manage
</div>

<div class="container py-3">
    <div class="row">
        <div class="col">
            <table class="table table-bordered">
                <thead>
                    <th>Employee</th>
                    <th>Chosen date</th>
                    <th>Type</th>
                    <th>Reason</th>
                    <th width="120">Approve</th>
                    <th width="100">View</th>
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
                            <td><?php echo ucwords(sprintf('%s, %s',$lv['last_name'], $lv['first_name']));?></td>
                            <td><?php echo $lv['chosen_date'];?></td>
                            <td><?php echo $lv['leave_type'];?></td>
                            <td><?php echo  substr($lv['reason'], 0, 20);?>...</td>
                            <td><?php echo $lv['approve'];?></td>
                            <td>
                                <a href="<?php echo BASE_URL.'admin/leave/view/'.$lv['id'];?>"
                                    class="text-decoration-none">
                                    [view]
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</main>

<?php echo $this->render('blocks/footer.php'); ?>
