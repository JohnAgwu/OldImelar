require('./bootstrap');

Vue.component('edit-project', require('./business/EditProject.vue').default);

const editProduct = new Vue({
    el: 'edit-project',
});
