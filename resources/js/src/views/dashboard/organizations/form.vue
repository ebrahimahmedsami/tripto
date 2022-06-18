<template>
  <div>
    <form-wizard
      color="#7367F0"
      :title="null"
      :subtitle="null"
      finish-button-text="Submit"
      back-button-text="Previous"
      class="steps-transparent mb-3"
      @on-complete="formSubmitted"
    >
      <!-- Organization detail tab -->
      <tab-content
        title="Details"
        icon="feather icon-file-text"
    >
        <b-row>
          <!-- Logo -->
          <b-col
            v-if="filePreview"
            md="6"
          >
            <b-form-group
              label="Logo"
              label-for="vi-previewBlock"
            >
              <a
                download="organization_Logo"
                :href="filePreview"
                title="ImageName"
              >
                <div
                  id="vi-previewBlock"
                  class="previewBlock"
                  :style="{ 'background-image': `url(${filePreview})` }"
                />
              </a>
            </b-form-group>
          </b-col>
          <!-- QR code -->
          <b-col
            v-if="qr_code"
            md="6"
          >
            <b-form-group
              label="QR code"
              label-for="vi-qrcode"
            >
              <a
                download="organization_Qrcode"
                :href="qr_code"
                title="ImageName"
              >
                <div
                  id="vi-qrcode"
                  class="previewBlock"
                  :style="{ 'background-image': `url(${qr_code})` }"
                />
              </a>

            </b-form-group>
          </b-col>
        </b-row>
        <b-row>
          <b-col
            cols="12"
            class="mb-2"
          >
            <h5 class="mb-0">
              Resort Details
            </h5>
            <small class="text-muted">
              Enter Your Resort Details.
            </small>
          </b-col>
          <!-- Logo -->
          <b-col md="6">
            <b-form-group
              label="Logo"
              label-for="vi-logo"
            >
              <b-input-group class="input-group-merge">
                <b-form-file
                  id="vi-logo"
                  ref="fileInput"
                  v-model="organization.logo"
                  accept="image/*"
                  placeholder="Logo"
                  @input="selectImgFile"
                />
              </b-input-group>
              <label
                v-if="Object.keys(errors).length > 0 && errors.logo !== undefined"
                class="text-danger"
              >
                {{ errors.logo[0] }}
              </label>
            </b-form-group>
          </b-col>
          <!-- name -->
          <b-col md="6">
            <b-form-group
              label="Name"
              label-for="vi-name"
            >
              <b-input-group class="input-group-merge">
                <b-input-group-prepend is-text>
                  <feather-icon icon="UserIcon" />
                </b-input-group-prepend>
                <b-form-input
                  id="vi-name"
                  v-model="organization.name"
                  placeholder="Name"
                />
              </b-input-group>
              <label
                v-if="Object.keys(errors).length > 0 && errors.name !== undefined"
                class="text-danger"
              >
                {{ errors.name[0] }}
              </label>
            </b-form-group>
          </b-col>
          <!-- phone -->
          <b-col md="6">
            <b-form-group
              label="Phone"
              label-for="vi-phone"
            >
              <b-input-group class="input-group-merge">
                <b-input-group-prepend is-text>
                  <feather-icon icon="SmartphoneIcon" />
                </b-input-group-prepend>
                <b-form-input
                  id="vi-phone"
                  v-model="organization.phone"
                  type="number"
                  placeholder="Phone"
                />
              </b-input-group>
              <label
                v-if="Object.keys(errors).length > 0 && errors.phone !== undefined"
                class="text-danger"
              >
                {{ errors.phone[0] }}
              </label>
            </b-form-group>
          </b-col>
          <!-- Email -->
          <b-col md="6">
            <b-form-group
              label="Email"
              label-for="vi-email"
            >
              <b-input-group class="input-group-merge">
                <b-input-group-prepend is-text>
                  <feather-icon icon="MailIcon" />
                </b-input-group-prepend>
                <b-form-input
                  id="vi-email"
                  v-model="organization.email"
                  type="email"
                  placeholder="Email"
                />
              </b-input-group>
              <label
                v-if="Object.keys(errors).length > 0 && errors.email !== undefined"
                class="text-danger"
              >
                {{ errors.email[0] }}
              </label>
            </b-form-group>
          </b-col>
          <!-- status -->
          <b-col cols="6">
            <b-form-group
              label="Status"
              label-for="vi-status"
            >
              <b-input-group class="input-group-merge">
                <v-select
                  v-model="organization.status"
                  placeholder="Status..."
                  :options="status"
                  :reduce="sta => sta.value"
                  label="name"
                />
              </b-input-group>
              <label
                v-if="Object.keys(errors).length > 0 && errors.status !== undefined"
                class="text-danger"
              >
                {{ errors.status[0] }}
              </label>
            </b-form-group>
          </b-col>

          <!-- website_url -->
          <b-col cols="6">
            <b-form-group
              label="Website Url"
              label-for="vi-website_url"
            >
              <b-input-group class="input-group-merge">
                <b-input-group-prepend is-text>
                  <feather-icon icon="LinkIcon" />
                </b-input-group-prepend>
                <b-form-input
                  id="vi-website_url"
                  v-model="organization.website_url"
                  type="url"
                  placeholder="Website Url"
                />
              </b-input-group>
              <label
                v-if="Object.keys(errors).length > 0 && errors.website_url !== undefined"
                class="text-danger"
              >
                {{ errors.website_url[0] }}
              </label>
            </b-form-group>
          </b-col>
          <!-- description -->
          <b-col cols="12">
            <label for="textarea-default">Description</label>
            <b-input-group class="input-group-merge">
              <b-form-textarea
                id="textarea-default"
                v-model="organization.desc"
                placeholder="Description"
                rows="3"
              />
            </b-input-group>
            <label
              v-if="Object.keys(errors).length > 0 && errors.desc !== undefined"
              class="text-danger"
            >
              {{ errors.desc[0] }}
            </label>
          </b-col>
        </b-row>
      </tab-content>

      <!-- Resort address -->
      <tab-content
        title="Address"
        icon="feather icon-map-pin"
      >
        <b-row>
          <b-col
            cols="12"
            class="mb-2"
          >
            <h5 class="mb-0">
              Resort Address
            </h5>
            <small class="text-muted">
              Enter Your Resort Address.
            </small>
          </b-col>
          <!-- Address -->
          <b-col cols="12">
            <b-form-group
              label="Address"
              label-for="vi-address"
            >
              <b-input-group class="input-group-merge">
                <b-input-group-prepend is-text>
                  <feather-icon icon="MapIcon" />
                </b-input-group-prepend>
                <b-form-input
                  id="vi-address"
                  v-model="organization.address"
                  type="text"
                  placeholder="Address"
                />
              </b-input-group>
              <label
                v-if="Object.keys(errors).length > 0 && errors.address !== undefined"
                class="text-danger"
              >
                {{ errors.address[0] }}
              </label>
            </b-form-group>
          </b-col>
                    <b-col cols="12">
            <b-form-group
              label="Welcome Message"
              label-for="vi-temp_msg"
            >

                    <emoji-picker @emoji="append" :search="search">
                    <div
                        class="emoji-invoker"
                        slot="emoji-invoker"
                        slot-scope="{ events: { click: clickEvent } }"
                        @click.stop="clickEvent"
                    >
                        <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none"/>
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                        </svg>
                    </div>
                    <div slot="emoji-picker" slot-scope="{ emojis, insert }">
                        <div class="emoji-picker" :style="{ top: 50 + 'px', right: 16 + 'px' }">
                        <div class="emoji-picker__search">
                            <input type="text" v-model="search" v-focus>
                        </div>
                        <div>
                            <div v-for="(emojiGroup, category) in emojis" :key="category">
                            <h5>{{ category }}</h5>
                            <div class="emojis">
                                <span
                                v-for="(emoji, emojiName) in emojiGroup"
                                :key="emojiName"
                                @click="insert(emoji)"
                                :title="emojiName"
                                >{{ emoji }}</span>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </emoji-picker>
              <b-input-group class="input-group-merge">
                <b-input-group-prepend is-text>
                  <feather-icon icon="MessageCircleIcon" />
                </b-input-group-prepend>

                <b-form-textarea
                  id="vi-temp_msg"
                  v-model="organization.temp_msg"
                  rows="5"
                  type="text"
                  placeholder="Welcome Message"
                  class="welcome_msg_textarea"
                />
              </b-input-group>
              <label
                v-if="Object.keys(errors).length > 0 && errors.temp_msg !== undefined"
                class="text-danger"
              >
                {{ errors.temp_msg[0] }}
              </label>
            </b-form-group>
          </b-col>


      <b-col cols="6">
                <b-form-group
                    label="Government"
                    label-for="vi-government"
                >
                    <b-input-group class="input-group-merge">
                        <v-select
                            placeholder="Government..."
                            :options="governments"
                            :reduce="gov => gov.id"
                            label="name"
                            @input="getGovCities"
                        />
                    </b-input-group>
                    <label
                        v-if="Object.keys(errors).length > 0 && errors.government !== undefined"
                        class="text-danger"
                    >
                        {{this.errors.government[0]}}
                    </label>
                </b-form-group>
            </b-col>

            <b-col cols="6">
                <b-form-group
                    label="City"
                    label-for="vi-city"
                >
                    <b-input-group class="input-group-merge">
                        <v-select
                            placeholder="City..."
                            :options="cities"
                            :reduce="city => city.id"
                            label="name"
                        />
                    </b-input-group>
                    <label
                        v-if="Object.keys(errors).length > 0 && errors.city !== undefined"
                        class="text-danger"
                    >
                        {{this.errors.city[0]}}
                    </label>
                </b-form-group>
            </b-col>

        </b-row>
      </tab-content>
    </form-wizard>
  </div>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import {
  BRow, BCol, BFormGroup, BFormInput, BFormCheckbox, BForm, BButton, BInputGroup, BInputGroupPrepend, BFormTextarea, BFormValidFeedback,
  BFormInvalidFeedback, BFormFile,
} from 'bootstrap-vue'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import axios from 'axios'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import { EmojiPicker } from 'vue-emoji-picker'

