
<?php echo $this->render('blocks/header_admin.php'); ?>

<main>

<div class="p-1 bg-dark text-light text-center">
    Live Stat
</div>

<div class="container-fluid py-3">
    <div class="row">
        <div class="col">
            <div id="d-livestat">
                Loading data... please wait.
            </div>
            <div><small>Refreshing at <span id="d-countdown" class="fw-bold">---</span> seconds</small></div>
        </div>
    </div>

</div>

</main>

<script>
    function get_live_stat(){
        const url = "<?php echo BASE_URL.'component/livestat';?>";
        $.get(url).then(function(data){
            $('#d-livestat').html(data);
        }).fail(function(){
            $('#d-livestat').html('Error getting data').css({'color':'red'});
        });
    }
    get_live_stat();

    setInterval(() => {
        get_live_stat();
    }, 360000);


    //countdown timer
    let cctime = 360;

    setInterval(() => {
        cctime -= 1;
        $('#d-countdown').html(cctime);
    }, 1000);
</script>

<?php echo $this->render('blocks/footer.php'); ?>