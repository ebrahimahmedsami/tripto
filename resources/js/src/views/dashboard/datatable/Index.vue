<template>
  <b-row>
    <b-col cols="12">
      <b-card :title="titleProp">

        <slot name="searchDiv" />
        <!-- table -->
        <vue-good-table
          mode="remote"
          :total-rows="totalRecords"
          :is-loading="isLoading"
          :rows="rows"
          :columns="columns"
          :rtl="direction"
          :pagination-options="{enabled: true}"
          :sort-options="{enabled: true}"
          :select-options="{
            enabled: true,
            selectOnCheckboxOnly: true,
            selectionInfoClass: 'custom-class',
            selectionText: 'rows selected',
            clearSelectionText: 'clear',
            disableSelectInfo: true,
            selectAllByGroup: true,
          }"
          @on-sort-change="onSortChange"
        >

          <template
            slot="table-row"
            slot-scope="props"
          >
            <!-- Column: Name -->
            <span
              v-if="props.column.field === 'name'"
              class="text-nowrap"
            >
              <span class="text-nowrap">{{ props.row.name }}</span>
            </span>

            <!-- Column: Status -->
            <span v-else-if="props.column.field === 'status'">
              <b-badge :variant="statusVariant(props.row.status)">
                {{ (props.row.status=='0')?'In Active':"Active" }}
              </b-badge>
            </span>
            <!-- Column: website_url -->
            <span v-else-if="props.column.field === 'website_url'">
              <a
                target="_blank"
                class="btn btn-primary website"
                :href="props.row.website_url"
              >
                <feather-icon
                  icon="Link2Icon"
                  class="mr-50"
                />
                <span class="align-middle">website</span>
              </a>
            </span>
            <!-- Column: Image Org -->
            <span v-else-if="props.column.field === 'logo'">
              <b-avatar
                :src="props.row.logo"
                class="mx-1"
              />
            </span>

              <!-- Column: Image Employee -->
              <span v-else-if="props.column.field === 'image'">
              <b-avatar
                  :src="props.row.image"
                  class="mx-1"
              />
            </span>
            <!-- Column: Action -->
            <span v-else-if="props.column.field === 'action'">
              <span>
                <b-dropdown
                  variant="link"
                  toggle-class="text-decoration-none"
                  no-caret
                >
                  <template v-slot:button-content>
                    <feather-icon
                      icon="MoreVerticalIcon"
                      size="16"
                      class="text-body align-middle mr-25"
                    />
                  </template>
                  <slot
                    name="actions"
                    :row="props.row"
                  />
                </b-dropdown>
              </span>
            </span>
          </template>
          <!-- pagination -->
          <template
            slot="pagination-bottom"
            slot-scope="props"
          >
            <div class="d-flex justify-content-between flex-wrap">

              <!-- page length -->
              <div class="d-flex align-items-center mb-0 mt-1">
                <span class="text-nowrap ">
                  Showing 1 to
                </span>
                <b-form-select
                  v-model="pageLength"
                  :options="pages"
                  class="mx-1"
                  @input="onPerPageChange"
                />
                <span class="text-nowrap"> of {{ props.total }} entries </span>
              </div>

              <!-- pagination -->
              <div>
                <b-pagination
                  :value="1"
                  :total-rows="totalRecords"
                  :per-page="pageLength"
                  first-number
                  last-number
                  align="right"
                  prev-class="prev-item"
                  next-class="next-item"
                  class="mt-1 mb-0"
                  @change="onPageChange"
                >
                  <template #prev-text>
                    <feather-icon
                      icon="ChevronLeftIcon"
                      size="18"
                    />
                  </template>
                  <template #next-text>
                    <feather-icon
                      icon="ChevronRightIcon"
                      size="18"
                    />
                  </template>
                </b-pagination>
              </div>
            </div>
          </template>

        </vue-good-table>

      </b-card>
    </b-col>
  </b-row>
</template>

<script>
import {
  BCard, BAvatar, BBadge, BPagination, BFormGroup, BFormInput, BFormSelect, BDropdownItem, BDropdown, BRow, BCol,
} from 'bootstrap-vue'
import { VueGoodTable } from 'vue-good-table'
import 'prismjs/themes/prism-tomorrow.css'

import axios from 'axios'
import store from '@/store/index'

export default {
  components: {
    BCard,
    VueGoodTable,
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
  props: ['columnsProp', 'titleProp', 'url', 'searchTermProp'],
  data() {
    return {
      isLoading: false,
      searchTerm: '',
      dir: false,
      pageLength: 10,
      pages: ['10', '20', '50', '100', '1000'],
      columns: [
      ],
      rows: [],
      totalRecords: 0,
      serverParams: {
        columnFilters: {},
        sort:
            {
              field: 'name',
              type: 'desc',
            },
        page: 1,
        perPage: 10,
      },
    }
  },
  computed: {
    statusVariant() {
      const statusColor = {
        0: 'light-danger',
        1: 'light-success',
      }
      return status => statusColor[status]
    },
    direction() {
      if (store.state.appConfig.isRTL) {
        this.dir = true
        return this.dir
      }
      this.dir = false
      return this.dir
    },
  },
  watch: {
    searchTermProp(val) {
      this.searchTerm = val
      this.loadItems()
    },
  },
  mounted() {
    if (this.$route.name == 'roles') {
      this.serverParams.sort.field = 'roleName'
    } else {
      this.serverParams.sort.field = 'name'
    }
    this.columns = this.columnsProp
    this.loadItems()
   Fire.$on('deleted',()=>{
          this.loadItems();
      })
  },
  methods: {
    getdata() {
      alert(1)
    },
    updateParams(newProps) {
      this.serverParams = { ...this.serverParams, ...newProps }
    },
    onPageChange(val) {
      this.serverParams.page = val
      this.loadItems()
    },

    onPerPageChange() {
      this.serverParams.perPage = this.pageLength
      this.loadItems()
    },
    handleSearch() {
      this.loadItems()
    },

    onSortChange(params) {
      if (params[0].type === 'none') {
        params[0].type = 'asc'
      }
      this.updateParams({
        sort: {
          type: params[0].type,
          field: params[0].field,
        },
      })
      this.loadItems()
    },
    loadItems() {
      this.isLoading = true
      axios.get(`${this.url}?searchTerm=${this.searchTerm}&page=${this.serverParams.page}&per_page=${this.serverParams.perPage}&field=${this.serverParams.sort.field}&type=${this.serverParams.sort.type}`).then(response => {
        this.isLoading = false
        this.rows = response.data.data
        this.totalRecords = response.data.meta.total
      }).catch(err => {
        this.isLoading = false
      })
    },
  },
}
</script>
<style lang="scss" >
@import '~@core/scss/vue/libs/vue-good-table.scss';
.website{
    display: flex!important;
}
</style>
