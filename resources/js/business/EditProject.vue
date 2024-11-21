<template>
    <div>
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="col-form-label">Title</label>
                <input name="title" type="text" :value="JSON.parse(project).title" class="form-control" placeholder="Enter project title" required>
            </div>
        </div>


        <!--DESCRIPTION-->
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="col-form-label">Description</label>
                <textarea name="description" class="form-control" rows="5">{{ JSON.parse(project).description }}</textarea>
            </div>
        </div>

<!--        End Date-->
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="col-form-label">End Date</label>
                <input name="end_date" type="date" class="form-control" :value="JSON.parse(project).end_date" required>
            </div>
        </div>


        <div class="row form-group">
            <!--Project STATUS-->
            <div class="col">
                <label class="col-form-label">Project Status</label>
                <select name="status" class="form-control" required :value="JSON.parse(project).status">
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

        </div>


        <div class="row form-group">
            <!--PAYMENT STATUS-->
            <div class="col">
                <label class="col-form-label">Payment Status</label>
                <select name="payment_status" class="form-control" required @change="paymentStatusChange" :value="JSON.parse(project).payment_status">
                    <option value="">--Select Payment Status--</option>
                    <option
                            v-for="status in JSON.parse(paymentStatus)"
                            :value="status">{{ status.toUpperCase() }}</option>
                </select>
            </div>

            <!--AMOUNT PAID-->
            <div v-show="this.showAmountPaid" class="col-sm-12 col-md-4">
                <label class="col-form-label">Amount Paid</label>
                <input type="text" name="amount_paid" class="form-control autoCurrency" placeholder="Enter amount paid" :value="JSON.parse(project).amount_paid">
            </div>

            <!--TOTAL PURCHASE PRICE-->
            <div class="col">
                <label class="col-form-label">Project Price</label>
                <input type="text" name="price" class="form-control autoCurrency" placeholder="Enter project price" :value="JSON.parse(project).price" required>
            </div>

        </div>


        <!--Purchase Expenses-->
        <div class="row mt-5 mb-5" style="background-color: #f7f7f7;padding-top: 15px">

            <div class="col-sm-12">
                <h5>Project Expenses
                    <span @click="addExpenses()" class="text-white label theme-bg btn-shadow" style="cursor:pointer;"><i class="fa fa-plus"></i></span>
                </h5>
                <hr>
            </div>

            <div v-for="index in expenses" class="col-sm-12">
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
        props: ['project', 'paymentStatus', 'purchaseExpenses'],
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
                this.autonumber = new AutoNumeric.multiple('.autoDecimal', {unformatOnSubmit: true, decimalPlaces: 2});
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
            // console.log(JSON.parse(this.paymentStatus));
        }
    }
</script>
