<?php

class Portal extends BaseController {

    function __construct(){
        parent::__construct();
        $this->secure();
    }

    public function index($f3){
        $user = $this->currentUser('id'); //employee.id
        $breaks = [];

        $timelog = $this->db->get('timesheet', '*', [
            'AND'=>['employee'=>$user, ],
            'ORDER'=>['id'=>'DESC']
        ]);

        if($timelog){
            $breaks = $this->db->select('breaks', '*', [
                'timesheet'=>$timelog['id'],
            ]);
        }

        $data = [
            'timelog'=>$timelog,
            'breaks'=>$breaks,
        ];
        echo $this->view->render('portal/home2.php', 'text/html', $data);
    }

    public function profile($f3){
        $uid = session('user');

        $profile = $this->db->get('employee', '*', ['id'=>$uid]);
        $contactinfo = $this->db->get('contactinfo', '*', ['employee'=>$uid]);
        $government = $this->db->get('government', '*', ['employee'=>$uid]);
        $employment = $this->db->get('employment', '*', ['employee'=>$uid]);

        $data=[
            'profile'=>$profile,
            'contactinfo'=>$contactinfo,
            'government'=>$government,
            'employment'=>$employment,
        ];

        echo $this->view->render('portal/profile.php', 'text/html', $data);
    }

    public function leave($f3){
        $user =$this->currentUser('id'); //employee.id
        $leaves = $this->db->select('leave', '*', [
            'employee'=>$user,
            'ORDER'=>['chosen_date'=>'DESC']
        ]);
        $this_year = date('Y');
        $leave_credit_total = 5;
        $leave_plotted = $this->db->count('leave', [
            'AND'=>[
                'employee'=>$user,
                'approve'=>'yes',
                'chosen_date[~]'=>$this_year
            ]
        ]);

        $dd = [
            'leaves' => $leaves,
            'leave_credit_total' => $leave_credit_total,
            'leave_plotted' => $leave_plotted,
        ];
        echo $this->view->render('portal/leave.php', 'text/html', $dd);
    }

    public function leavePlot($f3){
        echo $this->view->render('portal/leave_plot.php');
    }

    public function leaveCancel($f3){
        $id = $f3->get('PARAMS.leave_id');
        $employee = $this->currentUser('id'); //employee.id
        $delete_leave = $this->db->delete('leave',[
            'AND'=>[
                'employee'=>$employee,
                'id'=>$id,
                'approve'=>'pending',
            ]
        ]);
        if($delete_leave){
            flash_set('msg', alert('success', 'Leave record was cancelled'));
            $f3->reroute(BASE_URL.'portal/leave');
            exit();
        }else{
            echo 'ERROR! <a href="'.BASE_URL.'portal/leave'.'">go back</a>';
            exit();
        }
    }

    public function timesheet($f3){
        echo $this->view->render('portal/timesheet.php');
    }

    public function timelog($f3){
        $user = $this->currentUser('id');
        $timelog = $this->db->get('timesheet', '*', [
            'employee'=>$user,
            'ORDER'=>[
                'id'=>'DESC'
            ]
        ]);

        $last_status = $timelog['status'] ?? 'out';

        //$punch_status = qstr('val');
        $punch_status = $f3->get('PARAMS.val');

        $remote_address = $_SERVER['REMOTE_ADDR'];

        //check if there are break
        $breaks = $this->db->count('breaks', [
            'AND'=>[
                'timesheet'=>$timelog['id'],
                'status'=>'start',
            ]]);
        if($breaks > 0){
            flash_set('msg', alert('danger', 'You have active breaks! Please stop current break.'));
            $f3->reroute(BASE_URL);
            exit();    
        }

        //check sync

        if($punch_status == 'in'){
            if($last_status == 'out'){
                $user_rate = $this->currentUser('rate');
                $tdata = [
                    'employee' => $user,
                    'punch_date' => current_date(),
                    'datetime_in' => current_datetime(),
                    'status' => 'in',
                    'ip_address' => $remote_address,
                    'created_at' => current_datetime(),
                    'updated_at' => current_datetime(),
                    'rate' => $user_rate,
                ];
                $logtime = $this->db->insert('timesheet', $tdata);
                if($logtime){
                    flash_set('msg', alert('success', 'Time IN at '.$tdata['datetime_in']));
                    $f3->reroute(BASE_URL);
                    exit();
                }else{
                flash_set('msg', alert('danger', 'Error saving!'));
                    $f3->reroute(BASE_URL);
                    exit();
                }
            }else{
                flash_set('msg', alert('danger', 'Error!'));
                $f3->reroute(BASE_URL);
                exit();
            }
        }


        if($punch_status == 'out'){
            if($last_status == 'in'){//update the record
            
                $last_record_id = $timelog['id'];
                $last_datetime_in = strtotime($timelog['datetime_in']);
                $datetime_out = current_datetime();
                
                //calculate number of hours passed
                $time_diff = strtotime($datetime_out) - $last_datetime_in;
                $hours = $time_diff / (60 * 60);
                $paid_hours = 8;
                if($hours < 8){
                    $paid_hours = $hours;
                }
                $user_rate = $this->currentUser('rate');
                $pay_calculation = round($paid_hours * $user_rate, 2);
                
                $tdata = [
                    'datetime_out'=>$datetime_out,
                    'hours' => round($hours ,2),
                    'time_diff' => $time_diff,
                    'status' => 'out',
                    'pay_calculation' => $pay_calculation,
                    'paid_hours' => $paid_hours,
                    'updated_at' => current_datetime(),
                ];
                
                $logtime = $this->db->update('timesheet', $tdata, ['id'=>$last_record_id]);
                if($logtime){
                    flash_set('msg', alert('success', 'Time OUT at '.$tdata['datetime_out']));
                    $f3->reroute(BASE_URL);
                    exit();
                }else{
                    flash_set('msg', alert('danger', 'Error saving!'));
                    $f3->reroute(BASE_URL);
                    exit();
                }
            
            }else{
                flash_set('msg', alert('danger', 'Error!'));
                $f3->reroute(BASE_URL);
                exit();
            }
        }
    }

