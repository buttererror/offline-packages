<template>
    <b-modal
            v-model="show"
            centered
            :no-close-on-esc="true"
            :no-close-on-backdrop="true"
            :hide-header-close="true"
            :header-class="'justify-content-center'">
        <h5 slot="modal-title">
            اضافة عميل جديد
        </h5>
        <div class="form-group row">

            <div class="col-6 offset-3">
                <input type="text"
                       dir="rtl" v-model.trim="clientData.name" class="form-control"
                       @input="validateName" @blur="validateName"
                       v-bind:class="{'is-invalid': validation.name.invalid, 'is-valid': validation.name.valid}">
                <div class="invalid-feedback" v-if="validation.name.invalid">
                    {{validation.name.errorMessage}}
                </div>
            </div>

            <label class="col-form-label col-3 text-right">* الإسم</label>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input class="form-control" @input="validateMobile" @blur="validateMobile"
                       v-model.trim="clientData.mobile"
                       v-bind:class="{'is-invalid': validation.mobile.invalid,
                        'is-valid': validation.mobile.valid}">
                <div class="invalid-feedback" v-if="validation.mobile.invalid">
                    {{validation.mobile.errorMessage}}
                </div>
            </div>
            <div class="col-form-label col-3 text-right">* رقم الجوال</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input class="form-control" v-model="clientData.email"
                    @keyup.enter="validateEmail" @input="validateEmail" @blur="validateEmail"
                       v-bind:class="{'is-invalid': validation.email.invalid,
                        'is-valid': validation.email.valid}">
                <div class="invalid-feedback" v-if="validation.email.invalid">
                {{validation.email.errorMessage}}
            </div>
            </div>
            <div class="col-form-label col-3 text-right text-nowrap">البريد الإلكتروني</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <select class="form-control" dir="rtl" v-model="clientData.gender"
                    @blur="validateGender" @change="validateGender"
                        v-bind:class="{'is-invalid': validation.gender.invalid,
                        'is-valid': validation.gender.valid}">
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
                <div class="invalid-feedback" v-if="validation.gender.invalid">
                    {{validation.gender.errorMessage}}
                </div>
            </div>
            <div class="col-form-label col-3 text-right">* النوع</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input class="form-control" dir="rtl" v-model="clientData.age">
            </div>
            <div class="col-form-label col-3 text-right">السن</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <autocomplete
                        ref="countryAutocomplete"
                        :input-attrs="{
                            class: 'form-control',
                        }"
                        id="country-autocomplete"
                        dir="rtl"
                        :items="filteredCountries"
                        v-model="clientData.country"
                        :get-label="getLabel"
                        :component-item='countryTemplate'
                        @update-items="updateCountryList"
                        :auto-select-one-item="false"
                        @item-selected="autocompleteItemSelectedHandler"
                        @blur="autocompleteBlurHandler"
                        @change="validateCountry"
                        :min-len="0">
                </autocomplete>
            </div>
            <div class="col-form-label col-3 text-right">* البلد</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input class="form-control" dir="rtl" v-model="clientData.address">
            </div>
            <div class="col-form-label col-3 text-right">العنوان</div>
        </div>


        <div slot="modal-footer" class="w-100">
            <button class="btn btn-primary pull-left" @click="saveData"
                    v-bind:class="{'disabled': disableSaveBtn}">
                حفظ
            </button>
            <button @click="cancel" class="btn btn-danger pull-left">الغاء</button>
        </div>
    </b-modal>
</template>

