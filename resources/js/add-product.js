require('./bootstrap');

Vue.component('add-product', require('./business/AddProduct.vue').default);

const addProduct = new Vue({
    el: 'add-product',
});
