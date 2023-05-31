<?php


class Component extends BaseController {

    function construct(){
        parent::_construct();
        $this->secure();
    }


    public function livestat($f3){
        $this->secureAdmin();
        $records = [];
        $employees = $this->db->select('employee', '*', [
            'status'=>'active',
            'ORDER'=>'last_name'
        ]);

        foreach($employees as $emp){
            //get the timesheet record
            $timesheet = $this->db->get('timesheet', '*',[
                'employee'=>$emp['id'],
                'ORDER'=>['id'=>'DESC'],
            ]);
            //get the breaks record
            $break = $this->db->get('breaks', '*', [
                'AND'=>[
                    'employee'=>$emp['id'],
                    'status'=>'start',
                ],
                'ORDER'=>['id'=>'DESC']
            ]);

            $rec = [
                'employee'=>$emp,
                'timesheet'=>$timesheet,
                'break'=>$break,
            ];
            array_push($records, $rec);
        }

        $dd = [
            'records' => $records,
        ];
        echo $this->view->render('component/livestat.php', 'text/plain', $dd);
    }


    public function payrollEntryGenerated($f3){
        $id = $f3->get('PARAMS.id');
        $entry = $this->db->get('payroll_entry', '*', ['id'=>$id]);
        if($entry){
            $dd = ['entry'=>$entry];
            echo $this->view->render('component/payroll_entry_generated.php', 'text/plain', $dd);
        }else{
            http_response_code('404');
        }
    }

}