export default {
  components: {
    BRow,
    EmojiPicker,
    vSelect,
    BCol,
    BFormValidFeedback,
    BFormInvalidFeedback,
    BFormGroup,
    BFormInput,
    BFormTextarea,
    BFormCheckbox,
    BInputGroup,
    BInputGroupPrepend,
    BForm,
    BButton,
    FormWizard,
    TabContent,
    BFormFile,
    ToastificationContent,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
        input: '',
      search: '',
      errors: {},
      governments:[],
      cities:[],
      organization: {
        name: '',
        phone: '',
        email: '',
        address: '',
        website_url: '',
        lat: '',
        long: '',
        desc: '',
        token: '',
        instance_id: '',
        temp_msg: '',
        logo: null,
        qr_code: '',
        status: '',
        error_msg:'',
        department_msg:'',
        service_msg:'',
      },
      filePreview: null,
      qr_code: '',
        status:[
            {name:'Active',value:'1'},
            {name:'In Active',value:'0'},
        ],
    }
  },
  mounted() {
    if (this.$route.params.id) {
      this.getOrganization()
    }
  },
   directives: {
    focus: {
      inserted(el) {
        el.focus()
      },
    },
  },
  methods: {
    getGovCities(){

    },
      append(emoji) {
      this.organization.temp_msg += emoji
    },
    formSubmitted() {
      const config = {
        headers: {
          'content-type': 'multipart/form-data',
        },
      }
      const formData = new FormData()
      for (const key in this.organization) {
        if (this.organization[key]) {
          formData.append(key, this.organization[key])
        }
      }
      if (this.$route.params.id) {
          formData.append('_method', 'PATCH')
          axios.post(`organizations/${this.$route.params.id}`, formData, config)
          .then(data => this.formSuccess(data))
          .catch(error => this.formCatchError(error))
      } else {
        axios.post('organizations', formData, config)
          .then(data => this.formSuccess(data))
          .catch(error => this.formCatchError(error))
      }
    },
    selectImgFile() {
      const { fileInput } = this.$refs
      const imgFile = fileInput.files
      if (imgFile && imgFile[0]) {
        const reader = new FileReader()
        reader.onload = e => {
          this.filePreview = e.target.result
          this.organization.logo = imgFile[0]
        }
        reader.readAsDataURL(imgFile[0])
        this.$emit('fileInput', imgFile[0])
      }
    },
    formSuccess(data) {
      this.errors = {}
      this.makeToast('success', data.data.message)
      setTimeout(() => {
         this.$router.push({ name: 'organizations' })
      }, 1000)
    },
    formCatchError(error) {
      if (error.response) {
        this.makeToast('danger', error.response.data.message)
        this.errors = error.response.data.errors
      }
    },
    makeToast(variant = null, body) {
      return this.$bvToast.toast(body, {
            title: `Variant ${variant || 'default'}`,
            variant,
            solid: true,
          })
    },
    getOrganization() {
      axios.get(`/organizations/${this.$route.params.id}/edit`)
        .then(({ data }) => {
          if (data.status) {
            Object.keys(this.organization).forEach(key => {
                console.log(data.organization[key])
              if (key == 'logo') this.filePreview = data.organization[key]
              else this.organization[key] = data.organization[key]
            })
            this.qr_code = data.organization.qr_code
            this.organization.id = data.organization.id
          }
        })
    },
  },
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
<style lang="scss" >
@import 'https://unpkg.com/vue-select@3.0.0/dist/vue-select.css';
.v-select{
    width: 100% !important;
}



