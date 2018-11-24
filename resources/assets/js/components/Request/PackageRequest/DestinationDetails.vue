<i18n>
    {

    "ar":{
    "packageDetails":{
    "startPlace":"مكان البداية",
    "startEndJourney":"بداية ونهاية الرحلة",
    "countries":"البلاد",
    "placesNum":"عدد الاماكن",
    "transfer":"الانتقالات",
    "childrenNum":"عدد الاطفال",
    "adultsNum":"عدد البالغين",
    "childrenMaxNum":"اقصى عدد للاطفال",
    "childAge":"عمر الطفل",
    "city":"المدينة",
    "nightsNum":"عدد الليالى",
    "rentCar":"تاجير سيارة",
    "withDriver":"مع سائق",
    "carLevel":"مستوى السيارة",
    "toursNeed":" الحاجة لجولات" ,
    "reserveAccomodation":"حجز اقامة",
    "accomodationType":"نوع الاقامة",
    "typeHotel":"فندق",
    "typeApartment":"شقة"


    },
    "next":"التالى",
    "back":"السابق",
    "male":"ذكر",
    "female":"مؤنث",
    "noResults":"لايوجد نتائج",
    "hotelPickerLang":"ar",
    "yes":"نعم",
    "no":"لا",
    "labelDir":"text-right",
    "field": {
    "required": "هذا الحقل مطلوب"
    }
    },

    "en": {
    "packageDetails":{
    "startPlace":"Start Place",
    "startEndJourney":"Start and End of Journey",
    "countries":"Countries",
    "placesNum":"Number of Places",
    "transfer":"Transfer",
    "childrenNum":"Children Number",
    "adultsNum":"Adults Number",
    "childrenMaxNum":"Children Maximum Number",
    "childAge":"Child Age",
    "city":"City",
    "nightsNum":"Number of Nights",
    "rentCar":"Rent a Car",
    "withDriver":"With Driver",
    "carLevel":"Car Level",
    "toursNeed":" Tours Need" ,
    "reserveAccomodation":"Reserve Accommodation",
    "accomodationType":" Accommodation Type",
    "typeHotel":"Hotel",
    "typeApartment":"Apartment"

    },
    "next":"Next",
    "back":"Back",
    "male":"Male",
    "female":"Female",
    "noResults":"No Results",
    "hotelPickerLang":"en",
    "yes":"yes",
    "no":"no",
    "labelDir":"text-left",
    "field": {
    "required": "This field is required"
    }


    }
    }
</i18n>


