<html>

<head>
    <title>VORTEX BPO | Admin</title>

    <link rel="stylesheet" href="<?php echo BASE_URL.'assets/bs5/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL.'assets/css/design.css'; ?>">

    <script type="text/javascript" src="<?php echo BASE_URL.'assets/js/jquery-3.6.0.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo BASE_URL.'assets/js/alpine.js'; ?>" defer></script>
    <script type="text/javascript" src="<?php echo BASE_URL.'assets/js/moment.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo BASE_URL.'assets/bs5/js/bootstrap.bundle.min.js'; ?>"></script>

</head>

<body>

<header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">VBPO - Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo BASE_URL.'admin/home'; ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo BASE_URL.'admin/employee'; ?>">Employee</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo BASE_URL.'admin/leave'; ?>">Leave</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo BASE_URL.'admin/livestat'; ?>">LiveStat</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if( session('user') !== null ):?>
                    <li class="nav-item">
                       <span class="nav-link"><?php echo session('user_username'); ?></span>
                    </li>
                <?php endif;?>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL.'logout'; ?>" class="nav-link">Logout &rightarrow;</a>
                </li>
            </ul>
        </div>
    </div>
    </nav>

</header>