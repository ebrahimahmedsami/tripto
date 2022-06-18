<template>
    <div>
        <div class="d-flex align-items-center">
            <b-avatar
                rounded
                size="42"
                variant="light-primary"
                class="mr-1"
            >
                <feather-icon
                    icon="SunriseIcon"
                    size="20"
                />

            </b-avatar>
            <div>
                <h4 class="mb-0" >
                    Departments
                </h4>
            </div>
        </div>

<!--         collapse -->
        <app-collapse
            id="faq-payment-qna"
            accordion
            type="margin"
            class="mt-2"
            v-if="departments.length > 0"
        >

            <app-collapse-item
                v-for="( department,index) in departments"
                :key="index"
                :title="department.name + ' Department'"
                :status = "department.status"
            >
                <department-services :services="department.services"/>
            </app-collapse-item>
        </app-collapse>
        <app-collapse
            id="faq-payment-qna"
            accordion
            type="margin"
            class="mt-2 text-center"
            v-else-if="departments.length<=0"
        >
            <span>No Departments ...</span>
        </app-collapse>
    </div>
</template>

<script>
import { BAvatar } from 'bootstrap-vue'
import DepartmentServices from './DepartmentServices.vue'
import AppCollapse from '@core/components/app-collapse/AppCollapse.vue'
import AppCollapseItem from '@core/components/app-collapse/AppCollapseItem.vue'
export default {
    name:'OrganizationDepartments',
    components: {
        BAvatar,
        DepartmentServices,
        AppCollapseItem,
        AppCollapse,
    },
    props: {
        departments: {
            type: Array,
            default: () => [],
        },
    },
}
</script>
