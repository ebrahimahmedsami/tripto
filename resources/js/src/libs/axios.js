import Vue from 'vue'

// axios
import axios from 'axios'

axios.defaults.baseURL = '/api/v1'
axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('accessToken')}`

const axiosIns = axios.create({
  // You can add your headers here
  // ================================
  // baseURL: 'https://some-domain.com/api/v1',
  // timeout: 1000,
  // headers: {'X-Custom-Header': 'foobar'}
})

Vue.prototype.$http = axiosIns

export default axiosIns
