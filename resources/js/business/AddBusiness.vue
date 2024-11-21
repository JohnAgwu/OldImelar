<template>
    <div>
        <div class="row form-group">
            <!--NAME-->
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Business Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!--PHONE-->
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Business Phone Number</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <!--EMAIL-->
            <div class="col-sm-12 col-md-4">
                <label class="col-form-label">Business Email</label>
                <input type="text" name="email" class="form-control">
            </div>
        </div>

        <div class="row form-group p-3 position-relative" style="background: #ececec;">
            <div class="col-sm-12">
                <h5><u>Social media accounts</u></h5>
            </div>

            <div class="col-sm-12 col-md-4">
                <!--NAME-->
                <label class="col-form-label">Select Account</label>
                <select name="social[0][type]" class="form-control">
                    <option value="">--Select Account--</option>
                    <option v-for="sa in JSON.parse(socialAccounts)" :value="sa.toLowerCase()">{{ sa }}</option>
                </select>

                <!--VALUE-->
                <label class="col-form-label">Social Account URL</label>
                <input type="text" name="social[0][value]" class="form-control">
            </div>
            <div class="col-sm-12 col-md-4">
                <!--NAME-->
                <label class="col-form-label">Select Account</label>
                <select name="social[0][type]" class="form-control">
                    <option value="">--Select Account--</option>
                    <option v-for="sa in JSON.parse(socialAccounts)" :value="sa.toLowerCase()">{{ sa }}</option>
                </select>

                <!--VALUE-->
                <label class="col-form-label">Social Account URL</label>
                <input type="text" name="social[0][value]" class="form-control">
            </div>
            <div class="col-sm-12 col-md-4">
                <!--NAME-->
                <label class="col-form-label">Select Account</label>
                <select name="social[0][type]" class="form-control">
                    <option value="">--Select Account--</option>
                    <option v-for="sa in JSON.parse(socialAccounts)" :value="sa.toLowerCase()">{{ sa }}</option>
                </select>

                <!--VALUE-->
                <label class="col-form-label">Social Account URL</label>
                <input type="text" name="social[0][value]" class="form-control">
            </div>

        </div>

        <div class="row form-group">
            <!--COUNTRY-->
            <div class="col-sm-12 col-md-2">
                <label class="col-form-label">Country</label>
                <input type="text" name="country"
                       :value="JSON.parse(ipInfo).country"
                       class="form-control" required>
            </div>

            <!--STATE-->
            <div class="col-sm-12 col-md-2">
                <label class="col-form-label">State</label>
<!--                <input type="text" name="state"-->
<!--                       :value="JSON.parse(ipInfo).state_name"-->
<!--                       class="form-control" required>-->

                <select name="state" class="form-control" v-on:change="changeState()" v-model="myState">
                    <option
                            v-for="st in states"
                            :value="st">{{ st }}</option>
                </select>
            </div>

            <!--LGA-->
            <div class="col-sm-12 col-md-2">
                <label class="col-form-label">LGA</label>
