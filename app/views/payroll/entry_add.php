
<?php echo $this->render('blocks/header_payroll.php'); ?>


<main>


<div class="p-2 border-bottom d-flex justify-content-between">
    New Payroll Entry
    <a href="/payroll" class="btn btn-sm btn-primary">
        View List
    </a>
</div>

<div class="container py-3">
    <div class="row d-flex justify-content-center">
        <div class="col-sm-4">
            <?php echo $this->raw($msg); ?>
            <form method="post" class="p-3 border">
                <?php csrf_field(); ?>
                <div class="py-2">
                    <label>Payment Date</label>
                    <input type="date" name="payment_date" <?php echo request_post('payment_date'); ?> class="form-control">
                </div>

                <hr class="py-3">

                <strong>Date of Coverrage</strong>

                <div class="py-2">
                    <label>From Date</label>
                    <input type="date" name="date_from" <?php echo request_post('date_from'); ?> class="form-control">
                </div>
                <div class="py-2">
                    <label>To Date</label>
                    <input type="date" name="date_to" <?php echo request_post('date_to'); ?> class="form-control">
                </div>
                <div class="py-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



</main>


<?php echo $this->render('blocks/footer.php');