<?php echo $this->render('blocks/header.php'); ?>

<main>

<div class="p-1 text-light bg-dark text-center">
    Leave Records / Plot Leave
</div>

<div class="container py-3">
    
    <div class="row">
        <div class="col">
            <a href="<?php echo BASE_URL.'portal/leave'; ?>" class="btn btn-light">&leftarrow; Back to list</a>
        </div>
    </div>

    <div class="row mt-3 g-3">
        <div class="col-md-6">
            <form method="post" id="form-leave-plot" class="p-3 bg-light border">
                
                <?php echo csrf_field(); ?>
            
                <div>
                    <label>Plot Date</label>
                    <input type="date" name="plot_date" class="form-control">
                </div>
                
                <div class="mt-3">
                    <label>Type</label>
                    <select name="leave_type" class="form-control">
                        <option>sick leave</option>
                        <option>vacation leave</option>
                    </select>
                </div>
                
                <div class="mt-3">
                    <label>Reason</label>
                    <textarea name="reason" class="form-control" rows="5"></textarea>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            
            </form>
        </div>
        
        <div class="col-md-6">
            <div id="plot-result"></div>
        </div>
    </div>
</div>

</main>

<script type="text/javascript">
    $('#form-leave-plot').on('submit', function(e){
        e.preventDefault();
        $('.loader').fadeIn();
        $('#plot-result').html('loading...')
        let url = "<?php echo base_url('api/leave/plot');?>";
        let form_data = $(this).serialize();
        $.post(url, form_data).then(function(data){
            $('#plot-result').html(data);
        }).fail(function(){
            alert('Error processing your request!');
            $('#plot-result').html('-----');
        }).always(function(){
            $('.loader').fadeOut();
        });
    });
</script>



<?php echo $this->render('blocks/footer.php'); ?>
