<?php echo $this->render('blocks/header.php'); ?>

<main>

<div class="p-1 text-light bg-dark text-center">
    Timesheet
</div>

<div class="container py-3">
    <div class="row">
        <div class="col">
            <div class="p-2 border">
                <form method="post" id="form-timesheet">
                    <?php echo csrf_field();?>
                    Select month
                    <input type="month" name="month">
                    <button type="submit">submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div id="d-timesheet" class="no-display"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-show-breaks" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Breaks</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            loading data...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

</main>


<script type="text/javascript">
    function get_timesheets(){
        let url = "<?php echo BASE_URL.'api/timesheets';?>";
        $.get(url).then(function(data){
            $('#d-timesheet').html(data).fadeIn();
        }).fail(function(){
            $('#d-timesheet').html('Error getting timesheet data').css({'color':'red'});
        }).always(function(){
            view_btn();
        });
    }

    function view_btn(){
        $('.timesheet-tr').each(function(){
            let timesheet_id = $(this).attr('data-key');
            $(this).append(function(){
                return(`
                    <td class="text-end">
                        <button onClick=show_breaks(${timesheet_id}) class="btn btn-sm btn-light border py-0">
                            view breaks
                        </button>
                    </td>
                `);
            });
        });
    }

    function show_breaks(timesheet_id){
        $.get(`/api/breaks/${timesheet_id}`).done(
            function(data){
                $('#modal-show-breaks .modal-body').html(data);
            }
        ).fail(function(){
            $('#modal-show-breaks .modal-body').html('Error getting data').css({
                'color':'red'
            });
        }).always(function(){
             $('#modal-show-breaks').modal('show');
        });
    }

    $('#form-timesheet').on('submit', function(e){
        e.preventDefault();
        let url = "<?php echo BASE_URL.'api/timesheets';?>";
        let form_data = $(this).serialize();
        $('.loader').fadeIn();
        $.post(url, form_data).then(function(data){
            $('#d-timesheet').html(data);
        }).fail(function(){
            $('#d-timesheet').html('Error connecting to server!').css({'color':'red'});
        }).always(function(){
            $('.loader').fadeOut();
            view_btn();
        });
    });

    $(document).ready(function(){
        get_timesheets();
    });
</script>



<?php echo $this->render('blocks/footer.php'); ?>
