<html>

<head>
    <title>VORTEX BPO</title>

    <link rel="stylesheet" href="<?php echo BASE_URL.'assets/bs5/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL.'assets/css/design.css'; ?>">

    <script type="text/javascript" src="<?php echo BASE_URL.'assets/js/jquery-3.6.0.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo BASE_URL.'assets/js/alpine.js'; ?>" defer></script>
    <script type="text/javascript" src="<?php echo BASE_URL.'assets/js/moment.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo BASE_URL.'assets/bs5/js/bootstrap.bundle.min.js'; ?>"></script>
    
</head>

<body>

<header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">VBPO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL.'/'; ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL.'portal/profile'; ?>">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL.'portal/leave'; ?>">Leave</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL.'portal/timesheet'; ?>">Timesheet</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if( session('user') !== null ):?>
                    <li class="nav-item">
                       <span class="nav-link"><?php echo session('user_username'); ?></span>
                    </li>
                <?php endif;?>

                <?php if(session('user_level') == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL.'admin/home'; ?>">Admin Panel</a>
                    </li> 
                <?php endif; ?>

                <?php if( session('user') !== null ):?>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL.'logout'; ?>" class="nav-link text-danger">
                            Logout &rightarrow;
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    </nav>

</header>