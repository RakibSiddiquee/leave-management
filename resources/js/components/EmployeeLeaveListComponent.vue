<template>
    <div>
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Leave</h1>

            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Leave</li>
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
                            <h3 class="box-title">List of Leave</h3>
                            <div v-if="successMsg" class="alert alert-success alert-dismissable fade in custom-alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> {{ successMsg }}
                            </div>
                            <!--<a class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#leaveModal" @click="showLeaveModal"><i class="fa fa-plus"></i></a>-->
                            <a class="btn btn-primary btn-sm pull-right" @click="showLeaveModal"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- /.box-header -->
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Leave Type</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>Total Days</th>
                                <th>status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(leave,index) in leaves" :key="leave.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ leave.type.type_name }}</td>
                                <td>{{ leave.date_from }}</td>
                                <td>{{ leave.date_to }}</td>
                                <td>{{ leave.total_days }}</td>
                                <td>{{ leave.status }} <i class="fa fa-check"></i> </td>
                                <td>
                                    <a class="btn btn-warning btn-xs" @click="editLeave(leave.id)">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger btn-xs" @click="deleteLeave(leave.id)">
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

            <!-- Add Leave modal -->
            <div class="modal fade" :class="{ 'in show': showModal }" id="leaveModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="showModal=false">&times;</button>
                            <h4 class="modal-title">Request Leave</h4>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="onSubmit" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group">
                                    <label for="leaveType" class="col-sm-3 control-label">Leave Type <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="leaveType" v-model="leaveType" class="form-control" id="leaveType">
                                            <option value="">--Choose Leave Type--</option>
                                            <option v-for="type in types" :value="type.id" :key="type.id">{{ type.type_name }}</option>
                                        </select>
                                        <span v-if="errors.length && errors[0].leaveType" class="text-danger">{{ errors[0].leaveType[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dateFrom" class="col-sm-3 control-label">Date From <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="date" name="dateFrom" v-model="dateFrom" class="form-control" id="dateFrom" placeholder="Date From">
                                        <span v-if="errors.length && errors[0].dateFrom" class="text-danger">{{ errors[0].dateFrom[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dateTo" class="col-sm-3 control-label">Date To <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="date" name="dateTo" v-model="dateTo" class="form-control" id="dateTo" placeholder="Date To">
                                        <span v-if="errors.length && errors[0].dateTo" class="text-danger">{{ errors[0].dateTo[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="totalDays" class="col-sm-3 control-label">Total Days</label>
                                    <div class="col-sm-8">
                                        <span type="text" id="totalDays" class="form-control">{{ dateFrom && dateTo ? Math.ceil(Math.abs(new Date(dateTo).getTime() - new Date(dateFrom).getTime())/86400000)+1 : 0 }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="details" class="col-sm-3 control-label">Details</label>
                                    <div class="col-sm-8">
                                        <textarea name="details" v-model="details" id="details" class="form-control" placeholder="Leave Details" rows="10"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-8">
                                        <button type="button" v-if="updateBtn" @click="updateLeave(id)" class="btn btn-info" data-dismiss="modal">Update</button>
                                        <button type="button" v-else @click="addLeave()" class="btn btn-info"  data-dismiss="modal">Submit</button>
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

        props: ['lvs', 'leaveTypes'],

        data(){
            return {
                types: this.leaveTypes,
                leaves: this.lvs,
                showModal: false,
                id: '',
                errors: [],
                successMsg: '',
                updateBtn: false,
                leaveType: '',
                dateFrom: '',
                dateTo: '',
                totalDays: '',
                details: '',
            }
        },

        methods: {

            showLeaveModal(){
                this.showModal=true;
                this.updateBtn = false;
                this.errors = [];
                this.successMsg = '';
                this.leaveType = this.dateFrom = this.dateTo = this.totalDays = this.details = '';
            },

            addLeave(){

                axios.post(process.env.MIX_APP_URL+'employee/leaves',{

                    leaveType: this.leaveType,
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo,
                    totalDays: this.totalDays,
                    details: this.details

                }).then(response => {
                    console.log(response.data);
                    this.showModal=false;
                    this.leaves.push(response.data);
                    this.leaveType = this.dateFrom = this.dateTo = this.totalDays = this.details = '';
                    this.successMsg = 'Leave has been added successfully!';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors = [];
                        this.errors.push(e.response.data.errors);
                    }
                });

            },

            editLeave(id){
                axios.get(process.env.MIX_APP_URL+'employee/leaves/'+id+'/edit').then(response => {
                    this.showModal = true;
                    this.updateBtn = true;
                    this.errors = [];
                    this.successMsg = '';
                    this.id = response.data.id;
                    this.leaveType = response.data.type_id;
                    this.dateFrom = response.data.date_from;
                    this.dateTo = response.data.date_to;
                    this.totalDays = response.data.total_days;
                    this.details = response.data.details;
                }).catch(error => {
                    console.error(error)
                });
            },

            updateLeave(id){
                axios.put(process.env.MIX_APP_URL+'employee/leaves/'+id,{
                    leaveType: this.leaveType,
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo,
                    totalDays: this.totalDays,
                    details: this.details
                }).then(response => {
                    this.showModal=false;
                    this.$set(this.leaves, this.leaves.indexOf(this.leaves.filter(function (item) {
                        return item.id == id;
                    })[0]), response.data);
                    this.leaveType = this.dateFrom = this.dateTo = this.totalDays = this.details = '';
                    this.successMsg = 'Leave has been updated successfully!';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors = [];
                        this.errors.push(e.response.data.errors);
                    }
                });
            },

            deleteLeave(id){
                if (confirm("Do you want to delete the leave?")){
                    axios.delete(process.env.MIX_APP_URL+'employee/leaves/'+id).then(response => {
                        if (response.status == 200){
                            this.$delete(this.leaves, this.leaves.indexOf(this.leaves.filter(function (item) {
                                return item.id == id;
                            })[0]));
                            this.successMsg = 'Leave has been deleted successfully!';

                        }
                    }).catch(error => {
                        console.log(error);
                    });
                }

            }

        },


        mounted(){
            console.log('Leave mounted!', this.leaves);
        }
    }
</script>
