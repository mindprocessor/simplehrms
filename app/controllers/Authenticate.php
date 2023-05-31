<?php

class Authenticate extends BaseController {

    public function login($f3){

        $this->validate->rule('required', 'username')->label('Username');
        $this->validate->rule('required', 'password')->label('Password');

        //post login
        if($f3->get('VERB') == 'POST'){
            if($this->validate->validate()){
                $username = request_post('username');
                $password = jhash(request_post('password'));
                $user = $this->db->get('employee', ['id','username','password','level'], [
                    'AND'=>[
                        'username'=>$username,
                        'password'=>$password,
                    ]
                ]);
                if($user){
                    $_SESSION['user'] = $user['id'];
                    $_SESSION['user_username'] = $user['username'];
                    $_SESSION['user_level'] = $user['level'];
                    $f3->reroute(BASE_URL, false);
                }else{
                    $msg=alert('danger', 'Username / Password is wrong!');
                }
            }else{
                $msg = alert('danger', error_list($this->validate->errors()));
            }
        }

        $context=[
            'remote_addr'=>$_SERVER['REMOTE_ADDR'],
            'msg'=>$msg ?? null,
        ];

        echo $this->view->render('auth/login.php', 'text/html', $context);
    }

    public function logout($f3){
        session_destroy();
        $f3->reroute(BASE_URL.'login');
    }

}