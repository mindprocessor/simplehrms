<?php

class BaseController {

    var $db;
    var $validate;
    var $view;

    function __construct(){
        $this->view = new View;

        //database
        $this->db = new Medoo\Medoo([
            'type' => 'sqlite',
            'database' => 'app/database.db'
        ]);

        //valitron
        $this->validate = new Valitron\Validator($_POST);

        //check csrf
        csrf_check();

    }


    //current user
    public function currentUser($field=null){
        $uid = session('user');
        if($field !== null){
            $user = $this->db->get('employee', [$field] ,[
                'id'=>$uid
            ]);
            if($user){
                return $user[$field];
            }
        }else{
            return $uid;
        }
    }

    //secure
    public function secure() : void {
        $f3 = \Base::instance();
        if(session('user') == null){
            $f3->reroute(BASE_URL.'login', false);
        }else{
            //check if user(id) is in the database
            $user = $this->db->get('employee', ['id'], [
                'id'=>session('user')
            ]);
            if(!$user){
                $f3->reroute(BASE_URL.'login', false);
                exit();
            }
        }
    }

    //secure api
    public function secureAPI(){
        $f3 = \Base::instance();
        if(session('user') == null){
            $resp = [
                'result'=>'error',
                'msg'=>'authentication error'
            ];
            header('Content-type: application/json');
            http_response_code(500);
            echo json_encode($resp);
            exit();
        }else{
            //check if user(id) is in the database
            $user = $this->db->get('employee', ['id'], [
                'id'=>session('user')
            ]);
            if(!$user){
                $resp = [
                    'result'=>'error',
                    'msg'=>'identity error'
                ];
                http_response_code(500);
                header('Content-type: application/json');
                echo json_encode($resp);
                exit();
            }
        }
    }

    //secure admin
    public function secureAdmin() : void{
        $uid = session('user'); // employee id
        $user = $this->db->get('employee', ['id','level'], [
            'id'=>$uid
        ]);
        if($user){
            if($user['level'] !== 'admin'){
                die('YOU ARE NOT ALLOWED!');
                exit();
            }
        }else{
            die('NOT ALLOWED!---');
            exit();
        }
    }

}