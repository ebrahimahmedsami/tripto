<template>
  <section id="dashboard-analytics">
    <b-row class="match-height">
      <b-col
        lg="6"
        md="12"
      >
        <congratulation :data="data.congratulations" />
      </b-col>
      <b-col
        lg="3"
        sm="6"
      >
        <statistic-card-with-area-chart
          v-if="data.subscribersGained"
          icon="UsersIcon"
          :statistic="kFormatter(data.subscribersGained.analyticsData.subscribers)"
          statistic-title="Subscribers Gained"
          :chart-data="data.subscribersGained.series"
        />
      </b-col>
      <b-col
        lg="3"
        sm="6"
      >
        <statistic-card-with-area-chart
          v-if="data.ordersRecevied"
          icon="PackageIcon"
          color="warning"
          :statistic="kFormatter(data.ordersRecevied.analyticsData.orders)"
          statistic-title="Orders Received"
          :chart-data="data.ordersRecevied.series"
        />
      </b-col>
    </b-row>

    <b-row class="match-height">
      <b-col lg="6">
        <avg-sessions :data="data.avgSessions" />
      </b-col>
      <b-col lg="6">
        <support-tracker :data="data.supportTracker" />
      </b-col>
    </b-row>

    <b-row class="match-height">
      <b-col lg="4">
        <timeline :data="data.timeline" />
      </b-col>
      <b-col lg="4">
        <sales-radar-chart :data="data.salesChart" />
      </b-col>
      <b-col lg="4">
        <app-design :data="data.appDesign" />
      </b-col>
    </b-row>

    <!--    <b-row>-->
    <!--      <b-col cols="12">-->
    <!--        <invoice-list />-->
    <!--      </b-col>-->
    <!--    </b-row>-->
  </section>
</template>

<script>
import { BRow, BCol } from 'bootstrap-vue'

import StatisticCardWithAreaChart from '@core/components/statistics-cards/StatisticCardWithAreaChart.vue'
import { kFormatter } from '@core/utils/filter'
import Congratulation from './Congratulation.vue'
import AvgSessions from './AvgSessions.vue'
import SupportTracker from './SupportTracker.vue'
import Timeline from './Timeline.vue'
import SalesRadarChart from './SalesRadarChart.vue'
import AppDesign from './AppDesign.vue'

export default {
  components: {
    BRow,
    BCol,
    Congratulation,
    AvgSessions,
    StatisticCardWithAreaChart,
    SupportTracker,
    Timeline,
    SalesRadarChart,
    AppDesign,
  },
  data() {
    return {
      data: {},
    }
  },
  created() {
    // data
    this.$http.get('/analytics/data')
      .then(response => { this.data = response.data })
  },
  methods: {
    kFormatter,
  },
}
</script>
