<template>
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
    <template v-slot:actions='{row}'>
            <b-dropdown-item :to="{name:'edit-department',params:{'id':row.id}}">
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

        </template>

  </table-data>
</template>

<script>
import axios from 'axios'
import {
  BCard, BAvatar, BBadge, BPagination, BFormGroup, BFormInput, BFormSelect, BDropdownItem, BDropdown, BRow, BCol,
} from 'bootstrap-vue'
import tableData from '../datatable/Index'

export default {
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
      url: '/departments',
      searchTerm: '',
      title: 'Departments',
      columns: [
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
          label: 'Organization',
          field: 'organization_id',
          filterable: true,

        },
        {
          label: 'Branch',
          field: 'branch_id',
          filterable: true,

        },
        {
          label: 'Services Count',
          field: this.fieldFn,
          html:true
        }
        ,
        {
          label: 'Created At',
          field: 'created_at',
          filterable: true,

        },
        {
          label: 'Phone',
          field: 'phone',
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
  computed: {

  },
  created() {

  },
  methods: {
      fieldFn(rowObj) {
        return rowObj.services_count + `<i data-feather='server'></i>`;
    },
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
                  axios.delete(`/departments/${id}`, {
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
