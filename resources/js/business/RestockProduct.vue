<template>
    <div>
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="col-form-label">Name</label>
                <input name="name" type="text" class="form-control"
                       :value="JSON.parse(product).name"
                       placeholder="Enter product name" disabled>
            </div>
        </div>


        <div class="row form-group">
            <!--QUANTITY-->
            <div class="col-sm-12 col-md-3">
                <label class="col-form-label">Quantity</label>
                <input type="text" name="quantity"
                       :value="JSON.parse(product).quantity"
                       class="form-control autonumber" placeholder="Enter product quantity" required>
            </div>

            <!--PAYMENT STATUS-->
            <div class="col-sm-12 col-md-3">
                <label class="col-form-label">Payment Status</label>
                <select name="payment_status" class="form-control" required @change="paymentStatusChange">
                    <option value="">--Select Payment Status--</option>
                    <option
                            v-for="status in JSON.parse(paymentStatus)"
                            :select="JSON.parse(product).payment_status === status"
                            :value="status">{{ status.toUpperCase() }}</option>
                </select>
            </div>

            <!--AMOUNT PAID-->
            <div v-if="this.showAmountPaid" class="col-sm-12 col-md-3">
                <label class="col-form-label">Amount Paid</label>
                <input type="text" name="amount_paid" class="form-control autoCurrency" placeholder="Enter amount paid" required>
            </div>

            <!--TOTAL PURCHASE PRICE-->
            <div class="col-sm-12 col-md-3">
                <label class="col-form-label">Total Purchase Price</label>
                <input type="text" name="total_purchase_price" class="form-control autoCurrency" placeholder="Enter purchase price" required>
            </div>

        </div>


        <!--Purchase Expenses-->
        <div class="row mt-5 mb-5" style="background-color: #f7f7f7;padding-top: 15px">

            <div class="col-sm-12">
                <h5>Purchase Expenses
                    <span @click="addExpenses()" class="text-white label theme-bg btn-shadow" style="cursor:pointer;"><i class="fa fa-plus"></i></span>
                </h5>
                <hr>
            </div>

            <div v-for="index in expenses" class="col-sm-12 col-md-3">
                <h6>Expenses {{ index }}</h6>
                <div class="row form-group">
                    <div class="col-sm-12">
                        <label class="col-form-label">Type</label>
                        <select :name="`expenses[${index}][type]`" class="form-control" @change="paymentStatusChange">
                            <option value="">--Select Expense Type--</option>
                            <option
                                    v-for="expense in JSON.parse(purchaseExpenses)"
                                    :value="expense">{{ expense }}</option>
                        </select>
                    </div>

                    <!--AMOUNT-->
                    <div class="col-sm-12">
                        <label class="col-form-label">Amount</label>
                        <input type="text" :name="`expenses[${index}][amount]`" class="form-control autoCurrency">
                    </div>
                </div>
            </div>
        </div>


        <!-- SUBMIT BUTTON-->
        <div class="row">
            <div class="col-sm-12 text-center mt-5">
                <button class="btn text-white label theme-bg btn-shadow">
                    <i class="fa fa-paper-plane"></i>
                    <b>Submit</b>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['product', 'paymentStatus', 'purchaseExpenses'],
        data() {
            return {
                showAmountPaid: false,
                expenses: 1,
                autoCurrency: null, autonumber: null,
            }
        },
        methods: {
            addExpenses: function () {
                if ( this.expenses < 4 ) {
                    this.expenses += 1;
                    this.reInitScripts();
                }
            },
            paymentStatusChange: function (event) {
                switch(event.target.value) {
                    case 'FULLY PAID':
                        this.showAmountPaid = false;
                        break;

                    case 'PART PAYMENT':
                        this.showAmountPaid = true;
                        break;

                    case 'UNPAID':
                        this.showAmountPaid = false;
                        break;
                }
            },

            initScripts: function () {
                this.autoCurrency = new AutoNumeric.multiple('.autoCurrency', {unformatOnSubmit: true, currencySymbol: '₦'});
                this.autonumber = new AutoNumeric.multiple('.autonumber', {unformatOnSubmit: true, decimalPlaces: 0});
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
            this.initScripts();
            // console.log(JSON.parse(this.product));
        }
    }
</script>
