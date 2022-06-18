<template>
    <b-form @submit.prevent="editBranch">
        <b-row>
            <h2>Edit Branch</h2>
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
                            v-model="branch.name"
                            placeholder="Name"
                        /><br>
                    </b-input-group>
                    <label
                        v-if="Object.keys(errors).length > 0 && errors.name !== undefined"
                        class="text-danger"
                    >
                        Name is required
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
                            v-model="branch.phone"
                            type="number"
                            placeholder="Phone"
                        /><br>
                    </b-input-group>
                    <label
                        v-if="Object.keys(errors).length > 0 && errors.phone !== undefined"
                        class="text-danger"
                    >
                        Phone is required
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
                            v-model="branch.org"
                            placeholder="Organization..."
                            :options="organizations"
                            :reduce="org => org.id"
                            label="name"
                        />
                    </b-input-group>
                    <label
                        v-if="Object.keys(errors).length > 0 && errors.org !== undefined"
                        class="text-danger"
                    >
                        Organization is required
                    </label>
                </b-form-group>
            </b-col>

            <!-- description -->
            <b-col cols="12">
                <label for="textarea-default">Description</label>
                <b-input-group class="input-group-merge">
                    <b-form-textarea
                        id="textarea-default"
                        v-model="branch.desc"
                        placeholder="Description"
                        rows="3"
                    /><br>
                </b-input-group>
                <label
                    v-if="Object.keys(errors).length > 0 && errors.desc !== undefined"
                    class="text-danger"
                >
                    Description is required
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
    BButton,
    BCol, BForm, BFormCheckbox,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BFormTextarea,
    BFormValidFeedback, BInputGroup, BInputGroupPrepend,
    BRow
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import Ripple from 'vue-ripple-directive'
import axios from 'axios'
import {mapActions,mapGetters} from 'vuex'

export default {
    name: 'edit',
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
    data() {
        return {
            errors: {},
            branch: {
                name: '',
                phone: '',
                org: '',
                desc: '',
            },
            id:''
        }
    },
    created() {
        this.getBranch(this.$route.params.id)
        this.organizationsData()
    },
    computed:{
      ...mapGetters({
          'organizations':'dashboard/getAllOrganizations'
      })
    },
    methods:{
        ...mapActions({
            'organizationsData':'dashboard/getAllOrganizationsAction'
        }),
        makeToast(variant = null, body) {
            this.$bvToast.toast(body, {
                title: `Variant ${variant || 'default'}`,
                variant,
                solid: true,
            })
        },
        getBranch(id){
            axios.get(`branches/${id}/edit`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
                },
            }).then(response => {
                if(response.status){
                    this.branch.name = response.data.branch.name;
                    this.branch.phone = Number(response.data.branch.phone);
                    this.branch.org = Number(response.data.branch.organization_id);
                    this.branch.desc = response.data.branch.address;
                }
            })
        },
        editBranch() {
            let id = this.$route.params.id
            const instance = this
            axios.put(`/branches/${id}`, this.branch, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
                },
            }).then(response => {
                this.errors = {}
                this.makeToast('success', 'Branch Edited Successfully')
                setTimeout(() => {
                    instance.$router.push({ name: 'branches' })
                }, 1000)
            })
                .catch(error => {
                    this.makeToast('warning', error.response.data.message)
                    console.log(error.response.data.errors,1)
                    this.errors = error.response.data.errors
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
