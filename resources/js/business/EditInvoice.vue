<template>
    <div>
        <!--PRODUCT-->
        <div v-if="JSON.parse(business).mode == 'FREELANCE'" class="row form-group p-3" style="background-color: #e1e9f3">
            <div class="col-sm-12">
                <h5>Projects
                    <span @click="addProduct()" class="text-white label theme-bg btn-shadow" style="cursor:pointer;"><i class="fa fa-plus f-14"></i></span>
                </h5>
                <hr>
            </div>

            <div v-for="p in products" class="col-sm-12 mb-3">
                <h6>Product {{ p }}</h6>
                <div class="row">
                    <div class="col">
                        <label class="col-form-label">Select Project</label>
                        <select :name="`projects[${getProduct(p - 1).project_id}][project_id]`" class="form-control" required>
                            <option
                                    :selected="getProduct(p - 1).project_id === project.id"
                                    v-for="project in JSON.parse(business)['projects']"
                                    :value="project.id">{{ project.title }}</option>
                        </select>
                    </div>

                    <!--SELLINIG PRICE-->
                    <div class="col">
                        <label class="col-form-label">Project Price</label>
                        <input type="text"
                               :value="getProduct(p - 1).price"
                               :name="`products[${getProduct(p - 1).product_id}][price]`" class="form-control autoCurrency" required>
                    </div>
                </div>
            </div>

        </div>


        <div v-else class="row form-group p-3" style="background-color: #e1e9f3">
            <div class="col-sm-12">
                <h5>Products
                    <span @click="addProduct()" class="text-white label theme-bg btn-shadow" style="cursor:pointer;"><i class="fa fa-plus f-14"></i></span>
                </h5>
                <hr>
            </div>

            <div v-for="p in products" class="col-sm-12 mb-3">
                <h6>Product {{ p }}</h6>
                <div class="row">
                    <div class="col-sm-4">
                        <label class="col-form-label">Select Product</label>
                        <select :name="`products[${getProduct(p - 1).product_id}][product_id]`" class="form-control" required>
                            <option
                                    :selected="getProduct(p - 1).product_id === product.id"
                                    v-for="product in JSON.parse(business)['products']"
                                    :value="product.id">{{ product.name }}</option>
                        </select>
                    </div>

                    <!--QUANTITY-->
                    <div class="col-sm-12 col-md-4">
                        <label class="col-form-label">Quantity</label>
                        <input type="text"
                               :value="getProduct(p - 1).quantity"
                               :name="`products[${getProduct(p - 1).product_id}][quantity]`" class="form-control autonumber" required>
                    </div>

                    <!--SELLINIG PRICE-->
                    <div class="col-sm-12 col-md-4">
                        <label class="col-form-label">Selling Price (per unit)</label>
                        <input type="text"
                               :value="getProduct(p - 1).amount"
                               :name="`products[${getProduct(p - 1).product_id}][amount]`" class="form-control autoCurrency" required>
                    </div>
                </div>
            </div>

        </div>


        <div class="row form-group">
            <!--PAYMENT STATUS-->
            <div class="col-sm-12">
                <label class="col-form-label">Payment Status</label>
                <select name="payment_status" class="form-control" required @change="paymentStatusChange">
                    <option value="">--Select Payment Method--</option>
                    <option v-for="status in JSON.parse(paymentStatus)"
                            :selected="status == JSON.parse(invoice).payment_status"
                            :value="status">{{ status.toUpperCase() }}</option>
                </select>
            </div>
        </div>

        <!--PAYMENT METHOD-->
        <div class="row form-group" v-if="showPaymentMethod">
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Payment Method</label>
                <select name="payment_method" class="form-control" required>
                    <option v-for="method in JSON.parse(paymentMethods)"
                            :selected="method == JSON.parse(invoice).payment_method"
                            :value="method">{{ method.toUpperCase() }}</option>
                </select>
            </div>

            <!--PAYMENT DATE-->
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Payment Date</label>
                <input type="text" name="payment_date" :value="JSON.parse(invoice).payment_date" class="form-control datepicker" placeholder="Date" data-dtp="dtp_G1khd">
            </div>

            <!--AMOUNT PAID-->
            <div class="col-sm-12 col-md-4" v-if="!hideAmountPaid">
                <label class="col-form-label">Amount Paid</label>
                <input type="text" name="amount_paid" :value="JSON.parse(invoice).amount_paid" class="form-control autoCurrency" placeholder="Enter amount paid" required>
            </div>
        </div>

        <!--BANK DETAIL-->
        <div class="row form-group" v-if="showBank">
            <div class="col-sm-12 col-md-6" v-if="JSON.parse(banks).length > 0">
                <label class="col-form-label">Select Bank</label>
                <select name="bank" class="form-control" required>
                    <option v-for="bank in JSON.parse(banks)"
                            :value="bank.id">{{ bank.account_name }}({{bank.account_number}}) - {{bank.name.toUpperCase()}}</option>
                </select>
            </div>
            <div class="col-sm-12 col-md-6" v-else>
                <label class="col-form-label">You do not have any bank for this business</label>
                <a :href="`/business/${JSON.parse(business).id}/banks/add`" class="btn btn-block btn-sm btn-primary">Add Bank</a>
            </div>

            <!--PAYMENT OPTION-->
            <div class="col-sm-12 col-md-3">
                <label class="col-form-label">Payment Option</label>
                <select name="payment_option" class="form-control" required>
                    <option :selected="JSON.parse(invoice).payment_option === 'MANUAL'" value="MANUAL">Manual Payment</option>
                    <option :selected="JSON.parse(invoice).payment_option === 'AUTOMATIC'" value="AUTOMATIC">Automatic Payment</option>
                </select>
            </div>

            <!--PAYMENT DUE DATE-->
            <div class="col-sm-12 col-md-3">
                <label class="col-form-label">Payment Due Date</label>
                <input type="text" name="payment_due_date" :value="JSON.parse(invoice).payment_due_date" class="form-control datepicker" data-dtp="dtp_G1khd">
            </div>
        </div>

        <!--CUSTOMER DETAIL-->
        <div class="row form-group">
            <div class="col-sm-12 col-md-6">
                <label class="col-form-label">Select Channel</label>
                <select name="sending_channel" class="form-control" required>
                    <option v-for="channel in JSON.parse(channels)"
                            :selected="channel == JSON.parse(invoice).sending_channel"
                            :value="channel">{{ channel }}</option>
                </select>
            </div>

            <!--Customer-->
            <div class="col-sm-12 col-md-6">
                <label class="col-form-label">Select Customer</label>
                <select name="customer_id" class="form-control" required>
                    <option
                            v-for="customer in JSON.parse(customers)"
                            :selected="JSON.parse(invoice).customer.id == customer.id"
                            :value="customer['id']">{{ customer['user']['name'] }} ({{ customer['user']['email'] }})</option>
                </select>
            </div>
        </div>

        <div class="row form-group">
            <!--EXPENSES INCURRED-->
            <div class="col-sm-12 col-md-6">
                <label class="col-form-label">Expense Incurred</label>
                <input type="text" name="expenses_incurred" :value="JSON.parse(invoice).expenses_incurred" class="form-control autoCurrency" required>
            </div>

            <!--DATE DISPATCHED-->
            <div class="col-sm-12 col-md-6">
                <label class="col-form-label">Date Dispatched</label>
                <input type="text" name="dispatched_at" :value="JSON.parse(invoice).dispatched_at" class="form-control datepicker" data-dtp="dtp_G1khd">
            </div>
        </div>

        <!-- SUBMIT BUTTON-->
        <div class="row">
            <div class="col-sm-12 text-center mt-5">

                <div class="form-group">
                    <div class="radio radio-fill d-inline">
                        <input type="radio" name="action" id="save-invoice" value="save" checked>
                        <label for="save-invoice" class="cr">Save Invoice</label>
                    </div>

                    <div class="radio radio-fill d-inline ml-3">
                        <input type="radio" name="action" id="send-invoice" value="send">
                        <label for="send-invoice" class="cr">Send Invoice</label>
                    </div>
                </div>


                <button class="btn text-white label theme-bg btn-shadow" id="submit">
                    <i class="fa fa-paper-plane"></i>  &nbsp
                    <b>Submit</b>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['business', 'invoice', 'paymentStatus', 'paymentMethods', 'banks', 'channels', 'customers'],
        data() {
            return {
                showPaymentMethod: false,
                showBank: false,
                hideAmountPaid: true,
                products: 1,
                autoCurrency: null, autonumber: null,
                datepicker: null
            }
        },
        methods: {
            paymentStatusChange: function (event, local = false) {
                let value = event;
                if ( !local ) {
                    value = event.target.value;
                }

                switch(value) {
                    case 'FULLY PAID':
                        this.showPaymentMethod = true;
                        this.showBank = false;
                        this.hideAmountPaid = true;
                        this.reInitScripts();
                        break;

                    case 'PART PAYMENT':
                        this.showPaymentMethod = true;
                        this.showBank = true;
                        this.hideAmountPaid = false;
                        this.reInitScripts();
                        break;

                    case 'UNPAID':
                        this.showPaymentMethod = false;
                        this.showBank = true;
                        this.hideAmountPaid = true;
                        this.reInitScripts();
                        break;
                }
            },

            getProduct: function (index) {
                if ( JSON.parse(this.business).mode == 'FREELANCE' ) {
                    return JSON.parse(this.invoice)['projects'][index];
                }
                else {
                    return JSON.parse(this.invoice)['products'][index];
                }
            },

            hasProduct: function(id) {
                let products = JSON.parse(this.invoice).products;
                var length = products.length;
                for(var i = 0; i < length; i++) {
                    if (products[i].product_id === id) {
                        return true;
                    }
                }

                return false;
            },

            addProduct: function () {
                if ( JSON.parse(this.business).mode == 'FREELANCE' ) {
                    if ( this.products < JSON.parse(this.business)['projects'].length ) {
                        this.products += 1;
                        this.reInitScripts();
                    }
                }
                else {
                    if ( this.products < JSON.parse(this.business)['products'].length ) {
                        this.products += 1;
                        this.reInitScripts();
                    }
                }
            },

            initScripts: function () {
                $('#products').select2({
                    placeholder: "Select Products"
                });

                this.autoCurrency = new AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
                this.autonumber = new AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0});

                this.datepicker = $('.datepicker').bootstrapMaterialDatePicker({
                    weekStart: 0,
                    time: false
                });
            },

            reInitScripts: function () {
                for ( let i = 0; i < this.autoCurrency.length; i++ ) {
                    this.autoCurrency[i].remove();
                }
                for ( let i = 0; i < this.autonumber.length; i++ ) {
                    this.autonumber[i].remove();
                }

                this.$nextTick(function () {
                    this.initScripts();
                });
            }
        },
        mounted() {
            this.$nextTick(function () {
                this.paymentStatusChange(JSON.parse(this.invoice).payment_status, true);

                if ( JSON.parse(this.business).mode == 'FREELANCE' ) {
                    this.products = JSON.parse(this.invoice)['projects'].length;
                }
                else {
                    this.products = JSON.parse(this.invoice)['products'].length;
                }
            });
            this.initScripts();
        }
    }
</script>
