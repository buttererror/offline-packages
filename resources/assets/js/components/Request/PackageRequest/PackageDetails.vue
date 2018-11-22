<i18n>
    {

    "ar":{
    "packageDetails":{
    "startPlace":"مكان البداية",
    "endPlace":"مكان النهاية",
    "startEndJourney":"بداية الرحلة",
    "countries":"البلاد",
    "citiesNumber":"عدد المدن",
    "transfer":"الانتقالات",
    "childrenNum":"عدد الاطفال",
    "adultsNum":"عدد البالغين",
    "childrenMaxNum":"اقصى عدد للاطفال",
    "childAge":"عمر الطفل"

    },
    "field" : {
    "required" : "هذا الحقل مطلوب"
    },
    "header":"تفاصيل الباقة",
    "next":"التالى",
    "back":"السابق",
    "male":"ذكر",
    "female":"مؤنث",
    "noResults":"لايوجد نتائج",
    "save":"حفظ",
    "cancel":"الغاء",
    "addBirthDate":"ضع تاريخ ميلادك",
    "datePickerLang":"ar",
    "yes":"نعم",
    "no":"لا",
    "destinationDetails":"تفاصيل الاماكن",
    "labelDir":"ltr",
    "labelClass":"text-right"
    },

    "en": {
    "packageDetails":{
    "startPlace":"Pickup Place",
    "endPlace":"Drop off Place",
    "startEndJourney":"Start of Journey",
    "countries":"Countries",
    "citiesNumber":"Number of Cities",
    "transfer":"Transfer",
    "childrenNum":"Children Number",
    "adultsNum":"Adults Number",
    "childrenMaxNum":"Children maximum number",
    "childAge":"Child Age"
    },
    "field" : {
    "required" : "This field is required"
    },
    "header":"Package Details",
    "next":"Next",
    "back":"Back",
    "male":"male",
    "female":"female",
    "noResults":"No Results",
    "save":"save",
    "cancel":"cancel",
    "addBirthDate":"Add your BirthDate",
    "datePickerLang":"en",
    "yes":"yes",
    "no":"no",
    "destinationDetails":"Destination Details",
    "labelDir":"rtl",
    "labelClass":"text-left"
    }
    }
</i18n>


