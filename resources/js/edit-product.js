require('./bootstrap');

Vue.component('edit-product', require('./business/EditProduct.vue').default);
Vue.component('restock-product', require('./business/RestockProduct.vue').default);

const editProduct = new Vue({
    el: 'edit-product',
});


const restockProduct = new Vue({
    el: 'restock-product',
});