<div id="component-timesheets">

    <div class="row g-3">
        <div class="col fs-4">
            Current Date: <?php echo Date('M-d-y'); ?>
        </div>
    </div>

    <div class="mt-4 table-responsive">
        <table class="table border">
            <thead>
                <th>Status</th>
                <th>IN</th>
                <th>OUT</th>
                <th>Elapsed</th>
                <th>Hours</th>
                <th></th>
            </thead>
            <tbody>
                <?php
                    $tb_bg = "";
                    if($timelog['status'] == 'in'){
                        $tb_bg = 'bg-success bg-opacity-25';
                    }
                ?>
                <tr class="<?=$tb_bg;?>">
                    <td><?php echo strtoupper($timelog['status']);?></td>
                    <td>
                        <?php echo readable_datetime($timelog['datetime_in']);?>
                        <?php if($timelog['status'] =='in'): ?>
                            <input type="hidden" id="time-in-stamp" value="<?php echo $timelog['datetime_in'];?>">
                        <?php endif; ?>
                    </td>
                    <td><?php echo $timelog['datetime_out'] ? readable_datetime($timelog['datetime_out']) : '<em>in progress</em>';?></td>
                    <td>
                        <?php if($timelog['status'] == 'in'): ?>
                            <span class="time-elapsed"></span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $timelog['hours'] ?? '--:--';?></td>
                    <td class="text-end">
                        <?php if($timelog['status'] == 'in'): ?>
                            <button class="btn btn-danger">
                                Time-OUT
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php if($timelog['status'] == 'out'): ?>
                    <tr>
                        <td colpan=5>
                            <button class="btn btn-lg btn-primary">TIME IN</button>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4 table-responsive">
        <table class="table border">
            <thead>
                <tr>
                    <th>Break</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Elapsed</th>
                    <th>Minutes</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($breaks as $break): ?>
                    <?php 
                        if($break['status'] == 'start'){
                            echo '<tr class="bg-info bg-opacity-10">';
                        }else{
                            echo '<tr>';
                        }
                    ?>
                    <td><?php echo $break['name']; ?></td>
                    <td>
                        <?php echo readable_datetime($break['datetime_start']); ?>
                        <?php if($break['status'] == 'start'): ?>
                            <input type="hidden" id="break-start-stamp" value="<?php echo $break['datetime_start'];?>">
                        <?php endif; ?>
                    </td>
                    <td><?php echo $break['datetime_end'] ? readable_datetime($break['datetime_end']) : '<em>in progress</em>'; ?></td>
                    <td>
                        <?php if($break['status'] == 'start'): ?>
                            <span class="time-break-elapsed"></span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $break['hours'] ? floatval($break['hours']) * 60 : '--' ; ?></td>
                    <td class="text-end">
                        <?php if($break['status'] == 'start'): ?>
                            <button class="btn btn-info">
                                STOP
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>