<template>
    <div id="detailsContainer">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title text-center">{{$t('header')}}</h4>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-3"
                           :class="$t('labelClass')"
                    >{{$t('packageDetails.startPlace')}}</label>
                    <div class="col-6">
                        <input type="text" :placeholder="$t('packageDetails.startPlace')"
                               @input="anyInput('startPlace')"
                               v-model="packageMainDetails.startPlace"
                               class="form-control"
                               :class="{'is-invalid': validation.startPlace.message}">
                        <div class="invalid-feedback" :class="$t('labelClass')"
                             v-if="validation.startPlace.message">
                            {{validation.startPlace.message}}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-3"
                           :class="$t('labelClass')"
                    >{{$t('packageDetails.endPlace')}}</label>
                    <div class="col-6">
                        <input type="text" :placeholder="$t('packageDetails.endPlace')"
                               v-model="packageMainDetails.endPlace"
                               @input="anyInput('endPlace')"
                               :class="{'is-invalid': validation.endPlace.message}"
                               class="form-control">
                        <div class="invalid-feedback" :class="$t('labelClass')"
                             v-if="validation.endPlace.message">
                            {{validation.endPlace.message}}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-3"
                           :class="$t('labelClass')"
                    >{{$t('packageDetails.startEndJourney')}}</label>
                    <div class="col-6">
                        <datepicker
                                    @input="anyInput('tripStartAt')"
                                    v-model="packageMainDetails.tripStartAt"
                                    :disabledDates="disabledDates"
                                    :bootstrap-styling="true"
                                    :input-class="{'is-invalid': validation.tripStartAt.message}"
                                    calendar-class="h5 w-100"
                                    :language="ar">
                              <div slot="afterDateInput" :class="$t('labelClass')"
                                   class="animated-placeholder invalid-feedback d-block"
                                   v-if="validation.tripStartAt.message">
                                  {{validation.tripStartAt.message}}
                              </div>


                        </datepicker>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-form-label col-form-label-lg col-3"
                           :class="$t('labelClass')"
                    >{{$t('packageDetails.countries')}}</label>
                    <div class="col-6">
                        <multiselect
                            @input="anyInput('selectedCountries')"
                            v-model="packageMainDetails.selectedCountries"
                            :placeholder="$t('packageDetails.countries')"
                            tagPosition="bottom"
                            :options="countries" openDirection="bottom"
                            label="en_short_name"
                            track-by="id"
                            :multiple="true"
                            :close-on-select="false"
                            :hide-selected="true"
                            :loading="isLoading"
                            @search-change="countryFind"
                            :class="{'is-invalid': validation.selectedCountries.message}"
                            :max="maxCountriesNum"
                        ></multiselect>
                        <div class="invalid-feedback d-block" :class="$t('labelClass')"
                             v-if="validation.selectedCountries.message">
                            {{validation.selectedCountries.message}}
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-3"
                           :class="$t('labelClass')"
                    >{{$t('packageDetails.citiesNumber')}}</label>
                    <div class="col-6">
                        <input type="number" :placeholder="$t('packageDetails.citiesNumber')" min="0"
                               class="form-control"
                               @input="anyInput('citiesNumber')"
                               v-model="packageMainDetails.citiesNumber"
                               :class="{'is-invalid': validation.citiesNumber.message}"
                        >
                        <div class="invalid-feedback" :class="$t('labelClass')"
                             v-if="validation.citiesNumber.message">
                            {{validation.citiesNumber.message}}
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-3 text-nowrap"
                           :class="$t('labelClass')"
                    >{{$t('packageDetails.transfer')}}</label>
                    <div class="col-6 text-center">
                        <toggle-button @change="setTransferRequest"
                                       v-model="packageMainDetails.transfer" :value="false"
                                       :sync="true"
                                       :labels="{checked: $t('yes'), unchecked: $t('no')}"
                                       :width="70"
                                       :height="30"
                                       switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                        />
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-3"
                           :class="$t('labelClass')"
                    >{{$t('packageDetails.adultsNum')}}</label>
                    <div class="col-6">
                        <input type="number" :placeholder="$t('packageDetails.adultsNum')"
                               class="form-control"
                               @input="anyInput('adultsNum')"
                               v-model="packageMainDetails.adultsNum" min="1"
                               :class="{'is-invalid': validation.adultsNum.message}">
                        <div class="invalid-feedback d-block" :class="$t('labelClass')"
                             v-if="validation.adultsNum.message">
                            {{validation.adultsNum.message}}
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-3"
                           :class="$t('labelClass')"
                    >{{$t('packageDetails.childrenNum')}}</label>
                    <div class="col-6 d-flex align-items-center">
                        <input type="number"
                               :placeholder="$t('packageDetails.childrenNum')"
                               v-model="packageMainDetails.childrenNumber"
                               class="form-control" min="0"
                               :class="{'is-invalid': validation.childrenNumber.message}"
                               @input="updateChildAge"
                        >
                        <div class="invalid-feedback" :class="$t('labelClass')"
                             v-if="validation.childrenNumber.message">
                            {{validation.childrenNumber.message}}
                        </div>

                    </div>
                </div>

                <div v-if="packageMainDetails.childrenNumber > 0">

                    <div v-for="(num, key) in packageMainDetails.childrenNumber">
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-lg col-3"
                                   :class="$t('labelClass')"
                            >
                                {{$t('packageDetails.childAge')}} # {{num}}
                            </label>
                            <div class="col-6">
                                <multiselect :placeholder="$t('packageDetails.childAge')"
                                             v-model="packageMainDetails.childrenAges[key]"
                                             :options="staticChildrenAges"
                                             tagPosition="top"
                                             @input="anyAgeInput(key)"
                                             :class="{'is-invalid': validation.childrenAges[key].message}"
                                >

                                </multiselect>
                                <div class="invalid-feedback d-block" :class="$t('labelClass')"
                                     v-if="validation.childrenAges[key].message">
                                    {{validation.childrenAges[key].message}}
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer d-flex justify-content-between" :dir="$t('labelDir')">
                <button class="btn btn-primary" @click.prevent="nextComponent">
                    {{$t('next')}}
                </button>
                <button class="btn btn-primary" @click.prevent="previousComponent">{{$t('back')}}</button>
            </div>
        </div>
    </div>

</template>

