<template>
    <!--begin::Modal-->  
    <div class="modal fade bd-example-modal-lg" id="showImagesModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Campaign Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div> 
                <div class="modal-body row p-2 m-1"> 
                    <div class="col-md-4 mb-2 p-2" v-for="(image,i) in form.images">
                        <div class="card p-1">
                            <img class="w-100" :src="'/assets/images/campaigns/'+form.id+'/'+image">
                            <div class="row mt-2"> 
                                <div class="col-md-6">
                                    <a :href="'/assets/images/campaigns/'+form.id+'/'+image" download class="btn btn-success w-100"><i class="fa-solid fa-download"></i></a>
                                </div> 
                                <div class="col-md-6">
                                    <a href="javascript:;" @click="removeThisFile(image)" class="btn btn-danger w-100"><i class="fa-regular fa-trash-can"></i></a>
                                </div> 
                            </div> 
                        </div> 
                    </div> 
                </div> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" >Close</button>
                </div>
            </div>
        </div>
    </div>
    
    
    <!--end::Modal-->
</template>

<script>
    import {Form,HasError} from 'vform'
    import axios from 'axios';
    
    export default {
        components: {HasError},
        props: ['fetchData'],
        data() {
            return {
                form: new Form({id:null,name:null,images:[]}),
            };
        }, 
        methods: {
            open(campaign){
                this.form.fill(campaign);
                $('#showImagesModal').modal('show');                
            },
            
            removeThisFile(file) {
                let data={campaign_id:this.form.id,image_name:file}
                axios.post('remove-image',data).then(response => {
                    this.form.images = this.form.images.filter(o => o != file);
                    if (this.form.images.length==0) {
                        $('#showImagesModal').modal('hide');  
                    }
                    this.fetchData();
                })
            }
            
        },
    }
</script>
