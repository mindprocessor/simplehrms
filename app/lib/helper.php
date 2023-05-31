<?php


//session ============
function session($key){
    if(isset($_SESSION[$key])){
        return $_SESSION[$key];
    }else{
        return null;
    }
}
function flash_set($key, $val){
    $_SESSION[$key] = $val;
}
function flash_get($key){
    if(isset($_SESSION[$key])){
        $fmsg = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $fmsg;
    }
}

//base_url ==================
function base_url($url=null){
    return BASE_URL.$url;
}


//request method ==============
function request_method(){
    $req = $_SERVER['REQUEST_METHOD'];
    return $req;
}
function request_post($key){
    $post = $_POST[$key] ?? null;
    return $post;
}


//CSRF ==========================
function csrf_hash(){
    if(!isset($_SESSION['csrf_hash'])){
        $_SESSION['csrf_hash'] = md5(uniqid());
    }
    return $_SESSION['csrf_hash'];
}
function csrf_check(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $csrf = $_POST['csrf'] ?? null;
        if(!isset($csrf)){
            http_response_code(500);
            exit('NOT ALLOWED');
        }else{
            $csrf_hash = csrf_hash();
            if($csrf !== $csrf_hash){
                http_response_code(500);
                exit('MISMATCH');
            }
        }
    }
}
function csrf_field(){
    echo '<input type="hidden" name="csrf" value="'.csrf_hash().'"/>';
}


//DATES ======================
function current_datetime(){
    return Date('Y-m-d H:i:s');
}
function current_date(){
    return Date('Y-m-d');
}
function readable_date($date=null){
    if($date !== null){
        $str_date = date_create($date);
        $format_date = date_format($str_date, 'M d, Y');
        return $format_date;
    }else{
        return null;
    }
}
function readable_datetime($date=null){
    if($date !== null){
        $str_date = date_create($date);
        $format_date = date_format($str_date, 'M d, Y - h:i a');
        return $format_date;
    }else{
        return null;
    }
}
function readable_time($time = 0){
    $stime = gmdate('z H:i:s', $time);
    return $stime;
}
function datetime_diff($end, $start, $time_unit='seconds'){
    $datetime_start = strtotime($start);
    $datetime_end = strtotime($end);
    $time_diff = $datetime_end - $datetime_start; //returns seconds
    switch($time_unit){
        case 'milliseconds':
            return $time_diff * 1000;
            break;

        case 'seconds':
            return $time_diff;
            break;
        
        case 'minutes':
            $minutes = $time_diff / 60; //convert to minutes
            return $minutes;
            break;
        
        case 'hours':
            $hours = $time_diff / 3600; //convert to hours
            $hours = round($hours, 2);
            return $hours;
            break;

        case 'days':
            $days = $time_diff / 86400; //convert to days
            return $days;
            break;
        
        default:
           return $time_diff;
           break; 
    }
}


//hash ===========================
function jhash($str){
    return hash('sha256', $str);
}



//error list =====================
function error_list($data = []){ // this function is for valitron validation errors
    $list = "";
    foreach($data as $k=>$v){
        $list .= "<div>{$v[0]}</div>";
    }
    return $list;
}


//alert box =================
function alert($type, $str){
    $alert = "<div class='alert alert-{$type} alert-dismissible fade show' role='alert'>
            {$str}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    return $alert;
}


//sanitize
function sanitize($val){
    return strip_tags(trim($val));
}
function sanitize_lower($data){
    return strtolower(strip_tags(trim($data)));
}