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
                       v-bind:class="{'is-invalid': validation.name.state === 'invalid',
                       'is-valid': validation.name.state === 'valid'}">
                <div class="invalid-feedback" v-if="validation.name.state === 'invalid'">
                    {{validation.name.errorMessage}}
                </div>
            </div>

            <label class="col-form-label col-3 text-right">* الإسم</label>
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
            <div class="col-form-label col-3 text-right">* رقم الجوال</div>
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
            <div class="col-form-label col-3 text-right text-nowrap">البريد الإلكتروني</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <select class="form-control" dir="rtl" v-model="clientData.gender"
                    @blur="validateGender" @change="validateGender"
                        v-bind:class="{'is-invalid': validation.gender.state === 'invalid',
                        'is-valid': validation.gender.state === 'valid'}">
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
                <div class="invalid-feedback" v-if="validation.gender.state === 'invalid'">
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
                            class: 'form-control ' +  validation.country.state,
                            id: 'countryInput'
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
                <div class="invalid-feedback d-block" v-if="validation.country.state === 'is-invalid'">
                    {{this.validation.country.errorMessage}}
                </div>

            </div>
            <div class="col-form-label col-3 text-right">* البلد</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input class="form-control" dir="rtl" v-model="clientData.address">
            </div>
            <div class="col-form-label col-3 text-right">العنوان</div>
        </div>

        <div class="form-group row">
            <DatePicker></DatePicker>
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
    import DatePicker from './DatePicker';
    import CountryTemplate from './CountryAutocompleteItem';

    import validator from 'validator';

    export default {
        components: {
            Autocomplete,
            DatePicker
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
                    email: {
                        state: null,
                        errorMessage: ""
                    },
                    checkList: {
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
                    age: null,
                    birthDate:null,
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
                this.validation.name.state = "normal";
                this.validation.mobile.state = "normal";
                this.validation.gender.state = "normal";
                this.validation.email.state = "normal";
                this.validation.country.state = "normal";
            },
            removeFormData() {
                for (let prop in this.clientData) {
                    this.clientData[prop] = null;
                }
            },
            deactivateSaveBtn() {
                for (let item in this.validation.checkList){
                    this.validation.checkList[item] = false;
                }
                this.activateSaveBtn();
            },
            hidePopUpModal() {
                this.show = false;
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
            fieldState(formName, state, checked, message){
                this.validation[formName].state = state;
                this.validation.checkList[formName] = checked;
                this.validation[formName].errorMessage = message;
                this.activateSaveBtn();
            },
            validateName(e) {
                if(!this.clientData.name && e.type === 'input'){
                    return this.fieldState("name", "normal", false, null);
                }
                if(!this.clientData.name && e.type === 'blur'){
                    return this.fieldState("name", "invalid", false, "ادخل الاسم");
                }
                let trimName = this.clientData.name.split(' ').join("");
                if(!(validator.isAlpha(trimName, 'ar') || validator.isAlpha(trimName, 'en-US'))) {
                    return this.fieldState("name", "invalid", false, "حروف انجليزية فقط او عربية فقط");
                }
                this.fieldState("name", "valid", true, null);
            },
            validateMobile(e) {
                if(!this.clientData.mobile) this.clientData.mobile = "";
                let mobileNumber = this.clientData.mobile[0] === '+' ? this.clientData.mobile.slice(1)
                    : this.clientData.mobile;
                if(!this.clientData.mobile && e.type === "blur"){ // is empty validation
                    return this.fieldState("mobile", "invalid", false, "ادخل رقم الموبايل");
                }
                if(!Number.isInteger(Number(mobileNumber))) // is number validation
                    return this.fieldState("mobile", "invalid", false, "ارقام فقط");
                else if(mobileNumber.length < 3 && e.type === "input"){ // blue style
                    return this.fieldState("mobile", "normal", false, null);
                }
                if(!validator.isMobilePhone(mobileNumber, 'any')){ // numbers count validation
                    return this.fieldState("mobile", "invalid", false, "(20 ~ 3)");
                }
                if(this.clientData.mobile && mobileNumber.length > 2){ // not to send empty query
                    axios.get(`/api/client/mobile/is_unique?mobile=${this.clientData.mobile}`)
                        .then((response) => { // is unique validation
                            let mobileNumber = this.clientData.mobile[0] === '+' ? this.clientData.mobile.slice(1)
                                : this.clientData.mobile;

                            if(mobileNumber.length < 3 || !Number.isInteger(Number(mobileNumber)))
                                return; // return if the response comes after writing an invalid value
                            if(response.data.unique){
                                // green style success validation~4
                                this.fieldState("mobile", "valid", true, null);
                            }else {
                                return Promise.reject(new Error("mobile-taken"));
                            } // is unique validation
                        })
                        .catch((err) => {
                            if(err.message === "mobile-taken"){
                                this.fieldState("mobile", "invalid", false, "الموبايل موجود");
                            }else {
                                console.log(err);
                            }
                        });
                }
            },
            validateGender() {
                if(!this.clientData.gender){
                    return this.fieldState("gender", "invalid", false, "اختر النوع");
                }
                this.fieldState("gender", "valid", true, null);
            },
            validateCountry(country) {
                if(typeof country === 'object' || this.clientData.country){
                    return this.fieldState("country", "is-valid", true, null);
                }
                if(!this.clientData.country && !$("#countryInput").is(':focus')){
                    return this.fieldState("country", "is-invalid", false, "ادخل البلد");
                }
                if(typeof country === 'string' && !validator.isAlpha(country, "en-US") && country){
                    return this.fieldState("country", "is-invalid", false, "حروف انجليزية فقط");
                }
                this.fieldState("country", "normal", false, null);
            },
            validateEmail(e) {
                this.fieldState("email", "normal", false, null); // blue style @input
                // enable save button while empty field
                if(!this.clientData.email) return this.fieldState("email", "normal", true, null);
                if (!validator.isEmail(this.clientData.email) &&
                    (e.key === "Enter" || e.type === "blur")) { // is email validation~2
                    return this.fieldState("email", "invalid", false, "الايميل غير صالح");
                }
                if(this.clientData.email && (e.key === "Enter" || e.type === "blur")) {
                    axios.get(`/api/client/email/is_unique?email=${this.clientData.email}`)
                        .then((response) => {
                            if (response.data.unique) { // is unique validation~1
                                this.fieldState("email", "valid", true, null);
                            }else {
                                return Promise.reject(new Error("email-taken"));
                            }
                        })
                        .catch((err) => {
                            if(err.message === "email-taken"){ // is unique validation
                                this.fieldState("email", "invalid", false, "الايميل موجود");
                            }else {
                                console.log(err);
                            }
                        });
                } // not to send empty query, check email @blur or enter and check email @input ".com"
            },
            saveData() {
                bus.$on("client-birthDate", (birthDate) => {
                    console.log("modalPopup " + birthDate);
                    this.clientData.birthDate = birthDate;
                });
                if(!this.disableSaveBtn){
                    console.log(this.clientData);
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
            },activateSaveBtn() {
                for(let checkNote in this.validation.checkList){
                    if(this.validation.checkList.hasOwnProperty(checkNote) && !this.validation.checkList[checkNote]){
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
            }
        }
    }
</script>

<style scoped>

</style>
