<template>
    <!--begin::Modal-->  
    <div class="modal fade" id="addImagesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Upload Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div> 
                <div class="modal-body row"> 
                    <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"
                    v-on:vdropzone-sending="sendingEvent"
                    v-on:vdropzone-removed-file="removeThisFile"
                    v-on:vdropzone-success="vdropzoneSuccess"
                    ></vue-dropzone>
                    
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
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    
    export default {
        components: {HasError,vueDropzone: vue2Dropzone},
        props: ['fetchData'],
        mounted(){
            $('#addImagesModal').on("hidden.bs.modal", this.load)
        },
        data() {
            return {
                form: new Form({id:null,name:null}),
                dropzoneOptions: {
                    url: '/api/upload-image',
                    thumbnailWidth: 150,
                    maxFilesize: 5,
                    acceptedFiles: "image/*",
                    addRemoveLinks: true,
                    headers: { 
                        "My-Awesome-Header": "header value",
                        'Authorization': axios.defaults.headers.common['Authorization'] 
                    },
                    dictDefaultMessage:
                    "<i class='fas fa-cloud-upload-alt'></i><br/>Drop your files"
                }
            };
        }, 
        methods: {
            open(campaign){
                this.form.fill(campaign);
                $('#addImagesModal').modal('show');
            },
            vdropzoneSuccess(file, response) {
                file.name_=response.success;
            },
            sendingEvent(file, xhr, formData) {
                formData.append("campaign_id", this.form.id);
            },
            removeThisFile(file) {
                let data={campaign_id:this.form.id,image_name:file.name_}
                axios.post('remove-image',data).then(response => {
                    this.load();
                })
            },
            load() {
                this.fetchData();
            },
            
        },
    }
</script>
