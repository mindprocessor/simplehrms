<?php
    $menus = [
        'Home' => base_url('index.php'),
        'Projects' => base_url('projects.php'),
    ];

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">PManage</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php foreach($menus as $mk => $mv): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $mv; ?>"><?php echo $mk; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        </div>
    </div>
</nav>