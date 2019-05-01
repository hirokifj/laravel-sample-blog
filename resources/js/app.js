require('./bootstrap');

window.Vue = require('vue');

Vue.component('live-preview-input', require('./components/LivePreviewInput.vue').default);

const app = new Vue({
    el: '#app'
});
