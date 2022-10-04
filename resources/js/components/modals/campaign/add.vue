<template>
    <!--begin::Modal-->  
    <div class="modal fade" id="campaignModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form @submit.prevent="form.id ? update() : store()" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel" >{{ form.id ? 'Update':'Add New User' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div> 
                <div class="modal-body row"> 
                    <div class="col-12 mt-3">
                        <template v-for="error_group in errors">
                        <template v-for="error in error_group">
                            <div class="alert alert-danger" role="alert">{{error}}</div>
                        </template>
                        </template>
                    </div> 
                    <div class="col-12 mt-3">
                        <label >Name</label>
                        <input v-model="form.name" type="text" autocomplete="off" required
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div> 
                    <div class="col-md-6 mt-3">
                        <label >From</label>
                        <Datepicker input-class="form-control" v-model="form.from" format="dd-MM-yyyy"></Datepicker>
                        <has-error :form="form" field="from"></has-error>
                    </div> 
                    <div class="col-md-6 mt-3">
                        <label >To</label>
                        <Datepicker input-class="form-control" v-model="form.to" format="dd-MM-yyyy"></Datepicker>
                        <has-error :form="form" field="to"></has-error>
                    </div> 
                    <div class="col-md-6 mt-3">
                        <label >Total</label>
                        <input v-model="form.total" type="number" autocomplete="off" step="any"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('total') }">
                        <has-error :form="form" field="total"></has-error>
                    </div> 
                    <div class="col-md-6 mt-3">
                        <label >Daily Budget</label>
                        <input v-model="form.daily_budget" type="number" autocomplete="off" step="any"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('daily_budget') }">
                        <has-error :form="form" field="daily_budget"></has-error>
                    </div> 
                </div> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" >Close</button>
                    <button v-if="form.id" type="submit" class="btn btn-primary" >Update</button>
                    <button v-else type="submit" class="btn btn-primary" >Save</button>
                </div>
            </form>
        </div>
    </div>
    <!--end::Modal-->
</template>

<script>
import {Form,HasError} from 'vform'
import axios from 'axios';
import Datepicker from 'vuejs-datepicker';


export default {
    components: {HasError,Datepicker},
    props: ['fetchData'],
    data() {
        return {
            form: new Form({id:null,name:null,from:null,to:null,total:null,daily_budget:null}),
            errors:null,
        };
    }, 
    methods: {
        create(){
            this.form.reset();
            this.errors=null;
            $('#campaignModal').modal('show');
        },
        store(){ 
            this.form.post("campaigns").then(({data}) => {
                this.fetchData();
                $('#campaignModal').modal('hide');
            }).catch((error) => {this.errors=error.response.data.errors_bag})
        },  
        edit(form){ 
            console.log(form);
            this.form.reset();
            this.errors=null;
            this.form.fill(form);
            $('#campaignModal').modal('show');
        },
        update(){
            this.form.put("campaigns/"+this.form.id).then(({data}) => {
                this.fetchData();
                $('#campaignModal').modal('hide');
            }).catch((error) => {console.log("Error......")})
        },  
        destroy(id) {
            this.$swal.fire({
                 title: 'warning',
                text: "Are you sure you want to remove this row?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "cancel",
                confirmButtonText: "Yes,Delete It!",
            }).then((result) => {
                if (result.value) {
                    axios.delete('campaigns/'+id).then(response => {
                        this.$swal.fire(response.data.message, response.data.success+'!', 'success');
                        this.fetchData();
                    }).catch(() => {
                        this.$swal.fire({icon: 'error',title: 'Oops...',text: 'Something went wrong!',
                            footer: '<a href>Why do I have this issue?</a>'
                        }); 
                    });
                }
            })
        },
    },
}
</script>
