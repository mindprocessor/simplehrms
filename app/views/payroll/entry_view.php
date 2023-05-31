
<?php echo $this->render('blocks/header_payroll.php'); ?>


<main>


<div class="p-2 border-bottom d-flex justify-content-between">
    Payroll Entry
    <a href="/payroll" class="btn btn-sm btn-primary">
        View List
    </a>
    <a href="/payroll/entry/add" class="btn btn-sm btn-primary">
        Add New Entry
    </a>
</div>

<div class="container py-3">
    <div class="row d-flex justify-content-center">
        <div class="col-sm-12">
            <?php echo $this->raw($msg); ?>
            <table class="table table-bordered">
                <thead>
                    <th>Payment Date</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Gross Total</th>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $entry['payment_date']; ?></td>
                        <td><?php echo $entry['date_from']; ?></td>
                        <td><?php echo $entry['date_to']; ?></td>
                        <td>500,000</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <button type="button" id="d-generate" class="btn btn-light border">GENERATE</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pre id="d-generate-results"></pre>
        </div>
    </div>
    <div class="row py-2">
        <div class="row">
            <div class="col">
                <div id="d-generated-record"></div>
            </div> 
        </div>
    </div>
</div>

</main>

<script>

    function get_generated(){
        let host_generated = "<?=BASE_URL.'component/payroll/entry/generated/'.$entry['id'];?>";
        $.get(host_generated).then(function(data){
            $('#d-generated-record').html(data);
        });
    }

    $('#d-generate').on('click', function(){
        let host = "<?=BASE_URL.'api/payroll/entry/generate/'.$entry['id'];?>";
        $.get(host).then(function(data){
            //$('#d-generate-results').html(data);
            get_generated();
        });
    });
</script>


<?php echo $this->render('blocks/footer.php');