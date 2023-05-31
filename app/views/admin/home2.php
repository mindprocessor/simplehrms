<?php echo $this->render('blocks/header_admin.php'); ?>

<main>

<div class="container py-3">
    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header">
                    Active Employees
                </div>
                <div class="card-body fs-1 text-center">
                    <?= $employee_active; ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header">
                    On Duty
                </div>
                <div class="card-body fs-1 text-center">
                    <?= $on_duty; ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header">
                    On Break
                </div>
                <div class="card-body fs-1 text-center">
                    <?= $on_break; ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header">
                    On Leave
                </div>
                <div class="card-body fs-1 text-center">
                    <?= $on_leave; ?>
                </div>
            </div>
        </div>
    </div>

</div>

</main>

<?php echo $this->render('blocks/footer.php'); ?>