<template>
    <div>

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="userData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching user data
            </h4>
            <div class="alert-body">
                No user found with this user id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'employees'}"
                >
                    Employee List
                </b-link>
                for other employees.
            </div>
        </b-alert>

        <template v-if="userData">
            <!-- First Row -->
            <b-row>
                <b-col
                    cols="12"
                    xl="12"
                    lg="12"
                    md="7"
                >
                    <b-card>

                        <b-row>

                            <!-- User Info: Left col -->
                            <b-col
                                cols="21"
                                xl="6"
                                class="d-flex justify-content-between flex-column"
                            >
                                <!-- User Avatar & Action Buttons -->
                                <div class="d-flex justify-content-start">
                                    <b-avatar
                                        :src="'/images/employee/image/'+userData.image"
                                        size="104px"
                                        rounded
                                    />
                                    <div class="d-flex flex-column ml-1">
                                        <div class="mb-1">
                                            <h4 class="mb-0">
                                                {{ userData.name }}
                                            </h4>
                                            <span class="card-text">{{ userData.email }}</span>
                                        </div>
                                        <div class="d-flex flex-wrap">
                                            <b-button
                                                :to="{ name: 'edit-employee', params: { id: userData.id } }"
                                                variant="primary"
                                            >
                                                Edit
                                            </b-button>
                                            <b-button  @click.prevent="dropRow($route.params.id)"
                                                variant="outline-danger"
                                                class="ml-1"
                                            >
                                                Delete
                                            </b-button>
                                        </div>
                                    </div>
                                </div>

                                <!-- User Stats -->
                                <div class="d-flex align-items-center mt-2">
                                    <div class="d-flex align-items-center mr-2">
                                        <b-avatar
                                            variant="light-primary"
                                            rounded
                                        >
                                            <feather-icon
                                                icon="CalendarIcon"
                                                size="18"
                                            />
                                        </b-avatar>
                                        <div class="ml-1">
                                            <h5 class="mb-0">
                                                {{userData.created_at}}
                                            </h5>
                                            <small>Created At</small>
                                        </div>
                                    </div>


                                </div>
                            </b-col>

                            <!-- Right Col: Table -->
                            <b-col
                                cols="12"
                                xl="6"
                            >
                                <table class="mt-2 mt-xl-0 w-100">
                                    <tr>
                                        <th class="pb-50">
                                            <feather-icon
                                                icon="UserIcon"
                                                class="mr-75"
                                            />
                                            <span class="font-weight-bold">Username</span>
                                        </th>
                                        <td class="pb-50">
                                            {{ userData.name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pb-50">
                                            <feather-icon
                                                icon="CheckIcon"
                                                class="mr-75"
                                            />
                                            <span class="font-weight-bold">Status</span>
                                        </th>
                                        <td class="pb-50 text-capitalize">
                                            {{ (userData.status==1)?'Active':'InActive' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pb-50">
                                            <feather-icon
                                                icon="StarIcon"
                                                class="mr-75"
                                            />
                                            <span class="font-weight-bold">Role</span>
                                        </th>
                                        <td class="pb-50 text-capitalize">
                                            {{ userData.group }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pb-50">
                                            <feather-icon
                                                icon="FlagIcon"
                                                class="mr-75"
                                            />
                                            <span class="font-weight-bold">Type</span>
                                        </th>
                                        <td class="pb-50">
                                            {{ userData.type }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <feather-icon
                                                icon="PhoneIcon"
                                                class="mr-75"
                                            />
                                            <span class="font-weight-bold">Contact</span>
                                        </th>
                                        <td>
                                            {{ userData.phone }}
                                        </td>
                                    </tr>
                                </table>
                            </b-col>
                        </b-row>
                    </b-card>
                </b-col>

            </b-row>

            <b-row>
                <b-col
                    cols="12"
                    lg="12"
                >
                    <b-card
                        no-body
                    >
                        <b-card-body>
                            <b-card-title>Permissions</b-card-title>
                            <b-card-sub-title>Permission according to roles</b-card-sub-title>
                        </b-card-body>
                        <b-table
                            striped
                            responsive
                            :items="permissionsData"
                            class="mb-0"
                        >

                            <template #cell(name)="data">
                                {{ data.value }}
                            </template>
                            <template #cell()="data">
                                <b-form-checkbox
                                    disabled
                                    :checked="data.value"
                                />
                            </template>

                        </b-table>
                    </b-card>
                </b-col>
            </b-row>


        </template>

    </div>
</template>

<script>

    import {
        BRow, BCol, BAlert, BLink,BCard, BTable, BCardBody, BCardTitle, BCardSubTitle, BFormCheckbox,
         BButton,   BAvatar,
    } from 'bootstrap-vue'
    import { avatarText } from '@core/utils/filter'
    import axios from "axios";
    import Ripple from "vue-ripple-directive";

    export default {
        components: {
            BRow,
            BCol,
            BAlert,
            BLink,
            BCard, BTable, BCardBody, BCardTitle, BCardSubTitle, BFormCheckbox,
            BAvatar,
            BButton

        },
        directives: {
            Ripple,
        },
        created() {
        this.getEmployee(this.$route.params.id)
            },
        data(){
            return{
                permissionsData:[],

                userData:{
                    name:'',
                    phone:'',
                    email:'',
                    group:'',
                    image:null,
                    type:'',
                    status:'',
                    created_at:'',
                    id:''
                }
            };
        },
        methods:{
            dropRow(id) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                        axios.delete(`/employees/${id}`, {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
                            },
                        }).then(response => {
                            this.$swal({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Your Department has been deleted.',
                                customClass: {
                                    confirmButton: 'btn btn-success',
                                },
                            })
                            this.$router.push({ name: 'employees' })
                        }).catch(error => {
                            this.$swal({
                                icon: 'error',
                                title: 'Error!',
                                text: error.response.data.message,
                                customClass: {
                                    confirmButton: 'btn btn-danger',
                                },
                            })
                        })
                    } else if (result.dismiss === 'cancel') {
                        this.$swal({
                            title: 'Cancelled',
                            text: 'Your imaginary file is safe :)',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success',
                            },
                        })
                    }
                })
            },
            getEmployee(id) {
                axios.get(`/employees/${id}`)
                    .then(({data})=>{
                        this.permissionsData=data.employee.permissions


                        if(data.status){
                            Object.keys(this.userData).forEach((key)=>this.userData[key]= data.employee[key])
                        }
                    }).catch(({data})=>{
                        this.userData=undefined;
                })


            },
        }

    }
</script>

<style>

</style>
