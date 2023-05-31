<?php echo $this->render('blocks/header.php'); ?>

<main>

<div class="container py-3">
    
    <div class="row">
        <div class="col">
            <?php echo flash_get('msg'); ?>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-12">
            
            <div class="mt-4 table-responsive">
                <table class="table border">
                    <thead>
                        <th>Status</th>
                        <th>IN</th>
                        <th>OUT</th>
                        <th>Elapsed</th>
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
                                    <input type="hidden" id="timelog-datetime-in" value="<?php echo $timelog['datetime_in'];?>">
                                <?php endif; ?>
                            </td>
                            <td><?php echo $timelog['datetime_out'] ? readable_datetime($timelog['datetime_out']) : '<em>in progress</em>';?></td>
                            <td>
                                <?php if($timelog['status'] == 'in'): ?>
                                    <span class="timelog-elapsed"></span>
                                <?php else: ?>
                                    <?php echo readable_time($timelog['time_diff'] ?? 0);?>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <?php if($timelog['status'] == 'in'): ?>
                                    <a href="./portal/timelog/out" class="show-loader btn btn-danger">
                                        Time-OUT
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <?php if($timelog['status'] == 'out'): ?>
                            <tr>
                                <td colpan=5>
                                    <a href="./portal/timelog/in" class="show-loader btn btn-lg btn-primary">TIME IN</a>
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
                                        <input type="hidden" id="time-break-start" value="<?php echo $break['datetime_start'];?>">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $break['datetime_end'] ? readable_datetime($break['datetime_end']) : '<em>in progress</em>'; ?></td>
                                <td>
                                    <?php if($break['status'] == 'start'): ?>
                                        <span class="time-break-elapsed"></span>
                                    <?php else: ?>
                                        <?php echo readable_time($break['time_diff'] ?? 0); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <?php if($break['status'] == 'start'): ?>
                                        <a href="<?php echo BASE_URL.'portal/break/stop/lunch';?>" class="show-loader btn btn-info">
                                            STOP
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if($timelog['status'] == 'in'): ?>
                    <div class="p-2 border">
                        <h6>Select break</h6>
                        <a href="<?php echo BASE_URL.'portal/break/start/lunch';?>" class="show-loader btn btn-light border">lunch</a>
                        <a href="<?php echo BASE_URL.'portal/break/start/training';?>" class="show-loader btn btn-light border">training</a>
                        <a href="<?php echo BASE_URL.'portal/break/start/coaching';?>" class="show-loader btn btn-light border">coaching</a>
                        <a href="<?php echo BASE_URL.'portal/break/start/shortbreak';?>" class="show-loader btn btn-light border">shortbreak</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

</main>

<script>
  
   

    function timelapse(given_datetime){
        //let current_datetime = Date.parse('<?php echo current_datetime(); ?>');
        let parse_datetime = moment(given_datetime);
        let current_datetime = moment(Date.now());
        let time_diff = current_datetime.diff(parse_datetime); //milliseconds

        let time_elapsed = moment.utc(time_diff).format('HH:mm:ss');
        return time_elapsed;
    }

    $('document').ready(function(){

        const timelog_datetime_in = $('#timelog-datetime-in').val();
        const time_break_start = $('#time-break-start').val();

        setInterval( () => {
            let curr = moment(Date.now()).format('YYYY-MM-DD HH:mm:ss');
            
            if(time_break_start !== ''){
                time_break_elapsed = timelapse(time_break_start)
                $('.time-break-elapsed').html(time_break_elapsed);
            }

            if(timelog_datetime_in !== ''){
                timelog_elapsed = timelapse(timelog_datetime_in);
                $('.timelog-elapsed').html(timelog_elapsed);
            }
        }, 1000);

    });

    $('.show-loader').on('click', function(e){
        $('.loader').show();
    });

</script>


<?php echo $this->render('blocks/footer.php'); ?>