
<?php echo $this->render('blocks/header_blank.php'); ?>

<div class="container py-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="p-4 border rounded shadow">
                <h5 class="text-center">Vortex BPO</h5>
                <div class="fs-6 text-center"><?php echo $remote_addr; ?></div>
                <?php echo $this->raw($msg);?>
                <form method="post">
                    <?php echo csrf_field();?>
                    <div class="py-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo request_post('username');?>">
                    </div>
                    <div class="pb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="pb-3 text-end">
                        <button type="submit" name="gologin" class="btn btn-primary px-5">
                            Login
                        </button>
                    </div>
                </form>

                <div class="text-center text-muted">
                    <small>Vcompanion - v1.0.0</small>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo $this->render('blocks/footer.php'); ?>