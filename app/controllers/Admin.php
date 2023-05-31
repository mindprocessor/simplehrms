<?php

class Admin extends BaseController {
    function __construct(){
        parent::__construct();
        $this->secure();
        $this->secureAdmin();
    }

    public function home($f3){
        $current_date = date('Y-m-d');

        $employee_active = $this->db->count('employee',['status'=>'active']);
        $on_duty = $this->db->count('timesheet', ['status'=>'in']);
        $on_break = $this->db->count('breaks', ['status'=>'start']);
        $on_leave = $this->db->count('leave', [
            'AND'=>[
                'chosen_date'=>$current_date
            ]        
        ]);

        $dd = [
            'employee_active' => $employee_active,
            'on_duty'=>$on_duty,
            'on_break'=>$on_break,
            'on_leave'=>$on_leave,
        ];
        echo $this->view->render('admin/home.php', 'text/html', $dd);
    }

    public function employee($f3){
        $employees = $this->db->select('employee',[
                '[>]employment' => ['id'=>'employee']
            ], [
                'employee.id', 'employee.emp_id', 'employee.first_name', 'employee.middle_name', 'employee.last_name',
                'employment.employment_status', 'employment.position',
            ],[
                'ORDER'=>'employee.emp_id'
            ]
        );

        $data = [
            'employees'=>$employees,
        ];
        echo $this->view->render('admin/employee.php', 'text/html', $data);
    }

    public function employeeView($f3){
        $id = $f3->get('PARAMS.id');
        $profile = $this->db->get('employee', '*', ['id'=>$id]);
        $contactinfo = $this->db->get('contactinfo', '*', ['employee'=>$id]);
        $government = $this->db->get('government', '*', ['employee'=>$id]);
        $employment = $this->db->get('employment', '*', ['employee'=>$id]);

        if(!$profile){
            $f3->reroute(BASE_URL.'admin/employee');
        }

        $data=[
            'profile'=>$profile,
            'contactinfo'=>$contactinfo,
            'government'=>$government,
            'employment'=>$employment,
        ];
        echo $this->view->render('admin/employee_view.php', 'text/html',  $data);
    }