.emoji-invoker {
position: absolute;
    top: 25px;
    z-index: 9;
    right: 23px;
  width: 1.5rem;
  height: 1.5rem;
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.2s;
}
.emoji-invoker:hover {
  transform: scale(1.1);
}
.emoji-invoker > svg {
  fill: #b1c6d0;
}

.emoji-picker {
  position: absolute;
  z-index: 1;
  font-family: Montserrat;
  border: 1px solid #161d31;
  width: 15rem;
  height: 20rem;
  overflow-y: scroll;
  padding: 1rem;
  box-sizing: border-box;
  border-radius: 0.5rem;
  background: #283046 !important;

}
.emoji-picker__search {
  display: flex;
}
.emoji-picker__search > input {
  flex: 1;
  border-radius: 10rem;
  border: 1px solid #ccc;
  padding: 0.5rem 1rem;
  outline: none;
  margin-bottom: 7px;
    width: 166px !important;
}
.emoji-picker h5 {
  margin-bottom: 0;
  color: #b1b1b1;
  text-transform: uppercase;
  font-size: 0.8rem;
  cursor: default;
}
.emoji-picker .emojis {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}
.emoji-picker .emojis:after {
  content: "";
  flex: auto;
}
.emoji-picker .emojis span {
  padding: 0.2rem;
  cursor: pointer;
  border-radius: 5px;
}
.emoji-picker .emojis span:hover {
  background: #ececec;
  cursor: pointer;
}

</style>
