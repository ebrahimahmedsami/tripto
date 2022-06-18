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
            <label class="mr-1">{{$i18n.t('roles.serach')}}</label>
            <b-form-input
              v-model="searchTerm"
              :placeholder="$i18n.t('roles.serach')"
              type="text"
              class="d-inline-block"
            />
          </div>
        </b-form-group>
      </div>
    </template>
      <template v-slot:actions='{row}'>
          <b-dropdown-item :to="{name:'edit-role',params:{'id':row.id}}"  v-if="$gate.hasPermission('update roles')">
              <feather-icon
                  icon="Edit2Icon"
                  class="mr-50"
              />
              <span>{{$i18n.t('roles.edit')}}</span>
          </b-dropdown-item>

          <b-dropdown-item @click="confirmText(row.id)" v-if="$gate.hasPermission('delete roles')&&user.group_id!=row.id">
              <feather-icon
                  icon="TrashIcon"
                  class="mr-50"
              />
              <span>{{$i18n.t('roles.delete')}}</span>
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
import Ripple from 'vue-ripple-directive'

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
    directives: {
        Ripple,
    },
  data() {
    return {
        user:'',
      url: '/roles',
      searchTerm: '',
      title: this.$i18n.t('roles.roles'),
      columns: [
        {
          label: this.$i18n.t('roles.name'),
          field: 'name',
          filterable: true,
          sortable: true,
        },
        // {
        //   label: 'Permissions',
        //   field: 'permissions',
        //   sortable: false,

        // },
        {
          label: this.$i18n.t('roles.action'),
          field: 'action',
          sortable: false,
        },
      ],

    }
  },
  methods: {
      confirmText(id) {
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
                    axios.delete(`/roles/${id}`)
                    .then(response => {
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
      },
  },
    mounted() {
      this.user = JSON.parse(this.$user);
    }
}
</script>
