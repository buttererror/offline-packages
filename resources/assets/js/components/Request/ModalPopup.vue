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
                    :get-label="countryGetLabel"
                    :component-item='countryTemplate'
                    @update-items="updateCountryList"
                    :auto-select-one-item="false"
                    @item-selected="countryAutocompleteItemSelectedHandler"
                    @blur="countryAutocompleteBlurHandler"
                    @change="validateCountry"
                    :min-len="0">

                </autocomplete>
                <div class="invalid-feedback d-block" v-if="validation.country.state === 'is-invalid'">
                    {{this.validation.country.errorMessage}}
                </div>

            </div>
            <div class="col-form-label col-3 text-right">* بلد الاقامة</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <multiselect
                    v-model="selected" :options="options" tagPosition="bottom"
                    :preserveSearch="true" :showNoResults="false" selectLabel=""
                >

                </multiselect>

                <!--<autocomplete-->
                    <!--ref="cityAutocomplete"-->
                    <!--:input-attrs="{-->
                            <!--class: 'form-control ' +  validation.city.state,-->
                            <!--id: 'cityInput'-->
                        <!--}"-->
                    <!--id="city-autocomplete"-->
                    <!--dir="rtl"-->
                    <!--:items="filteredCites"-->
                    <!--v-model="clientData.city"-->
                    <!--:get-label="cityGetLabel"-->
                    <!--:component-item='cityTemplate'-->
                    <!--@update-items="updateCityList"-->
                    <!--:auto-select-one-item="false"-->
                    <!--@item-selected="cityAutocompleteItemSelectedHandler"-->
                    <!--@blur="cityAutocompleteBlurHandler"-->
                    <!--@change="validateCity"-->
                    <!--:min-len="0">-->

                <!--</autocomplete>-->

                <div class="invalid-feedback d-block" v-if="validation.city.state === 'is-invalid'">
                    {{this.validation.city.errorMessage}}
                </div>

            </div>
            <div class="col-form-label col-3 text-right">* المدينة</div>
        </div>
        <div class="form-group row">
            <div class="col-6 offset-3">

                <autocomplete
                    ref="nationalityAutocomplete"
                    :input-attrs="{
                            class: 'form-control ' +  validation.nationality.state,
                            id: 'nationalityInput'
                        }"
                    id="nationality-autocomplete"
                    dir="rtl"
                    :items="filteredNationalities"
                    v-model="clientData.nationality"
                    :get-label="nationalityGetLabel"
                    :component-item='nationalityTemplate'
                    @update-items="updateNationalityList"
                    :auto-select-one-item="false"
                    @item-selected="nationalityAutocompleteItemSelectedHandler"
                    @blur="nationalityAutocompleteBlurHandler"
                    @change="validateNationality"
                    :min-len="0">

                </autocomplete>
                <div class="invalid-feedback d-block" v-if="validation.nationality.state === 'is-invalid'">
                    {{this.validation.nationality.errorMessage}}
                </div>

            </div>
            <div class="col-form-label col-3 text-right">* الجنسية</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <datepicker placeholder="ضع تاريخ ميلادك" class="text-right"
                            v-model="clientData.birthDate"
                            :bootstrap-styling="true"
                            :language="ar"

                ></datepicker>
            </div>
            <div class="col-form-label col-3 text-right">تاريخ الميلاد</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <UploadFile></UploadFile>
            </div>
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
    import Datepicker from 'vuejs-datepicker';
    import UploadFile from './FileUpload';
    import CountryTemplate from './autocompleteTemplate/CountryAutocompleteItem';
    import CityTemplate from './autocompleteTemplate/CityAutocompleteItem';
    import NationalityTemplate from './autocompleteTemplate/NationalityAutocompleteItem';
    import {en, ar} from 'vuejs-datepicker/dist/locale'

    import validator from 'validator';
    import Multiselect from 'vue-multiselect'

    export default {
        components: {
            Autocomplete,
            Datepicker,
            UploadFile,
            Multiselect
        },
        mounted() {
            axios.get('/api/countries').then(response => {
                this.countries = response.data;
                this.nationalities = response.data;
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
                ar: ar,
                show: false,
                countries: [],
                cities: [],
                nationalities: [],
                filteredCountries: [],
                filteredCites: [],
                filteredNationalities: [],
                countryTemplate: CountryTemplate,
                cityTemplate: CityTemplate,
                nationalityTemplate: NationalityTemplate,
                clientData: {
                    name: null,
                    email: null,
                    country: null,
                    city: null,
                    nationality: null,
                    country_id: null,
                    city_id: null,
                    nationality_id: null,
                    mobile: null,
                    gender: null,
                    address: null,
                    birthDate: null,
                    file_id: null
                },
                options: ['Mahmoud', 'Mohamed', 'Ahmed', 'Gamal', 'Rania', 'Ibrahim', 'Abdo',
                    'Soha', 'Karim', 'Basant', 'Magdy'],
                selected:''

            }
        },
        methods: {
            countryGetLabel(country) {
                if (country) {
                    return country.en_short_name
                }
                return ''
            },
            cityGetLabel(city) {
                if(city) {
                    return city.name;
                }
            },
            nationalityGetLabel(nationality) {
                if(nationality) {
                    return nationality.nationality;
                }
            },
            updateCountryList(text) {
                if (!text) {
                    this.filteredCountries = [];
                    return;
                }
                this.filteredCountries = this.countries.filter(country => {
                    return country.en_short_name.toLowerCase().startsWith(text.toLowerCase());
                });
                console.log("filteredCountries", this.filteredCountries);
            },
            updateCityList(text) {
                if (!text) {
                    this.filteredCites = [];
                    return;
                }
                console.log("text", text);
                this.filteredCites = this.cities.filter(city => {
                    return city.name.toLowerCase().startsWith(text.toLowerCase());
                });
                console.log("filteredCites", this.filteredCites);
            },
            updateNationalityList(text) {
                if (!text) {
                    this.filteredNationalities = [];
                    return;
                }
                this.filteredNationalities = this.nationalities.filter(nationality => {
                    return nationality.nationality.toLowerCase().startsWith(text.toLowerCase());
                });
                console.log(this.filteredNationalities);
            },
            removeValidationStyle() {
                this.validation.name.state = "normal";
                this.validation.mobile.state = "normal";
                this.validation.gender.state = "normal";
                this.validation.email.state = "normal";
                this.validation.country.state = "normal";
                this.validation.city.state = "normal";
                this.validation.nationality.state = "normal";
            },
            removeFormData() {
                for (let prop in this.clientData) {
                    this.clientData[prop] = null;
                }
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
            selectedCountry(country) {
                this.clientData.country_id = country.id;
            },
            selectedCity(city) {
                this.clientData.city_id = city.id;
            },
            selectedNationality(nationality) {
                this.clientData.nationality_id = nationality.id;
            },
            countryEmptyIfNotSelected() {
                setTimeout(() => {
                    if (!this.clientData.country) {
                        this.$refs.countryAutocomplete.searchText = '';
                    }
                }, 200);
            },
            cityEmptyIfNotSelected() {
                setTimeout(() => {
                    if (!this.clientData.city) {
                        this.$refs.cityAutocomplete.searchText = '';
                    }
                }, 200);
            },
            nationalityEmptyIfNotSelected() {
                setTimeout(() => {
                    if (!this.clientData.nationality) {
                        this.$refs.nationalityAutocomplete.searchText = '';
                    }
                }, 200);
            },
            countryAutocompleteBlurHandler(country) {
                this.countryEmptyIfNotSelected();
                this.validateCountry(country);
            },
            cityAutocompleteBlurHandler(city) {
                this.cityEmptyIfNotSelected();
                this.validateCity(city);
            },
            nationalityAutocompleteBlurHandler(nationality) {
                this.nationalityEmptyIfNotSelected();
                this.validateNationality(nationality);
            },
            countryAutocompleteItemSelectedHandler(country) {
                this.selectedCountry(country);
                this.validateCountry(country);
            },
            cityAutocompleteItemSelectedHandler(city) {
                this.selectedCity(city);
                this.validateCity(city);
            },
            nationalityAutocompleteItemSelectedHandler(nationality) {
                this.selectedNationality(nationality);
                this.validateNationality(nationality);
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
                    return this.fieldState("name", "invalid", false, "ادخل الاسم");
                }
                let trimName = this.clientData.name.split(' ').join("");
                if (!(validator.isAlpha(trimName, 'ar') || validator.isAlpha(trimName, 'en-US'))) {
                    return this.fieldState("name", "invalid", false, "حروف انجليزية فقط او عربية فقط");
                }
                this.fieldState("name", "valid", true, null);
                console.log(this.clientData.name)
            },
            validateMobile(e) {
                if (!this.clientData.mobile) this.clientData.mobile = "";
                let mobileNumber = this.clientData.mobile[0] === '+' ? this.clientData.mobile.slice(1)
                    : this.clientData.mobile;
                if (!this.clientData.mobile && e.type === "blur") { // is empty validation
                    return this.fieldState("mobile", "invalid", false, "ادخل رقم الموبايل");
                }
                if (!Number.isInteger(Number(mobileNumber))) // is number validation
                    return this.fieldState("mobile", "invalid", false, "ارقام فقط");
                else if (mobileNumber.length < 3 && e.type === "input") { // blue style
                    return this.fieldState("mobile", "normal", false, null);
                }
                if (!validator.isMobilePhone(mobileNumber, 'any')) { // numbers count validation
                    return this.fieldState("mobile", "invalid", false, "(20 ~ 3)");
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
                                this.fieldState("mobile", "invalid", false, "الموبايل موجود");
                            } else {
                                console.log(err);
                            }
                        });
                }
            },
            validateGender() {
                if (!this.clientData.gender) {
                    return this.fieldState("gender", "invalid", false, "اختر النوع");
                }
                this.fieldState("gender", "valid", true, null);
            },
            validateCountry(country) {
                if (typeof country === 'object' || this.clientData.country) {
                    axios.get(`/api/cities/${country.id}`).then((response) => {
                        this.cities = response.data.cities;
                        console.log(this.cities);
                    }).catch((err) => {
                        console.log(err);
                    });
                    return this.fieldState("country", "is-valid", true, null);
                }
                if (!this.clientData.country && !$("#countryInput").is(':focus')) {
                    return this.fieldState("country", "is-invalid", false, "ادخل البلد");
                }
                if (typeof country === 'string' && !validator.isAlpha(country, "en-US") && country) {
                    return this.fieldState("country", "is-invalid", false, "حروف انجليزية فقط");
                }
                this.fieldState("country", "normal", false, null);
            },
            validateCity(city) {
                if (typeof city === 'object' || this.clientData.city) {
                    return this.fieldState("city", "is-valid", true, null);
                }
                if (!this.clientData.city && !$("#cityInput").is(':focus')) {
                    return this.fieldState("city", "is-invalid", false, "ادخل المدينة");
                }
                if (typeof city === 'string' && !validator.isAlpha(city, "en-US") && city) {
                    return this.fieldState("city", "is-invalid", false, "حروف انجليزية فقط");
                }
                this.fieldState("city", "normal", false, null);
            },
            validateNationality(nationality) {
                if (typeof nationality === 'object' || this.clientData.nationality) {
                    return this.fieldState("nationality", "is-valid", true, null);
                }
                if (!this.clientData.nationality && !$("#nationalityInput").is(':focus')) {
                    return this.fieldState("nationality", "is-invalid", false, "ادخل الجنسية");
                }
                if (typeof nationality === 'string' && !validator.isAlpha(nationality, "en-US") && nationality) {
                    return this.fieldState("nationality", "is-invalid", false, "حروف انجليزية فقط");
                }
                this.fieldState("nationality", "normal", false, null);
            },
            validateEmail(e) {
                this.fieldState("email", "normal", false, null); // blue style @input
                // enable save button while empty field
                if (!this.clientData.email) return this.fieldState("email", "normal", true, null);
                if (!validator.isEmail(this.clientData.email) &&
                    (e.key === "Enter" || e.type === "blur")) { // is email validation~2
                    return this.fieldState("email", "invalid", false, "الايميل غير صالح");
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
                                this.fieldState("email", "invalid", false, "الايميل موجود");
                            } else {
                                console.log(err);
                            }
                        });
                } // not to send empty query, check email @blur or enter and check email @input ".com"
            },
            saveData() {
                console.log(this.clientData);
                if (!this.disableSaveBtn) {
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
            }, activateSaveBtn() {
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
            }
        }
    }
</script>

<style scoped>

</style>
