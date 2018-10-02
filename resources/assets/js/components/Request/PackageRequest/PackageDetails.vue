<i18n>
    {

    "ar":{
    "packageDetails":{
    "startPlace":"مكان البداية",
    "endPlace":"مكان النهاية",
    "startEndJourney":"بداية الرحلة",
    "countries":"البلاد",
    "placesNum":"عدد المدن",
    "transfer":"الانتقالات",
    "childrenNum":"عدد الاطفال",
    "adultsNum":"عدد البالغين",
    "childrenMaxNum":"اقصى عدد للاطفال",
    "childAge":"عمر الطفل"

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
    "placesNum":"Number of Cities",
    "transfer":"Transfer",
    "childrenNum":"Children Number",
    "adultsNum":"Adults Number",
    "childrenMaxNum":"Children maximum number",
    "childAge":"Child Age"
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
                               v-model="packageMainDetails.startPlace"
                               @input="validateStartPlace"
                               class="form-control"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-3"
                           :class="$t('labelClass')"
                    >{{$t('packageDetails.endPlace')}}</label>
                    <div class="col-6">
                        <input type="text" :placeholder="$t('packageDetails.endPlace')"
                               v-model="packageMainDetails.endPlace"
                               @input="validateEndPlace"
                               class="form-control"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-3"
                           :class="$t('labelClass')"
                    >{{$t('packageDetails.startEndJourney')}}</label>
                    <div class="col-6">
                        <datepicker @input="validateTripStartAt"
                                    v-model="updatedDate" :disabledDates="disabledDates"
                                    :bootstrap-styling="true"
                                    calendar-class="h5 w-100"
                                    :language="ar"
                        >


                        </datepicker>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-form-label col-form-label-lg col-3"
                           :class="$t('labelClass')"
                    >{{$t('packageDetails.countries')}}</label>
                    <div class="col-6">
                        <multiselect
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
                            @input="validateCountries"

                        ></multiselect>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-3"
                           :class="$t('labelClass')"
                    >{{$t('packageDetails.placesNum')}}</label>
                    <div class="col-6">
                        <input type="number" :placeholder="$t('packageDetails.placesNum')" min="0"
                               class="form-control"
                               v-model="packageMainDetails.placesNum"
                               @input="validatePlacesNum"
                        />
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
                    <!--<div class="col-3 d-flex align-items-center justify-content-end text-right-->
                    <!--rounded"-->
                    <!--style="background-color: rgba(91,192,222, .8);"-->
                    <!--v-if="packageMainDetails.adultsNum">-->
                    <!--{{$t('packageDetails.childrenMaxNum')}} {{maxChildrenNum}}-->
                    <!--</div>-->
                    <!--<div v-else class="col-3"></div>-->
                    <div class="col-6 d-flex align-items-center">
                        <input type="number" :placeholder="$t('packageDetails.adultsNum')"
                               class="form-control"
                               v-model="packageMainDetails.adultsNum" min="1" @input="validateAdultsNum"/>
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
                               @input="updateChildAge"
                        />
                    </div>
                </div>

                <div v-if="show">

                    <div v-for="(num, key) in packageMainDetails.childrenNumber">
                        <div class="form-group row">
                            <label class="col-form-label col-form-label-lg col-3"
                                   :class="$t('labelClass')"
                            >
                                {{$t('packageDetails.childAge')}}
                            </label>
                            <div class="col-6">
                                <multiselect :placeholder="$t('packageDetails.childAge')"
                                             v-model="packageMainDetails.childrenAges[key]"
                                             :options="staticChildrenAges"
                                             tagPosition="top"
                                             @input="validateChildrenAge"
                                >

                                </multiselect>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer d-flex justify-content-between" :dir="$t('labelDir')">
                <button class="btn btn-primary" @click.prevent="nextComponent"
                        :class="{'disabled': !activateNextBtn}"
                >{{$t('next')}}
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
    import HotelDatePicker from 'vue-hotel-datepicker';


    export default {
        name: 'PackageDetails',
        components: {
            Datepicker,
            Multiselect,
            DestinationDetails,
            HotelDatePicker
        },
        data() {
            return {
                show: false,
                isLoading: false,
                countries: [
                    {id: '', en_short_name: ''}
                ],
                staticChildrenAges: ["< 1", 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                activateNextBtn: false,
                maxChildrenNum: null,
                maxChildrenPerRoom: 4,
                updatedDate: null,
                validation: {
                    startPlace: false,
                    endPlace: false,
                    tripStartAt: false,
                    // tripEndAt: false,
                    selectedCountries: false,
                    adultsNum: false,
                    placesNum: false,
                    childrenNumber: true,
                    childrenAges: true
                },
                packageMainDetails: {
                    startPlace: '',
                    endPlace: '',
                    tripStartAt: null,
                    // tripEndAt: null,
                    selectedCountries: [],
                    placesNum: null,
                    transfer: false,
                    adultsNum: null,
                    childrenNumber: 0,
                    childrenAges: [],
                },
                // i18n_ar: {
                //     night: 'الليله',
                //     nights: 'الليالى',
                //     'day-names': ['الاحد', 'الاثنين', 'الثلاثاء', 'الاربعاء', 'الخميس', 'الجمعة', 'السبت'],
                //     'check-in': 'بداية الرحلة',
                //     'check-out': 'نهاية الرحلة',
                //     'month-names': ['يناير', 'فبراير', 'مارس', 'ابريل', 'مايو', 'يونيو', 'يوليو', 'اغسطس', 'سبتمبر', 'اكتوبر', 'نوفمبر', 'ديسمبر'],
                // },
                // i18n_en: {
                //     night: 'Night',
                //     nights: 'Nights',
                //     'day-names': ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
                //     'check-in': 'Check-in',
                //     'check-out': 'Check-Out',
                //     'month-names': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                // }
            }
        }
        ,
        mounted() {
            bus.$on('go-back', (component) => {
                this.$emit('selected-component', component);
            });
            axios.get('/api/countries').then(response => {
                this.countries = response.data;
            });
        },
        methods: {
            activateNxtBtn() {
                for (let check in this.validation) {
                    if (!this.validation[check]) {
                        this.activateNextBtn = false;
                        return;
                    }
                    this.activateNextBtn = true;
                }
            },
            validateStartPlace() {
                if (this.packageMainDetails.startPlace) {
                    this.validation.startPlace = true;
                } else this.validation.startPlace = false;
                // console.log(this.validation.startPlace);
                this.activateNxtBtn();

            },
            validateEndPlace() {
                if (this.packageMainDetails.endPlace) {
                    this.validation.endPlace = true;
                } else this.validation.endPlace = false;
                this.activateNxtBtn();
            },
            validateCountries() {
                if (this.packageMainDetails.selectedCountries.length) {
                    this.validation.selectedCountries = true;
                } else this.validation.selectedCountries = false;
                this.activateNxtBtn();
            },
            validateAdultsNum() {
                this.maxChildrenNum = this.packageMainDetails.adultsNum * this.maxChildrenPerRoom;
                this.validateChildrenNum();
                if (this.packageMainDetails.adultsNum) {
                    this.validation.adultsNum = true;
                } else this.validation.adultsNum = false;
                this.activateNxtBtn();

            },
            validatePlacesNum() {
                // console.log(this.packageMainDetails.placesNum);
                if (Number(this.packageMainDetails.placesNum)) {
                    this.validation.placesNum = true;
                } else this.validation.placesNum = false;
                this.activateNxtBtn();
            },
            validateChildrenAge() {
                // console.log("validating children ages");
                // console.log("childrenNumber", this.packageMainDetails.childrenNumber);
                // console.log("childrenAges", this.packageMainDetails.childrenAges);
                if (this.packageMainDetails.childrenNumber === this.packageMainDetails.childrenAges.length) {
                    for (let i = 0; i < this.packageMainDetails.childrenAges.length; i++) {
                        if (!this.packageMainDetails.childrenAges[i]) {
                            this.validation.childrenAges = false;
                            break;
                        }
                        this.validation.childrenAges = true;
                    }
                } else if (this.packageMainDetails.childrenNumber < this.packageMainDetails.childrenAges.length) {
                    this.removeChildrenAges();
                } else if (this.packageMainDetails.childrenNumber > this.packageMainDetails.childrenAges.length) {
                    this.validation.childrenAges = false;
                }
                this.activateNxtBtn();
            },
            validateChildrenNum() {
                // validate the max children number allowed
                if (Number(this.packageMainDetails.childrenNumber) <= Number(this.maxChildrenNum)) {
                    this.validation.childrenNumber = true;
                } else {
                    this.validation.childrenNumber = false;
                }
                //
                if (Number(this.packageMainDetails.childrenNumber) === 0) {
                    this.removeChildrenAges();
                    this.validation.childrenNumber = true;
                    this.validation.childrenAges = true;
                } else {
                    this.validateChildrenAge();
                    return;
                }
                this.activateNxtBtn();
            },
            removeChildrenAges() { // remove from childrenAges until it's equal to childrenNumber
                while (this.packageMainDetails.childrenAges.length !== this.packageMainDetails.childrenNumber) {
                    this.packageMainDetails.childrenAges.pop();
                }
            },
            setTransferRequest(transfer) {
                this.packageMainDetails.transfer = transfer.value;
            },
            validateTripStartAt() {
                console.log(this.updatedDate)
                // if (this.updatedDate) {
                //     this.validation.tripStartAt = true;
                //     // set the time to 0, fixing nightsNum
                //     let updateDate = new Date(this.updated)
                //     let date = this.updatedDate.getDate();
                //     let month = this.updatedDate.getMonth();
                //     let year = this.updatedDate.getFullYear();
                //     this.packageMainDetails.tripStartAt = new Date(year, month, date, 0, 0, 0);
                // } else {
                //     this.validation.tripStartAt = false;
                // }
                this.activateNxtBtn();
            },
            // getCheckOutDate(checkOut) {
            //     this.packageMainDetails.tripEndAt = checkOut;
            //     if (this.packageMainDetails.tripStartAt) {
            //         this.validation.tripEndAt = true;
            //     } else {
            //         this.validation.tripEndAt = false;
            //     }
            //     this.activateNxtBtn();
            // },
            nextComponent() {
                if (this.activateNextBtn) {
                    window.packageDetails.packageMainDetails = this.packageMainDetails;
                    this.$emit('next-component', {
                        component: 'DestinationBase',
                        step: 'destinationDetails'
                    });
                }
            },
            previousComponent() {
                this.$emit('previous-component', "SelectService");
            },
            updateChildAge() {
                this.packageMainDetails.childrenNumber = parseInt(this.packageMainDetails.childrenNumber);
                this.validateChildrenNum();
                if (this.packageMainDetails.childrenNumber > 0) {
                    this.show = true
                } else {
                    this.show = false
                }
            }
            ,
            countryFind(query) {
                this.isLoading = true;
                axios.post('/api/countries', {query: query}).then(response => {
                    this.countries = response.data;
                    this.isLoading = false

                });
            }
            ,
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
        }
    }
</script>

<style scoped>

</style>
