<div id="component-timesheets">
    <table class="table">
        <thead>
            <th>Name</th>
            <th>Status</th>
            <th>Start</th>
            <th>End</th>
            <th>Minutes</th>
        </thead>
        <tbody>
            <?php foreach($breaks as $break): ?>
                <?php
                    $tb_bg = "";
                    if($break['status'] == 'start'){
                        $tb_bg = 'bg-success bg-opacity-25';
                    }
                ?>
                <tr class="<?=$tb_bg;?>">
                    <td><?=strtoupper($break['name']);?></td>
                    <td><?=strtoupper($break['status']);?></td>
                    <td><?=readable_datetime($break['datetime_start']);?></td>
                    <td><?=$break['datetime_end'] ? readable_datetime($break['datetime_end']) : '<em>in progress</em>';?></td>
                    <td><?=($break['hours'] * 60) ?? '--:--';?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>