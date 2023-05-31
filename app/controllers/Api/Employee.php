<?php

namespace Api;

class Employee extends \BaseController {

    function __construct(){
        parent::__construct();
        $this->secureAPI();
        //$this->secureAdmin();
    }


    public function add($f3){
        $this->validate->rule('required', 'employee_id')->label('Employee ID');
        $this->validate->rule('required', 'first_name')->label('First name');
        $this->validate->rule('required', 'last_name')->label('Last name');
        $this->validate->rule('required', 'username')->rule('lengthMin','username', 4)->label('Username');
        $this->validate->rule('required', 'password')->rule('lengthMin','password', 6)->label('Password');
        if($f3->get('VERB') == 'POST'){
            if($this->validate->validate()) {
                //add data to database
                //check employee id
                //find match by first, middle and last name
                $post_emp_id = sanitize_lower(request_post('employee_id'));
                $post_first_name = sanitize_lower(request_post('first_name'));
                $post_middle_name = sanitize_lower(request_post('middle_name'));
                $post_last_name = sanitize_lower(request_post('last_name'));
                $post_username = sanitize_lower(request_post('username'));
                $post_password = sanitize_lower(request_post('password'));
                
                $has_emp_id = $this->db->has('employee', ['emp_id'=>$post_emp_id]);
                if($has_emp_id){
                    $msg = alert('danger', 'Employee ID is already taken');
                }else{
                    $has_name = $this->db->has('employee', [
                        'AND'=>[
                            'first_name'=>$post_first_name,
                            'middle_name'=>$post_middle_name,
                            'last_name'=>$post_last_name,
                        ]
                    ]);
                    if($has_name){
                        $resp['result'] = 'error';
                        $resp['msg'] = 'Employee already exist';
                    }else{
                        //check userame
                        $has_username = $this->db->has('employee', ['username'=>$post_username]);
                        if($has_username){
                            $resp['result'] = 'error';
                            $resp['msg'] = 'Username was already taken';
                        }else{
                            
                            $employee_data = [
                                'emp_id'=>$post_emp_id,
                                'first_name' => $post_first_name,
                                'middle_name' => $post_middle_name,
                                'last_name' => $post_last_name,
                                'username' => $post_username,
                                'password' => jhash($post_password),
                                'status' => 'active',
                                'level' => 'user',
                                'created_at' => current_datetime(),
                                'updated_at' => current_datetime(),
                            ];

                            $save = $this->db->insert('employee', $employee_data);

                            if($save){
                                $resp['result'] = 'ok';
                                $resp['msg'] = 'New Record was added!';
                            }else{
                                $resp['result'] = 'error';
                                $resp['msg'] = 'ERROR processing your request!';
                            }
                        }
                        
                    }
                }
            } else {
                // Errors
                $resp['result'] = 'error';
                $resp['msg'] = 'validation errors';
                $resp['validation_errors'] =  $this->validate->errors();
            }
            http_response_code(200);
        }else{
            http_response_code(500);
            $resp['result'] = 'error';
            $resp['msg'] = 'not allowed';
        }
        $data['json'] = $resp ?? [];
        echo $this->view->render('api/response.php', 'application/json', $data);
    }


    public function delete(){
        $resp['result'] = 'ok';
        $resp['msg'] = 'this is a message';
        $data['json'] = $resp;
        http_response_code(403);
        echo $this->view->render('api/response.php', 'application/json', $data); 
    }

