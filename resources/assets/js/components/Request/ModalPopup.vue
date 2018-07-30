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

            <label class="col-form-label col-3">* الإسم</label>
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
            <div class="col-3">* رقم الجوال</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input class="form-control" dir="rtl" v-model="clientData.email">
            </div>
            <div class="col-3">البريد الإلكتروني</div>
        </div>

        <div class="form-group row mt-4">
            <div class="col-6 offset-3">
                <select class="form-control" dir="rtl" v-model="clientData.gender"
                    @change="validateGender"
                        v-bind:class="{'is-invalid': gender.invalid,
                        'is-valid': gender.valid}">
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
                <div class="invalid-feedback" v-if="gender.invalid">
                    {{gender.errorMessage}}
                </div>
            </div>
            <div class="col-3">* النوع</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input class="form-control" dir="rtl" v-model="clientData.age">
            </div>
            <div class="col-3">السن</div>
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
                        v-model="country"
                        :get-label="getLabel"
                        :component-item='countryTemplate'
                        @update-items="updateCountryList"
                        :auto-select-one-item="false"
                        @item-selected="selectedCountry"
                        @blur="handler('emptyIfNotSelected', 'validateCountry')"
                        :min-len="0">
                </autocomplete>
            </div>
            <div class="col-3">* البلد</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input class="form-control" dir="rtl" v-model="clientData.address">
            </div>
            <div class="col-3">العنوان</div>
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
                    required: false,
                    errorMessage: ""
                },
                mobile: {
                    valid: false,
                    invalid: false,
                    required: false,
                    errorMessage: ""
                },
                gender: {
                    valid: false,
                    invalid: false,
                    required: false,
                    errorMessage: ""
                },
                disableSaveBtn: true,
                requiredCheck: 0,
                show: false,
                countries: [],
                filteredCountries: [],
                country: null,
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
                this.validNameStyle = false;
                this.invalidNameStyle = false;
                this.validMobileNumber = false;
                this.invalidMobileNumber = false;
                for (let prop in this.clientData) {
                    this.clientData[prop] = null;
                }
                this.show = false;
            },
            selectedCountry(country) {
                this.clientData.country_id = country.id;
            },
            emptyIfNotSelected() {
                setTimeout(() => {
                    if(!this.country){
                        this.$refs.countryAutocomplete.searchText = '';
                    }
                },200);
            },
            validateName(e) {
                if(!this.clientData.name && e.type === 'blur'){
                    this.name.errorMessage = "ادخل الاسم";
                    this.name.invalid = true;
                    return;
                }
                let trimName = this.clientData.name.split(' ').join("");
                if(!validator.isAlpha(trimName, 'ar')) {
                    this.invalidNameStyle = true;
                    this.validNameStyle = false;
                    this.name.errorMessage = "ادخل الاسم بحروف عربيه";
                    return;
                }
                this.name.invalid = false;
                this.name.valid = true;
            },
            validateMobile(e) {
                if(!this.clientData.mobile && e.type === "blur"){
                    this.mobile.invalid = true;
                    this.mobile.errorMessage = "ادخل رقم الموبايل";
                    return;
                }
                let mobileNumber = this.clientData.mobile[0] === '+' ? this.clientData.mobile.slice(1)
                    : this.clientData.mobile;
                if(!validator.isMobilePhone(mobileNumber, 'any')){
                    this.mobile.invalid = true;
                    this.mobile.valid = false;
                    this.mobile.errorMessage = "ليس اقل من 3 ارقام";
                    return;
                }
                this.mobile.invalid = false;
                this.mobile.valid = true;
            },
            validateGender() {
                console.log("here")
                if(!this.clientData.gender){
                    this.gender.invalid = true;
                    this.gender.errorMessage = "ادخل رقم الموبايل";
                    return;
                }
                this.gender.invalid = false;
                this.gender.valid = true;
            },
            validateCountry() {

            },
            activateSaveBtn() {
                return this.requiredCheck === 4;
            }
        }
    }
</script>

<style scoped>

</style>