<template>
    <div>
        <div class="form-group row">
            <label class="col-form-label col-form-label-lg col-3" :class="$t('labelDir')"
            >{{$t('packageDetails.city')}}</label>
            <div class="col-6">
                <multiselect
                    v-model="destinationDetails.selectedCity"
                    tagPosition="bottom" openDirection="bottom"
                    :placeholder="$t('packageDetails.city')"
                    :options="cities"
                    label="name"
                    track-by="id"
                    group-values="cities"
                    group-label="target"
                    :group-select="false"
                    :multiple="false"
                    :searchable="true"
                    :class="{'is-invalid': validation.selectedCity.message}"
                >

                </multiselect>
                <div class="invalid-feedback d-block" :class="$t('labelDir')"
                     v-if="validation.selectedCity.message">
                    {{validation.selectedCity.message}}
                </div>

            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-form-label-lg col-3" :class="$t('labelDir')"
            >{{$t('packageDetails.startEndJourney')}}
            </label>
            <div class="col-6">

                <HotelDatePicker :startDate="disableDatesBefore"
                                 :minNights="1"
                                 format="DD/MM/YYYY"
                                 :hoveringTooltip="getNights"
                                 :i18n="hotelPickerLang"
                                 :showYear="true"
                                 :startingDateValue="startRangeDate"
                                 :endingDateValue="endRangeDate"
                                 dir="ltr" :cityNumber="cityNumber"
                                 @checkInChanged="getCheckInDate"
                                 @checkOutChanged="getCheckOutDate"
                                 :class="{'is-invalid': validation.checkInDate.message || validation.checkOutDate.message}"
                >


                </HotelDatePicker>
                <div class="d-flex justify-content-around">
                    <div class="invalid-feedback d-block" :class="$t('labelDir')"
                         v-if="validation.checkInDate.message">
                        {{validation.checkInDate.message}}
                    </div>
                    <div class="invalid-feedback d-block" :class="$t('labelDir')"
                         v-if="validation.checkOutDate.message">
                        {{validation.checkOutDate.message}}
                    </div>

                </div>

            </div>

        </div>


        <div class="form-group row">
            <label class="col-form-label col-form-label-lg col-3" :class="$t('labelDir')"
            >{{$t('packageDetails.nightsNum')}}</label>
            <div class="col-6">
                <input type="text" placeholder=""
                       class="form-control" :class="$t('labelDir')" readonly
                       v-model="destinationDetails.nightsNum"
                >
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-form-label-lg col-3 text-nowrap" :class="$t('labelDir')"
            >{{$t('packageDetails.rentCar')}}</label>
            <div class="col-6 text-center">
                <toggle-button v-model="destinationDetails.rentCar" :value="false"
                               :sync="true"
                               :labels="{checked: $t('yes'), unchecked: $t('no')}"
                               :width="70"
                               :height="30"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="setArentedCar"
                />

            </div>
        </div>
        <div v-if="destinationDetails.rentCar">
            <div class="form-group row">
                <label class="col-form-label col-form-label-lg col-3 text-nowrap"
                       :class="$t('labelDir')">{{$t('packageDetails.withDriver')}}</label>
                <div class="col-6 text-center">
                    <toggle-button v-model="destinationDetails.rentCarWithDriver" :value="false"

                                   :sync="true"
                                   :labels="{checked: $t('yes'), unchecked: $t('no')}"
                                   :width="65"
                                   :height="25"
                                   switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                                   @change="setAcarWithAdriver"
                    />

                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-form-label-lg text-nowrap col-3"
                       :class="$t('labelDir')"
                >
                    {{$t('packageDetails.carLevel')}}</label>
                <div class="col-6">
                    <multiselect placeholder=""
                                 v-model="destinationDetails.selectedCarLevel"
                                 :options="carLevel"
                                 tagPosition="bottom" openDirection="bottom"
                                 :preserveSearch="true" :showNoResults="false" selectLabel=""
                                 :class="{'is-invalid': validation.selectedCarLevel.message}"
                    >
                    </multiselect>
                    <div class="invalid-feedback d-block" :class="$t('labelDir')"
                         v-if="validation.selectedCarLevel.message">
                        {{validation.selectedCarLevel.message}}
                    </div>

                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-form-label-lg col-3 text-nowrap"
                   :class="$t('labelDir')"
            >{{$t('packageDetails.toursNeed')}}</label>
            <div class="col-6 text-center">
                <toggle-button v-model="destinationDetails.needTours" :value="false"

                               :sync="true"
                               :labels="{checked: $t('yes'), unchecked: $t('no')}"
                               :width="70"
                               :height="30"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="goTours"
                />

            </div>
        </div>


        <div class="form-group row">
            <label class="col-form-label col-form-label-lg col-3 text-nowrap" :class="$t('labelDir')"
            >{{$t('packageDetails.reserveAccomodation')}}</label>
            <div class="col-6 text-center">
                <toggle-button v-model="destinationDetails.reserveAccomodation" :value="false"
                               :sync="true"
                               :labels="{checked:$t('yes'), unchecked:$t('no')}"
                               :width="70"
                               :height="30"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="updateAccomodationType"
                />
            </div>
        </div>
        <div class="form-group row" v-if="destinationDetails.reserveAccomodation">

            <label class="col-form-label col-form-label-lg col-3" :class="$t('labelDir')"
            >{{$t('packageDetails.accomodationType')}}
            </label>
            <div class="col-6">

                <multiselect placeholder=""
                             v-model="destinationDetails.selectedAccomodationType"
                             :options="accomodationType" @input="emptyOnAccommodationType"
                             tagPosition="bottom" openDirection="bottom"
                             :preserveSearch="true" :showNoResults="false" selectLabel=""
                             :class="{'is-invalid': validation.selectedAccomodationType.message}"
                >

                </multiselect>
                <div class="invalid-feedback d-block" :class="$t('labelDir')"
                     v-if="validation.selectedAccomodationType.message">
                    {{validation.selectedAccomodationType.message}}
                </div>

            </div>

        </div>
        <div v-if="destinationDetails.reserveAccomodation">
            <AccommodationDetails :cityNumber="cityNumber" :reserveAccomodation="destinationDetails.reserveAccomodation"
                                  :accomType="destinationDetails.selectedAccomodationType"
                                  :validation="validation.accommodationDetails"
            >
            </AccommodationDetails>
        </div>
    </div>

