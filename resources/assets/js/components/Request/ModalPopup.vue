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
                       @input="validateName" @blur="fieldEmptinessValidation"
                       v-bind:class="{'is-invalid': invalidNameStyle, 'is-valid': validNameStyle}">
                <div class="invalid-feedback" v-if="invalidNameStyle" id="tooltip">
                    <b-tooltip id="nameTooltip" target="tooltip" placement="left"></b-tooltip>
                    قف هنا لتعرف الخطأ
                </div>
            </div>

            <label class="col-form-label col-3">* الإسم</label>

        </div>
        <div class="row mt-4">
            <div class="col-6 offset-3">
                <input class="form-control" dir="rtl" v-model="clientData.mobile">
            </div>
            <div class="col-3" @input="validateMobile">* رقم الجوال</div>
        </div>

        <div class="row mt-4">
            <div class="col-6 offset-3">
                <input class="form-control" dir="rtl" v-model="clientData.email">
            </div>
            <div class="col-3">البريد الإلكتروني</div>
        </div>

        <div class="row mt-4">
            <div class="col-6 offset-3">
                <select class="form-control" dir="rtl" v-model="clientData.gender">
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
            </div>
            <div class="col-3">النوع</div>
        </div>

        <div class="row mt-4">
            <div class="col-6 offset-3">
                <input class="form-control" dir="rtl" v-model="clientData.age">
            </div>
            <div class="col-3">السن</div>
        </div>

        <div class="row mt-4">
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
                        @blur="emptyIfNotSelected"
                        :min-len="0">
                </autocomplete>
            </div>
            <div class="col-3">البلد</div>
        </div>

        <div class="row mt-4">
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
                invalidNameStyle: false,
                validNameStyle: false,
                disableSaveBtn: true,
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
            validateName() {
                let trimName = this.clientData.name.split(' ').join("");
                if(!validator.isAlpha(trimName, 'ar')) {
                    this.invalidNameStyle = true;
                    $('#tooltip').attr("data-original-title", "ادخل الاسم بحروف عربيه");
                    return;
                }
                this.invalidNameStyle = false;
                this.validNameStyle = true;
                return
            },
            validateMobile() {
                if(!validator.isMobilePhone(this.clientData.mobile, 'any')){

                }
            },
            fieldEmptinessValidation() {
                if(!this.clientData.name) this.invalidNameStyle = true;
                $('#tooltip').attr("data-original-title", "لم يتم ادخال الاسم")
            }
        }
    }
</script>

<style scoped>

</style>
