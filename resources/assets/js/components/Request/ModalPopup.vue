<i18n>
    {
        "ar":{
            "client": {
                "add": "اضافة عميل جديد",
                "name": "الاسم",
                "telephone":"رقم الجوال",
                "email":"البريد الاليكترونى",
                "gender":"النوع",
                "country":"بلد الاقامة",
                "city":"المدينة",
                "nationality":"الجنسية",
                "birthDate":"تاريخ الميلاد"
            },
            "validations":{
                "addName":"من فضلك ادخل الاسم",
                "nameChar":"مسموح فقط بالحروف العربية والانجليزية",
                "mobileExists":"الرقم موجود مسبقا بالفعل",
                "mobileCount":"عدد الارقام يجب ان يكون من 3 ل 20 رقم",
                "mobileNumbers":"مسموح بالارقام فقط",
                "mobileEmpty":"من فضلك ضع رقم التليفون",
                "chooseGender":"ن فضلك اختار النوع",
                "addCountry":"من فضلك اختار المدينة",
                "addCity":"من فضلك اختار المدينة",
                "nationality":"من فضلك اختار الجنسية",
                "email":"من فضلك ادخل ايميل صالح",
                "emailExists":"الايميل موجود بالفعل"
            },
            "next":"التالى",
            "male":"ذكر",
            "female":"مؤنث",
            "noResults":"لايوجد نتائج",
            "save":"حفظ",
            "cancel":"الغاء",
            "addBirthDate":"ضع تاريخ ميلادك",
            "datePickerLang":"ar"
        },

        "en": {
            "client": {
                "add": "Add New Client",
                "name": "name",
                "telephone":"telephone",
                "email":"email",
                "gender":"gender",
                "country":"Accomodation Country",
                "city":"city",
                "nationality":"Nationality",
                "birthDate":"birthDate"
            },
            "validations":{
                "addName":"Please Add Name",
                "nameChar":"Only English and Arabic characters valid",
                "mobileExists":"Mobile Number already exists",
                "mobileCount":"Mobile Number must be from 3 to 20 number",
                "mobileNumbers":"Must be numbers only",
                "mobileEmpty":"Mobile Number must not be empty",
                "chooseGender":"Please choose gender",
                "addCountry":"please choose country",
                "addCity":"please choose city",
                "nationality":"please choose nationality",
                "email":"please enter valid email",
                "emailExists":"Email already exists"
            },
            "next":"next",
            "male":"male",
            "female":"female",
            "noResults":"No Results",
            "save":"save",
            "cancel":"cancel",
            "addBirthDate":"Add your BirthDate",
            "datePickerLang":"en"
        }
    }
</i18n>

