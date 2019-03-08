<template>
    <div>
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Leave Type</h1>

            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Leave Type</li>
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
                            <h3 class="box-title">List of Leave Type</h3>
                            <div v-if="successMsg" class="alert alert-success alert-dismissable fade in custom-alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> {{ successMsg }}
                            </div>
                            <!--<a class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#typeModal" @click="showTypeModal"><i class="fa fa-plus"></i></a>-->
                            <a class="btn btn-primary btn-sm pull-right" @click="showTypeModal"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- /.box-header -->
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Type Name</th>
                                <th>Type Details</th>
                                <th>Total Days</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(type,index) in types" :key="type.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ type.type_name }}</td>
                                <td>{{ type.type_details }}</td>
                                <td>{{ type.total_days }}</td>
                                <td>
                                    <a class="btn btn-warning btn-xs" @click="editLeaveType(type.id)">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger btn-xs" @click="deleteLeaveType(type.id)">
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

            <!-- Add Leave Type modal -->
            <div class="modal fade" :class="{ 'in show': showModal }" id="typeModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="showModal=false">&times;</button>
                            <h4 class="modal-title">Add Leave Type</h4>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="onSubmit" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group">
                                    <label for="typeName" class="col-sm-3 control-label">Type Name <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="typeName" v-model="typeName" class="form-control" id="typeName" placeholder="Leave Type Name">
                                        <span v-if="errors.length && errors[0].typeName" class="text-danger">{{ errors[0].typeName[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="typeDetails" class="col-sm-3 control-label">Type Details</label>
                                    <div class="col-sm-8">
                                        <textarea name="typeDetails" v-model="typeDetails" id="typeDetails" class="form-control" placeholder="Leave Type Details"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="totalDays" class="col-sm-3 control-label">Total Days <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="number" name="totalDays" v-model="totalDays" class="form-control" id="totalDays" placeholder="Total Days">
                                        <span v-if="errors.length && errors[0].totalDays" class="text-danger">{{ errors[0].totalDays[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-8">
                                        <button type="button" v-if="updateBtn" @click="updateLeaveType(id)" class="btn btn-info" data-dismiss="modal">Update</button>
                                        <button type="button" v-else @click="addLeaveType()" class="btn btn-info"  data-dismiss="modal">Submit</button>
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

        props: ['leaveTypes'],

        data(){
            return {
                types: this.leaveTypes,
                showModal: false,
                id: '',
                errors: [],
                successMsg: '',
                updateBtn: false,
                typeName : '',
                typeDetails : '',
                totalDays : '',

            }
        },

        methods: {

            showTypeModal(){
                this.showModal=true;
                this.typeName = '';
                this.typeDetails = '';
                this.totalDays = '';
                this.updateBtn = false;
                this.errors = [];
            },

            addLeaveType(){
                axios.post(process.env.MIX_APP_URL+'admin/leave-types',{
                    typeName: this.typeName,
                    typeDetails: this.typeDetails,
                    totalDays: this.totalDays
                }).then(response => {
                    this.showModal=false;
                    this.types.push(response.data);
                    this.typeName = '';
                    this.typeDetails = '';
                    this.totalDays = '';
                    this.successMsg = 'Leave Type has been added successfully!';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors.push(e.response.data.errors);
                    }
                });

            },

            editLeaveType(id){
                axios.get(process.env.MIX_APP_URL+'admin/leave-types/'+id+'/edit').then(response => {
                    this.showModal = true;
                    this.updateBtn = true;
                    this.errors = [];
                    this.id = response.data.id;
                    this.typeName = response.data.type_name;
                    this.typeDetails = response.data.type_details;
                    this.totalDays = response.data.total_days;
                }).catch(error => {
                    console.error(error)
                });
            },

            updateLeaveType(id){
                axios.put(process.env.MIX_APP_URL+'admin/leave-types/'+id,{
                    typeName: this.typeName,
                    typeDetails: this.typeDetails,
                    totalDays: this.totalDays
                }).then(response => {
                    this.showModal=false;
                    this.$set(this.types, this.types.indexOf(this.types.filter(function (item) {
                        return item.id == id;
                    })[0]), response.data);
                    this.typeName = '';
                    this.typeDetails = '';
                    this.totalDays = '';
                    this.successMsg = 'Leave Type has been updated successfully!';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors.push(e.response.data.errors);
                    }
                });
            },

            deleteLeaveType(id){
                if (confirm("Do you want to delete this record?")){
                    axios.delete(process.env.MIX_APP_URL+'admin/leave-types/'+id).then(response => {
                        if (response.status == 200){
                            this.$delete(this.types, this.types.indexOf(this.types.filter(function (item) {
                                return item.id == id;
                            })[0]));
                            this.successMsg = 'Leave Type has been deleted successfully!';

                        }
                    }).catch(error => {
                        console.log(error);
                    });
                }

            }

        },

        mounted(){
            console.log('Leave Type mounted!', process.env.MIX_APP_URL);
        }
    }
</script>
