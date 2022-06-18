<template>
  <b-form @submit.prevent="saveBranch">
    <b-row>
        <h2>{{$i18n.t('branches.add_branch')}}</h2>
      <!-- first name -->
      <b-col cols="12">
        <b-form-group
          :label="$i18n.t('branches.name')"
          label-for="vi-name"
        >
          <b-input-group class="input-group-merge">
            <b-input-group-prepend is-text>
              <feather-icon icon="UserIcon" />
            </b-input-group-prepend>
            <b-form-input
              id="vi-name"
              v-model="branch.name"
              :placeholder="$i18n.t('branches.name')"
            /><br>
          </b-input-group>
          <label
            v-if="Object.keys(errors).length > 0 && errors.name !== undefined"
            class="text-danger"
          >
            {{$i18n.t('branches.required_name')}}
          </label>
        </b-form-group>
      </b-col>

      <!-- phone -->
      <b-col cols="12">
        <b-form-group
          :label="$i18n.t('branches.phone')"
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
              :placeholder="$i18n.t('branches.phone')"
            /><br>
          </b-input-group>
          <label
            v-if="Object.keys(errors).length > 0 && errors.phone !== undefined"
            class="text-danger"
          >
            {{$i18n.t('branches.required_phone')}}
          </label>
        </b-form-group>
      </b-col>

      <!-- orgnization -->
      <b-col cols="12">
        <b-form-group
          :label="$i18n.t('branches.org')"
          label-for="vi-organization"
        >
          <b-input-group class="input-group-merge">
            <v-select
              v-model="branch.org"
              :placeholder="$i18n.t('branches.org')"
              :options="organizations"
              :reduce="org => org.id"
              :dir="arabic ? 'rtl' : 'ltr'"
              label="name"
            />
          </b-input-group>
          <label
            v-if="Object.keys(errors).length > 0 && errors.org !== undefined"
            class="text-danger"
          >
            {{$i18n.t('branches.required_org')}}
          </label>
        </b-form-group>
      </b-col>

      <!-- description -->
      <b-col cols="12">
        <label for="textarea-default">{{$i18n.t('branches.desc')}}</label>
        <b-input-group class="input-group-merge">
          <b-form-textarea
            id="textarea-default"
            v-model="branch.desc"
            :placeholder="$i18n.t('branches.desc')"
            rows="3"
          /><br>
        </b-input-group>
        <label
          v-if="Object.keys(errors).length > 0 && errors.desc !== undefined"
          class="text-danger"
        >
          {{$i18n.t('branches.required_desc')}}
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
          {{$i18n.t('branches.add_btn')}}
        </b-button>
        <b-button
          v-ripple.400="'rgba(186, 191, 199, 0.15)'"
          type="reset"
          variant="outline-secondary"
        >
          {{$i18n.t('branches.reset_btn')}}
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
import {mapGetters} from "vuex";

export default {
  name: 'AddBranch',
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
      organizations: [],
        arabic:false,
      errors: {},
      branch: {
        name: '',
        phone: '',
        org: '',
        desc: '',
      },
    }
  },
    computed:{
      ...mapGetters({
          "isArabic" : 'appConfig/get_iSrtl'
      })
    },
  created() {
    this.getAllOrganizations()
      this.arabic = this.isArabic
  },
    watch:{
      'isArabic'(val){
          this.arabic = val
      }
    },
  methods: {
    makeToast(variant = null, body) {
      this.$bvToast.toast(body, {
        title: `Variant ${variant || 'default'}`,
        variant,
        solid: true,
      })
    },
    saveBranch() {
      const instance = this
      axios.post('/branches', this.branch, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
        },
      }).then(response => {
        this.errors = {}
        this.makeToast('success', 'Branch Stored Successfully')
        setTimeout(() => {
          instance.$router.push({ name: 'branches' })
        }, 1000)
      })
        .catch(error => {
          this.makeToast('warning', error.response.data.message)
          this.errors = error.response.data.errors
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
  },
}
</script>
<style lang="scss" >
@import 'https://unpkg.com/vue-select@3.0.0/dist/vue-select.css';
.v-select{
    width: 100% !important;
}
</style>
