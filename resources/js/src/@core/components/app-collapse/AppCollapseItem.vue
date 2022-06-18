<template>
  <b-card
    no-body
    :class="{'open': visible}"
    @mouseenter="collapseOpen"
    @mouseleave="collapseClose"
  >
    <b-card-header

      :class="{'collapsed': !visible}"
      :aria-expanded="visible ? 'true' : 'false'"
      :aria-controls="collapseItemID"
      role="tab"
      data-toggle="collapse"
      @click="updateVisible(!visible)"
    >
      <slot name="header">
        <span class="lead collapse-title">{{ title }}</span>
          <b-badge :variant="statusVariant(status)">
              {{ (status=='0')?'In Active':"Active" }}
          </b-badge>
      </slot>
    </b-card-header>

    <b-collapse
      :id="collapseItemID"
      v-model="visible"
      :accordion="accordion"
      role="tabpanel"
    >
      <b-card-body>
        <slot />
      </b-card-body>
    </b-collapse>
  </b-card>
</template>

<script>
import {
    BCard, BCardHeader, BCardBody, BCollapse, BBadge
} from 'bootstrap-vue'
import { v4 as uuidv4 } from 'uuid'

export default {
  components: {
    BCard,
    BCardHeader,
    BCardBody,
    BCollapse,
    BBadge,
  },
  props: {
    isVisible: {
      type: Boolean,
      default: false,
    },
    title: {
      type: String,
      required: true,
    },
    status: {
        type: Number,
        required: true
    }
  },
  data() {
    return {
      visible: false,
      collapseItemID: '',
      openOnHover: this.$parent.hover,
    }
  },
  computed: {
    accordion() {
      return this.$parent.accordion ? `accordion-${this.$parent.collapseID}` : null
    },
    statusVariant() {
          const statusColor = {
              0: 'light-danger',
              1: 'light-success',
          }
          return status => statusColor[status]
    },
  },
  created() {
    this.collapseItemID = uuidv4()
    this.visible = this.isVisible
  },
  methods: {
    updateVisible(val = true) {
      this.visible = val
      this.$emit('visible', val)
    },
    collapseOpen() {
      if (this.openOnHover) this.updateVisible(true)
    },
    collapseClose() {
      if (this.openOnHover) this.updateVisible(false)
    },
  },
}
</script>
