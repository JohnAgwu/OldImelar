require('./bootstrap');

Vue.component('send-invoice', require('./business/SendInvoice.vue').default);

const SendInvoice = new Vue({
    el: 'send-invoice',
});
