<template>
    <section class="faq-contact">
        <b-row>
            <b-col sm="4" class=" d-flex align-self-stretch">
                <b-card
                    class="shadow-none py-1 faq-contact-card d-flex flex-column" style="width: 100%!important;"
                >
                    <b-avatar
                        size="42"
                        rounded
                        variant="light-primary"
                        class="text-center mb-2"
                        style="margin-left: 45%;"
                    >
                        <feather-icon
                            icon="MailIcon"
                            size="18"
                        />
                    </b-avatar>
                    <h4  class="text-center">Details </h4>
                    <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Name : </span>{{organization.name}}
                    </div>
                    <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Phone : </span>{{organization.phone}}
                    </div>
                    <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Email : </span>{{organization.email}}
                    </div>
                    <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Website url : </span>
                        <a  v-if="organization.website_url"
                            target="_blank"
                            class="btn btn-primary website"
                            :href="organization.website_url"
                        >
                            <feather-icon
                                icon="Link2Icon"
                                class="mr-50"
                            />
                            <span class="align-middle">website</span>
                        </a>
                        <span v-else>....</span>
                    </div>
                    <div class="text-body mb-1" v-if="organization.desc">
                        <span class="mr-1 text-light font-weight-bold">Description : </span>{{organization.desc}}
                    </div>
                </b-card>
            </b-col>

            <b-col sm="4" class=" d-flex align-self-stretch">
                <b-card
                    class="shadow-none py-1 faq-contact-card d-flex flex-column" style="width: 100%!important;"
                >
                    <b-avatar
                        size="42"
                        rounded
                        variant="light-primary"
                        class="text-center mb-2"
                        style="margin-left: 45%;"
                    >
                        <feather-icon
                            icon="MapIcon"
                            size="18"
                        />
                    </b-avatar>
                    <h4  class="text-center">Address</h4>
                    <div class="text-body mb-1" v-if="organization.desc">
                        <span class="mr-1 text-light font-weight-bold">Description : </span>{{organization.desc}}
                    </div>
                    <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Address: </span>{{organization.address}}
                    </div>
                    <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Latitude: </span>{{organization.lat}}
                    </div>
                    <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Longitude: </span>{{organization.long}}
                    </div>

                </b-card>
            </b-col>
            <b-col sm="4" class=" d-flex align-self-stretch">
                <b-card
                    class="shadow-none py-1 faq-contact-card d-flex flex-column" style="width: 100%!important;"
                >
                    <b-avatar
                        size="42"
                        rounded
                        variant="light-primary"
                        class="mb-2"
                        style="margin-left: 45%;"
                    >
                        <feather-icon
                            icon="MessageCircleIcon"
                            size="18"
                        />
                    </b-avatar>
                    <h4 class="text-center">ChatBot</h4>
                    <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Token: </span>{{organization.token}}
                    </div>
                    <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Instance Id: </span>{{organization.instance_id}}
                    </div>
                    <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Welcome Message: </span>{{organization.welcome_msg}}
                    </div>
                                        <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Error Message: </span>{{organization.error_msg}}
                    </div>
                                        <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Department Message: </span>{{organization.department_msg}}
                    </div>
                                        <div class="text-body mb-1">
                        <span class="mr-1 text-light font-weight-bold">Service Message: </span>{{organization.service_msg}}
                    </div>
                </b-card>
            </b-col>
        </b-row>
    </section>
</template>
<script>
import {
    BCard,
    BCardBody,
    BCardText,
    BImg,
    BRow,
    BCol,
    BAvatar,
} from 'bootstrap-vue'
export default {
    name:'OrganizationDetails',
    props:{
        organization:{
            type: Object,
            default: () => {},
        }
    },
    components: {
        BCard,
        BRow,
        BCol,
        BAvatar,
        BCardBody,
        BCardText,
        BImg,
    },
}
</script>
