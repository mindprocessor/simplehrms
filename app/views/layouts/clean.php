<html>

<head>
    <title>VORTEX BPO</title>

    <link rel="stylesheet" href="<?php echo base_url('assets/bs5/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/design.css'); ?>">

    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/bs5/js/bootstrap.bundle.min.js'); ?>"></script>
    
    <?php echo $meta ?? null; ?>
</head>

<body>


<main>

    <?php echo $contents ?? null;?>

</main>



<div class="loader">Processing please wait...</div>


<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

    <?php echo $scripts ?? null;?>

</body>

</html>