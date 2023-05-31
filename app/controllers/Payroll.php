<?php

class Payroll extends BaseController {

    function __construct(){
        parent::__construct();
        $this->secure();
        $this->secureAdmin();
    }

    public function entry($f3){
        $entry = $this->db->select('payroll_entry', '*', [
            'ORDER'=>[
                'payment_date'=>'DESC'
            ]
        ]);

        $data = [
            'entry'=>$entry,
        ];

        echo $this->view->render('payroll/entry.php', 'text/html', $data);
    }

    public function entryAdd($f3){
        if($f3->get('VERB') == 'POST'){
            $this->validate->rule('required', 'payment_date')->label('Payment Date');
            $this->validate->rule('required', 'date_from')->label('From Date');
            $this->validate->rule('required', 'date_to')->label('To Date');
            if($this->validate->validate()){
                $data = [
                    'payment_date' => request_post('payment_date'),
                    'date_from' => request_post('date_from'),
                    'date_to' => request_post('date_to'),
                    'created_at' => current_datetime(),
                    'updated_at' => current_datetime(),
                ];

                if($data['date_from'] > $data['date_to']){
                    $msg = alert('danger', 'From Date should not be greater than To Date');
                }else{
                    //check payment date if it existing
                    $find_pament_date = $this->db->count('payroll_entry', ['payment_date'=>$data['payment_date']]);
                    if($find_pament_date > 0){
                        $msg = alert('danger', 'Payment date already existing');
                    }else{
                        //add
                        $add = $this->db->insert('payroll_entry', $data);
                        if($add){
                            flash_set('msg', alert('success','New payroll entry was added!'));
                            $f3->reroute(base_url('payroll'));
                        }else{
                            $msg = alert('danger', 'Failed to process your request! please check database.');
                        }
                    }
                }
                
            }else{
                $msg = alert('danger', error_list($this->validate->errors()) );
            }
        }
        $dd = [
            'msg' => $msg ?? null,
        ];
        echo $this->view->render('payroll/entry_add.php', 'text/html', $dd);
    }

    public function entryView($f3){
        $id = $f3->get('PARAMS.id');
        $entry = $this->db->get('payroll_entry', '*', ['id'=>$id]);

        if($entry){
            $dd=[
                'entry'=>$entry,
                'msg'=>$msg ?? null,
            ];
            echo $this->view->render('payroll/entry_view.php', 'text/html', $dd);
        }else{
            http_response_code('404');
        }
    }

}