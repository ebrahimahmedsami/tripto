import Vue from 'vue'
import { ToastPlugin, ModalPlugin, BvComponent } from 'bootstrap-vue'
import VueCompositionAPI from '@vue/composition-api'

import i18n from '@/libs/i18n'
import router from './router'
import store from './store'
import App from './App.vue'

// Global Components
import './global-components'

// 3rd party plugins
import axios from '@axios'
import '@/libs/acl'
import '@/libs/portal-vue'
import '@/libs/clipboard'
import '@/libs/toastification'
import '@/libs/sweet-alerts'
import '@/libs/vue-select'
import '@/libs/tour'
import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

// Axios Mock Adapter
import '@/@fake-db/db';

// auth user
Vue.prototype.$user = localStorage.getItem('userData');
// gate
import Gate from './Gate';
Vue.prototype.$gate = new Gate(JSON.parse(Vue.prototype.$user));
// BSV Plugin Registration
Vue.use(ToastPlugin)
Vue.use(ModalPlugin)
Vue.use(VueSweetalert2)

// Composition API
Vue.use(VueCompositionAPI)
// Feather font icon - For form-wizard
// * Shall remove it if not using font-icons of feather-icons - For form-wizard
require('@core/assets/fonts/feather/iconfont.css') // For form-wizard

// import core styles
require('@core/scss/core.scss')

// import assets styles
require('@/assets/scss/style.scss')

Vue.config.productionTip = false

window.axios = axios;

window.Fire = new Vue();

new Vue({
  router,
  store,
  i18n,
  render: h => h(App),
}).$mount('#app')
