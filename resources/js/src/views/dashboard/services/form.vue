<template>
<b-form @submit.prevent="submit">
    <b-row>
        <h2>{{title}}</h2>

      <!-- first name -->
      <b-col cols="12">
        <b-form-group label="Name" label-for="vi-name">
          <b-input-group class="input-group-merge">
            <b-input-group-prepend is-text>
              <feather-icon icon="UserIcon"/>
            </b-input-group-prepend>
            <b-form-input id="vi-name" v-model="form.name" placeholder="Name" /><br>
          </b-input-group>
          <label v-if="Object.keys(errors).length > 0 && errors.name !== undefined" class="text-danger" >
            Name is required
          </label>
        </b-form-group>
      </b-col>

    <!-- description -->
      <b-col cols="12">
        <label for="textarea-default">Description</label>
        <b-input-group class="input-group-merge">
          <b-form-textarea id="textarea-default" v-model="form.desc" placeholder="Description" rows="3" />
          <br>
        </b-input-group>
        <label v-if="Object.keys(errors).length > 0 && errors.desc !== undefined" class="text-danger">
          Description is required
        </label>
      </b-col>

      <!-- status -->
      <b-col cols="12">
        <b-form-group label="Status" label-for="vi-status" >
          <b-input-group class="input-group-merge">
            <v-select v-model="form.status" placeholder="Status..." :options="status" :reduce="statu => statu.value" label="name"/>
          </b-input-group>
          <label v-if="Object.keys(errors).length > 0 && errors.status !== undefined" class="text-danger" >
            Status is required
          </label>
        </b-form-group>
      </b-col>

      <!-- window number -->
      <b-col cols="12">
        <b-form-group label="Window Number" label-for="vi-queue_number">
          <b-input-group class="input-group-merge">
            <b-input-group-prepend is-text>
              <feather-icon icon="BookmarkIcon"/>
            </b-input-group-prepend>
            <b-form-input type="number" id="vi-queue_number" v-model="form.queue_number" placeholder="window number" /><br>
          </b-input-group>
          <label v-if="Object.keys(errors).length > 0 && errors.queue_number !== undefined" class="text-danger" >
            window number is required
          </label>
        </b-form-group>
      </b-col>

        <!-- range time -->
      <b-col cols="12">
        <b-form-group label="Range Time" label-for="vi-range_time">
          <b-input-group class="input-group-merge">
            <b-input-group-prepend is-text>
              <feather-icon icon="ClockIcon"/>
            </b-input-group-prepend>
            <b-form-input type="number" id="vi-range_time" v-model="form.range_time" placeholder="Range time" /><br>
          </b-input-group>
          <label v-if="Object.keys(errors).length > 0 && errors.range_time !== undefined" class="text-danger" >
            Range time is required
          </label>
        </b-form-group>
      </b-col>

      <!-- department -->
      <b-col cols="12">
        <b-form-group label="Department" label-for="vi-department" >
          <b-input-group class="input-group-merge">
            <v-select v-model="form.department_id" placeholder="Department..." :options="departments" :reduce="department => department.id" label="name"/>
          </b-input-group>
          <label v-if="Object.keys(errors).length > 0 && errors.department_id !== undefined" class="text-danger" >
            Department is required
          </label>
        </b-form-group>
      </b-col>

      <!-- reset and submit -->
      <b-col cols="12" class="mt-2">
        <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" type="add" variant="primary" class="mr-1" >
          Submit
        </b-button>
        <b-button v-ripple.400="'rgba(186, 191, 199, 0.15)'" type="reset" variant="outline-secondary">
          Reset
        </b-button>
      </b-col>
    </b-row>
</b-form>
</template>

<script>
import {
    BForm,BRow, BCol, BFormGroup, BFormInput,
    BFormCheckbox, BButton, BInputGroup, BInputGroupPrepend,
    BFormTextarea, BFormValidFeedback,
    BFormInvalidFeedback,
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import Ripple from 'vue-ripple-directive'
    export default {
        props:{
            title:{ type: String, required: true},
            errors:{type: Object, required: true},
        },
        components: {
            BForm,
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
            BButton,
        },
        data(){
            return{
                status:[
                    {name:'active',value:true},
                    {name:'in active',value:false},
                ],
                departments:[],
                form:{
                    name:'',
                    status:'',
                    desc:'',
                    queue_number:'',
                    range_time:'',
                    department_id:''
                }
            }
        },
        directives: {
            Ripple,
        },
        methods:{
            getDepartments() {
                axios.get('spinner/departments')
                .then(response => {
                    this.departments = response.data.departments
                })
            },
            submit(){
                if(this.$route.params.id){
                    this.$emit('editService',this.form)
                }else{
                    this.$emit('addService',this.form)
                }
            },
            getService(){
                axios.get(`/services/${this.$route.params.id}/edit`)
                .then(({data})=>{
                    if(data.status){
                        Object.keys(this.form).forEach((key)=>this.form[key]= (key!='status')?data.service[key]:Boolean(data.service[key]))
                    }
                })
            }
        },
        mounted(){
            this.getDepartments()
            if(this.$route.params.id){
                this.getService()
            }
        },
    }
</script>

<style scoped>
@import 'https://unpkg.com/vue-select@3.0.0/dist/vue-select.css';
.v-select{
    width: 100% !important;
}
</style>
