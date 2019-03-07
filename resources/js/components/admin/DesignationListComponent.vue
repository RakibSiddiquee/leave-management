<template>
    <div>
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Designation</h1>

            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Designation</li>
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
                            <h3 class="box-title">List of Designation</h3>
                            <div v-if="successMsg" class="alert alert-success alert-dismissable fade in custom-alert">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> {{ successMsg }}
                            </div>
                            <!--<a class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#desgModal" @click="showDesgModal"><i class="fa fa-plus"></i></a>-->
                            <a class="btn btn-primary btn-sm pull-right" @click="showDesgModal"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- /.box-header -->
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Designation Name</th>
                                <th>Designation Description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(designation,index) in designations" :key="designation.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ designation.desg_name }}</td>
                                <td>{{ designation.desg_details }}</td>
                                <td>
                                    <a class="btn btn-warning btn-xs" @click="editDesignation(designation.id)">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger btn-xs" @click="deleteDesignation(designation.id)">
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

            <!-- Add Designation modal -->
            <div class="modal fade" :class="{ 'in show': showModal }" id="desgModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="showModal=false">&times;</button>
                            <h4 class="modal-title">Add Designation</h4>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="onSubmit" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group">
                                    <label for="designationName" class="col-sm-3 control-label">Designation Name <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="designationName" v-model="designationName" class="form-control" id="designationName" placeholder="Designation Name">
                                        <span v-if="errors.length && errors[0].designationName" class="text-danger">{{ errors[0].designationName[0] }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="designationDetails" class="col-sm-3 control-label">Designation Details</label>
                                    <div class="col-sm-8">
                                        <textarea name="designationDetails" v-model="designationDetails" id="designationDetails" class="form-control" placeholder="Designation Details"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-8">
                                        <button type="button" v-if="updateBtn" @click="updateDesignation(id)" class="btn btn-info" data-dismiss="modal">Update</button>
                                        <button type="button" v-else @click="addDesignation()" class="btn btn-info"  data-dismiss="modal">Submit</button>
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

        props: ['desgs'],

        data(){
            return {
                designations: this.desgs,
                showModal: false,
                id: '',
                errors: [],
                successMsg: '',
                updateBtn: false,
                designationName : '',
                designationDetails : '',

            }
        },

        methods: {

            showDesgModal(){
                this.showModal=true;
                this.designationName = '';
                this.designationDetails = '';
                this.updateBtn = false;
                this.errors = [];
            },

            addDesignation(){
                axios.post(process.env.MIX_APP_URL+'admin/designations',{
                    designationName: this.designationName,
                    designationDetails: this.designationDetails
                }).then(response => {
                    this.showModal=false;
                    this.designations.push(response.data);
                    this.designationName = '';
                    this.designationDetails = '';
                    this.successMsg = 'Designation has been added successfully!';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors.push(e.response.data.errors);
                    }
                });

            },

            editDesignation(id){
                axios.get(process.env.MIX_APP_URL+'admin/designations/'+id+'/edit').then(response => {
                    this.showModal = true;
                    this.updateBtn = true;
                    this.errors = [];
                    this.id = response.data.id;
                    this.designationName = response.data.desg_name;
                    this.designationDetails = response.data.desg_details;
                }).catch(error => {
                    console.error(error)
                });
            },

            updateDesignation(id){
                axios.put(process.env.MIX_APP_URL+'admin/designations/'+id,{
                    designationName: this.designationName,
                    designationDetails: this.designationDetails
                }).then(response => {
                    this.showModal=false;
                    this.$set(this.designations, this.designations.indexOf(this.designations.filter(function (item) {
                        return item.id == id;
                    })[0]), response.data);
                    this.designationName = '';
                    this.designationDetails = '';
                    this.successMsg = 'Designation has been updated successfully!';
                }).catch(e => {
                    if (e.response.status == 422){
                        this.errors.push(e.response.data.errors);
                    }
                });
            },

            deleteDesignation(id){
                if (confirm("Do you want to delete this record?")){
                    axios.delete(process.env.MIX_APP_URL+'admin/designations/'+id).then(response => {
                        if (response.status == 200){
                            this.$delete(this.designations, this.designations.indexOf(this.designations.filter(function (item) {
                                return item.id == id;
                            })[0]));
                            this.successMsg = 'Designation has been deleted successfully!';

                        }
                    }).catch(error => {
                        console.log(error);
                    });
                }

            }

        },

        mounted(){
            console.log('Designation mounted!', process.env.MIX_APP_URL);
        }
    }
</script>