<template>
    <b-modal
        v-model="show"
        centered
        :no-close-on-esc="true"
        :no-close-on-backdrop="true"
        :hide-header-close="true"
        size="lg"
        :header-class="'justify-content-center'">
        <h5 slot="modal-title">
            {{ $t("client.add") }}
        </h5>
        <div class="form-group row">

            <div class="col-6 offset-3">
                <input type="text"
                       dir="rtl" v-model.trim="clientData.name" class="form-control"
                       @input="validateName" @blur="validateName"
                       v-bind:class="{'is-invalid': validation.name.state === 'invalid',
                       'is-valid': validation.name.state === 'valid'}">
                <div class="invalid-feedback" v-if="validation.name.state === 'invalid'">
                    {{validation.name.errorMessage}}
                </div>
            </div>

            <label class="col-form-label col-3 text-left">{{$t('client.name')}} *</label>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input class="form-control" @input="validateMobile" @blur="validateMobile"
                       v-model.trim="clientData.mobile"
                       v-bind:class="{'is-invalid': validation.mobile.state === 'invalid',
                        'is-valid': validation.mobile.state === 'valid'}">
                <div class="invalid-feedback" v-if="validation.mobile.state === 'invalid'">
                    {{validation.mobile.errorMessage}}
                </div>
            </div>
            <div class="col-form-label col-3 text-right">{{$t('client.telephone')}}</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input class="form-control" v-model="clientData.email"
                       @keyup.enter="validateEmail" @input="validateEmail" @blur="validateEmail"
                       v-bind:class="{'is-invalid': validation.email.state === 'invalid',
                        'is-valid': validation.email.state === 'valid'}">
                <div class="invalid-feedback" v-if="validation.email.state === 'invalid'">
                    {{validation.email.errorMessage}}
                </div>
            </div>
            <div class="col-form-label col-3 text-right text-nowrap">{{$t('client.email')}}</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <select class="form-control" dir="rtl" v-model="clientData.gender"
                        @blur="validateGender" @change="validateGender"
                        v-bind:class="{'is-invalid': validation.gender.state === 'invalid',
                        'is-valid': validation.gender.state === 'valid'}">
                    <option value="male">{{$t('male')}}</option>
                    <option value="female">{{$t('female')}}</option>
                </select>
                <div class="invalid-feedback" v-if="validation.gender.state === 'invalid'">
                    {{validation.gender.errorMessage}}
                </div>
            </div>
            <div class="col-form-label col-3 text-right">{{$t('client.gender')}} *</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <multiselect v-model="country" :options="countries"
                             id="country"
                             label="en_short_name"
                             tagPosition="bottom" :tabIndex="0"
                             openDirection="bottom"
                             placeholder="" @remove="removeCities"
                             @open="validateCountry"
                             @blur.native.capture="validateCountry('blur')"
                             @input="validateCountry"
                             :class="{'is-invalid': validation.country.state === 'invalid',
                        'is-valid': validation.country.state === 'valid',
                        'select' : validation.country.state === 'normal'}"

                >
                    <template slot="noResult">{{$t("noResults")}}</template>
                </multiselect>
                <div class="invalid-feedback d-block" v-if="validation.country.state === 'invalid'">
                    {{this.validation.country.errorMessage}}
                </div>

            </div>
            <div class="col-form-label col-3 text-right">{{$t('client.country')}}</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <multiselect
                    v-model="city" :options="cities" tagPosition="bottom"
                    placeholder="" label="name" selectLabel="" :tabIndex="0"
                    openDirection="bottom"
                    @open="validateCity"
                    @blur.native.capture="validateCity('blur')"
                    @input="validateCity"
                    :class="{'is-invalid': validation.city.state === 'invalid',
                        'is-valid': validation.city.state === 'valid',
                        'select' : validation.city.state === 'normal'}"
                >
                    <template slot="noResult">{{$t("noResults")}}</template>

                </multiselect>
                <div class="invalid-feedback d-block" v-if="validation.city.state === 'invalid'">
                    {{this.validation.city.errorMessage}}
                </div>

            </div>
            <div class="col-form-label col-3 text-right">{{$t('client.city')}}</div>
        </div>
        <div class="form-group row">
            <div class="col-6 offset-3">
                <multiselect
                    v-model="nationality" :options="countries" tagPosition="bottom"
                    label="nationality"
                    placeholder="" selectLabel="" :tabIndex="0"
                    openDirection="bottom"
                    @blur.native.capture="validateNationality('blur')"
                    @open="validateNationality"
                    @input="validateNationality"
                    :class="{'is-invalid': validation.nationality.state === 'invalid',
                        'is-valid': validation.nationality.state === 'valid',
                        'select' : validation.nationality.state === 'normal'}"
                >
                    <template slot="noResult">{{$t("noResults")}}</template>

                </multiselect>
                <div class="invalid-feedback d-block" v-if="validation.nationality.state === 'invalid'">
                    {{this.validation.nationality.errorMessage}}
                </div>

            </div>
            <div class="col-form-label col-3 text-right">* {{$t('client.nationality')}}</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <datepicker :placeholder="$t('addBirthDate')" class="text-right"
                            v-model="clientData.birthDate"
                            :bootstrap-styling="true"
                            calendar-class="h5 w-100"
                            :language="ar"

                ></datepicker>
            </div>
            <div class="col-form-label col-3 text-right">{{$t('client.birthDate')}}</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <UploadFile></UploadFile>
            </div>
        </div>


        <div slot="modal-footer" class="w-100">
            <button class="btn btn-primary pull-left" @click="saveData"
                    :class="{'disabled': disableSaveBtn}">
                {{$t('save')}}
            </button>
            <button @click="cancel" class="btn btn-danger pull-left">{{$t('cancel')}}</button>
        </div>
    </b-modal>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import UploadFile from './FileUpload';
    import {en, ar} from 'vuejs-datepicker/dist/locale'

    import validator from 'validator';
    import Multiselect from 'vue-multiselect'

    export default {
        components: {
            // Autocomplete,
            Datepicker,
            UploadFile,
            Multiselect
        },
        mounted() {
            axios.get('/api/countries').then(response => {
                response.data.forEach((country) => {
                    this.countries.push(country);
                });
            });
            bus.$on('new-client-clicked', () => {
                this.show = true;
            });
            bus.$on("client-birthDate", (birthDate) => {
                this.clientData.birthDate = birthDate;

            });
            bus.$on("client-passport", (file_id) => {
                this.clientData.file_id = file_id;

            });
        },
        data() {
            return {
                validation: {
                    name: {
                        state: null,
                        errorMessage: ""
                    },
                    mobile: {
                        state: null,
                        errorMessage: ""
                    },
                    gender: {
                        state: null,
                        errorMessage: ""
                    },
                    country: {
                        state: null,
                        errorMessage: ""
                    },
                    city: {
                        state: null,
                        errorMessage: ""
                    },
                    nationality: {
                        state: null,
                        errorMessage: ""
                    },
                    email: {
                        state: null,
                        errorMessage: ""
                    },
                    checkList: {
                        name: false,
                        mobile: false,
                        gender: false,
                        email: true,
                        country: false,
                        city: false,
                        nationality: false
                    }
                },
                disableSaveBtn: true,
                show: false,
                countries: [],
                country: null,
                cities: [],
                city: null,
                nationality: null,
                clientData: {
                    name: null,
                    email: null,
                    country_id: null,
                    city_id: null,
                    nationality_id: null,
                    mobile: null,
                    gender: null,
                    address: null,
                    birthDate: null,
                    file_id: null
                }
            }
        },
        methods: {
            removeValidationStyle() {
                this.validation.name.state = "normal";
                this.validation.mobile.state = "normal";
                this.validation.gender.state = "normal";
                this.validation.email.state = "normal";
                this.validation.country.state = null;
                this.validation.city.state = null;
                this.validation.nationality.state = null;
            },
            removeFormData() {
                for (let prop in this.clientData) {
                    this.clientData[prop] = null;
                }
                this.country = null;
                this.city = null;
                this.nationality = null;
                this.cities = [];

            },
            deactivateSaveBtn() {
                for (let item in this.validation.checkList) {
                    this.validation.checkList[item] = false;
                }
                this.validation.checkList.email = true;
                this.activateSaveBtn();
            },
            hidePopUpModal() {
                this.show = false;
            },
            fieldState(formName, state, checked, message) {
                this.validation[formName].state = state;
                this.validation.checkList[formName] = checked;
                this.validation[formName].errorMessage = message;
                this.activateSaveBtn();
            },
            validateName(e) {
                if (!this.clientData.name && e.type === 'input') {
                    return this.fieldState("name", "normal", false, null);
                }
                if (!this.clientData.name && e.type === 'blur') {
                    return this.fieldState("name", "invalid", false, this.$t('validations.addName'));
                }
                let trimName = this.clientData.name.split(' ').join("");
                if (!(validator.isAlpha(trimName, 'ar') || validator.isAlpha(trimName, 'en-US'))) {
                    return this.fieldState("name", "invalid", false, this.$t('validations.nameChar'));
                }
                this.fieldState("name", "valid", true, null);
            },
            validateMobile(e) {
                if (!this.clientData.mobile) this.clientData.mobile = "";
                let mobileNumber = this.clientData.mobile[0] === '+' ? this.clientData.mobile.slice(1)
                    : this.clientData.mobile;
                if (!this.clientData.mobile && e.type === "blur") { // is empty validation
                    return this.fieldState("mobile", "invalid", false, this.$t('validations.mobileEmpty'));
                }
                if (!Number.isInteger(Number(mobileNumber))) // is number validation
                    return this.fieldState("mobile", "invalid", false, this.$t('validations.mobileNumbers'));
                else if (mobileNumber.length < 3 && e.type === "input") { // blue style
                    return this.fieldState("mobile", "normal", false, null);
                }
                if (!validator.isMobilePhone(mobileNumber, 'any')) { // numbers count validation
                    return this.fieldState("mobile", "invalid", false, this.$t('validations.mobileCount'));
                }
                if (this.clientData.mobile && mobileNumber.length > 2) { // not to send empty query
                    axios.get(`/api/client/mobile/is_unique?mobile=${this.clientData.mobile}`)
                        .then((response) => { // is unique validation
                            let mobileNumber = this.clientData.mobile[0] === '+' ? this.clientData.mobile.slice(1)
                                : this.clientData.mobile;

                            if (mobileNumber.length < 3 || !Number.isInteger(Number(mobileNumber)))
                                return; // return if the response comes after writing an invalid value
                            if (response.data.unique) {
                                // green style success validation~4
                                this.fieldState("mobile", "valid", true, null);
                            } else {
                                return Promise.reject(new Error("mobile-taken"));
                            } // is unique validation
                        })
                        .catch((err) => {
                            if (err.message === "mobile-taken") {
                                this.fieldState("mobile", "invalid", false, this.$t('validations.mobileExists'));
                            } else {
                                console.log(err);
                            }
                        });
                }
            },
            validateGender() {
                if (!this.clientData.gender) {
                    return this.fieldState("gender", "invalid", false, this.$t('validations.chooseGender'));
                }
                this.fieldState("gender", "valid", true, null);
            },
            validateCountry(type) {
                if (this.country) {
                    this.fieldState("country", "valid", true, null);
                    this.clientData.country_id = this.country.id;
                    axios.post("/api/cities", {country_ids: [this.clientData.country_id]}).then((response) => {
                        this.cities = response.data.cities;
                    }).catch((err) => {
                        console.log(err);
                    });
                    return;
                }
                if (type === "blur" && !this.country) {
                    return this.fieldState("country", "invalid", false, this.$t('validations.addCountry'));
                }
                this.fieldState("country", "normal", false, null);
            },
            validateCity(type) {
                if (this.city) {
                    this.clientData.city_id = this.city.id;
                    return this.fieldState("city", "valid", true, null);
                }
                if (!this.country) {
                    this.fieldState("country", "invalid", false, this.$t('validations.addCountry'));
                }
                if (type === "blur" && !this.city) {
                    return this.fieldState("city", "invalid", false, this.$t('validations.addCity'));
                }
                this.fieldState("city", "normal", false, null);
            },
            validateNationality(type) {
                if (this.nationality) {
                    this.clientData.nationality_id = this.nationality.id;
                    return this.fieldState("nationality", "valid", true, null);
                }
                if (type === 'blur' && !this.nationality) {
                    return this.fieldState("nationality", "invalid", false, this.$t('validations.nationality'));
                }
                this.fieldState("nationality", "normal", false, null);
            },
            validateEmail(e) {
                this.fieldState("email", "normal", false, null); // blue style @input
                // enable save button while empty field
                if (!this.clientData.email) return this.fieldState("email", "normal", true, null);
                if (!validator.isEmail(this.clientData.email) &&
                    (e.key === "Enter" || e.type === "blur")) { // is email validation~2
                    return this.fieldState("email", "invalid", false, this.$t('validations.email'));
                }
                if (this.clientData.email && (e.key === "Enter" || e.type === "blur")) {
                    axios.get(`/api/client/email/is_unique?email=${this.clientData.email}`)
                        .then((response) => {
                            if (response.data.unique) { // is unique validation~1
                                this.fieldState("email", "valid", true, null);
                            } else {
                                return Promise.reject(new Error("email-taken"));
                            }
                        })
                        .catch((err) => {
                            if (err.message === "email-taken") { // is unique validation
                                this.fieldState("email", "invalid", false, this.$t('validations.emailExists'));
                            } else {
                                console.log(err);
                            }
                        });
                } // not to send empty query, check email @blur or enter and check email @input ".com"
            },
            saveData() {
                if (!this.disableSaveBtn) {
                    axios.post("api/client", this.clientData)
                        .then((response) => {
                            console.log(response.data);
                            bus.$emit('new-client-saved', response.data.client);
                            this.hidePopUpModal();
                            this.removeValidationStyle();
                            this.removeFormData();
                            this.deactivateSaveBtn();
                        })
                        .catch((err) => {
                            console.log(err);
                        });
                }
            },
            activateSaveBtn() {
                for (let checkNote in this.validation.checkList) {
                    if (this.validation.checkList.hasOwnProperty(checkNote) && !this.validation.checkList[checkNote]) {
                        this.disableSaveBtn = true;
                        return;
                    }
                }
                this.disableSaveBtn = false;
            },
            cancel() {
                this.removeValidationStyle();
                this.removeFormData();
                this.deactivateSaveBtn();
                this.hidePopUpModal();
            },
            removeCities() {
                this.cities = [];
                this.city = null;
                this.fieldState("city", "normal", false, null);
            }
        },
        computed: {
            ar: function () {
                if (this.$t("datePickerLang") === "ar") {
                    return ar
                }
                else {
                    return en
                }
            }
        }

    }
</script>

<style scoped>

    .is-valid {
        border: 1px solid #28a745;
        border-radius: 5px;
    }
    .is-valid:focus {
        border: 1px solid #28a745 !important;
        border-radius: 5px;
    }
    .is-invalid {
        border: 1px solid #dc3545;
        border-radius: 5px;
    }
    .is-invalid:focus {
        border: 1px solid #dc3545 !important;
    }
    .select {
        color: #495057 !important;
        background-color: #fff !important;
        border: 1px solid #80bdff !important;
        border-radius: 5px;
        outline: 0 !important;
        -webkit-box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
    }

</style>
