<template>
    <div>
        <b-row class="mb-1">
            <b-col cols="12" >
                <router-link  class="btn btn-primary float-right" :to="{name: 'add-organization'}" tag="button">
                    <feather-icon
                        icon="PlusSquareIcon"
                        class="mr-50"
                    />
                    <span class="align-middle">Add</span>
                </router-link>
            </b-col>
        </b-row>
        <table-data
            :title-prop="title"
            :search-term-prop="searchTerm"
            :columns-prop="columns"
            :url="url"
        >
            <template v-slot:searchDiv>
                <div class="custom-search d-flex justify-content-end">
                    <b-form-group>
                        <div class="d-flex align-items-center">
                            <label class="mr-1">Search</label>
                            <b-form-input
                                v-model="searchTerm"
                                placeholder="Search"
                                type="text"
                                class="d-inline-block"
                            />
                        </div>
                    </b-form-group>
                </div>
            </template>
            <template v-slot:actions="{row}">
                <b-dropdown-item :to="{name:'edit-organization',params:{'id':row.id}}">
                    <feather-icon
                        icon="Edit2Icon"
                        class="mr-50"
                    />
                    <span>Edit</span>
                </b-dropdown-item>
                <b-dropdown-item @click.prevent="dropRow(row.id)">
                    <feather-icon
                        icon="TrashIcon"
                        class="mr-50"
                    />
                    <span>Delete</span>
                </b-dropdown-item>
                <b-dropdown-item :to="{name:'show-organization',params:{'id':row.id}}">
                    <feather-icon
                        icon="EyeIcon"
                        class="mr-50"
                    />
                    <span>Show</span>
                </b-dropdown-item>
            </template>
        </table-data>
    </div>
</template>

<script>
import { reactive, toRefs } from 'vue'
import {
  BCard, BAvatar, BBadge, BPagination, BFormGroup, BFormInput, BFormSelect, BDropdownItem, BDropdown, BRow, BCol,
} from 'bootstrap-vue'
import axios from 'axios'
import tableData from '../datatable/Index'

export default {
  name: 'Organization',
  components: {
    tableData,
    BCard,
    BAvatar,
    BBadge,
    BPagination,
    BFormGroup,
    BFormInput,
    BFormSelect,
    // Prism,
    BDropdownItem,
    BDropdown,
    BRow,
    BCol,
  },
  data() {
    return {
      url: '/organizations',
      searchTerm: '',
      title: 'Organization',
      columns: [
        {
          label: 'Logo',
          field: 'logo',
        },
        {
          label: 'Name',
          field: 'name',
          filterable: true,
          sortable: true,
        },
          {
              label: 'Status',
              field: 'status',
              filterable: true,

          },
        {
          label: 'Email',
          field: 'email',
          filterable: true,
        },
        {
          label: 'Phone',
          field: 'phone',
          filterable: true,
        },
        {
          label: 'Website Url',
          field: 'website_url',
        },
        {
          label: 'latitude',
          field: 'lat',
          filterable: true,
        },
        {
          label: 'longitude',
          field: 'long',
          filterable: true,
        },
        {
          label: 'Created At',
          field: 'created_at',
          filterable: true,
        },
        {
          label: 'Action',
          field: 'action',
          sortable: false,
        },
      ],
    }
  },
  methods: {
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
          axios.delete(`/organizations/${id}`).then(response => {
            this.$swal({
              icon: 'success',
              title: 'Deleted!',
              text: response.data.message,
              customClass: {
                confirmButton: 'btn btn-success',
              },
            })
              Fire.$emit('deleted');
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
  },
}
</script>

<style>
.vgt-left-align span{
    white-space: nowrap!important;
}
</style>
