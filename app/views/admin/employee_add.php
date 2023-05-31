<?php echo $this->render('blocks/header_admin.php'); ?>

<main>

<div class="p-1 bg-dark text-light text-center">
    Employee - ADD
</div>

<?php echo $this->render('blocks/employee_nav.php'); ?>

<div class="container py-3">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="">
                <form method="post" id="form-add-employee" x-data="formAddEmployee()">
                    <div x-text="msg" x-show="show_msg"></div>
                    <input type="hidden" name="csrf" x-model="fdata.csrf">
                    <div>
                        <label>Employee ID</label>
                        <input type="text" name="employee_id" x-model="fdata.employee_id" class="form-control">
                    </div>
                    <div class="mt-3">
                        <label>First Name</label>
                        <input type="text" name="first_name" x-model="fdata.first_name" class="form-control">
                    </div>
                    <div class="mt-3">
                        <label>Middle Name</label>
                        <input type="text" name="middle_name" x-model="fdata.middle_name" class="form-control">
                    </div>
                    <div class="mt-3">
                        <label>Last Name</label>
                        <input type="text" name="last_name" x-model="fdata.last_name" class="form-control">
                    </div>
                    
                    <h5 class="mt-4">Login Credentials</h5>
                    <div class="mt-3">
                        <label>Usernarme</label>
                        <input type="text" name="username" x-model="fdata.username" class="form-control">
                    </div>
                    <div class="mt-3">
                        <label>Password</label>
                        <input type="text" name="password" x-model="fdata.password" class="form-control">
                    </div>
                    <div class="mt-3 text-end">
                        <button type="button" x-on:click="goAdd()" class="btn btn-success px-5">Save</button>
                    </div>
                </form>
      
            </div>
        </div>
    </div>

</div>

</main>

<script>
    let csrf = '<?=csrf_hash();?>';
    function formAddEmployee(){
        return {
            fdata:{
                csrf:csrf,
                first_name:'',
                middle_name:'',
                last_name:'',
                username:'',
                password:''
            },
            msg: null,
            show_msg: false,
            async goAdd(){
                //let add_employee = await $.post('/api/employee/add', this.fdata); 
                let form_data = new FormData();
                for(let [key, val] of Object.entries(this.fdata)){
                    form_data.append(key, val);
                }
                let post_data = await fetch('/api/employee/add', {
                    method: 'POST',
                    body: form_data,
                }).then(function(data){
                    if(data.status == 200){
                        return data.json();
                    }else{
                        return false;
                    }
                });
                //let resp = await post_data.json();
                if(post_data !== false){
                    this.msg = post_data.msg;
                    this.show_msg = true;
                }else{
                    this.msg = 'Something went wrong!';
                    this.show_msg = true;
                }
                
            }
        };
    }
</script>

<?php echo $this->render('blocks/footer.php'); ?>