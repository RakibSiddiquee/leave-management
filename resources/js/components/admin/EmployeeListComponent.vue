<template>
    <div>
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Employee</h1>

            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Employee</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">List of Employee</h3>
                            <div v-if="successMsg" class="alert alert-success alert-dismissable fade in custom-alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> {{ successMsg }}
                            </div>
                            <!--<a class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#deptModal" @click="showEmployeeModal"><i class="fa fa-plus"></i></a>-->
                            <a class="btn btn-primary btn-sm pull-right" @click="showEmployeeModal"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- /.box-header -->
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(employee,index) in employees" :key="employee.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ employee.name }}</td>
                                <td>{{ employee.username }}</td>
                                <td>{{ employee.email }}</td>
                                <td>{{ employee.address }}</td>
                                <td>
                                    <a class="btn btn-xs" :class="employee.status?'btn-success':'btn-danger'" @click="statusChange(employee.id, employee.status)" :title="employee.status?'Inactive the employee':'Activate the employee'">
                                        <i class="fa" :class="employee.status?'fa-check':'fa-times'"></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-warning btn-xs" @click="editEmployee(employee.id)">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-warning btn-xs" @click="getChangePassword(employee.id)">
                                        <i class="fa fa-lock"></i>
                                    </a>
                                    <a class="btn btn-danger btn-xs" @click="deleteEmployee(employee.id)">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Add Employee modal -->
            <div class="modal fade" :class="{ 'in show': showModal }" id="deptModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="showModal=false">&times;</button>
                            <h4 class="modal-title">Add Employee</h4>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="onSubmit" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Name <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" v-model="name" class="form-control" id="name" placeholder="Employee Name">
                                        <span v-if="errors.length && errors[0].name" class="text-danger">{{ errors[0].name[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="designation" class="col-sm-3 control-label">Designation <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="designation" v-model="designation" class="form-control" id="designation">
                                            <option value="">--Choose designation--</option>
                                            <option v-for="designation in designations" :value="designation.id" :key="designation.id">{{ designation.desg_name }}</option>
                                        </select>
                                        <span v-if="errors.length && errors[0].designation" class="text-danger">{{ errors[0].designation[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="department" class="col-sm-3 control-label">Department <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="department" v-model="department" class="form-control" id="department">
                                            <option value="">--Choose department--</option>
                                            <option v-for="department in departments" :value="department.id" :key="department.id"">{{ department.dept_name }}</option>
                                        </select>
                                        <span v-if="errors.length && errors[0].department" class="text-danger">{{ errors[0].department[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="username" class="col-sm-3 control-label">Username <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="username" v-model="username" class="form-control" id="username" placeholder="Employee Username">
                                        <span v-if="errors.length && errors[0].username" class="text-danger">{{ errors[0].username[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="contactNumber" class="col-sm-3 control-label">Contact Number <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="contactNumber" v-model="contactNumber" class="form-control" id="contactNumber" placeholder="Employee Contact Number">
                                        <span v-if="errors.length && errors[0].contactNumber" class="text-danger">{{ errors[0].contactNumber[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">Email <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="email" name="email" v-model="email" class="form-control" id="email" placeholder="Employee email">
                                        <span v-if="errors.length && errors[0].email" class="text-danger">{{ errors[0].email[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group" v-if="!updateBtn">
                                    <label for="password" class="col-sm-3 control-label">Password <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="password" name="password" v-model="password" class="form-control" id="password" placeholder="Password">
                                        <span v-if="errors.length && errors[0].password" class="text-danger">{{ errors[0].password[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group" v-if="!updateBtn">
                                    <label for="confirm_password" class="col-sm-3 control-label">Confirm Password <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="password" name="password_confirmation" v-model="password_confirmation" class="form-control" id="confirm_password" placeholder="Confirm Password">
                                        <span v-if="errors.length && errors[0].confirm_password" class="text-danger">{{ errors[0].confirm_password[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address" class="col-sm-3 control-label">Address</label>
                                    <div class="col-sm-8">
                                        <textarea name="address" v-model="address" id="address" class="form-control" placeholder="Employee Address"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-8">
                                        <button type="button" v-if="updateBtn" @click="updateEmployee(id)" class="btn btn-info" data-dismiss="modal">Update</button>
                                        <button type="button" v-else @click="addEmployee()" class="btn btn-info"  data-dismiss="modal">Submit</button>
                                        <button type="reset" class="btn btn-default">Clear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" @click="showModal=false">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Admin Password Change modal -->
            <div class="modal fade" :class="{ 'in show': changePasswordModal }" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="changePasswordModal=false">&times;</button>
                            <h4 class="modal-title">Password Change</h4>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="onSubmit" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">New Password <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="password" v-model="newPassword" class="form-control" placeholder="Password">
                                        <span v-if="errors.length && errors[0].newPassword" class="text-danger">{{ errors[0].newPassword[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Confirm Password <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="password" v-model="confirmPassword" class="form-control" placeholder="Confirm Password">
                                        <span v-if="errors.length && errors[0].confirmPassword" class="text-danger">{{ errors[0].confirmPassword[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-8">
                                        <button type="button" @click="changePassword(id)" class="btn btn-info" data-dismiss="modal">Update</button>
                                        <button type="reset" class="btn btn-default">Clear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" @click="changePasswordModal=false">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    <!-- /.content -->
    </div>
</template>

<script>
    export default {

        props: ['desgs', 'depts', 'empls'],

        data(){
            return {
                designations: this.desgs,
                departments: this.depts,
                employees: this.empls,
                showModal: false,
                changePasswordModal: false,
                id: '',
                errors: [],
                successMsg: '',
                updateBtn: false,
                name: '',
                designation: '',
                department: '',
                username: '',
                contactNumber: '',
                email: '',
                password: '',
                password_confirmation: '',
                address: '',
                status: '',
                newPassword: '',
                confirmPassword: '',

            }
        },

        methods: {

            showEmployeeModal(){
                this.showModal=true;
                this.updateBtn = false;
                this.errors = [];
                this.successMsg = '';
                this.name = this.designation = this.department = this.username = this.contactNumber = this.email = this.password = this.password_confirmation = this.address = this.status = '';
            },

            addEmployee(){
                axios.post(process.env.MIX_APP_URL+'admin/employees',{
                    name: this.name,
                    designation: this.designation,
                    department: this.department,
                    username: this.username,
                    contactNumber: this.contactNumber,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    address: this.address,
                    status: this.status,
                }).then(response => {
                    this.showModal=false;
                    this.employees.push(response.data);
                    this.name = this.designation = this.department = this.username = this.email = this.password = this.password_confirmation = this.address = this.status = '';
                    this.successMsg = 'Employee has been added successfully!';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors = [];
                        this.errors.push(e.response.data.errors);
                    }
                });

            },

            statusChange(id,status){
                if (confirm("Do you want to "+(status==1?'Inactive':'active')+" the employee?")) {
                    axios.post(process.env.MIX_APP_URL + 'admin/employees/change-status', {
                        id: id,
                        status: status,
                    }).then(response => {
                        this.$set(this.employees, this.employees.indexOf(this.employees.filter(function (item) {
                            return item.id == id;
                        })[0]), response.data);
//                    console.log(response);
                        this.successMsg = 'Employee status has been changed successfully!';
                    }).catch(e => {
                        if (e.response.status == 422) {
                            console.log(e);
                        }
                    });
                }
            },

            // Show change password form
            getChangePassword(id){
                this.id = '';
                this.id = id;
                this.errors = [];
                this.changePasswordModal = true;
            },

            // Update password method
            changePassword(id){
                axios.post(process.env.MIX_APP_URL+'admin/employees/change-password',{
                    id: id,
                    newPassword: this.newPassword,
                    confirmPassword: this.confirmPassword
                }).then(response => {
                    this.changePasswordModal=false;
                    this.successMsg = 'Employee password has been changed successfully!';
                    this.id = this.newPassword = this.confirmPassword = '';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors = [];
                        this.errors.push(e.response.data.errors);
                    }
                });
            },

            editEmployee(id){
                axios.get(process.env.MIX_APP_URL+'admin/employees/'+id+'/edit').then(response => {
                    this.showModal = true;
                    this.updateBtn = true;
                    this.errors = [];
                    this.successMsg = '';
                    this.id = response.data.id;
                    this.name = response.data.name;
                    this.designation = response.data.desg_id;
                    this.department = response.data.dept_id;
                    this.username = response.data.username;
                    this.contactNumber = response.data.phone;
                    this.email = response.data.email;
                    this.address = response.data.address;
                }).catch(error => {
                    console.error(error)
                });
            },

            updateEmployee(id){
                axios.put(process.env.MIX_APP_URL+'admin/employees/'+id,{
                    name: this.name,
                    designation: this.designation,
                    department: this.department,
                    username: this.username,
                    contactNumber: this.contactNumber,
                    email: this.email,
                    address: this.address,
                    status: this.status,
                }).then(response => {
                    this.showModal=false;
                    this.$set(this.employees, this.employees.indexOf(this.employees.filter(function (item) {
                        return item.id == id;
                    })[0]), response.data);
                    this.name = this.designation = this.department = this.username = this.contactNumber = this.email = this.password = this.password_confirmation = this.address = this.status = '';
                    this.successMsg = 'Employee has been updated successfully!';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors = [];
                        this.errors.push(e.response.data.errors);
                    }
                });
            },

            deleteEmployee(id){
                if (confirm("Do you want to delete the employee?")){
                    axios.delete(process.env.MIX_APP_URL+'admin/employees/'+id).then(response => {
                        if (response.status == 200){
                            this.$delete(this.employees, this.employees.indexOf(this.employees.filter(function (item) {
                                return item.id == id;
                            })[0]));
                            this.successMsg = 'Employee has been deleted successfully!';

                        }
                    }).catch(error => {
                        console.log(error);
                    });
                }

            }

        },


        mounted(){
            console.log('Employee mounted!', process.env.MIX_APP_URL);
        }
    }
</script>
