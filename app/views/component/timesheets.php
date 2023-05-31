<div id="component-timesheets">
    <table class="table">
        <thead>
            <th>Status</th>
            <th>IN</th>
            <th>OUT</th>
            <th>Hours</th>
        </thead>
        <tbody>
            <?php foreach($timelog as $tlog): ?>
                <?php
                    $tb_bg = "";
                    if($tlog['status'] == 'in'){
                        $tb_bg = 'bg-success bg-opacity-25';
                    }
                ?>
                <tr class="<?=$tb_bg;?> timesheet-tr" data-key="<?php echo $tlog['id']; ?>">
                    <td><?=strtoupper($tlog['status']);?></td>
                    <td><?=readable_datetime($tlog['datetime_in']);?></td>
                    <td><?=$tlog['datetime_out'] ? readable_datetime($tlog['datetime_out']) : '<em>in progress</em>';?></td>
                    <td><?=$tlog['hours'] ?? '--:--';?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>