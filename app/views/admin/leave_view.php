
<?php echo $this->render('blocks/header_admin.php'); ?>

<main>

<div class="p-1 bg-dark text-light text-center">
    Leave Manage
</div>

<div class="container py-3">
    <div class="row">
        <div class="col">
            <?php echo flash_get('msg');?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="150">Employee</th>
                        <td>
                            <?php 
                                echo strtoupper(
                                    sprintf(
                                        '%s - %s,  %s %s', 
                                        $employee['emp_id'], 
                                        $employee['last_name'], 
                                        $employee['first_name'],
                                        $employee['middle_name']
                                    )
                                );
                            ?>
                            <a href="<?php echo BASE_URL.'admin/leave';?>" 
                                class="text-decoration-none float-end">[ back to list ]</a>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Chosen date</th>
                        <td><?php echo $leave['chosen_date']; ?></td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td><?php echo $leave['leave_type']; ?></td>
                    </tr>
                    <tr>
                        <th>Reason</th>
                        <td><?php echo $leave['reason']; ?></td>
                    </tr>
                    <tr>
                        <th>Approve</th>
                        <td><?php echo strtoupper($leave['approve']); ?></td>
                    </tr>

                    <?php if($leave['approve']=='pending'): ?>
                        <th></th>
                        <td>
                            <a href="<?php echo BASE_URL.'admin/leave/approve/'.$leave['id'].'/yes';?>" class="btn btn-success">YES</a>
                            <a href="<?php echo BASE_URL.'admin/leave/approve/'.$leave['id'].'/no';?>" class="btn btn-primary float-end">NO</a>
                        </td>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</main>

<?php echo $this->render('blocks/footer.php'); ?>