    public function employeeAdd($f3){
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
                        $msg = alert('danger', 'Employee already exist');
                    }else{
                        //check userame
                        $has_username = $this->db->has('employee', ['username'=>$post_username]);
                        if($has_username){
                            $msg = alert('danger','Username was already taken');
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
                                $msg = alert('success', 'New Record was added!');
                                $display_form = false;
                            }else{
                                $msg = alert('danger', 'ERROR processing your request!');
                            }
                        }
                        
                    }
                }
            } else {
                // Errors
                $msg = alert('danger', error_list($this->validate->errors()));
            }
        }

        $data=[
            'msg'=>$msg ?? null,
            'display_form'=>$display_form ?? true,
        ];
        echo $this->view->render('admin/employee_add.php', 'text/html', $data);
    }

    public function employeeEditProfile($f3){
        $id = $f3->get('PARAMS.id');
        $profile = $this->db->get('employee', '*', ['id'=>$id]);

        $this->validate->rule('required', 'emp_id')->label('Employee ID');
        $this->validate->rule('required', 'first_name')->label('First name');
        $this->validate->rule('required', 'last_name')->label('Last name');
        $this->validate->rule('required', 'rate')->label('Rate');

        if(!$profile){die('ERROR!');}

        if($f3->get('VERB') == 'POST'){
            
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
                //check if emp id is taken if its updated
                $check_emp_id = $this->db->has('employee', [
                    'AND'=>[
                        'emp_id' => $emp_id,
                        'id[!]' => $id,
                    ]
                ]);
                if($check_emp_id){
                    $msg = alert('danger',  'Employee ID is already taken!');
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
                        $msg = alert('danger', 'Full name already exists!');
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
                            flash_set('msg', alert('success', 'Changes was saved'));
                            $f3->reroute(BASE_URL.'admin/employee/editprofile/'.$id);
                            exit('redirecting...');
                        }else{
                            $msg = alert('danger', 'Failed to process your request!');
                        }
                    }
                }
            }else{
                $msg = alert('danger', error_list($this->validate->errors()));
            }
        }
        if($profile){
            $data = [
                'profile'=>$profile,
                'msg'=>$msg ?? null,
            ];
            echo $this->view->render('admin/employee/edit_profile.php', 'text/html', $data);
        }else{
            echo 'ERROR! no record found!';
        }
    }

    public function employeeEditGovernment($f3){
        $id = $f3->get('PARAMS.id'); //employee.id

        $profile = $this->db->get('employee', '*', ['id'=>$id]);
        $government = $this->db->get('government', '*', ['employee'=>$id]);

        if(!$profile){die('ERROR!');}

        if($f3->get('VERB') == 'POST'){
            
            //posted data
            $sss = sanitize_lower(request_post('sss'));
            $philhealth = sanitize_lower(request_post('philhealth'));
            $pagibig = sanitize_lower(request_post('pagibig'));
            $tin = sanitize_lower(request_post('tin'));
            
            if($government){
                //update
                $save = $this->db->update('government',
                    [
                        'sss'=>$sss,
                        'philhealth'=>$philhealth,
                        'pagibig'=>$pagibig,
                        'tin'=>$tin,
                        'updated_at'=>current_datetime(),
                    ],['id'=>$government['id']]
                );
                
            }else{
                //insert
                //update the record
                $save = $this->db->insert('government', [
                    'sss'=>$sss,
                    'philhealth'=>$philhealth,
                    'pagibig'=>$pagibig,
                    'tin'=>$tin,
                    'employee'=>$id,
                    'created_at'=>current_datetime(),
                ]);
                
            }
            if($save){
                flash_set('msg', alert('success', 'Changes was saved'));
                $f3->reroute(BASE_URL.'admin/employee/editgovernment/'.$id);
                exit('redirecting...');
            }else{
                $msg = alert('danger', 'Failed to process your request!');
            }

        }

        $data = [
            'profile'=>$profile,
            'government'=>$government ?? null,
            'msg'=>$msg ?? null,
        ];
        echo $this->view->render('admin/employee/edit_government.php', 'text/html', $data);
    }

    public function employeeEditEmployment($f3){
        $id = $f3->get('PARAMS.id'); //employee.id

        $profile = $this->db->get('employee', '*', ['id'=>$id]);
        $employment = $this->db->get('employment', '*', ['employee'=>$id]);

        if(!$profile){die('ERROR!');}

        if($f3->get('VERB') =='POST'){
            
            
            $post_data = [
                'department'=> sanitize_lower(request_post('department')),
                'position'=> sanitize_lower(request_post('position')),
                'hire_date'=> sanitize(request_post('hire_date')),
                'training_date'=> sanitize(request_post('training_date')),
                'probationary_date'=> sanitize(request_post('probationary_date')),
                'regularization_date'=> sanitize(request_post('regularization_date')),
                'forecasted_regularization'=> sanitize(request_post('forecasted_regularization')),
                'wave'=> sanitize_lower(request_post('wave')),
                'employment_status'=> sanitize_lower(request_post('employment_status')),
            ];
            
            if($employment){
                //save
                $post_data['updated_at'] = current_datetime();
                $save = $this->db->update('employment', $post_data, ['id'=>$employment['id']]);
            }else{
                //insert
                $post_data['created_at'] = current_datetime();
                $post_data['employee'] = $id;
                $save = $this->db->insert('employment', $post_data);
            }
            
            if($save){
                flash_set('msg', alert('success', 'Changes was saved'));
                $f3->reroute(BASE_URL.'admin/employee/editemployment/'.$id);
                exit('redirecting...');
            }else{
                $msg = alert('danger', 'Failed to process your request!');
            }

        }

        $data = [
            'profile'=>$profile,
            'employment'=>$employment ?? null,
            'msg'=>$msg ?? null,
        ];
        echo $this->view->render('admin/employee/edit_employment.php', 'text/html', $data);
    }

    public function employeeEditContactInfo($f3){
        $id = $f3->get('PARAMS.id'); //employee.id

        $profile = $this->db->get('employee','*', ['id'=>$id]);
        $contactinfo = $this->db->get('contactinfo', '*', ['employee'=>$id]);

        if(!$profile){die('ERROR!');}

        if($f3->get('VERB') == 'POST'){
            
            $post_data = [
                'email'=> sanitize_lower(request_post('email')),
                'contact_number'=> sanitize_lower(request_post('contact_number')),
                'current_address'=> sanitize(request_post('current_address')),
                'home_address'=> sanitize(request_post('home_address')),
                'contact_person'=> sanitize(request_post('contact_person')),
                'contact_person_number'=> sanitize(request_post('contact_person_number')),
                'contact_person_relation'=> sanitize(request_post('contact_person_relation')),
                'contact_person_address'=> sanitize_lower(request_post('contact_person_address')),
            ];
            
            if($contactinfo){
                //update
                $post_data['updated_at'] = current_datetime();
                $save = $this->db->update('contactinfo', $post_data, ['id'=>$contactinfo['id']]);
                
            }else{
                //insert
                $post_data['created_at'] = current_datetime();
                $post_data['employee'] = $id;
                $save = $this->db->insert('contactinfo', $post_data);
            }
            
            if($save){
                flash_set('msg', alert('success', 'Changes was saved!'));
                $f3->reroute(BASE_URL.'admin/employee/editcontactinfo/'.$id);
                exit('redirecting...');
            }else{
                $msg = alert('danger', 'Error saving!');
            }

        }

        $data = [
            'profile'=>$profile,
            'contactinfo'=>$contactinfo ?? null,
            'msg'=>$msg ?? null,
        ];
        echo $this->view->render('admin/employee/edit_contactinfo.php', 'text/html', $data);
    }

    public function employeeEditLogin($f3){
        $id = $f3->get('PARAMS.id'); //employee.id

        $profile = $this->db->get('employee', '*', ['id'=>$id]);

        $this->validate->rule('required', 'username')->rule('lengthMin', 'username', 4)->label('Username');
        $this->validate->rule('required', 'your_password')->label('Your password');

        if(!$profile){die('ERROR!');}

        if($f3->get('VERB')=='POST'){
            if(!empty(request_post('password'))){
                $this->validate->rule('required', 'password')->rule('lengthMin', 'password', 4)->label('Password');
            }
            
            if($this->validate->validate()){
                $your_password = jhash(request_post('your_password'));
                $current_user_password = $this->currentUser('password');
                $password = request_post('password');
                $post_data['username'] = sanitize(request_post('username'));
                
                //check password for current user
                if($current_user_password == $your_password){
                    if(!empty($password)){
                        $post_data['password'] = jhash($password);
                    }
                    //check if username exists
                    $find_username = $this->db->has('employee', [
                        'AND'=>[
                            'username' => $post_data['username'],
                            'id[!]' => $id,
                        ]
                    ]);
                    if($find_username){
                        $msg = alert('danger', 'Username already taken!');
                    }else{
                        //update record
                        $post_data['updated_at'] = current_datetime();
                        $save = $this->db->update('employee', $post_data, ['id'=>$id]);
                        if($save){
                            flash_set('msg', alert('success', 'Changes was saved!'));
                            $f3->reroute(BASE_URL.'admin/employee/editlogin/'.$id);
                            exit('redirecting...');
                        }else{
                            $msg = alert('danger', 'Error saving!');
                        }
                    }
                }else{
                    $msg = alert('danger', 'Your password is wrong!');
                }
                
            }else{
                $msg = alert('danger', error_list($this->validate->errors()));
            }
        }

        $data = [
            'profile'=>$profile,
            'msg'=>$msg ?? null,
        ];
        echo $this->view->render('admin/employee/edit_login.php', 'text/html', $data);
    }

    public function leave($f3){
        $leaves = $this->db->select('leave', 
            array('[>]employee'=>['employee'=>'id']),
            array(
                'employee.first_name', 'employee.last_name',
                'leave.employee', 'leave.approve', 'leave.chosen_date', 'leave.leave_type', 'leave.reason',
                'leave.id',
            ),array('ORDER'=>['chosen_date'=>'DESC']));
        $dd = [
            'leaves'=>$leaves
        ];
        echo $this->view->render('admin/leave.php', 'text/html', $dd);
    }

    public function leaveView($f3){
        $id = $f3->get('PARAMS.id'); //leave.id
        $leave = $this->db->get('leave', '*', ['id'=>$id]);
        if($leave){
            $employee = $this->db->get('employee', ['id','emp_id','first_name','middle_name','last_name'],
                    ['id'=>$leave['employee']]
                );
            $dd=[
                'leave'=>$leave,
                'employee'=>$employee,
            ];
            echo $this->view->render('admin/leave_view.php', 'text/html', $dd);
        }else{
            echo 'ERROR! <a href="'.BASE_URL.'admin/leave">go back</a>';
            exit();
        }
    }

    public function leaveApprove($f3){
        $id = $f3->get('PARAMS.id'); //leave.id
        $confirm = $f3->get('PARAMS.confirm'); //yes or no

        $leave = $this->db->get('leave', '*', ['id'=>$id]);
        $confirm_choice = ['yes', 'no'];
        if(!in_array($confirm, $confirm_choice)){ // check if the confirm is only yes or no
            exit('ERROR!');
        }
        if($leave){
            if($leave['approve'] == 'pending'){
                $update = $this->db->update('leave',[
                    'approve'=>$confirm,
                    'updated_at'=>current_datetime(),
                ],['id'=>$id]);
                if($update){
                    $msg = alert('success', 'Changes was saved!');
                }else{
                    $msg = alert('danger', 'Error processing your request!');
                }
            }
            flash_set('msg', $msg);
            $f3->reroute(BASE_URL.'admin/leave/view/'.$id);
            exit();
        }else{
            $msg = alert('danger', 'ERROR!');
            flash_set('msg', $msg);
            $f3->reroute(BASE_URL.'admin/leave');
            exit();
        }
    }

    public function livestat($f3){
        echo $this->view->render('admin/livestat.php');
    }


}