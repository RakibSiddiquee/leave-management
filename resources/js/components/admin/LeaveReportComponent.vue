<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Leave Report</h1>

            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Leave Report</li>
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
                            <h3 class="box-title">Leave Report of {{ getMonths()[monthNo] }}</h3>

                            <form class="pull-right form-inline">
                                <select v-model="year" class="form-control input-sm">
                                    <option v-for="yr in getCurrentYear()" v-if="yr >= 2010" :value="yr">{{ yr }}</option>
                                </select>
                                <select v-model="month" class="form-control input-sm">
                                    <option v-for="(mn,index) in getMonths()" :value="index">{{ mn }}</option>
                                </select>

                                <input @click="showReport" type="button" value="Show Report" class="btn btn-success btn-sm">
                            </form>
                        </div>
                        <!-- /.box-header -->
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee Name</th>
                                <th>Total Leave</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(employee,index) in employees" :key="employee.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ employee.name }}</td>
                                <td>{{ getTotal(employee.leaves) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>

        <!-- /.content -->
    </div>
</template>

<script>
    export default {

        props: ['emps'],

        data(){
            return {
                employees: this.emps,
                year: this.getCurrentYear(),
                month: new Date().getMonth(),
                monthNo: new Date().getMonth()
            }
        },

        methods: {
            getCurrentYear() {
                return new Date().getFullYear();
            },

            getMonths() {
                return ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            },

            getTotal(leaves){
                let total = 0;
                return leaves.reduce(function(total, item){ return total + Number(item.total_days) }, 0);
            },

            showReport(){
                axios.post(process.env.MIX_APP_URL + 'admin/leaves/filter-report', {
                    year: this.year,
                    month: this.month,
                }).then(response => {
                    this.employees = response.data;
                    this.monthNo = this.month;
                }).catch(e => {
                    if (e.response.status == 422) {
                        console.log(e);
                    }
                });

            },


        },


        mounted(){
            console.log('Leave report mounted!', this.month);
        }
    }
</script>