</template>

<script>

    import Multiselect from 'vue-multiselect';
    import AccommodationDetails from './AccommodationDetails';
    import HotelDatePicker from '../vue-datepicker/HotelDatePicker.vue';


    import {ar, en} from 'vuejs-datepicker/dist/locale'

    export default {
        name: "DestinationDetails",
        props: {
            cities: Array,
            cityNumber: Number
        },
        components: {
            Multiselect,
            AccommodationDetails,
            HotelDatePicker
        },
        data() {
            return {
                ar,
                en,
                carLevel: ['standard', 'premium'],
                accomodationType: [
                    this.$t('packageDetails.typeHotel'),
                    this.$t('packageDetails.typeApartment')
                ],
                adultsNum: window.packageDetails.packageMainDetails.adultsNum,
                childrenNum: window.packageDetails.packageMainDetails.childrenNum,
                hasErrors: false,
                validation: {
                    selectedCity: {
                        message: null,
                        required: true
                    },
                    checkInDate: {
                        message: null,
                        required: true
                    },
                    checkOutDate: {
                        message: null,
                        required: true
                    },
                    rentCar: {
                        message: null,
                        required: false
                    },
                    rentCarWithDriver: {
                        message: null,
                        required: false
                    },
                    selectedCarLevel: {
                        message: null,
                        required: false
                    },
                    needTours: {
                        message: null,
                        required: false
                    },
                    reserveAccomodation: {
                        message: null,
                        required: false
                    },
                    selectedAccomodationType: {
                        message: null,
                        required: false
                    },
                    accommodationDetails: {
                        roomsNum: {
                            message: null,
                            required: true
                        },
                        selectedRoomType: {
                            message: null,
                            required: true
                        },
                        selectedStars: {
                            message: null,
                            required: true
                        },
                        selectedAdultsNum: [],
                        selectedChildrenNum: [],
                        hotelName: {
                            message: null,
                            required: false
                        },
                        area: {
                            message: null,
                            required: false
                        }
                    }
                },
                destinationDetails: {
                    selectedCity: null,
                    checkInDate: window.packageDetails.packageMainDetails.tripStartAt,
                    checkOutDate: null,
                    rentCar: false, // optional
                    rentCarWithDriver: false, // optional
                    selectedCarLevel: '', // mandatory if optional selected
                    needTours: false, // optional
                    reserveAccomodation: false, // optional but has mandatory
                    selectedAccomodationType: this.$t('packageDetails.typeHotel'),
                    nightsNum: 0, // readonly
                    accommodationDetails: null // collected in one value
                },
                i18n_ar: {
                    night: 'الليله',
                    nights: 'الليالى',
                    'day-names': ['الاحد', 'الاثنين', 'الثلاثاء', 'الاربعاء', 'الخميس', 'الجمعة', 'السبت'],
                    'check-in': '   البداية',
                    'check-out': 'النهاية',
                    'month-names': ['يناير', 'فبراير', 'مارس', 'ابريل', 'مايو', 'يونيو', 'يوليو', 'اغسطس', 'سبتمبر', 'اكتوبر', 'نوفمبر', 'ديسمبر'],
                },
                i18n_en: {
                    night: 'Night',
                    nights: 'Nights',
                    'day-names': ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
                    'check-in': 'Check-in',
                    'check-out': 'Check-out',
                    'month-names': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                }
            }
        },
        mounted() {
            if (window.packageDetails.destinationsDetails[0]) {
                this.destinationDetails = JSON.parse(JSON.stringify(window.packageDetails.destinationsDetails[0]));
            }
            bus.$on("reserve-accommodation", (accommodationDetails) => {
                this.destinationDetails.accommodationDetails =  accommodationDetails;
            });
            bus.$on("previous-destination", () => {
                // set the validation messages to null because the previous is already validated
                for (let property in this.validation) {
                    this.validation.selectedCarLevel.required = this.rentCar;
                    this.validation.selectedAccomodationType.required = this.reserveAccomodation;
                    this.validation[property].message = null;
                }
            });
            bus.$on("validate-destination-details", () => {
                this.hasErrors = false;
                // validate destination details on next destination
                for (let property in this.validation) {
                    if (property === "accommodationDetails" && this.destinationDetails.accommodationDetails) {
                        for (let prop in this.validation.accommodationDetails) {
                            if (this.validation.accommodationDetails[prop].required && !this.destinationDetails.accommodationDetails[prop]) {
                                this.validation.accommodationDetails[prop].message = this.$t('field.required');
                                this.hasErrors = true;
                            }else{
                                this.validation.accommodationDetails[prop].message = null;
                            }
                        }
                        continue;
                    }
                    if (this.validation[property].required && !this.destinationDetails[property]) {
                        this.validation[property].message = this.$t('field.required');
                        this.hasErrors = true;
                    } else {
                        this.validation[property].message = null;
                    }
                }
                if (!this.hasErrors) {
                    this.saveAccommodationTypeInEnglish();
                    window.packageDetails.destinationsDetails[this.cityNumber] = JSON.parse(JSON.stringify(this.destinationDetails));
                    bus.$emit('destination-is-valid');
                }
            });
        },
        destroyed() {
            bus.$off('validate-destination-details');
        },
        methods: {
            getNights(checkIn, checkOut) {
                return (new Date(checkOut) - new Date(checkIn)) / (1000 * 3600 * 24);
            },
            getCheckInDate(checkIn) {
                this.destinationDetails.checkInDate = checkIn;
            },
            getCheckOutDate(checkOut) {
                this.destinationDetails.checkOutDate = checkOut;
                if (checkOut || !this.destinationDetails.checkInDate && !checkOut) {
                    this.destinationDetails.nightsNum = this.getNights(this.destinationDetails.checkInDate, checkOut);
                } else {
                    this.destinationDetails.nightsNum = 0;
                }
                this.emptyNextDates(checkOut);
            },
            emptyNextDates(checkOut) {
                if (!checkOut) {
                    // empty the next destinations dates if the current date changes
                    for (let i = this.cityNumber + 1; i < window.packageDetails.destinationsDetails.length; i++) {
                        window.packageDetails.destinationsDetails[i].checkInDate = null;
                        window.packageDetails.destinationsDetails[i].checkOutDate = null;
                    }
                }
            },
            setArentedCar(car) {
                this.destinationDetails.rentCar = car.value;
                this.validation.selectedCarLevel.required = car.value;
                if (!this.destinationDetails.rentCar) {
                    this.destinationDetails.rentCarWithDriver = false;
                    this.destinationDetails.selectedCarLevel = '';
                }
            },
            setAcarWithAdriver(driver) {
                this.destinationDetails.rentCarWithDriver = driver.value;
            },
            goTours(tours) {
                this.needTours = tours.value;
            },
            updateAccomodationType(accommodationNeed) {
                this.destinationDetails.reserveAccomodation = accommodationNeed.value;
                // set the validation required prop of accommodation type with true
                this.validation.selectedAccomodationType.required = accommodationNeed.value;
            },
            emptyOnAccommodationType() {
                bus.$emit("empty-accommodation-fields");
            },
            clearRangeSelection() {
                bus.$emit("clear-selection"); // listen in hotelDatePicker
                // this.destinationDetails.checkInDate = null;
                // this.destinationDetails.checkOutDate = null;
                // this.destinationDetails.nightsNum = 0;
            },
            setStartDate(date) {
                date = new Date(date);
                this.clearRangeSelection(); // this set checkIn and checkOut with null, call both validation
                bus.$emit("set-checkIn", date);
                this.destinationDetails.checkInDate = date;

            },
            setEndDate(date) {
                if (!date) {
                    this.destinationDetails.checkOutDate = date;
                    return;
                }
                date = new Date(date);
                bus.$emit("set-checkOut", date);
            },
            saveAccommodationTypeInEnglish() {
                // save the accommodation type data in English when the language is Arabic
                if (this.destinationDetails.selectedAccomodationType === "فندق") {
                    this.destinationDetails.selectedAccomodationType = "Hotel";
                } else if (this.destinationDetails.selectedAccomodationType === "شقة") {
                    this.destinationDetails.selectedAccomodationType = "Apartment";
                }
            },
            setDestinationDetailsDataToDefault() {
                // set every property to its default value
                for (let property in this.destinationDetails) {
                    if (typeof this.destinationDetails[property] === "number") {
                        this.destinationDetails[property] = 0;
                    } else if (typeof this.destinationDetails[property] === "object") {
                        this.destinationDetails[property] = null;
                    } else if (typeof this.destinationDetails[property] === "boolean") {
                        this.destinationDetails[property] = false;
                    } else if (typeof this.destinationDetails[property] === "string") {
                        this.destinationDetails[property] = '';
                        if (property === "selectedAccomodationType") {
                            this.destinationDetails[property] = this.$t('packageDetails.typeHotel');
                        }
                    }
                }
            }
        },
        watch: {
            cityNumber(currentCityNumber, pastCityNumber) {
                // the case of : first time to pass on the destination
                if (!window.packageDetails.destinationsDetails[currentCityNumber]) {
                    this.setDestinationDetailsDataToDefault();
                    this.destinationDetails.checkInDate = window.packageDetails.destinationsDetails[pastCityNumber].checkOutDate;
                    this.setStartDate(this.destinationDetails.checkInDate);
                } else { // the case of : not the first time to pass on the destination
                    this.destinationDetails = JSON.parse(JSON.stringify(window.packageDetails.destinationsDetails[currentCityNumber]));
                    this.setStartDate(this.destinationDetails.checkInDate);
                    this.setEndDate(this.destinationDetails.checkOutDate);
                }
            }
        },
        computed: {
            hotelPickerLang: function () {
                if (this.$t("hotelPickerLang") === "ar") {
                    return this.i18n_ar
                }
                else {
                    return this.i18n_en
                }
            },
            startRangeDate() {
                if (!window.packageDetails.destinationsDetails[this.cityNumber] && this.cityNumber === 0) {
                    return window.packageDetails.packageMainDetails.tripStartAt;
                } else if (window.packageDetails.destinationsDetails[this.cityNumber] && this.cityNumber === 0) {
                    return new Date(window.packageDetails.destinationsDetails[this.cityNumber].checkInDate);
                }
                return new Date(window.packageDetails.destinationsDetails[this.cityNumber - 1].checkOutDate);
            },
            endRangeDate() {
                if (window.packageDetails.destinationsDetails[this.cityNumber]) {
                    if (window.packageDetails.destinationsDetails[this.cityNumber].checkOutDate) {
                        return new Date(window.packageDetails.destinationsDetails[this.cityNumber].checkOutDate);
                    }
                }
                return null;
            },
            disableDatesBefore() {
                if (this.cityNumber === 0) {
                    return window.packageDetails.packageMainDetails.tripStartAt;
                } else {
                    return new Date(window.packageDetails.destinationsDetails[this.cityNumber - 1].checkOutDate);
                }
            }
        }


    }
</script>

<style scoped>

</style>
