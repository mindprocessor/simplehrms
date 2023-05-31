<?php ob_start(); // content ?>
<div class="container py-3">
    <?php echo view('components/projects_nav.php'); ?>
    <div class="row mt-3">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered" style="min-width:800px;">
                    <thead>
                        <th width="50">ID</th>
                        <th width="200">Name</th>
                        <th width="200">Status</th>
                        <th>Location</th>
                        <th width="200">Added on</th>
                        <th width="50"></th>
                    </thead>
                    <tbody>
                        <?php foreach($list as $rec): ?>
                            <tr>
                                <td><?php echo $rec['id']; ?></td>
                                <td><?php echo $rec['name']; ?></td>
                                <td><?php echo $rec['status']; ?></td>
                                <td><?php echo $rec['location']; ?></td>
                                <td><?php echo readable_date($rec['created_at']); ?></td>
                                <td><a href="<?php echo base_url("projects.php?a=view&id={$rec['id']}")?>">select</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php include layout('layouts/main.php');?>