<script>
    import Autocomplete from 'v-autocomplete';
    import CountryTemplate from './CountryAutocompleteItem';
    import validator from 'validator';

    export default {
        components: {
            Autocomplete,
        },
        mounted() {
            axios.get('/api/countries').then(response => {
                this.countries = response.data;
            });
            bus.$on('new-client-clicked', () => {
                this.show = true;
            });
        },
        data() {
            return {
                validation: {
                    name: {
                        valid: false,
                        invalid: false,
                        errorMessage: ""
                    },
                    mobile: {
                        valid: false,
                        invalid: false,
                        errorMessage: ""
                    },
                    gender: {
                        valid: false,
                        invalid: false,
                        errorMessage: ""
                    },
                    country: {
                        errorMessage: ""
                    },
                    email: {
                        valid: false,
                        invalid: false,
                        errorMessage: ""
                    },
                    checkNotes: {
                        name: false,
                        mobile: false,
                        gender: false,
                        email: true,
                        country: false
                    }
                },
                disableSaveBtn: true,
                show: false,
                countries: [],
                filteredCountries: [],
                countryTemplate: CountryTemplate,
                clientData: {
                    name: null,
                    email: null,
                    country: null,
                    mobile: null,
                    country_id: null,
                    gender: null,
                    address: null,
                    age: null
                }
            }
        },
        methods: {
            getLabel(country) {
                if (country) {
                    return country.en_short_name
                }
                return ''
            },
            updateCountryList(text) {
                if (!text) {
                    this.filteredCountries = [];
                    return;
                }
                this.filteredCountries = this.countries.filter(country => {
                    return country.en_short_name.toLowerCase().startsWith(text.toLowerCase());
                });
            },
            removeValidationStyle() {
                let $countryInput = $("#__BVID__7___BV_modal_outer_ .v-autocomplete-input-group input");
                this.validation.name.valid = false;
                this.validation.name.invalid = false;
                this.validation.mobile.valid = false;
                this.validation.mobile.invalid = false;
                this.validation.gender.valid = false;
                this.validation.gender.invalid = false;
                this.validation.email.valid = false;
                this.validation.email.invalid = false;
                $countryInput.removeClass("is-valid is-invalid");
            },
            removeFormData() {
                for (let prop in this.clientData) {
                    this.clientData[prop] = null;
                }
            },
            deactivateSaveBtn() {
                for (let check in this.validation.checkNotes){
                    this.validation.checkNotes[check] = false;
                }
                this.activateSaveBtn();
            },
            hidePopUpModal() {
                this.show = false;
            },
            cancel() {
                this.removeValidationStyle();
                this.removeFormData();
                this.deactivateSaveBtn();
                this.hidePopUpModal();
            },
            selectedCountry(country) {
                this.clientData.country_id = country.id;
            },
            emptyIfNotSelected() {
                setTimeout(() => {
                    if(!this.clientData.country){
                        this.$refs.countryAutocomplete.searchText = '';
                    }
                },200);
            },
            autocompleteBlurHandler(country) {
                this.emptyIfNotSelected();
                this.validateCountry(country);
            },
            autocompleteItemSelectedHandler(country) {
                this.selectedCountry(country);
                this.validateCountry(country);
            },
            validateName(e) {
                if(!this.clientData.name && e.type === 'blur'){
                    this.validation.name.errorMessage = "ادخل الاسم";
                    this.validation.name.invalid = true;
                    this.validation.checkNotes.name = false;
                    this.activateSaveBtn();
                    return;
                }
                let trimName = this.clientData.name.split(' ').join("");
                if(!validator.isAlpha(trimName, 'ar')) {
                    this.validation.name.invalid = true;
                    this.validation.name.valid = false;
                    this.validation.checkNotes.name = false;
                    this.activateSaveBtn();
                    this.validation.name.errorMessage = "ادخل الاسم بحروف عربيه";
                    return;
                }
                this.validation.name.invalid = false;
                this.validation.name.valid = true;
                this.validation.checkNotes.name = true;
                this.activateSaveBtn();
            },
            invalidMobile(message) {
                this.validation.mobile.invalid = true;
                this.validation.mobile.valid = false;
                this.validation.checkNotes.mobile = false;
                this.activateSaveBtn();
                this.validation.mobile.errorMessage = message;
            },
            validateMobile(e) {
                if(this.clientData.mobile){ // not to send empty query
                    axios.get(`/api/client/mobile/is_unique?mobile=${this.clientData.mobile}`)
                        .then((response) => { // is unique validation~1
                            if(response.data.unique){
                                let mobileNumber = this.clientData.mobile[0] === '+' ? this.clientData.mobile.slice(1)
                                    : this.clientData.mobile;
                                if(!validator.isMobilePhone(mobileNumber, 'any') &&
                                     e.type === "input"){
                                    // is number, not less 3 numbers validation~3
                                    return this.invalidMobile("ارقام فقط وليس اقل من 3 ارقام");
                                }
                                // green style success validation~4
                                this.validation.mobile.invalid = false;
                                this.validation.mobile.valid = true;
                                this.validation.checkNotes.mobile = true;
                                this.activateSaveBtn();
                            }else {
                                return Promise.reject(new Error("mobile-taken"));
                            } // is unique validation
                        })
                        .catch((err) => {
                            if(err.message === "mobile-taken"){ // is unique validation
                                this.invalidMobile("الموبايل موجود");
                            }else {
                                console.log(err);
                            }
                        });
                }else if(!this.clientData.mobile && e.type === "blur"){
                    return this.invalidMobile("ادخل رقم الموبايل");
                } // is empty validation~2
            },
            validateGender() {
                if(!this.clientData.gender){
                    this.validation.gender.invalid = true;
                    this.validation.gender.errorMessage = "اختر النوع";
                    return;
                }
                this.validation.gender.invalid = false;
                this.validation.gender.valid = true;
                this.validation.checkNotes.gender = true;
                this.activateSaveBtn();
            },
            invalidCountry($countryInput, message){
                this.validation.country.errorMessage = message;
                let invalidFeedback = `<div class="invalid-feedback">
                            ${this.validation.country.errorMessage}
                        </div>`;
                $countryInput.removeClass("is-valid").addClass("is-invalid");
                this.validation.checkNotes.country = false;
                this.activateSaveBtn();
                if($countryInput.parent().children().length < 2)
                    $(invalidFeedback).insertAfter($countryInput);
                else $countryInput.next().text(message);
            },
            validateCountry(country) {
                let $countryInput = $("#__BVID__7___BV_modal_outer_ .v-autocomplete-input-group input");
                if(typeof country === 'object' || this.clientData.country){
                    $countryInput.removeClass("is-invalid").addClass("is-valid");
                    this.validation.checkNotes.country = true;
                    this.activateSaveBtn();
                    return;
                }
                if(!this.clientData.country && !$countryInput.is(':focus')){
                    this.invalidCountry($countryInput, "ادخل البلد");
                    return;
                }
                if(typeof country === 'string' && validator.isAlpha(country, "ar")){
                    this.invalidCountry($countryInput, "حروف انجليزية فقط");
                    return;
                }
                $countryInput.removeClass("is-valid is-invalid");
                this.validation.checkNotes.country = false;
                this.activateSaveBtn();
            },
            activateSaveBtn() {
                for(let checkNote in this.validation.checkNotes){
                    if(this.validation.checkNotes.hasOwnProperty(checkNote) && !this.validation.checkNotes[checkNote]){
                        this.disableSaveBtn = true;
                        return;
                    }
                }
                this.disableSaveBtn = false;
            },
            invalidEmail(message) {
                this.validation.email.invalid = true;
                this.validation.email.valid = false;
                this.validation.email.errorMessage = message;
                this.validation.checkNotes.email = false;
                this.activateSaveBtn();
            },
            validateEmail(e) {
                if(e.type === "input"){
                    var string = this.clientData.email.slice(this.clientData.email.lastIndexOf(".com"));
                    this.validation.email.invalid = false;
                    this.validation.email.valid = false;
                    // prevent save button from flashing while editing and ".com" exists
                    if(string !== ".com") this.validation.checkNotes.email = false;
                    // enable save button while empty field
                    if(!this.clientData.email) this.validation.checkNotes.email = true;
                    this.activateSaveBtn();
                } // blue style @input
                if(this.clientData.email && (e.type === "keyup" || e.type === "blur")
                    || (string === ".com" && e.type === "input")) {
                    axios.get(`/api/client/email/is_unique?email=${this.clientData.email}`)
                        .then((response) => {
                            if (response.data.unique) { // is unique validation~1
                                if (!validator.isEmail(this.clientData.email)) { // is email validation~2
                                    this.invalidEmail("الايميل غير صالح");
                                } else {
                                    this.validation.email.invalid = false;
                                    this.validation.email.valid = true;
                                    this.validation.checkNotes.email = true;
                                    this.activateSaveBtn();
                                } // green style success validation~3
                            }else {
                                return Promise.reject(new Error("email-taken"));
                            }
                        })
                        .catch((err) => {
                            if(err.message === "email-taken"){ // is unique validation
                                this.invalidEmail("الايميل موجود");
                            }else {
                                console.log(err);
                            }
                        });
                } // not to send empty query, check email @blur or enter and check email @input ".com"
            },
            saveData() {
                if(!this.disableSaveBtn){
                    axios.post("api/client", this.clientData)
                        .then((response) => {
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
            }
        }
    }
</script>

<style scoped>

</style>
