
<?php
    $generated = json_decode($entry['json_data'], true);
?>


<table class="table table-bordered">
<thead>
    <th>First name</th>
    <th>Last name</th>
    <th>Timesheet</th>
    <th>Gross Pay</th>
</thead>
<?php  foreach($generated as $dkey=>$gval) : ?>
    <tr>
        <td><?=$gval['employee']['first_name'];?></td>
        <td><?=$gval['employee']['last_name'];?></td>
        <td>
            <table class="table-sm table-bordered">
                <thead>
                    <th>IN</th>
                    <th>OUT</th>
                    <th>Hours</th>
                    <th>Paid hours</th>
                    <th>Overtime</th>
                    <th>OT pay</th>
                    <th>Rate/hr</th>
                    <th>Pay</th>
                </thead>
               <?php foreach($gval['timesheet'] as $tkey=>$tval):?>
                    <tr>
                        <td><?=readable_datetime($tval['datetime_in']);?></td>
                        <td><?=readable_datetime($tval['datetime_out']);?></td>
                        <td><?=$tval['hours'];?></td>
                        <td><?=$tval['paid_hours'];?></td>
                        <td><?=$tval['overtime'];?></td>
                        <td><?=$tval['overtime_calculation'];?></td>
                        <td><?=$tval['rate'];?></td>
                        <td><?=$tval['pay_calculation'];?></td>
                    </tr>
               <?php endforeach; ?>
            </table>
        </td>
        <td><?=$gval['gross_pay'];?></td>
    </tr>
<?php endforeach; ?>
</table>