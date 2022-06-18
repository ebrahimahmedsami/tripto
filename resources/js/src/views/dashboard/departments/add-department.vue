<template>
    <b-form @submit.prevent="saveDepartment">
        <b-row>

            <!-- first name -->
            <b-col cols="12">
                <b-form-group
                    label="Name"
                    label-for="vi-name"
                >
                    <b-input-group class="input-group-merge">
                        <b-input-group-prepend is-text>
                            <feather-icon icon="UserIcon" />
                        </b-input-group-prepend>
                        <b-form-input
                            id="vi-name"
                            v-model="department.name"
                            placeholder="Name"
                        /><br>
                    </b-input-group>
                    <label
                        v-if="Object.keys(errors).length > 0 && errors.name !== undefined"
                        class="text-danger"
                    >
                        {{this.errors.name[0]}}
                    </label>
                </b-form-group>
            </b-col>

            <!-- phone -->
            <b-col cols="12">
                <b-form-group
                    label="Phone"
                    label-for="vi-phone"
                >
                    <b-input-group class="input-group-merge">
                        <b-input-group-prepend is-text>
                            <feather-icon icon="SmartphoneIcon" />
                        </b-input-group-prepend>
                        <b-form-input
                            id="vi-phone"
                            v-model="department.phone"
                            type="number"
                            placeholder="Phone"
                        /><br>
                    </b-input-group>
                    <label
                        v-if="Object.keys(errors).length > 0 && errors.phone !== undefined"
                        class="text-danger"
                    >
                        {{this.errors.phone[0]}}
                    </label>
                </b-form-group>
            </b-col>

            <!-- orgnization -->
            <b-col cols="12">
                <b-form-group
                    label="Organization"
                    label-for="vi-organization"
                >
                    <b-input-group class="input-group-merge">
                        <v-select
                            v-model="department.organization_id"
                            placeholder="Organization..."
                            :options="organizations"
                            :reduce="org => org.id"
                            label="name"
                            @input="getOrgBranches"
                        />
                    </b-input-group>
                    <label
                        v-if="Object.keys(errors).length > 0 && errors.organization_id !== undefined"
                        class="text-danger"
                    >
                        {{this.errors.organization_id[0]}}
                    </label>
                </b-form-group>
            </b-col>
            <!-- Branch -->
            <b-col cols="12">
                <b-form-group
                    label="Branches"
                    label-for="vi-branch"
                >
                    <b-input-group class="input-group-merge">
                        <v-select
                            v-model="department.branch_id"
                            placeholder="Branches..."
                            :options="branches"
                            :reduce="branch => branch.id"
                            label="name"
                        />
                    </b-input-group>
                    <label
                        v-if="Object.keys(errors).length > 0 && errors.branch_id !== undefined"
                        class="text-danger"
                    >
                        {{this.errors.branch_id[0]}}
                    </label>
                </b-form-group>
            </b-col>
            <!-- status -->
            <b-col cols="12">
                <b-form-group
                    label="Status"
                    label-for="vi-status"
                >
                    <b-input-group class="input-group-merge">
                        <v-select
                            v-model="department.status"
                            placeholder="Status..."
                            :options="status"
                            :reduce="sta => sta.value"
                            label="name"
                        />
                    </b-input-group>
                    <label
                        v-if="Object.keys(errors).length > 0 && errors.status !== undefined"
                        class="text-danger"
                    >
                        {{this.errors.status[0]}}
                    </label>
                </b-form-group>
            </b-col>

            <!-- description -->
            <b-col cols="12">
                <label for="textarea-default">Description</label>
                <b-input-group class="input-group-merge">
                    <b-form-textarea
                        id="textarea-default"
                        v-model="department.desc"
                        placeholder="Description"
                        rows="3"
                    /><br>
                </b-input-group>
                <label
                    v-if="Object.keys(errors).length > 0 && errors.desc !== undefined"
                    class="text-danger"
                >
                    {{this.errors.desc[0]}}

                </label>
            </b-col>

            <!-- reset and submit -->
            <b-col
                cols="12"
                class="mt-2"
            >
                <b-button
                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                    type="add"
                    variant="primary"
                    class="mr-1"
                >
                    Submit
                </b-button>
                <b-button
                    v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                    type="reset"
                    variant="outline-secondary"
                >
                    Reset
                </b-button>
            </b-col>
        </b-row>
    </b-form>
</template>

<script>
import {
    BRow, BCol, BFormGroup, BFormInput, BFormCheckbox, BForm, BButton, BInputGroup, BInputGroupPrepend, BFormTextarea, BFormValidFeedback,
    BFormInvalidFeedback,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import axios from 'axios'

export default {
    name: 'AddDepartment',
    components: {
        BRow,
        vSelect,
        BCol,
        BFormValidFeedback,
        BFormInvalidFeedback,
        BFormGroup,
        BFormInput,
        BFormTextarea,
        BFormCheckbox,
        BInputGroup,
        BInputGroupPrepend,
        BForm,
        BButton,
    },
    directives: {
        Ripple,
    },
    data(){
        return{
            branches:[],
            organizations:[],
            errors: {},
            status:[
                {name:'Active',value:'1'},
                {name:'In Active',value:'0'},
            ],
            department:{
                name:'',
                phone:'',
                desc:'',
                branch_id:'',
                organization_id:'',
                status:''
            }
        };
    },
    created() {
       this.getAllOrganizations();
    //    this.getBranches();
    },
    methods:{
        makeToast(variant = null, body) {
            this.$bvToast.toast(body, {
                title: `Variant ${variant || 'default'}`,
                variant,
                solid: true,
            })
        },
        saveDepartment(){
            const instance = this
            axios.post('/departments', this.department, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
                },
            }).then(response => {
                this.errors = {}
                this.makeToast('success', 'Department Stored Succeffully')
                setTimeout(() => {
                    instance.$router.push({ name: 'departments' })
                }, 1000)
            })
                .catch(error => {
                    this.makeToast('warning', error.response.data.message)
                    this.errors = error.response.data.errors
                })
        },
        getOrgBranches(){
            this.getBranches(this.department.organization_id)
        },
        getBranches(id){
            axios.get(`all-branches/${id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
                },
            }).then(response => {
                this.branches = response.data.data
            })
        },
        getAllOrganizations() {
            axios.get('all-organizations', {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
                },
            }).then(response => {
                this.organizations = response.data.data
            })
        },
    }
}
</script>

<style lang="scss" >
@import 'https://unpkg.com/vue-select@3.0.0/dist/vue-select.css';
.v-select{
    width: 100% !important;
}
</style>
