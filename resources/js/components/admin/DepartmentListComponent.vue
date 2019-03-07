<template>
    <div>
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Department</h1>

            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Department</li>
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
                            <h3 class="box-title">List of Department</h3>
                            <div v-if="successMsg" class="alert alert-success alert-dismissable fade in custom-alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> {{ successMsg }}
                            </div>
                            <!--<a class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#deptModal" @click="showDeptModal"><i class="fa fa-plus"></i></a>-->
                            <a class="btn btn-primary btn-sm pull-right" @click="showDeptModal"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- /.box-header -->
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Department Name</th>
                                <th>Department Description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(department,index) in departments" :key="department.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ department.dept_name }}</td>
                                <td>{{ department.dept_details }}</td>
                                <td>
                                    <a class="btn btn-warning btn-xs" @click="editDepartment(department.id)">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger btn-xs" @click="deleteDepartment(department.id)">
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

            <!-- Add Department modal -->
            <div class="modal fade" :class="{ 'in show': showModal }" id="deptModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="showModal=false">&times;</button>
                            <h4 class="modal-title">Add Department</h4>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="onSubmit" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group">
                                    <label for="departmentName" class="col-sm-3 control-label">Department Name <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="departmentName" v-model="departmentName" class="form-control" id="departmentName" placeholder="Department Name">
                                        <span v-if="errors.length && errors[0].departmentName" class="text-danger">{{ errors[0].departmentName[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="departmentDetails" class="col-sm-3 control-label">Department Details</label>
                                    <div class="col-sm-8">
                                        <textarea name="departmentDetails" v-model="departmentDetails" id="departmentDetails" class="form-control" placeholder="Department Details"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-8">
                                        <button type="button" v-if="updateBtn" @click="updateDepartment(id)" class="btn btn-info" data-dismiss="modal">Update</button>
                                        <button type="button" v-else @click="addDepartment()" class="btn btn-info"  data-dismiss="modal">Submit</button>
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

        props: ['depts'],

        data(){
            return {
                departments: this.depts,
                showModal: false,
                id: '',
                errors: [],
                successMsg: '',
                updateBtn: false,
                departmentName : '',
                departmentDetails : '',

            }
        },

        methods: {

            showDeptModal(){
                this.showModal=true;
                this.departmentName = '';
                this.departmentDetails = '';
                this.updateBtn = false;
                this.errors = [];
            },

            addDepartment(){
                axios.post(process.env.MIX_APP_URL+'admin/departments',{
                    departmentName: this.departmentName,
                    departmentDetails: this.departmentDetails
                }).then(response => {
                    this.showModal=false;
                    this.departments.push(response.data);
                    this.departmentName = '';
                    this.departmentDetails = '';
                    this.successMsg = 'Department has been added successfully!';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors.push(e.response.data.errors);
                    }
                });

            },

            editDepartment(id){
                axios.get(process.env.MIX_APP_URL+'admin/departments/'+id+'/edit').then(response => {
                    this.showModal = true;
                    this.updateBtn = true;
                    this.errors = [];
                    this.id = response.data.id;
                    this.departmentName = response.data.dept_name;
                    this.departmentDetails = response.data.dept_details;
                }).catch(error => {
                    console.error(error)
                });
            },

            updateDepartment(id){
                axios.put(process.env.MIX_APP_URL+'admin/departments/'+id,{
                    departmentName: this.departmentName,
                    departmentDetails: this.departmentDetails
                }).then(response => {
                    this.showModal=false;
                    this.$set(this.departments, this.departments.indexOf(this.departments.filter(function (item) {
                        return item.id == id;
                    })[0]), response.data);
                    this.departmentName = '';
                    this.departmentDetails = '';
                    this.successMsg = 'Department has been updated successfully!';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors.push(e.response.data.errors);
                    }
                });
            },

            deleteDepartment(id){
                if (confirm("Do you want to delete this record?")){
                    axios.delete(process.env.MIX_APP_URL+'admin/departments/'+id).then(response => {
                        if (response.status == 200){
                            this.$delete(this.departments, this.departments.indexOf(this.departments.filter(function (item) {
                                return item.id == id;
                            })[0]));
                            this.successMsg = 'Department has been deleted successfully!';

                        }
                    }).catch(error => {
                        console.log(error);
                    });
                }

            }

        },


        mounted(){
            console.log('Department mounted!', process.env.MIX_APP_URL);
        }
    }
</script>
