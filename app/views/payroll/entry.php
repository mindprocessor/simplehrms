
<?php echo $this->render('blocks/header_payroll.php'); ?>


<main>


<div class="p-2 border-bottom d-flex justify-content-between">
    Payroll Entry
    <a href="/payroll/entry/add" class="btn btn-sm btn-primary">
        Add New Entry
    </a>
</div>

<div class="container py-3">
    <div class="row">
        <div class="col">
            <?php echo flash_get('msg'); ?>
            <table class="table table-bordered">
                <thead>
                    <th>Payment Date</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Gross</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach($entry as $rec): ?>
                        <tr>
                            <td><?php echo readable_date($rec['payment_date']); ?></td>
                            <td><?php echo readable_date($rec['date_from']); ?></td>
                            <td><?php echo readable_date($rec['date_to']); ?></td>
                            <td>500,000</td>
                            <td><a href="<?php echo base_url('payroll/entry/view/'.$rec['id']); ?>">view</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



</main>


<?php echo $this->render('blocks/footer.php');