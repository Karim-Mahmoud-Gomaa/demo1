<template>
    <layout-default>
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">Advertising Campaigns Table</h4>
                            <div class="page-title-right">
                                <button type="button" @click="$refs.FormModal.create()" class="btn btn-success waves-effect waves-light">Add New +</button>
                                <form-modal ref="FormModal" :fetchData="fetchData" />
                                <add-images-modal ref="AddImagesModal" :fetchData="fetchData" />
                                <show-images-modal ref="ShowImagesModal" :fetchData="fetchData" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div v-if="campaigns&&campaigns.data.length" class="card-body" >
                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Created By</th>
                                            
                                            <th>Total</th>
                                            <th>Daily Budget</th>
                                            
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Created At</th>
                                            
                                            <th>Optionis</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <tr v-for="(campaign,index) in campaigns.data">
                                            <td>
                                                <a v-if="campaign.images.length" @click="$refs.ShowImagesModal.open(campaign)" href="javascript:;"><i class="fa-regular fa-eye"></i></a>
                                                {{campaign.name}}
                                            </td>
                                            <td>{{campaign.created_by.name}}</td>
                                            
                                            <td>{{moneyFormat(campaign.total)}}</td>
                                            <td>{{moneyFormat(campaign.daily_budget)}}</td>
                                            
                                            <td>{{campaign.from| moment("DD/MM/YYYY")}}</td>
                                            <td>{{campaign.to| moment("DD/MM/YYYY")}}</td>
                                            <td>{{campaign.created_at| moment("DD/MM/YYYY")}}</td>
                                            
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-chevron-down"></i> More
                                                    </button>
                                                    <div class="dropdown-menu" style="min-width: 120px;">
                                                        <a @click="$refs.AddImagesModal.open(campaign)" class="dropdown-item dropdownItem" href="javascript:;">
                                                            <i class="far fa-edit"></i> Upload Images
                                                        </a>
                                                        <a @click="$refs.FormModal.edit(campaign)" class="dropdown-item dropdownItem" href="javascript:;">
                                                            <i class="far fa-edit"></i> Edit
                                                        </a>
                                                        <a @click="$refs.FormModal.destroy(campaign.id)" class="dropdown-item dropdownItem" href="javascript:;">
                                                            <i class="far fa-trash-alt"></i> Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <pagination-nav class="mt-3" v-if="campaigns.last_page>1" :pageSize="campaigns.last_page" :currentPage="campaigns.current_page" :GoToPage="fetchData" />
                                </div>
                                <div v-else class="card-body">
                                    <beat-loader v-if="loader" :loading="loader" color="#5578eb"></beat-loader>
                                    <p v-else class="card-title-desc" style="text-align: center;">No Data</p>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- container-fluid -->
            </div>
        </layout-default>
    </template>
    <script>
        import LayoutDefault from '../../layouts/App';
        import PaginationNav from '../../components/pagination';
        import FormModal from '../../components/modals/campaign/add';
        import AddImagesModal from '../../components/modals/campaign/addImages';
        import ShowImagesModal from '../../components/modals/campaign/showImages';
        import axios from 'axios';
        ///////////////////////////////
        export default {
            components: { LayoutDefault, PaginationNav, FormModal,AddImagesModal,ShowImagesModal },
            data() {
                return { campaigns: null,loader: false }
            },
            created() {
                this.fetchData();
            },
            methods: {
                fetchData(num = 1) {
                    this.campaigns = null;
                    this.loader = true;
                    let data = { params: { page: num } };
                    axios.get('campaigns',data).then(({data})=>{
                        this.campaigns=data.success.campaigns;
                        if(!data.success.campaigns.data.length&&num!=1){this.fetchData(1)}
                        this.loader=false;
                    });
                },
            },
        }
    </script>