    public function update($f3){

        if($f3->get('VERB') == 'POST'){

            $this->validate->rule('required', 'id')->label('ID');
            $this->validate->rule('required', 'emp_id')->label('Employee ID');
            $this->validate->rule('required', 'first_name')->label('First name');
            $this->validate->rule('required', 'last_name')->label('Last name');
            $this->validate->rule('required', 'rate')->label('Rate');
            
            //posted data
            $emp_id = sanitize_lower(request_post('emp_id'));
            $first_name = sanitize_lower(request_post('first_name'));
            $middle_name = sanitize_lower(request_post('middle_name'));
            $last_name = sanitize_lower(request_post('last_name'));
            $date_of_birth = sanitize(request_post('date_of_birth'));
            $gender = sanitize(request_post('gender'));
            $civil_status = sanitize(request_post('civil_status'));
            $rate = request_post('rate');
                
            if($this->validate->validate()){

                $id = request_post('id');
                $profile = $this->db->get('employee', '*', ['id'=>$id]);

                if($profile){

                    //check if emp id is taken if its updated
                    $check_emp_id = $this->db->has('employee', [
                        'AND'=>[
                            'emp_id' => $emp_id,
                            'id[!]' => $id,
                        ]
                    ]);
                    if($check_emp_id){
                        $resp['result'] = 'error';
                        $resp['msg'] = 'Employee ID is already taken!';
                    }else{
                        //check if full name already exists
                        $check_name = $this->db->has('employee', [
                            'AND'=>[
                                'first_name'=>$first_name,
                                'middle_name'=>$middle_name,
                                'last_name'=>$last_name,
                                'id[!]'=>$id,
                            ]
                        ]);
                        if($check_name){
                            $resp['result'] = 'error';
                            $resp['msg'] = 'Full name already exists!';
                        }else{
                            //update the record
                            $save = $this->db->update('employee', [
                                'emp_id' => $emp_id,
                                'first_name' => $first_name,
                                'middle_name' => $middle_name,
                                'last_name' => $last_name,
                                'date_of_birth' => $date_of_birth,
                                'gender' => $gender,
                                'civil_status' => $civil_status,
                                'rate'=> $rate,
                                'updated_at'=>current_datetime(),
                            ],['id'=>$id]);
                            if($save){
                                $resp['result'] = 'ok';
                                $resp['msg'] = 'Changes was saved';
                            }else{
                                $resp['result'] = 'error';
                                $resp['msg'] = 'Failed to process your request!';
                            }
                        }
                    }
                }else{
                    $resp['result'] = 'error';
                    $resp['msg'] = 'Employee does not exist';
                }
            }else{
                $resp['result'] = 'error';
                $resp['msg'] = 'validation error';
                $resp['validation_errors'] = $this->validate->errors();
            }
            http_response_code(200);
        }else{
            http_response_code(500);
        }
        $data['json'] = $resp ?? [];
        echo $this->view->render('api/response.php', 'application/json', $data); 
    }

    public function get($f3){
        $id = $f3->get('PARAMS.id');
        $profile = $this->db->get('employee', '*', ['id'=>$id]);
        $contactinfo = $this->db->get('contactinfo', '*', ['employee'=>$id]);
        $government = $this->db->get('government', '*', ['employee'=>$id]);
        $employment = $this->db->get('employment', '*', ['employee'=>$id]);

        if($profile){
            $resp['result'] = 'ok';
            $resp['msg'] = 'record found';
            $resp['record'] = [
                'profile'=>$profile,
                'contactinfo'=>$contactinfo,
                'government'=>$government,
                'employment'=>$employment,
            ];
            http_response_code(200);
        }else{
            http_response_code(500);
            $resp['result'] = 'error';
            $resp['msg'] = 'no records found';
        }

        $data['json'] = $resp;
        echo $this->view->render('api/response.php', 'application/json', $data); 
    }

    public function getAll(){
        $employees = $this->db->select('employee',[
                '[>]employment' => ['id'=>'employee']
            ], [
                'employee.id', 'employee.emp_id', 'employee.first_name', 'employee.middle_name', 'employee.last_name',
                'employment.employment_status', 'employment.position',
            ],[
                'ORDER'=>'employee.emp_id'
            ]
        );

        $resp['result'] = 'ok';
        $resp['msg'] = count($employees).' records found';
        $resp['records'] = $employees;

        $data['json'] = $resp;
        echo $this->view->render('api/response.php', 'application/json', $data); 
    }

}