<!--                <input type="text" name="lga" class="form-control">-->
                <select name="lga" class="form-control">
                    <option
                            v-for="lg in lga"
                            :value="lg">{{ lg }}</option>
                </select>
            </div>

            <!--ADDRESS-->
            <div class="col-sm-12 col-md-6">
                <label class="col-form-label">Address</label>
                <input type="text" name="address" class="form-control" placeholder="Business Address">
            </div>
        </div>

        <!--DESCRIPTION-->
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="col-form-label">Description</label>
                <textarea name="description" class="form-control" rows="5"></textarea>
            </div>
        </div>

        <div class="row form-group">
            <!--Business Mode-->
            <div class="col-sm-12">
                <label class="col-form-label">Business Mode</label>
                <select name="mode" class="form-control" required @change="this.changeMode">
                    <option value="BUY_&_SELL">Buying and selling</option>
                    <option value="FREELANCE">Freelance</option>
                </select>
            </div>
        </div>

        <div class="row form-group">
            <!--CATEGORY-->
            <div class="col">
                <label class="col-form-label">Business category</label>
                <select name="category" class="form-control" required>
                    <option v-for="btype in JSON.parse(businessTypes)" :value="btype">{{ btype }}</option>
                </select>
            </div>

            <!--SUB-CATEGORY-->
            <div class="col">
                <label class="col-form-label">Sub Category</label>
                <input type="text" name="sub_category" class="form-control">
            </div>

            <!--TYPE-->
            <div class="col" v-show="!this.hideBusinessType">
                <label class="col-form-label">Business Type</label>
                <select name="type" class="form-control" required>
                    <option value="WHOLESALER">WHOLESALER</option>
                    <option value="RETAILER">RETAILER</option>
                    <option value="BOTH">BOTH</option>
                </select>
            </div>
        </div>

        <div class="row form-group">
            <!--LOGO-->
            <div class="col-sm-12 col-md-6">
                <label class="col-form-label">Business Logo</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
            </div>

            <!--COVER PHOTO-->
            <div class="col-sm-12 col-md-6">
                <label class="col-form-label">Cover Photo</label>
                <input type="file" name="cover" class="form-control" accept="image/*">
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
        props: ['businessTypes', 'socialAccounts', 'ipInfo'],
        data() {
            return {
                myState: "Select item...",
                myLga: "",
                states: ['Select item...', 'Abia', 'Adamawa', 'Akwa-Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno', 'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'Gombe', 'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara'],
                lga: ['Select item...'],
                hideBusinessType: false,
            }
        },
        methods: {
            changeState: function () {
                let data = [];
                switch (this.myState) {
                    case "Abia":
                        data = ['Select item...', 'Aba North', 'Aba South', 'Arochukwu', 'Bende', 'Ikwuano', 'Isiala Ngwa North', 'Isiala Ngwa South', 'Isuikwuato', 'Obi Ngwa', 'Ohafia', 'Osisioma', 'Ugwunagbo', 'Ukwa East', 'Ukwa West', 'Umuahia North', 'muahia South', 'Umu Nneochi'];
                        break;

                    case "Adamawa":
                        data = ['Select item...', 'Demsa', 'Fufure', 'Ganye', 'Gayuk', 'Gombi', 'Grie', 'Hong', 'Jada', 'Larmurde', 'Madagali', 'Maiha', 'Mayo Belwa', 'Michika', 'Mubi North', 'Mubi South', 'Numan', 'Shelleng', 'Song', 'Toungo', 'Yola North', 'Yola South'];
                        break;
                    case "Akwa-Ibom":
                        data = ['Select item...', 'Abak', 'Eastern Obolo', 'Eket', 'Esit Eket', 'Essien Udim', 'Etim Ekpo', 'Etinan', 'Ibeno', 'Ibesikpo Asutan', 'Ibiono-Ibom', 'Ika', 'Ikono', 'Ikot Abasi', 'Ikot Ekpene', 'Ini', 'Itu', 'Mbo', 'Mkpat-Enin', 'Nsit-Atai', 'Nsit-Ibom', 'Nsit-Ubium', 'Obot Akara', 'Okobo', 'Onna', 'Oron', 'Oruk Anam', 'Udung-Uko', 'Ukanafun', 'Uruan', 'Urue-Offong Oruko', 'Uyo'];
                        break;
                    case "Anambra":
                        data = ['Select item...', 'Aguata', 'Anambra East', 'Anambra West', 'Anaocha', 'Awka North', 'Awka South', 'Ayamelum', 'Dunukofia', 'Ekwusigo', 'Idemili North', 'Idemili South', 'Ihiala', 'Njikoka', 'Nnewi North', 'Nnewi South', 'Ogbaru', 'Onitsha North', 'Onitsha South', 'Orumba North', 'Orumba South', 'Oyi'];
                        break;

                    case "Anambra":
                        data = ['Select item...', 'Aguata', 'Anambra East', 'Anambra West', 'Anaocha', 'Awka North', 'Awka South', 'Ayamelum', 'Dunukofia', 'Ekwusigo', 'Idemili North', 'Idemili South', 'Ihiala', 'Njikoka', 'Nnewi North', 'Nnewi South', 'Ogbaru', 'Onitsha North', 'Onitsha South', 'Orumba North', 'Orumba South', 'Oyi'];
                        break;
                    case "Bauchi":
                        data = ['Select item...', 'Alkaleri', 'Bauchi', 'Bogoro', 'Damban', 'Darazo', 'Dass', 'Gamawa', 'Ganjuwa', 'Giade', 'Itas-Gadau', 'Jama are', 'Katagum', 'Kirfi', 'Misau', 'Ningi', 'Shira', 'Tafawa Balewa', ' Toro', ' Warji', ' Zaki'];

                        break;

                    case "Bayelsa":
                        data = ['Select item...', 'Brass', 'Ekeremor', 'Kolokuma Opokuma', 'Nembe', 'Ogbia', 'Sagbama', 'Southern Ijaw', 'Yenagoa'];

                        break;
                    case "Benue":
                        data = ['Select item...', 'Agatu', 'Apa', 'Ado', 'Buruku', 'Gboko', 'Guma', 'Gwer East', 'Gwer West', 'Katsina-Ala', 'Konshisha', 'Kwande', 'Logo', 'Makurdi', 'Obi', 'Ogbadibo', 'Ohimini', 'Oju', 'Okpokwu', 'Oturkpo', 'Tarka', 'Ukum', 'Ushongo', 'Vandeikya'];

                        break;
                    case "Borno":
                        data =  ['Select item...', 'Abadam', 'Askira-Uba', 'Bama', 'Bayo', 'Biu', 'Chibok', 'Damboa', 'Dikwa', 'Gubio', 'Guzamala', 'Gwoza', 'Hawul', 'Jere', 'Kaga', 'Kala-Balge', 'Konduga', 'Kukawa', 'Kwaya Kusar', 'Mafa', 'Magumeri', 'Maiduguri', 'Marte', 'Mobbar', 'Monguno', 'Ngala', 'Nganzai', 'Shani'];

                        break;
                    case "Cross River":
                        data =  ['Select item...', 'Abi', 'Akamkpa', 'Akpabuyo', 'Bakassi', 'Bekwarra', 'Biase', 'Boki', 'Calabar Municipal', 'Calabar South', 'Etung', 'Ikom', 'Obanliku', 'Obubra', 'Obudu', 'Odukpani', 'Ogoja', 'Yakuur', 'Yala'];

                        break;

                    case "Delta":
                        data =  ['Select item...', 'Aniocha North', 'Aniocha South', 'Bomadi', 'Burutu', 'Ethiope East', 'Ethiope West', 'Ika North East', 'Ika South', 'Isoko North', 'Isoko South', 'Ndokwa East', 'Ndokwa West', 'Okpe', 'Oshimili North', 'Oshimili South', 'Patani', 'Sapele', 'Udu', 'Ughelli North', 'Ughelli South', 'Ukwuani', 'Uvwie', 'Warri North', 'Warri South', 'Warri South West'];

                        break;

                    case "Ebonyi":
                        data = ['Select item...', 'Abakaliki', 'Afikpo North', 'Afikpo South', 'Ebonyi', 'Ezza North', 'Ezza South', 'Ikwo', 'Ishielu', 'Ivo', 'Izzi', 'Ohaozara', 'Ohaukwu', 'Onicha'];
                        break;
                    case "Edo":
                        data = ['Select item...', 'Akoko-Edo', 'Egor', 'Esan Central', 'Esan North-East', 'Esan South-East', 'Esan West', 'Etsako Central', 'Etsako East', 'Etsako West', 'Igueben', 'Ikpoba Okha', 'Orhionmwon', 'Oredo', 'Ovia North-East', 'Ovia South-West', 'Owan East', 'Owan West', 'Uhunmwonde'];
                        break;

                    case "Ekiti":
                        data = ['Select item...', 'Ado Ekiti', 'Efon', 'Ekiti East', 'Ekiti South-West', 'Ekiti West', 'Emure', 'Gbonyin', 'Ido Osi', 'Ijero', 'Ikere', 'Ikole', 'Ilejemeje', 'Irepodun-Ifelodun', 'Ise-Orun', 'Moba', 'Oye'];
                        break;
                    case "Rivers":
                        data = ['Select item...', 'Port Harcourt', 'Obio-Akpor', 'Okrika', 'Ogu–Bolo', 'Eleme', 'Tai', 'Gokana', 'Khana', 'Oyigbo', 'Opobo–Nkoro', 'Andoni', 'Bonny', 'Degema', 'Asari-Toru', 'Akuku-Toru', 'Abua–Odual', 'Ahoada West', 'Ahoada East', 'Ogba–Egbema–Ndoni', 'Emohua', 'Ikwerre', 'Etche', 'Omuma'];
                    case "Enugu":
                        data =  ['Select item...', 'Aninri', 'Awgu', 'Enugu East', 'Enugu North', 'Enugu South', 'Ezeagu', 'Igbo Etiti', 'Igbo Eze North', 'Igbo Eze South', 'Isi Uzo', 'Nkanu East', 'Nkanu West', 'Nsukka', 'Oji River', 'Udenu', 'Udi', 'Uzo Uwani'];
                        break;
                    case "Abuja":
                        data =  ['Select item...', 'Abaji', 'Bwari', 'Gwagwalada', 'Kuje', 'Kwali', 'Municipal Area Council'];
                        break;
                    case "Gombe":
                        data =   ['Select item...', 'Akko', 'Balanga', 'Billiri', 'Dukku', 'Funakaye', 'Gombe', 'Kaltungo', 'Kwami', 'Nafada', 'Shongom', 'Yamaltu-Deba'];
                        break;
                    case "Imo":
                        data =   ['Select item...', 'Aboh Mbaise', 'Ahiazu Mbaise', 'Ehime Mbano', 'Ezinihitte', 'Ideato North', 'Ideato South', 'Ihitte-Uboma', 'Ikeduru', 'Isiala Mbano', 'Isu', 'Mbaitoli', 'Ngor Okpala', 'Njaba', 'Nkwerre', 'Nwangele', 'Obowo', 'Oguta', 'Ohaji-Egbema', 'Okigwe', 'Orlu', 'Orsu', 'Oru East', 'Oru West', 'Owerri Municipal', 'Owerri North', 'Owerri West', 'Unuimo'];
                        break;
                    case "Jigawa":
                        data =   ['Select item...', 'Auyo', 'Babura', 'Biriniwa', 'Birnin Kudu', 'Buji', 'Dutse', 'Gagarawa', 'Garki', 'Gumel', 'Guri', 'Gwaram', 'Gwiwa', 'Hadejia', 'Jahun', 'Kafin Hausa', 'Kazaure', 'Kiri Kasama', 'Kiyawa', 'Kaugama', 'Maigatari', 'Malam Madori', 'Miga', 'Ringim', 'Roni', 'Sule Tankarkar', 'Taura', 'Yankwashi'];
                        break;
                    case "Kaduna":
                        data =  ['Select item...', 'Birnin Gwari', 'Chikun', 'Giwa', 'Igabi', 'Ikara', 'Jaba', 'Jema a', 'Kachia', 'Kaduna North', 'Kaduna South', 'Kagarko', 'Kajuru', 'Kaura', 'Kauru', 'Kubau', 'Kudan', 'Lere', 'Makarfi', 'Sabon Gari', 'Sanga', 'Soba', 'Zangon Kataf', 'Zaria'];
                        break;
                    case "Kano":
                        data = ['Select item...', 'Ajingi', 'Albasu', 'Bagwai', 'Bebeji', 'Bichi', 'Bunkure', 'Dala', 'Dambatta', 'Dawakin Kudu', 'Dawakin Tofa', 'Doguwa', 'Fagge', 'Gabasawa', 'Garko', 'Garun Mallam', 'Gaya', 'Gezawa', 'Gwale', 'Gwarzo', 'Kabo', 'Kano Municipal', 'Karaye', 'Kibiya', 'Kiru', 'Kumbotso', 'Kunchi', 'Kura', 'Madobi', 'Makoda', 'Minjibir', 'Nasarawa', 'Rano', 'Rimin Gado', 'Rogo', 'Shanono', 'Sumaila', 'Takai', 'Tarauni', 'Tofa', 'Tsanyawa', 'Tudun Wada', 'Ungogo', 'Warawa', 'Wudil'];
                        break;
                    case "Katsina":
                        data = ['Select item...', 'Bakori', 'Batagarawa', 'Batsari', 'Baure', 'Bindawa', 'Charanchi', 'Dandume', 'Danja', 'Dan Musa', 'Daura', 'Dutsi', 'Dutsin Ma', 'Faskari', 'Funtua', 'Ingawa', 'Jibia', 'Kafur', 'Kaita', 'Kankara', 'Kankia', 'Katsina', 'Kurfi', 'Kusada', 'Mai Adua', 'Malumfashi', 'Mani', 'Mashi', 'Matazu', 'Musawa', 'Rimi', 'Sabuwa', 'Safana', 'Sandamu', 'Zango'];
                        break;
                    case "Kebbi":
                        data =  ['Select item...', 'Aleiro', 'Arewa Dandi', 'Argungu', 'Augie', 'Bagudo', 'Birnin Kebbi', 'Bunza', 'Dandi', 'Fakai', 'Gwandu', 'Jega', 'Kalgo', 'Koko Besse', 'Maiyama', 'Ngaski', 'Sakaba', 'Shanga', 'Suru', 'Wasagu Danko', 'Yauri', 'Zuru'];
                        break;
                    case "Kogi":
                        data =  ['Select item...', 'Adavi', 'Ajaokuta', 'Ankpa', 'Bassa', 'Dekina', 'Ibaji', 'Idah', 'Igalamela Odolu', 'Ijumu', 'Kabba Bunu', 'Kogi', 'Lokoja', 'Mopa Muro', 'Ofu', 'Ogori Magongo', 'Okehi', 'Okene', 'Olamaboro', 'Omala', 'Yagba East', 'Yagba West'];
                        break;
                    case "Kwara":
                        data =  ['Select item...', 'Asa', 'Baruten', 'Edu', 'Ekiti', 'Ifelodun', 'Ilorin East', 'Ilorin South', 'Ilorin West', 'Irepodun', 'Isin', 'Kaiama', 'Moro', 'Offa', 'Oke Ero', 'Oyun', 'Pategi'];
                        break;
                    case "Lagos":
                        data = ['Select item...', 'Agege', 'Ajeromi-Ifelodun', 'Alimosho', 'Amuwo-Odofin', 'Apapa', 'Badagry', 'Epe', 'Eti Osa', 'Ibeju-Lekki', 'Ifako-Ijaiye', 'Ikeja', 'Ikorodu', 'Kosofe', 'Lagos Island', 'Lagos Mainland', 'Mushin', 'Ojo', 'Oshodi-Isolo', 'Shomolu', 'Surulere'];
                        break;
                    case "Nassarawa":
                        data = ['Select item...', 'Akwanga', 'Awe', 'Doma', 'Karu', 'Keana', 'Keffi', 'Kokona', 'Lafia', 'Nasarawa', 'Nasarawa Egon', 'Obi', 'Toto', 'Wamba'];
                        break;
                    case "Niger":
                        data = ['Select item...', 'Agaie', 'Agwara', 'Bida', 'Borgu', 'Bosso', 'Chanchaga', 'Edati', 'Gbako', 'Gurara', 'Katcha', 'Kontagora', 'Lapai', 'Lavun', 'Magama', 'Mariga', 'Mashegu', 'Mokwa', 'Moya', 'Paikoro', 'Rafi', 'Rijau', 'Shiroro', 'Suleja', 'Tafa', 'Wushishi'];
                        break;
                    case "Ogun":
                        data = ['Select item...', 'Abeokuta North', 'Abeokuta South', 'Ado-Odo Ota', 'Egbado North', 'Egbado South', 'Ewekoro', 'Ifo', 'Ijebu East', 'Ijebu North', 'Ijebu North East', 'Ijebu Ode', 'Ikenne', 'Imeko Afon', 'Ipokia', 'Obafemi Owode', 'Odeda', 'Odogbolu', 'Ogun Waterside', 'Remo North', 'Shagamu'];
                        break;
                    case "Ondo":
                        data = ['Select item...', 'Akoko North-East', 'Akoko North-West', 'Akoko South-West', 'Akoko South-East', 'Akure North', 'Akure South', 'Ese Odo', 'Idanre', 'Ifedore', 'Ilaje', 'Ile Oluji-Okeigbo', 'Irele', 'Odigbo', 'Okitipupa', 'Ondo East', 'Ondo West', 'Ose', 'Owo'];
                        break;
                    case "Osun":
                        data = ['Select item...', 'Atakunmosa East', 'Atakunmosa West', 'Aiyedaade', 'Aiyedire', 'Boluwaduro', 'Boripe', 'Ede North', 'Ede South', 'Ife Central', 'Ife East', 'Ife North', 'Ife South', 'Egbedore', 'Ejigbo', 'Ifedayo', 'Ifelodun', 'Ila', 'Ilesa East', 'Ilesa West', 'Irepodun', 'Irewole', 'Isokan', 'Iwo', 'Obokun', 'Odo Otin', 'Ola Oluwa', 'Olorunda', 'Oriade', 'Orolu', 'Osogbo'];
                        break;
                    case "Oyo":
                        data = ['Select item...', 'Afijio', 'Akinyele', 'Atiba', 'Atisbo', 'Egbeda', 'Ibadan North', 'Ibadan North-East', 'Ibadan North-West', 'Ibadan South-East', 'Ibadan South-West', 'Ibarapa Central', 'Ibarapa East', 'Ibarapa North', 'Ido', 'Irepo', 'Iseyin', 'Itesiwaju', 'Iwajowa', 'Kajola', 'Lagelu', 'Ogbomosho North', 'Ogbomosho South', 'Ogo Oluwa', 'Olorunsogo', 'Oluyole', 'Ona Ara', 'Orelope', 'Ori Ire', 'Oyo', 'Oyo East', 'Saki East', 'Saki West', 'Surulere'];
                        break;
                    case "Plateau":
                        data = ['Select item...', 'Bokkos', 'Barkin Ladi', 'Bassa', 'Jos East', 'Jos North', 'Jos South', 'Kanam', 'Kanke', 'Langtang South', 'Langtang North', 'Mangu', 'Mikang', 'Pankshin', 'Qua an Pan', 'Riyom', 'Shendam', 'Wase'];
                        break;
                    case "Sokoto":
                        data = ['Select item...', 'Binji', 'Bodinga', 'Dange Shuni', 'Gada', 'Goronyo', 'Gudu', 'Gwadabawa', 'Illela', 'Isa', 'Kebbe', 'Kware', 'Rabah', 'Sabon Birni', 'Shagari', 'Silame', 'Sokoto North', 'Sokoto South', 'Tambuwal', 'Tangaza', 'Tureta', 'Wamako', 'Wurno', 'Yabo'];
                        break;
                    case "Taraba":
                        data =  ['Select item...', 'Ardo Kola', 'Bali', 'Donga', 'Gashaka', 'Gassol', 'Ibi', 'Jalingo', 'Karim Lamido', 'Kumi', 'Lau', 'Sardauna', 'Takum', 'Ussa', 'Wukari', 'Yorro', 'Zing'];
                        break;
                    case "Yobe":
                        data =   ['Select item...', 'Bade', 'Bursari', 'Damaturu', 'Fika', 'Fune', 'Geidam', 'Gujba', 'Gulani', 'Jakusko', 'Karasuwa', 'Machina', 'Nangere', 'Nguru', 'Potiskum', 'Tarmuwa', 'Yunusari', 'Yusufari'];
                        break;
                    case "Zamfara":
                        data =   ['Select item...', 'Anka', 'Bakura', 'Birnin Magaji Kiyaw', 'Bukkuyum', 'Bungudu', 'Gummi', 'Gusau', 'Kaura Namoda', 'Maradun', 'Maru', 'Shinkafi', 'Talata Mafara', 'Chafe', 'Zurmi'];

                }

                this.lga = data;
            },

            changeMode: function (event) {
                if ( event.target.value === 'FREELANCE' ) {
                    this.hideBusinessType = true
                } else {
                    this.hideBusinessType = false
                }
            }
        },
        mounted() {
        }
    }
</script>
