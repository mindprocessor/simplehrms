<?php echo $this->render('blocks/header.php'); ?>

<script src="https://cdn.rawgit.com/visionmedia/page.js/master/page.js"></script>


<div x-data="myData()">
    <div x-text="data.msg"></div>
    <button x-on:click="change()">change</button>
</div>


<script>

    function myData(){
        return {
            msg: 'this is a text',
            data: {
                'msg': 'from data message'
            },
            change(){
                this.data.msg = 'change text'
            }
        };
    }

    page('/', index)
    page('/user/:user', show)
    page('/user/:user/edit', edit)
    page('/user/:user/album', album)
    page('/user/:user/album/sort', sort)
    page('*', notfound)
    page()

</script>






<?php echo $this->render('blocks/footer.php'); ?>
