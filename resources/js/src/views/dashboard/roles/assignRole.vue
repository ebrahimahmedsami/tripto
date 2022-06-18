<template>
     <b-row>
        <b-col cols="4">
            <b-form-group
            :label="$i18n.t('roles.roles')"
            label-for="vi-roles"
            >
            <b-input-group class="input-group-merge">
                 <b-form-input id="vi-name" v-model="role" :placeholder="$i18n.t('roles.name')" />
            </b-input-group>
            <label
                v-if="Object.keys(errors).length > 0 && errors.rol !== undefined"
                class="text-danger"
            >
                {{$i18n.t('roles.required_role')}}
            </label>
            </b-form-group>
        </b-col>
        <b-col cols="12">
            <button class="btn btn-success mt-2 mb-2" :loading="is_sending" :disabled="is_sending" @click="assignRole">{{$i18n.t('roles.assign')}}</button>
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th class="text-center" colspan="3">{{$i18n.t('roles.routes')}}</th>
                        <th class="text-center" colspan="2">
                            <input type="checkbox" v-model="check_all" />
                            Select All
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="r in all_permissions" :key="r.name">
                        <td>{{ $i18n.t(`roles.${r.name}`)}}</td>
                        <td>{{$i18n.t('roles.read')}} <input type="checkbox" v-model="r.read" /></td>
                        <td>{{$i18n.t('roles.write')}} <input type="checkbox" v-model="r.write" /></td>
                        <td>{{$i18n.t('roles.update')}} <input type="checkbox" v-model="r.update" /></td>
                        <td>{{$i18n.t('roles.delete')}} <input type="checkbox" v-model="r.delete" /></td>
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
            check_all:false,
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
        assignRole(){
            let data = JSON.stringify(this.all_permissions)
            axios.post('roles',{'role':this.role,'permissions' : data})
            .then((res)=>{
                if(res.status === 200){
                    this.makeToast('success', res.data.message);
                    this.$router.push({name:'roles'})
                }
            }).catch((err) => {
                console.log(err)
            })

        },
        makeToast(variant = null, body) {
            this.$bvToast.toast(body, {
                title: `Variant ${variant || 'default'}`,
                variant,
                solid: true,
            })
        },
        permissions(){
            axios.get('/spinner/permissions')
            .then(({data})=>{
                data.permissions.forEach(permission=>{
                    this.all_permissions.push({
                        name: permission , read: false,write: false,delete: false,update: false
                    })
                })
            })
        }
    },
    created(){
        this.permissions();
    }

}
</script>
<style lang="scss" >
@import 'https://unpkg.com/vue-select@3.0.0/dist/vue-select.css';
.v-select{
    width: 100% !important;
}
</style>