<script>

    import Datepicker from 'vuejs-datepicker';
    import {en, ar} from 'vuejs-datepicker/dist/locale';
    import Multiselect from 'vue-multiselect';
    import DestinationDetails from './DestinationDetails';


    export default {
        name: 'PackageDetails',
        components: {
            Datepicker,
            Multiselect,
            DestinationDetails
        },
        data() {
            return {
                isLoading: false,
                countries: [],
                staticChildrenAges: ["< 1", 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                maxChildrenNum: 0,
                maxChildrenNumLimit: 20,
                maxChildrenPerRoom: 4,
                maxAdultsNum: 20,
                maxCitiesNum: 20,
                maxCountriesNum: 20,
                hasErrors: false,
                validation: {
                    startPlace: {
                        message: null,
                        required: true
                    },
                    endPlace: {
                        message: null,
                        required: true
                    },
                    tripStartAt: {
                        message: null,
                        required: true
                    },
                    selectedCountries: {
                        message: null,
                        required: true
                    },
                    adultsNum: {
                        message: null,
                        required: true
                    },
                    citiesNumber: {
                        message: null,
                        required: true
                    },
                    childrenNumber: {
                        message: null,
                        required: false,
                    },
                    childrenAges: [],
                },
                packageMainDetails: {
                    startPlace: '',
                    endPlace: '',
                    tripStartAt: null,
                    selectedCountries: [],
                    citiesNumber: null,
                    transfer: false,
                    adultsNum: null,
                    childrenNumber: 0,
                    childrenAges: [],
                }
            }
        },
        mounted() {
            axios.get('/api/countries').then(response => {
                this.countries = response.data;
            });
        },
        methods: {
            setTransferRequest(transfer) {
                this.packageMainDetails.transfer = transfer.value;
            },
            nextComponent() {
                this.hasErrors = false;
                // Validate required fields
                for (let property in this.validation) {
                    // in case of children ages
                    if(property == 'childrenAges'){
                        for(let i = 0; i < this.validation.childrenAges.length; i++){
                            if(this.packageMainDetails.childrenAges.length <= i || !this.packageMainDetails.childrenAges[i]){
                                this.hasErrors = true;
                                this.validation.childrenAges[i].message = this.$t('field.required');
                            }
                        }
                        continue;
                    }
                    // in case of selected countries
                    if(property == 'selectedCountries' && this.packageMainDetails.selectedCountries.length == 0){
                        this.validation.selectedCountries.message = this.$t('field.required');
                        this.hasErrors = true;
                        continue;
                    }
                    if (this.validation[property].required && !this.packageMainDetails[property]) {
                        this.validation[property].message = this.$t('field.required');
                        this.hasErrors = true;
                    } else {
                        this.validation[property].message = null;
                    }
                }
                // validate children ages fields
                if(this.hasErrors){
                    return;
                }
                window.packageDetails.packageMainDetails = this.packageMainDetails;
                this.$emit('next-component', {
                    component: 'DestinationBase',
                    step: 'destinationDetails'
                });
            },
            previousComponent() {
                this.$emit('previous-component', "SelectService");
            },
            updateChildAge() {
                this.packageMainDetails.childrenNumber = parseInt(this.packageMainDetails.childrenNumber);
                if(!this.packageMainDetails.childrenNumber){
                    this.packageMainDetails.childrenNumber = 0;
                }
                if(this.packageMainDetails.childrenNumber > this.maxChildrenNum){
                    this.packageMainDetails.childrenNumber = this.maxChildrenNum;
                }
                this.validation.childrenAges = [];
                for(let i = 0; i < this.packageMainDetails.childrenNumber; i++){
                    this.validation.childrenAges.push({
                        message: null,
                        required: true,
                    })
                }
                // this.packageMainDetails.childrenAges = new Array(this.packageMainDetails.childrenNumber);
            }
            ,
            countryFind(query) {
                this.isLoading = true;
                axios.post('/api/countries', {query: query}).then(response => {
                    this.countries = response.data;
                    this.isLoading = false

                });
            },
            anyInput(prop){
                this.validation[prop].message = null;
            },
            anyAgeInput(index){
                this.validation.childrenAges[index].message = null;
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
            },
            disabledDates() {
                let date = new Date();
                date.setDate(new Date().getDate() - 1);
                return {to: date};
            }
        },
        watch: {
            'packageMainDetails.citiesNumber' () {
                this.packageMainDetails.citiesNumber = parseInt(this.packageMainDetails.citiesNumber );
                if(!this.packageMainDetails.citiesNumber || this.packageMainDetails.citiesNumber < 1){
                    this.packageMainDetails.citiesNumber = 1;
                }else if(this.packageMainDetails.citiesNumber > this.maxCitiesNum){
                    this.packageMainDetails.citiesNumber = this.maxCitiesNum;
                }

            },
            'packageMainDetails.adultsNum' () {
                this.packageMainDetails.adultsNum = parseInt(this.packageMainDetails.adultsNum );
                if(!this.packageMainDetails.adultsNum || this.packageMainDetails.adultsNum < 1){
                    this.packageMainDetails.adultsNum = 1;
                }else if(this.packageMainDetails.adultsNum > this.maxAdultsNum){
                    this.packageMainDetails.adultsNum = this.maxAdultsNum;
                }
                this.maxChildrenNum = this.maxChildrenPerRoom * this.packageMainDetails.adultsNum;
                if(this.maxChildrenNum > this.maxChildrenNumLimit){
                    this.maxChildrenNum = this.maxChildrenNumLimit;
                }
            },
            'packageMainDetails.tripStartAt'() {
                this.packageMainDetails.tripStartAt.setHours(0, 0, 0, 0);
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

</style>
