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
            <?php foreach($records as $rec): ?>

                <?php
                    $current_datetime = date('Y-m-d H:i:s');
                    $tb_bg = "";
                    if(isset($rec['timesheet']['status'])){
                        if($rec['timesheet']['status'] == 'in'){
                            $tb_bg = 'bg-success bg-opacity-10';
                        }
                    }
                    if(isset($rec['break']['name'])){
                        $tb_bg = 'bg-warning bg-opacity-10';
                    }
                ?>
                <tr class="<?php echo $tb_bg;?>">
                    <td><?php echo ucwords(sprintf('%s, %s', $rec['employee']['last_name'], $rec['employee']['first_name'])); ?></td>
                    <td><?php echo strtoupper($rec['timesheet']['status'] ?? '');?></td>
                    <td>
                        <?php
                            if(isset($rec['break']['name'])){
                                /**--calculate elapse time */
                                $time_diff = strtotime($current_datetime) - strtotime($rec['break']['datetime_start']);
                                //$hours = $time_diff / (60 * 60); //convert to hours
                                $hours = $time_diff / (60); //convert to mins
                                $min = round($hours, 2);
                                /**--end calculate */
                                echo $rec['break']['name'] ?? null; echo ' - '; 
                                echo readable_datetime($rec['break']['datetime_start']) .' - ';
                                echo '( '.$min.' min )';
                                if($min >= 60){
                                    echo ' !!!';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            if(isset($rec['timesheet']['datetime_in'])){
                                echo readable_datetime($rec['timesheet']['datetime_in']); 
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            if(isset($rec['timesheet']['datetime_out'])){
                                echo readable_datetime($rec['timesheet']['datetime_out']);
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            echo $rec['timesheet']['hours'] ?? null;
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>