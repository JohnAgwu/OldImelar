<template>
    <div>
        <div class="row form-group">
            <!--NAME-->
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Business Name</label>
                <input type="text" :value="JSON.parse(business).name" name="name" class="form-control">
            </div>

            <!--PHONE-->
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Business Phone Number</label>
                <input type="text" :value="JSON.parse(business).phone" name="phone" class="form-control">
            </div>

            <!--EMAIL-->
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Business Email</label>
                <input type="text" :value="JSON.parse(business).email" name="email" class="form-control">
            </div>
        </div>

        <div class="row form-group p-3 position-relative" style="background: #ececec;">
            <div class="col-sm-12">
                <h5><u>Social Accounts</u></h5>
            </div>
            <!--NAME-->
            <div class="col-sm-12 col-md-4" v-for="(social, key) in JSON.parse(this.business).social">
                <label class="col-form-label">Select Account</label>
                <select :name="`social[${key}][type]`" class="form-control">
                    <option value="">--Select Account--</option>
                    <option v-for="sa in JSON.parse(socialAccounts)" :selected="social.type === sa.toLowerCase()" :value="sa.toLowerCase()">{{ sa }}</option>
                </select>

                <label class="col-form-label">Social Account URL</label>
                <input type="text" :value="social['value']" :name="`social[${key}][value]`"  class="form-control">
            </div>

        </div>

        <div class="row form-group">
            <!--ADDRESS-->
            <div class="col-sm-12 col-md-6">
                <label class="col-form-label">Address</label>
                <input type="text" name="address" class="form-control" :value="JSON.parse(business).address">
            </div>

            <!--LGA-->
            <div class="col-sm-12 col-md-2">
                <label class="col-form-label">LGA</label>
                <input type="text" :value="JSON.parse(business).lga" name="lga" class="form-control">
            </div>

            <!--STATE-->
            <div class="col-sm-12 col-md-2">
                <label class="col-form-label">State</label>
                <input type="text" :value="JSON.parse(business).state" name="state" class="form-control">
            </div>

            <!--COUNTRY-->
            <div class="col-sm-12 col-md-2">
                <label class="col-form-label">Country</label>
                <input type="text" :value="JSON.parse(business).country" name="country" class="form-control">
            </div>
        </div>

        <div class="row form-group">
            <!--DESCRIPTION-->
            <div class="col-sm-12">
                <label class="col-form-label">Description</label>
                <textarea :value="JSON.parse(business).description" name="description" class="form-control" rows="5"></textarea>
            </div>
        </div>

        <div class="row form-group">
            <!--CATEGORY-->
            <div class="col-sm-4">
                <label class="col-form-label">Select Type of Business</label>
                <select name="category" class="form-control" required>
                    <option v-for="btype in JSON.parse(businessTypes)" :selected="btype === JSON.parse(business).category" :value="btype">{{ btype }}</option>
                </select>
            </div>

            <!--SUB-CATEGORY-->
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Sub Category</label>
                <input type="text" :value="JSON.parse(business).sub_category" name="sub_category" class="form-control">
            </div>

            <!--TYPE-->
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Business Type</label>
                <select name="type" class="form-control" required>
                    <option value="WHOLESALER" :selected="JSON.parse(business).type.toUpperCase() == 'WHOLESALER'">WHOLESALER</option>
                    <option value="RETAILER" :selected="JSON.parse(business).type.toUpperCase() == 'RETAILER'">RETAILER</option>
                </select>
            </div>
        </div>

        <div class="row form-group">
            <!--LOGO-->
            <div class="col-sm-12 col-md-6">
                <label class="col-form-label">Business Logo</label>
                <img :src="JSON.parse(business).logo" width="150" v-if="JSON.parse(business).logo !== null">
                <input type="file" name="logo" class="form-control" accept="image/*" :required="JSON.parse(business).logo === null">
            </div>

            <!--COVER PHOTO-->
            <div class="col-sm-12 col-md-6">
                <label class="col-form-label">Cover Photo</label>
                <img :src="JSON.parse(business).cover" width="150" v-if="JSON.parse(business).cover !== null">
                <input type="file" name="cover" class="form-control" accept="image/*" :required="JSON.parse(business).logo === null">
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
        props: ['business', 'businessTypes', 'socialAccounts'],
        data() {
            return {}
        },
        methods: {},
        mounted() {}
    }
</script>
