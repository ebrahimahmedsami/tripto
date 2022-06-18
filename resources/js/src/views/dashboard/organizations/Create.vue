<template>
  <b-row>
    <!-- reset and submit -->
    <b-col
      cols="12"
    >
      <FormData />
    </b-col>
  </b-row>
</template>

<script>
import { BRow, BCol } from 'bootstrap-vue'
import FormData from './form'

export default {
  name: 'AddOrganization',
  components: {
    BRow,
    BCol,
    FormData,
  },
  methods: {
  },
}
</script>

<style lang="scss" >
@import 'https://unpkg.com/vue-select@3.0.0/dist/vue-select.css';
@import '~@core/scss/vue/libs/vue-wizard.scss';
.v-select{
    width: 100% !important;
}
</style>
