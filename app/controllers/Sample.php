<?php

class Sample extends BaseController {
    function index($f3){
        echo $this->view->render('portal/sample.php');
    }
}