    public function break($f3){
        //$type = qstr('val');
        //$mode = qstr('mode');
        $type = $f3->get('PARAMS.val');
        $mode = $f3->get('PARAMS.mode');

        $break_list = ['lunch', 'coaching', 'training', 'shortbreak'];
        if(!in_array($type, $break_list)){
            exit('ERROR! <a href="'.base_url().'">back</a>');
        }

        $user = $this->currentUser('id'); // employee.id

        //get the current timesheet log with the status in
        $timesheet = $this->db->get('timesheet', '*', [
            'AND'=>[
                'employee'=>$user,
                'status'=>'in',
            ],
            'ORDER'=>['id'=>'DESC']
        ]);

        if($timesheet){

            //check if there are active break, else dont start break
            $is_there_active = $this->db->count('breaks', [
                'AND'=>[
                    'status'=>'start',
                    'timesheet'=>$timesheet['id'],
                    'employee'=>$user,
                ]
            ]);

            $break = $this->db->get('breaks', '*', [
                'AND'=>[
                    'status'=>'start',
                    'timesheet'=>$timesheet['id'],
                    'employee'=>$user,
                ],
                'ORDER'=>'DESC'
            ]);

            switch($mode){

                //start break
                case 'start':
                    if($is_there_active > 0){
                        flash_set('msg', alert('danger', 'There are active break, please stop to set another break.'));
                        $f3->reroute(BASE_URL);
                    }else{
                        //add break;
                        $datetime_start = current_datetime();
                        $addbreak = $this->db->insert('breaks',[
                            'datetime_start'=> $datetime_start,
                            'name'=>$type,
                            'status'=>'start',
                            'employee'=>$user,
                            'timesheet'=>$timesheet['id'],
                            'created_at'=>current_datetime(),
                            'updated_at'=>current_datetime(),
                        ]);
                        if($addbreak){
                            flash_set('msg', alert('success','Break started at '.$datetime_start));
                            $f3->reroute(BASE_URL);
                            exit();
                        }else{
                            flash_set('msg', alert('danger','Error processing'));
                            $f3->reroute(BASE_URL);
                            exit();
                        }
                    }
                    break;
                
                //stop break
                case 'stop':
                    //end the break
                    $datetime_start = strtotime($break['datetime_start']);
                    $datetime_end = current_datetime();
                    //calculate number of hours passed
                    $time_diff = strtotime($datetime_end) - $datetime_start;
                    $hours = $time_diff / (60 * 60); //convert to hours
                    $hours = round($hours, 2);
                    //update break
                    $update = $this->db->update('breaks', [
                        'datetime_end'=>$datetime_end,
                        'status'=>'end',
                        'hours'=>$hours,
                        'time_diff'=>$time_diff,
                        'updated_at'=>current_datetime(),
                    ],[
                        'AND'=>[
                            'status'=>'start',
                            'timesheet'=>$timesheet['id'],
                        ]
                    ]);
                    if($update){
                        flash_set('msg', alert('success','Break ended'));
                        $f3->reroute(BASE_URL);
                        exit();
                    }else{
                        flash_set('msg', alert('danger','Error processing'));
                        $f3->reroute(BASE_URL);
                        exit();
                    }
                    break;

                default:
                    flash_set('msg', alert('danger', 'No action detected!'));
                    $f3->reroute(BASE_URL);
                    break;

            }

        }else{
            flash_set('msg', alert('danger', 'Error, you are not time-in.'));
            $f3->reroute(BASE_URL);
            exit();
        }
    }

}