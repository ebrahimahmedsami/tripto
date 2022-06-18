<template>
    <section id="faq-tabs" class="mt-2">
        <b-tabs
            vertical
            content-class="col-12 col-md-8 col-lg-9"
            pills
            nav-wrapper-class="faq-navigation col-md-4 col-lg-3 col-12"
            nav-class="nav-left"
        >

            <!-- payment tab -->
            <b-tab
                v-for="(branch, index) in branches"
                :key="branch.name"
                :active="!index"
            >
                <!-- title -->
                <template #title>
                    <feather-icon
                        icon="GitBranchIcon"
                        size="18"
                        class="mr-1 font-weight-bold"
                    />
                    <span class="font-weight-bold">{{ branch.name }} Branch</span>
                </template>

                <organization-departments :departments="branch.departments" />
            </b-tab>
            <!--/ payment tab -->

            <!-- sitting lady image -->
            <template #tabs-end>
                <b-img
                    fluid
                    :src="require('@/assets/images/illustration/faq-illustrations.svg')"
                    class="d-none d-md-block mt-auto"
                />
            </template>
            <!--/ sitting lady image -->
        </b-tabs>
    </section>
</template>
<script>
import {
    BCard,
    BCardBody,
    BForm,
    BInputGroup,
    BFormInput,
    BCardText,
    BInputGroupPrepend,
    BTabs,
    BTab,
    BImg,
    BRow,
    BCol,
    BAvatar,
} from 'bootstrap-vue'
import OrganizationDepartments from './OrganizationDepartments.vue'

export default {
    name:'OrganizationBranches',
    components: {
        BRow,
        BCol,
        BAvatar,
        BInputGroup,
        BCardText,
        BInputGroupPrepend,
        BTabs,
        BTab,
        BImg,
        OrganizationDepartments
    },
    props:{
        branches:{
            type:Array,
            default:()=>[]
        }
    }
}

</script>
