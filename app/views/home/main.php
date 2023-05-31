
<?php ob_start(); //content ?>
<div class="container py-3">
    <div class="row g-3">
        <div class="col-md-3 col-sm-12">
            <div class="card">
                <div class="card-header">
                    Progress Update
                </div>
                <div class="card-body">
                    <table class="table">
                        <?php foreach($projects as $pkey=>$pval): ?>
                            <tr>
                                <td><?php echo strtoupper($pkey); ?></td>
                                <td><?php echo $pval; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Ongoing Projects
                </div>
                <div class="card-body">
                    <ul>
                        <?php foreach($projects_ongoing as $ongoing):?>
                            <li><?php echo $ongoing['name']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Pending Projects
                </div>
                <div class="card-body">
                    <ul>
                        <?php foreach($projects_pending as $pending):?>
                            <li><?php echo $pending['name']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Upcoming Projects
                </div>
                <div class="card-body">
                    <ul>
                        <?php foreach($projects_upcoming as $upcoming):?>
                            <li><?php echo $upcoming['name']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>


<?php include(layout('layouts/main.php'));?>