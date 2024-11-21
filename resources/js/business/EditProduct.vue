<template>
    <div>
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="col-form-label">Name</label>
                <input name="name" type="text" class="form-control"
                       :value="JSON.parse(product).name"
                       placeholder="Enter product name" required>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-4">
                <img :src="'/storage/'+JSON.parse(product).image.path" class="img-thumbnail" width="100">
            </div>
            <!--PRODUCT IMAGE-->
            <div class="col-sm-8">
                <label class="col-form-label">Change Product Image</label>
                <input type="file" accept="image/*" name="image" class="form-control">
            </div>
        </div>

        <!--DESCRIPTION-->
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="col-form-label">Description</label>
                <textarea name="description" class="form-control" rows="5">{{ JSON.parse(product).description }}</textarea>
            </div>
        </div>

        <div class="row form-group">
            <!--SIZE-->
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Size</label>
                <input type="text" name="size"
                       :value="JSON.parse(product).size"
                       class="form-control autonumber" placeholder="Enter product size" required>
            </div>

            <!--UNIT-->
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Unit</label>
                <select name="unit" id="" class="form-control" required>
                    <option value="">--Select unit of measurement--</option>
                    <option
                            v-for="unit in JSON.parse(unitOfMearsurement)"
                            :selected="JSON.parse(product).unit === unit"
                            :value="unit">{{ unit.toUpperCase() }}</option>
                </select>
            </div>

            <!--QUANTITY-->
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Quantity</label>
                <input type="text" name="quantity"
                       :value="JSON.parse(product).quantity"
                       class="form-control autonumber" placeholder="Enter product quantity" required>
            </div>
        </div>

        <div class="row form-group">
            <!--PAYMENT STATUS-->
            <div class="col-sm-12 col-md-3">
                <label class="col-form-label">Payment Status</label>
                <select name="payment_status" class="form-control" required @change="paymentStatusChange">
                    <option value="">--Select Payment Status--</option>
                    <option
                            v-for="status in JSON.parse(paymentStatus)"
                            :selected="status == JSON.parse(product).payment_status"
                            :value="status">{{ status.toUpperCase() }}</option>
                </select>
            </div>

            <!--AMOUNT PAID-->
            <div v-if="this.showAmountPaid" class="col-sm-12 col-md-3">
                <label class="col-form-label">Amount Paid</label>
                <input type="text" name="amount_paid" class="form-control autoCurrency" placeholder="Enter amount paid" required :value="JSON.parse(product).amount_paid">
            </div>

            <!--TOTAL PURCHASE PRICE-->
            <div class="col-sm-12 col-md-3">
                <label class="col-form-label">Total Purchase Price</label>
                <input type="text" name="total_purchase_price" class="form-control autoCurrency" placeholder="Enter purchase price" required :value="JSON.parse(product).total_purchase_price">
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

            <div v-for="(exp, index) in pexpenses" class="col-sm-12 col-md-3">
                <h6>Expenses {{ index + 1}}</h6>
                <div class="row form-group">
                    <div class="col-sm-12">
                        <label class="col-form-label">Type {{ exp.type }}</label>
                        <select :name="`expenses[${index}][type]`" class="form-control" required @change="paymentStatusChange">
                            <option value="">--Select Expense Type--</option>
                            <option
                                    v-for="expense in JSON.parse(purchaseExpenses)"
                                    :selected="expense === exp.type"
                                    :value="expense">{{ expense }}
                            </option>
                        </select>
                    </div>

                    <!--AMOUNT-->
                    <div class="col-sm-12">
                        <label class="col-form-label">Amount</label>
                        <input type="text" :name="`expenses[${index}][amount]`" class="form-control autoCurrency" required :value="exp.amount">
                    </div>
                </div>
            </div>
        </div>


<!--        <div class="row form-group">-->
<!--            &lt;!&ndash;MIN SELLING PRICE&ndash;&gt;-->
<!--            <div class="col-sm-12 col-md-6">-->
<!--                <label class="col-form-label">Min Selling Price(per unit)</label>-->
<!--                <input type="text" name="min_selling_price" class="form-control autoCurrency" required>-->
<!--            </div>-->

<!--            &lt;!&ndash;MAX SELLING PRICE&ndash;&gt;-->
<!--            <div class="col-sm-12 col-md-6">-->
<!--                <label class="col-form-label">Max Selling Price(per unit)</label>-->
<!--                <input type="text" name="max_selling_price" class="form-control autoCurrency" required>-->
<!--            </div>-->
<!--        </div>-->


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
        props: ['product', 'unitOfMearsurement', 'paymentStatus', 'purchaseExpenses'],
        data() {
            return {
                showAmountPaid: false,
                pexpenses: null,
                expenses: 1,
                autoCurrency: null, autonumber: null,
            }
        },
        methods: {
            addExpenses: function () {
                console.log(this.expenses, JSON.parse(this.purchaseExpenses).length);
                if ( this.expenses < JSON.parse(this.purchaseExpenses).length ) {
                    this.expenses += 1;
                    this.pexpenses.push({type: null, amount: null});

                    console.log(this.pexpenses);
                    this.reInitScripts();
                }
            },

            paymentStatusChange: function (event, local = false) {
                let value = event;
                if ( !local ) {
                    value = event.target.value;
                }

                switch(value) {
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
            this.$nextTick(function () {
                this.pexpenses = JSON.parse(this.product).expenses;
                this.expenses = this.pexpenses.length;
                this.paymentStatusChange(JSON.parse(this.product).payment_status, true);
            });
            this.initScripts();
            // console.log(JSON.parse(this.product));
        }
    }
</script>
