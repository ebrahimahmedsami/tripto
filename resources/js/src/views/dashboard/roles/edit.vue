<template>
     <b-row>
        <b-col cols="4">
            <b-form-group
            label="Roles"
            label-for="vi-roles"
            >
            <b-input-group class="input-group-merge">
                 <b-form-input id="vi-name" v-model="role" placeholder="Name" />
            </b-input-group>
            <label
                v-if="Object.keys(errors).length > 0 && errors.rol !== undefined"
                class="text-danger"
            >
                Role is required
            </label>
            </b-form-group>
        </b-col>
        <b-col cols="12">
            <button class="btn btn-success mt-2 mb-2" :loading="is_sending" :disabled="is_sending" @click="edit">Update</button>
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th class="text-center" colspan="3">Routes</th>
                        <th class="text-center" colspan="2">
                            <input type="checkbox" v-model="check_all" />
                            Select All
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="r in all_permissions" :key="r.name">
                        <td>{{r.name}}</td>
                        <td>read <input type="checkbox" v-model="r.read" /></td>
                        <td>write <input type="checkbox" v-model="r.write" /></td>
                        <td>update <input type="checkbox" v-model="r.update" /></td>
                        <td>delete <input type="checkbox" v-model="r.delete" /></td>
                    </tr>
                </tbody>
            </table>
        </b-col>
     </b-row>
</template>

<script>
import {
  BRow, BCol, BFormGroup, BFormInput, BFormCheckbox, BForm, BButton, BInputGroup, BInputGroupPrepend, BFormTextarea, BFormValidFeedback,
  BFormInvalidFeedback,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
    export default {
         components: {
            BRow,
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
                is_sending:false,
                errors:{},
                role:'',
                all_permissions:[],
                check_all:false
            }
        },
        watch:{
            check_all(new_val){
                for(let permission of this.all_permissions){
                    permission.read = new_val;
                    permission.write = new_val;
                    permission.update = new_val;
                    permission.delete = new_val;
                }
            }
        },
        methods:{
            getRole(){
                axios.get(`/roles/${this.$route.params.id}/edit`)
                .then(({data})=>{
                    this.all_permissions = data.role.permissions;
                    this.role = data.role.name;
                    this.check_all = data.role.select_all;
                })
            },
            edit(){
                let data = JSON.stringify(this.all_permissions)
                axios.patch(`/roles/${this.$route.params.id}`,{'role':this.role,'permissions' : data})
                .then(({data})=>{
                    if(data.status){
                        this.makeToast('success', data.message);
                        let user = JSON.parse(this.$user);
                        if(user.group_id == this.$route.params.id){
                            user.permissions = data.permissions
                            localStorage.setItem('userData', JSON.stringify(user));
                        }
                        this.$router.push({name:'roles'})
                    }
                })
            },
            makeToast(variant = null, body) {
                this.$bvToast.toast(body, {
                    title: `Variant ${variant || 'default'}`,
                    variant,
                    solid: true,
                })
            },
        },
        mounted(){
            this.getRole();
        }

    }
</script>

<style scoped>

</style>
