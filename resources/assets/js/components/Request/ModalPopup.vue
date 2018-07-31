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
                       v-bind:class="{'is-invalid': name.invalid, 'is-valid': name.valid}">
                <div class="invalid-feedback" v-if="name.invalid">
                    {{name.errorMessage}}
                </div>
            </div>

            <label class="col-form-label col-3 text-right">* الإسم</label>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input class="form-control" @input="validateMobile" @blur="validateMobile"
                       v-model.trim="clientData.mobile"
                       v-bind:class="{'is-invalid': mobile.invalid,
                        'is-valid': mobile.valid}">
                <div class="invalid-feedback" v-if="mobile.invalid">
                    {{mobile.errorMessage}}
                </div>
            </div>
            <div class="col-form-label col-3 text-right">* رقم الجوال</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input class="form-control" dir="rtl" v-model="clientData.email">
            </div>
            <div class="col-form-label col-3 text-right text-nowrap">البريد الإلكتروني</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <select class="form-control" dir="rtl" v-model="clientData.gender"
                    @blur="validateGender" @change="validateGender"
                        v-bind:class="{'is-invalid': gender.invalid,
                        'is-valid': gender.valid}">
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
                <div class="invalid-feedback" v-if="gender.invalid">
                    {{gender.errorMessage}}
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
                        v-model="country.object"
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
            <button class="btn btn-primary pull-left" v-bind:class="{'disabled': disableSaveBtn}">
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
                    object: null,
                    // valid: false,
                    // invalid: false,
                    errorMessage: ""
                },
                checkNotes: {
                    name: false,
                    mobile: false,
                    gender: false,
                    country: false
                },
                disableSaveBtn: true,
                show: false,
                countries: [],
                filteredCountries: [],
                countryTemplate: CountryTemplate,
                clientData: {
                    name: null,
                    email: null,
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
            cancel() {
                let $countryInput = $("#__BVID__7___BV_modal_outer_ .v-autocomplete-input-group input");
                this.name.valid = false;
                this.name.invalid = false;
                this.mobile.valid = false;
                this.mobile.invalid = false;
                this.gender.valid = false;
                this.gender.invalid = false;
                $countryInput.removeClass("is-valid is-invalid");
                for (let prop in this.clientData) {
                    this.clientData[prop] = null;
                }
                this.country.object = null;
                this.show = false;
            },
            selectedCountry(country) {
                this.clientData.country_id = country.id;
            },
            emptyIfNotSelected() {
                setTimeout(() => {
                    if(!this.country.object){
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
                    this.name.errorMessage = "ادخل الاسم";
                    this.name.invalid = true;
                    this.checkNotes.name = false;
                    this.activateSaveBtn();
                    return;
                }
                let trimName = this.clientData.name.split(' ').join("");
                if(!validator.isAlpha(trimName, 'ar')) {
                    this.name.invalid = true;
                    this.name.valid = false;
                    this.checkNotes.name = false;
                    this.activateSaveBtn();
                    this.name.errorMessage = "ادخل الاسم بحروف عربيه";
                    return;
                }
                this.name.invalid = false;
                this.name.valid = true;
                this.checkNotes.name = true;
                this.activateSaveBtn();
            },
            validateMobile(e) {
                if(!this.clientData.mobile && e.type === "blur"){
                    this.mobile.invalid = true;
                    this.checkNotes.mobile = false;
                    this.activateSaveBtn();
                    this.mobile.errorMessage = "ادخل رقم الموبايل";
                    return;
                }
                let mobileNumber = this.clientData.mobile[0] === '+' ? this.clientData.mobile.slice(1)
                    : this.clientData.mobile;
                if(!validator.isMobilePhone(mobileNumber, 'any')){
                    this.mobile.invalid = true;
                    this.mobile.valid = false;
                    this.checkNotes.mobile = false;
                    this.activateSaveBtn();
                    this.mobile.errorMessage = "ليس اقل من 3 ارقام";
                    return;
                }
                this.mobile.invalid = false;
                this.mobile.valid = true;
                this.checkNotes.mobile = true;
                this.activateSaveBtn();
            },
            validateGender() {
                if(!this.clientData.gender){
                    this.gender.invalid = true;
                    this.gender.errorMessage = "اختر النوع";
                    return;
                }
                this.gender.invalid = false;
                this.gender.valid = true;
                this.checkNotes.gender = true;
                this.activateSaveBtn();
            },
            invalidCountry($countryInput, message){
                this.country.errorMessage = message;
                let invalidFeedback = `<div class="invalid-feedback">
                            ${this.country.errorMessage}
                        </div>`;
                $countryInput.removeClass("is-valid").addClass("is-invalid");
                this.checkNotes.country = false;
                this.activateSaveBtn();
                if($countryInput.parent().children().length < 2)
                    $(invalidFeedback).insertAfter($countryInput);
                else $countryInput.next().text(message);
            },
            validateCountry(country) {
                let $countryInput = $("#__BVID__7___BV_modal_outer_ .v-autocomplete-input-group input");
                if(typeof country === 'object' || this.country.object){
                    $countryInput.removeClass("is-invalid").addClass("is-valid");
                    this.checkNotes.country = true;
                    this.activateSaveBtn();
                    return;
                }
                if(!country && !$countryInput.is(':focus')){
                    this.invalidCountry($countryInput, "ادخل البلد");
                    return;
                }
                if(typeof country === 'string' && validator.isAlpha(country, "ar")){
                    this.invalidCountry($countryInput, "حروف انجليزية فقط");
                    return;
                }
                $countryInput.removeClass("is-valid is-invalid");
                this.checkNotes.country = false;
                this.activateSaveBtn();
            },
            activateSaveBtn() {
                for(let checkNote in this.checkNotes){
                    if(this.checkNotes.hasOwnProperty(checkNote) && !this.checkNotes[checkNote]){
                        this.disableSaveBtn = true;
                        return;
                    }
                }
                this.disableSaveBtn = false;
            }
        }
    }
</script>

<style scoped>

</style>
