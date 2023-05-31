

<?php ob_start(); ?>

<div class="container py-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="p-4 bg-light text-center">
                <p>You have successfuly logged out!</p>
                <a href="<?php echo base_url('login.php');?>">Login again</a>
            </div>
        </div>
    </div>
</div>

<?php $contents = ob_get_clean(); ?>

<?php include layout('layouts/clean.php'); ?>