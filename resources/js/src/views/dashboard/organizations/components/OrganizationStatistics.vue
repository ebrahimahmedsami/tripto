<template>
    <b-row class="match-height">
        <b-col lg="2" cols="6">
            <b-card body-class="pb-50">
                <h6>Logo</h6>
                <b-form-group
                    label-for="vi-logo"
                >
                    <a
                        download="organization_Logo"
                        :href="'/images/organization/logo/'+logo||'no-image-icon.png'"
                        title="ImageName"
                    >
                        <div
                            id="vi-logo"
                            class="previewBlock"
                            :style="{ 'background-image': `url(/images/organization/logo/${logo||'no-image-icon.png'})` }"
                        />
                    </a>
                </b-form-group>
            </b-card>
        </b-col>
        <b-col
            lg="2"
            cols="6"
        >
            <b-card body-class="pb-50">
                <h6>QrCode</h6>
                <b-form-group
                    label-for="vi-previewBlock"
                >
                    <a
                        download="organization_Logo"
                        :href="'/images/organization/qrcode/'+qr_code||'no-image-icon.png'"
                        title="ImageName"
                    >
                        <div
                            id="vi-previewBlock"
                            class="previewBlock"
                            :style="{ 'background-image': `url(/images/organization/qrcode/${qr_code||'no-image-icon.png'})` }"
                        />
                    </a>
                </b-form-group>
            </b-card>
        </b-col>
        <b-col
            lg="8"
            cols="12"
        >
            <b-card
                no-body
                class="card-statistics"
            >
                <b-card-header>
                    <b-card-title>Statistics</b-card-title>
                </b-card-header>
                <b-card-body class="statistics-body">
                    <b-row>
                        <b-col
                            v-for="item in statistics"
                            :key="item.icon"
                            md="3"
                            sm="6"
                            class="mb-2 mb-md-0"
                            :class="item.customClass"
                        >
                            <b-media no-body>
                                <b-media-aside

                                    class="mr-2"
                                >
                                    <b-avatar
                                        size="48"
                                        :variant="item.color"
                                    >
                                        <feather-icon
                                            size="24"
                                            :icon="item.icon"
                                        />
                                    </b-avatar>
                                </b-media-aside>
                                <b-media-body class="my-auto">
                                    <h4 class="font-weight-bolder mb-0">
                                        {{ item.count }}
                                    </h4>
                                    <b-card-text class="font-small-3 mb-0">
                                        {{ item.subtitle }}
                                    </b-card-text>
                                </b-media-body>
                            </b-media>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
</template>
<script>
import {
    BCard,BFormGroup, BCardHeader, BCardTitle, BCardText, BCardBody, BRow, BCol, BMedia, BMediaAside, BAvatar, BMediaBody,
} from 'bootstrap-vue'
import axios from "axios";

export default {
    name:'OrganizationStatistics',
    components: {
        BRow,
        BCol,
        BCard,
        BCardHeader,
        BCardTitle,
        BCardText,
        BCardBody,
        BMedia,
        BAvatar,
        BMediaAside,
        BMediaBody,
        BFormGroup
    },
    props:{
        qr_code:{
            type:String,
            default:()=>''
        },
        logo:{
            type:String,
            default:()=>''
        }
    },
    data() {
        return {
            statistics:[],
        }
    },
    mounted(){
        this.getStatistics()
    },
    methods:{
        getStatistics(){
            axios.get(`organization-statistics/${this.$route.params.id}`)
                .then(response=> this.statistics = response.data.statistics)
                .catch(error=>console.log(error))
        }
    }
}
</script>
<style scoped>
.previewBlock {
    display: block;
    cursor: pointer;
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    background-position: center center;
    background-size: cover;
}
</style>

