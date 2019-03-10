<template>
    <div>
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Admin</h1>

            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Admin</li>
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
                            <h3 class="box-title">List of Admin</h3>
                            <div v-if="successMsg" class="alert alert-success alert-dismissable fade in custom-alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> {{ successMsg }}
                            </div>
                            <!--<a class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#deptModal" @click="showAdminModal"><i class="fa fa-plus"></i></a>-->
                            <a class="btn btn-primary btn-sm pull-right" @click="showAdminModal"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- /.box-header -->
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(admin,index) in admins" :key="admin.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ admin.name }}</td>
                                <td>{{ admin.username }}</td>
                                <td>{{ admin.role == 1 ? 'System Admin' : 'Manager' }}</td>
                                <td>{{ admin.email }}</td>
                                <td>{{ admin.address }}</td>
                                <td>
                                    <a class="btn btn-xs" :class="admin.status?'btn-success':'btn-danger'" @click="statusChange(admin.id, admin.status)" :title="admin.status?'Inactive the user':'Activate the user'">
                                        <i class="fa" :class="admin.status?'fa-check':'fa-times'"></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-warning btn-xs" @click="editAdmin(admin.id)" title="Edit the user">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <a class="btn btn-danger btn-xs" @click="deleteAdmin(admin.id)" title="Delete the user">
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

            <!-- Add Admin modal -->
            <div class="modal fade" :class="{ 'in show': showModal }" id="deptModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="showModal=false">&times;</button>
                            <h4 class="modal-title">Add Admin</h4>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="onSubmit" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Name <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" v-model="name" class="form-control" id="name" placeholder="Admin Name">
                                        <span v-if="errors.length && errors[0].name" class="text-danger">{{ errors[0].name[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="username" class="col-sm-3 control-label">Username <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="username" v-model="username" class="form-control" id="username" placeholder="Admin Username">
                                        <span v-if="errors.length && errors[0].username" class="text-danger">{{ errors[0].username[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="role" class="col-sm-3 control-label">Role <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="role" v-model="role" class="form-control" id="role">
                                            <option value="">Choose Role</option>
                                            <option value="1">System Admin</option>
                                            <option value="2">Manager</option>
                                        </select>
                                        <span v-if="errors.length && errors[0].role" class="text-danger">{{ errors[0].role[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">Email <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="email" name="email" v-model="email" class="form-control" id="email" placeholder="Admin email">
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
                                        <textarea name="address" v-model="address" id="address" class="form-control" placeholder="Admin Address"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-8">
                                        <button type="button" v-if="updateBtn" @click="updateAdmin(id)" class="btn btn-info" data-dismiss="modal">Update</button>
                                        <button type="button" v-else @click="addAdmin()" class="btn btn-info"  data-dismiss="modal">Submit</button>
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

        </section>

    <!-- /.content -->
    </div>
</template>

<script>
    export default {

        props: ['admns'],

        data(){
            return {
                admins: this.admns,
                showModal: false,
                id: '',
                errors: [],
                successMsg: '',
                updateBtn: false,
                name: '',
                username: '',
                role: '',
                email: '',
                password: '',
                password_confirmation: '',
                address: '',
                status: '',

            }
        },

        methods: {

            showAdminModal(){
                this.showModal=true;
                this.updateBtn = false;
                this.errors = [];
                this.successMsg = '';
                this.name = this.username = this.role = this.email = this.password = this.password_confirmation = this.address = this.status = '';
            },

            addAdmin(){
                axios.post(process.env.MIX_APP_URL+'admin/admins',{
                    name: this.name,
                    username: this.username,
                    role: this.role,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    address: this.address,
                    status: this.status,
                }).then(response => {
                    this.showModal=false;
                    this.admins.push(response.data);
                    this.name = this.username = this.role = this.email = this.password = this.password_confirmation = this.address = this.status = '';
                    this.successMsg = 'Admin has been added successfully!';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors = [];
                        this.errors.push(e.response.data.errors);
                    }
                });

            },

            statusChange(id,status){
                if (confirm("Do you want to "+(status==1?'Inactive':'active')+" the admin?")) {
                    axios.post(process.env.MIX_APP_URL + 'admin/admins/change-status', {
                        id: id,
                        status: status,
                    }).then(response => {
                        this.$set(this.admins, this.admins.indexOf(this.admins.filter(function (item) {
                            return item.id == id;
                        })[0]), response.data);
//                    console.log(response);
                        this.successMsg = 'Admin status has been changed successfully!';
                    }).catch(e => {
                        if (e.response.status == 422) {
                            console.log(e);
                        }
                    });
                }
            },

            editAdmin(id){
                axios.get(process.env.MIX_APP_URL+'admin/admins/'+id+'/edit').then(response => {
                    this.showModal = true;
                    this.updateBtn = true;
                    this.errors = [];
                    this.successMsg = '';
                    this.id = response.data.id;
                    this.name = response.data.name;
                    this.username = response.data.username;
                    this.role = response.data.role;
                    this.email = response.data.email;
                    this.address = response.data.address;
                }).catch(error => {
                    console.error(error)
                });
            },

            updateAdmin(id){
                axios.put(process.env.MIX_APP_URL+'admin/admins/'+id,{
                    name: this.name,
                    username: this.username,
                    role: this.role,
                    email: this.email,
                    address: this.address,
                }).then(response => {
                    this.showModal=false;
                    this.$set(this.admins, this.admins.indexOf(this.admins.filter(function (item) {
                        return item.id == id;
                    })[0]), response.data);
                    this.name = this.username = this.role = this.email = this.password = this.password_confirmation = this.address = this.status = '';
                    this.successMsg = 'Admin has been updated successfully!';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors.push(e.response.data.errors);
                    }
                });
            },

            deleteAdmin(id){
                if (confirm("Do you want to delete the admin?")){
                    axios.delete(process.env.MIX_APP_URL+'admin/admins/'+id).then(response => {
                        if (response.status == 200){
                            this.$delete(this.admins, this.admins.indexOf(this.admins.filter(function (item) {
                                return item.id == id;
                            })[0]));
                            this.successMsg = 'Admin has been deleted successfully!';

                        }
                    }).catch(error => {
                        console.log(error);
                    });
                }

            }

        },


        mounted(){
            console.log('Admin mounted!', process.env.MIX_APP_URL);
        }
    }
</script>
