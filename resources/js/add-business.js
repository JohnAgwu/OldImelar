require('./bootstrap');

Vue.component('add-business', require('./business/AddBusiness.vue').default);

const AddBusiness = new Vue({
    el: 'add-business',
});
