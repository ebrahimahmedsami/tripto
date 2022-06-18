<template>
    <table-data :titleProp="title" :searchTermProp="searchTerm" :columnsProp="columns" :url="url">
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
            <b-dropdown-item :to="{name:'edit-service',params:{'id':row.id}}" v-if="$gate.hasPermission('update services')">
                <feather-icon
                    icon="Edit2Icon"
                    class="mr-50"
                />
                <span>Edit</span>
              </b-dropdown-item>

              <b-dropdown-item @click.prevent="dropRow(row.id)"  v-if="$gate.hasPermission('delete services')">
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
import { reactive, toRefs } from 'vue'
import tableData from '../datatable/Index'
import {
    BCard,BAvatar, BBadge, BPagination, BFormGroup, BFormInput, BFormSelect, BDropdownItem, BDropdown,BRow, BCol
} from 'bootstrap-vue'
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
        BRow, BCol
     },
      data() {
        return {
            url:'/services',
            searchTerm:'',
            title:'Services',
            columns: [
                {
                    label: 'Name',
                    field: 'name',
                    filterable:true,
                    sortable:true
                },
                {
                    label: 'Department Name',
                    field: 'department_name',
                    filterable:true
                },
                {
                    label: 'Status',
                    field: 'status',
                    filterable:true
                },
                {
                    label: 'Window Number',
                    field: 'queue_number',
                    filterable:true
                },
                {
                    label: 'range time',
                    field: 'range_time',
                    filterable:true
                },
                 {
                    label: 'Description',
                    field: 'desc',
                    filterable:true
                },
                {
                    label: 'Created At',
                    field: 'created_at',
                    filterable:true
                },
                {
                    label: 'Action',
                    field: 'action',
                    sortable:false
                },
            ],
        }
    },
    computed: {

    },
    methods: {
        dropRow(id)
        {
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
                    axios.delete(`/services/${id}`).then(response => {
                        this.$swal({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Your branch has been deleted.',
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
        }
    },
     created() {

    },
}
</script>

<style scoped>

</style>
