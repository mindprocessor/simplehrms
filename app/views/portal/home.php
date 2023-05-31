<main>

<div class="container py-3">
    
    <div class="row">
        <div class="col">
            <?php echo flash_get('msg'); ?>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Time-IN/OUT
                </div>
                <div class="card-body fs-5">
                    <div id="get-timepunch" class="no-display">Loading time clocking..</div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Current Status
                </div>
                <div class="card-body">
                    <div id="last-timesheet"></div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>

<script>
    function last_timesheet(){
        $.get("<?php echo base_url('component.php?a=last_timesheet');?>")
            .then(function(data){
                $('#last-timesheet').html(data);
            }).fail(function(){
                $('#last-timesheet').html('Error connection to server. Cannot load time');
                $('#last-timesheet').css({'border':'1px solid red', 'padding':'20px'});
            }).always(function(){
                $('#last-timesheet').fadeIn();
                timelapse();
            });
    }

    function get_timepunch(){
        $.get("<?php echo base_url('component.php?a=timepunch');?>")
            .then(function(data){
                $('#get-timepunch').html(data);
            }).fail(function(){
                $('#get-timepunch').html('Error connection to server. Cannot load time');
                $('#get-timepunch').css({'border':'1px solid red', 'padding':'20px'});
            }).always(function(){
                $('#get-timepunch').fadeIn();
            });
    }

    function timelapse(){
        let current_datetime = Date.parse('<?php echo current_datetime(); ?>');
        let time_in_stamp = $('#time-in-stamp').val();
        let parse_stamp = Date.parse(time_in_stamp);
        let time_diff = Date.now() - parse_stamp;
        let time_elapsed = Math.round(time_diff / 60);

        const seconds = 1000;
        const minutes = seconds * 60;
        const hours = minutes * 60;
        const days = hours * 24;
        const years = days * 365;

        $('.time-elapsed').html(time_elapsed);
    }

    $(document).ready(function(){
        get_timepunch();
        last_timesheet();
        setInterval(() => {
            timelapse();
        }, 3000);
    });

    $(document).on('click', '.tm-btn-punch', function(e){
        e.preventDefault();
        $('#get-timesheets').fadeOut();
        $('#get-timepunch').fadeOut();
        $('.loader').fadeIn();
        let url = $(this).attr('href');
        $.get(url).then(function(data){
            get_timepunch();
            last_timesheet();
        }).fail(function(){
            $('#get-timepunch').html('Error processing your request');
        }).always(function(){
            $('.loader').fadeOut();
        });
    });

</script>
