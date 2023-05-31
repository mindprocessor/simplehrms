<div id="component-timepunch">
    <div class="">
        <?php echo flash_get('msg'); ?>
        <?php if($timelog): ?>
            <?php if($timelog['status'] == 'out'): ?>
                <a href="<?php echo base_url('ajax.php?a=timelog&val=in');?>" class="tm-btn-punch btn btn-primary">Time-IN</a>
            <?php endif; ?>
            
            <?php if($timelog['status'] == 'in'): ?>

                <?php if($break && $break['status']=='start'): ?>
                    <p>
                        <a href="<?php echo base_url('ajax.php?a=break&val='.$break['name']);?>" class="tm-btn-punch btn btn-primary">End Break</a>                            You are on <strong><?php echo $break['name'];?></strong>
                        Started at <strong><?php echo readable_datetime($break['datetime_start']);?></strong>
                    </p>
                <?php else: ?>
                
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <a href="<?php echo base_url('ajax.php?a=timelog&val=out');?>" class="tm-btn-punch btn btn-danger">Time-OUT</a>

                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" 
                                type="button" class="btn btn-primary dropdown-toggle" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                                breaks
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item tm-btn-punch" href="<?php echo base_url('ajax.php?a=break&val=lunch');?>">lunch</a></li>
                                <li><a class="dropdown-item tm-btn-punch" href="<?php echo base_url('ajax.php?a=break&val=coaching');?>">coaching</a></li>
                                <li><a class="dropdown-item tm-btn-punch" href="<?php echo base_url('ajax.php?a=break&val=training');?>">training</a></li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
        <?php else: ?>
            <a href="<?php echo base_url('ajax.php?a=timelog&val=in');?>" class="tm-btn-punch btn btn-primary">Time-IN</a>
        <?php endif; ?>
    </div>
</div>