require('./bootstrap');

Vue.component('edit-invoice', require('./business/EditInvoice').default);

const EditInvoice = new Vue({
    el: 'edit-invoice',
});
