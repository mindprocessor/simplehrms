<?php echo $this->render('blocks/header_admin.php'); ?>

<main>

<div class="p-1 bg-dark text-light text-center">
    Employees
</div>

<?php echo $this->render('blocks/employee_nav.php'); ?>


<div class="container py-3">
    <div class="row">
        <div class="col">
            <table class="table table-fixed table-hover border">
                <thead>
                    <th>EMP ID</th>
                    <th>Last name</th>
                    <th>First name</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach($employees as $emp): ?>
                        <tr>
                            <td><?php echo ucwords($emp['emp_id']);?></td>
                            <td><?php echo ucwords($emp['last_name']);?></td>
                            <td><?php echo ucwords($emp['first_name']);?></td>
                            <td><?php echo ucwords($emp['position'] ?? '');?></td>
                            <td><?php echo ucwords($emp['employment_status'] ?? '');?></td>
                            <td class="text-end">
                                <a href="<?php echo BASE_URL.'admin/employee/view/'.$emp['id'];?>" class="text-decoration-none">[ view ]</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <caption>
                    Returned <?php echo count($employees); ?> results
                </caption>
            </table>
        </div>
    </div>
</div>

</main>

<?php echo $this->render('blocks/footer.php'); ?>
