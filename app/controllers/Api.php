<?php


class Api extends BaseController {

    function construct(){
        parent::_construct();
        $this->secure();
    }


    public function timesheets($f3){
        $uid = session('user');
        $timelog = $this->db->select('timesheet', '*', [
            'AND'=>[
                'employee'=>$uid,
            ],
            'LIMIT'=>10,
            'ORDER'=>[
                    'id'=>'DESC',
                ],
        ]);

        if(request_method() == 'POST'){
            $month=request_post('month');
            $timelog = $this->db->select('timesheet', '*', [
                'AND'=>[
                    'employee'=>$uid,
                    'punch_date[~]'=>$month,
                ],
                'ORDER'=>['id'=>'DESC'],
            ]);
        }

        $context=[
            'timelog'=>$timelog
        ];
        echo $this->view->render('component/timesheets.php', 'text/html', $context);
    }


    public function breaks($f3){
        $uid = session('user');
        $timesheet = $f3->get('PARAMS.timesheet_id');

        $breaks = $this->db->select('breaks', '*', [
            'AND'=>[
                'employee'=>$uid,
                'timesheet'=>$timesheet,
            ]
        ]);

        $context=[
            'breaks'=>$breaks
        ];
        echo $this->view->render('component/breaks.php', 'plain/text', $context);
    }


    public function leavePlot($f3){
        $user = $this->currentUser('id'); //employee.id

        $this->validate->rule('required', 'plot_date')->label('Plot date');
        $this->validate->rule('required', 'reason')->label('Reason');
        $this->validate->rule('required', 'leave_type')->label('Type');


        if($f3->get('VERB') == 'POST'){
            if($this->validate->validate()){

                $this_year = date('Y');
                $leave_credit_total = 5; //total leave credit in a year
                $leave_plotted = $this->db->count('leave', [
                    'AND'=>[
                        'employee'=>$user,
                        'approve'=>'yes',
                        'chosen_date[~]'=>$this_year,
                    ]
                ]);
                if($leave_plotted < $leave_credit_total){

                    $plot_date = request_post('plot_date');
                    $reason = sanitize(request_post('reason'));
                    $leave_type = sanitize(request_post('leave_type'));
                    $find_date = $this->db->has('leave', [
                        'AND'=>[
                            'chosen_date'=>$plot_date,
                            'employee'=>$user,
                        ]
                    ]);
                    if($find_date){
                        $msg = alert('danger', 'Chosen date is already in the record!');
                    }else{
                        $data=[
                            'chosen_date' => $plot_date,
                            'approve' => 'pending',
                            'reason' => $reason,
                            'leave_type' => $leave_type,
                            'employee' => $user,
                            'created_at'=>current_datetime(),
                            'updated_at'=>current_datetime(),
                        ];
                        $plot = $this->db->insert('leave', $data);
                        if($plot){
                            $msg = '<div class="border p-3">Plot date: '.$plot_date.'<br/> Reason: '.$reason.'</div>';
                        }else{
                            $msg = alert('danger', 'Fail to plot leave!');
                        }
                    }
                }else{
                    $msg = alert('danger', 'Leave creadit already reach its limit.');
                }
            }else{
                $msg = alert('danger', error_list($this->validate->errors()));
            }

            echo $msg ?? null;
        }else{
            http_response_code(403);
            exit();
        }
    }

    public function payrollEntryGenerate($f3){
        $id = $f3->get('PARAMS.id');
        $entry = $this->db->get('payroll_entry', '*', ['id'=>$id]);
        if($entry){
            $date_from = $entry['date_from'];
            $date_to = $entry['date_to'];

            //select active employee
            $employee = $this->db->select('employee', ['id', 'emp_id', 'first_name', 'last_name'], ['status'=>'active']);
            $data = []; //prepare data for json
            foreach($employee as $emp){
                $gross_pay = $this->db->sum('timesheet', 'pay_calculation', 
                    [
                        'AND'=>[
                            'employee'=>$emp['id'],
                            'punch_date[<=]'=>$date_to,
                            'punch_date[>=]'=>$date_from,
                        ]
                    
                    ]);
                $timesheet = $this->db->select('timesheet', '*', [
                    'AND'=>[
                            'employee'=>$emp['id'],
                            'punch_date[<=]'=>$date_to,
                            'punch_date[>=]'=>$date_from,
                        ]
                ]);
                $record = [
                    'employee'=>$emp,
                    'gross_pay'=>$gross_pay,
                    'timesheet'=>$timesheet,
                ];
                array_push($data, $record);
            }

            //save to database
            $generate_save = $this->db->update('payroll_entry', ['json_data'=>json_encode($data)], ['id'=>$id]);

            print_r($data);

        }else{
            die('ERROR ID not found!');
        }
    }

}