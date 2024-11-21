require('./bootstrap');

Vue.component('add-project', require('./business/AddProject.vue').default);

const addProduct = new Vue({
    el: 'add-project',
});
