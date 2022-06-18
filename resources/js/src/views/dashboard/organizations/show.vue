<template>
    <div>
        <organization-statistics :qr_code="organization.qr_code" :logo="organization.logo" />
        <organization-details :organization="organization"/>
        <organization-branches v-if="organization.branches" :branches="organization.branches"/>
    </div>
</template>

<script>
import OrganizationDetails from './components/OrganizationDetails.vue'
import OrganizationBranches from './components/OrganizationBranches.vue'
import OrganizationStatistics from './components/OrganizationStatistics.vue'
import axios from 'axios';
export default {
    name:'ShowOrganization',
    components: {
        OrganizationDetails,
        OrganizationBranches,
        OrganizationStatistics
    },
    data() {
        return {
            organization:{},
        }
    },
    watch: {
    },
    methods: {
        getOrganization(){
            axios.get(`organizations/${this.$route.params.id}`)
                 .then(response=> this.organization = response.data.organization)
                 .catch(error=>console.log(error))
        }
    },
    mounted() {
        this.getOrganization()
    }
}
</script>

<style lang="scss">
@import '~@core/scss/vue/pages/page-faq.scss';
@import '~@core/scss/vue/pages/page-pricing.scss';

</style>
