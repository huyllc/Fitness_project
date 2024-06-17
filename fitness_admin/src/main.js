import { createApp } from 'vue'
import App from './App.vue'
import './assets/css/app.css'
import './registerServiceWorker'
import store from './store'
import router from './router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import { getCookie } from './utils/cookie'

axios.defaults.baseURL = 'http://127.0.0.1:8000/api'
axios.interceptors.request.use(config => {
    const token = getCookie('adminToken'); 
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});
createApp(App)
    .use(store)
    .use(router)
    .use(VueAxios, axios)
    .mount('#app')
