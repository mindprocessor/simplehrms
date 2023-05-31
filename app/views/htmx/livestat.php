<?php $db = db_connect(); ?>
<div>
    <table class="table border">
        <thead>
            <th>Employee</th>
            <th>STATUS</th>
            <th>BREAKS</th>
            <th>IN</th>
            <th>OUT</th>
            <th>HOURS</th>
        </thead>
        <tbody>
            <?php foreach($employees as $employee): ?>
                <?php
                    //get the timesheet record
                    $timesheet = $db->table('timesheet')->where('employee',$employee['id'])
                        ->orderBy('id', 'desc')->get()->getRow();
                    $break = $db->table('breaks')
                        ->where('employee', $employee['id'])->where('status', 'start')
                        ->orderBy('id','desc')->get()->getRow();
                ?>

                <?php
                    $tb_bg = "";
                    if(isset($timesheet->status)){
                        if($timesheet->status == 'in'){
                            $tb_bg = 'bg-success bg-opacity-10';
                        }
                    }
                    if(isset($break->name)){
                        $tb_bg = 'bg-warning bg-opacity-10';
                    }
                ?>
                <tr class="<?=$tb_bg;?>">
                    <td><?php echo ucwords(sprintf('%s, %s', $employee['last_name'], $employee['first_name'])); ?></td>
                    <td><?=strtoupper($timesheet->status ?? null);?></td>
                    <td><?=$break->name ?? null;?></td>
                    <td><?=$timesheet->datetime_in ?? null;?></td>
                    <td><?=$timesheet->datetime_out ?? null;?></td>
                    <td><?=$timesheet->hours ?? null;?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>