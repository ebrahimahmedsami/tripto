<template>
    <b-row>
        <b-col
            cols="12"
            lg="12"
        >
            <h4>Services</h4>
            <app-timeline>
                <app-timeline-item  v-if="services" v-for="service in services" :key="service.id" :variant="randomVariant">
                    <div class="d-flex flex-sm-row flex-column flex-wrap justify-content-between mb-1 mb-sm-0">
                        <h6><span class="font-weight-bold">Name: </span>  {{service.name}}</h6>
                        <small class="text-muted">{{service.created_at}}</small>
                    </div>
                    <p><span class="font-weight-bold">Description: </span> {{service.desc}}</p>
                    <b-media>
                        <template #aside>
                            <feather-icon
                                icon="ServerIcon"
                                size="18"
                            />
                        </template>
                        <h6>
                            <span class="font-weight-bold">Window Number: </span>
                            {{service.queue_number}}
                        </h6>
                        <p class="mb-0">
                            <span class="font-weight-bold">Range Time: </span>
                            {{service.range_time}}
                        </p>
                    </b-media>
                </app-timeline-item>
            </app-timeline>
        </b-col>
    </b-row>
</template>
<script>
import {
    BCard, BImg, BMedia, BAvatar,BRow, BCol
} from 'bootstrap-vue'
import AppTimeline from '@core/components/app-timeline/AppTimeline.vue'
import AppTimelineItem from '@core/components/app-timeline/AppTimelineItem.vue'

export default {
    name:'DepartmentServices',
    components: {
        BCard,
        BImg,
        BMedia,
        BAvatar,
        AppTimeline,
        AppTimelineItem,
        BRow,
        BCol,
    },
    props: {
        services: {
            type: Array,
            default: () => [],
        },
    },
    computed:{
        randomVariant(){
            const variants = ['warning', 'info', 'primary', 'danger'];
            return variants[Math.floor(Math.random() * variants.length)];
        }
    }
}
</script>


