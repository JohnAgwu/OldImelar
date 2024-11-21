require('./bootstrap');

Vue.component('edit-business', require('./business/EditBusiness.vue').default);

const EditBusiness = new Vue({
    el: 'edit-business',
});
