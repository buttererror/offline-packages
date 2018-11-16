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
    "rangeDateMessage":"برجاء استكمال التواريخ السابقة"
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
    "rangeDateMessage":"Please, complete the previous dates"

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
                    @input="validateCity"
                >

                </multiselect>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label col-form-label-lg col-3" :class="$t('labelDir')"
            >{{$t('packageDetails.startEndJourney')}}
            </label>
            <div class="col-6 bg-white text-center d-flex flex-column justify-content-center"
                 style="height: 48px" v-if="disableDatePicker">{{$t("rangeDateMessage")}}
            </div>
            <div class="col-6" v-else>

                <HotelDatePicker :startDate="disableDatesBefore"
                                 :minNights="1"
                                 format="DD/MM/YYYY"
                                 :hoveringTooltip="getNights"
                                 :i18n="hotelPickerLang"
                                 :showYear="true"
                                 :startingDateValue="startRangeDate"
                                 dir="ltr" :cityNumber="cityNumber"
                                 @checkInChanged="getCheckInDate"
                                 @checkOutChanged="getCheckOutDate"
                >


                </HotelDatePicker>
            </div>

        </div>


        <div class="form-group row">
            <label class="col-form-label col-form-label-lg col-3" :class="$t('labelDir')"
            >{{$t('packageDetails.nightsNum')}}</label>
            <div class="col-6">
                <input type="text" placeholder=""
                       class="form-control" :class="$t('labelDir')" readonly
                       v-model="destinationDetails.nightsNum"
                />
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
        <div v-if="show">
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
                                 :options="carLevel" @input="validateCarLevel"
                                 tagPosition="bottom" openDirection="bottom"
                                 :preserveSearch="true" :showNoResults="false" selectLabel=""
                    >
                    </multiselect>
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
        <div class="form-group row" v-if="showAccomodationType">

            <label class="col-form-label col-form-label-lg col-3" :class="$t('labelDir')"
            >{{$t('packageDetails.accomodationType')}}
            </label>
            <div class="col-6">

                <multiselect placeholder=""
                             v-model="destinationDetails.selectedAccomodationType"
                             :options="accomodationType" @input="emptyOnAccommodationType"
                             tagPosition="bottom" openDirection="bottom"
                             :preserveSearch="true" :showNoResults="false" selectLabel=""
                >

                </multiselect>
            </div>

        </div>
        <div v-if="destinationDetails.reserveAccomodation">
            <AccommodationDetails :cityNumber="cityNumber"
                                  :accomType="destinationDetails.selectedAccomodationType"
            >
            </AccommodationDetails>
        </div>
    </div>

</template>

<script>

    import Datepicker from 'vuejs-datepicker';
    import Multiselect from 'vue-multiselect';
    import AccommodationDetails from './AccommodationDetails';
    import HotelDatePicker from '../vue-datepicker/HotelDatePicker.vue';


    import {en, ar} from 'vuejs-datepicker/dist/locale'

    export default {
        name: "DestinationDetails",
        props: {
            cities: Array,
            cityNumber: Number
        },
        components: {
            Datepicker,
            Multiselect,
            AccommodationDetails,
            HotelDatePicker
        },
        data() {
            return {
                ar,
                en,
                show: false,
                showAccomodationType: false,
                carLevel: ['standard', 'premium'],
                accomodationType: [
                    this.$t('packageDetails.typeHotel'),
                    this.$t('packageDetails.typeApartment')
                ],
                adultsNum: window.packageDetails.packageMainDetails.adultsNum,
                childrenNum: window.packageDetails.packageMainDetails.childrenNum,
                nextStartDate: null,
                startRangeDate: window.packageDetails.packageMainDetails.tripStartAt,
                disableDatesBefore: window.packageDetails.packageMainDetails.tripStartAt,
                disableDatePicker: false,
                validation: {
                    city: false,
                    checkInDate: false,
                    checkOutDate: false,
                    selectedCarLevel: true,
                    accommodationDetailsValidation: true,
                },
                destinationDetailsValidation: false,
                destinationDetails: {
                    checkInDate: window.packageDetails.packageMainDetails.tripStartAt,
                    checkOutDate: null,
                    selectedCity: null,
                    rentCar: false, // optional
                    rentCarWithDriver: false, // optional
                    reserveAccomodation: false, // optional but has mandatory
                    selectedCarLevel: '', // mandatory if optional selected
                    selectedAccomodationType: this.$t('packageDetails.typeHotel'),
                    needTours: false, // optional
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
            bus.$on("previous-destination", () => {
                window.packageDetails.destinationsDetails[this.cityNumber] = JSON.parse(JSON.stringify(this.destinationDetails));
            });
            bus.$on("next-destination", () => {
                this.accommodationTypeToEnglish();
                window.packageDetails.destinationsDetails[this.cityNumber] = JSON.parse(JSON.stringify(this.destinationDetails));
                // TODO: bug in range date picker validation
                // this.validateRangePicker();
            });
            bus.$on(`next-component-${this.cityNumber}`, (cityIndex) => {
                this.accommodationTypeToEnglish();
                window.packageDetails.destinationsDetails[cityIndex] = this.destinationDetails;
            });

            bus.$on(`hotel-validation-dest-${this.cityNumber}`, (validation) => {
                if (this.destinationDetails.selectedAccomodationType === this.$t('packageDetails.typeHotel')) {
                    this.validation.accommodationDetailsValidation = validation;
                }
                this.validateWholeAccommodationDetails();
            });
            // trigger this event from inside hotel component to send data on input
            bus.$on(`send-validation-destination-from-nested-inputs-${this.cityNumber}`, () => {
                this.sendValidationToBase();
            });
        },

        methods: {
            getNights(checkIn, checkOut) {
                return (new Date(checkOut) - new Date(checkIn)) / (1000 * 3600 * 24);
            },
            getCheckInDate(checkIn) {
                this.destinationDetails.checkInDate = checkIn;
                this.validateCheckInDate();
            },
            getCheckOutDate(checkOut) {
                this.destinationDetails.checkOutDate = checkOut;
                if (checkOut || !this.destinationDetails.checkInDate && !checkOut) {
                    this.nextStartDate = checkOut;
                    this.destinationDetails.nightsNum = this.getNights(this.destinationDetails.checkInDate, checkOut);
                } else {
                    this.destinationDetails.nightsNum = 0;
                }
                this.emptyNextDates(checkOut);
                console.log(window.packageDetails.destinationsDetails);
                this.validateCheckOutDate();
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
                this.show = car.value;
                if (!this.destinationDetails.rentCar) {
                    this.destinationDetails.rentCarWithDriver = false;
                    this.destinationDetails.selectedCarLevel = '';
                }
                this.validateCarLevel();
            },
            setAcarWithAdriver(driver) {
                this.destinationDetails.rentCarWithDriver = driver.value;
            },
            goTours(tours) {
                this.needTours = tours.value;
            },
            updateAccomodationType(accommodationNeed) {
                this.showAccomodationType = accommodationNeed.value;
                this.destinationDetails.reserveAccomodation = accommodationNeed.value;
                this.validateReserveAccommodation();
            },
            validateCity() {
                if (this.destinationDetails.selectedCity) {
                    this.validation.city = true;
                } else {
                    this.validation.city = false;
                }
                this.processValidationData();
                this.sendValidationToBase();

            },
            validateCheckInDate() {
                if (this.destinationDetails.checkInDate) this.validation.checkInDate = true;
                else this.validation.checkInDate = false;
                this.processValidationData();
                this.sendValidationToBase();

            },
            validateCheckOutDate() {
                if (this.destinationDetails.checkOutDate) this.validation.checkOutDate = true;
                else this.validation.checkOutDate = false;
                this.processValidationData();
                this.sendValidationToBase();

            },

            validateCarLevel() {
                if (this.destinationDetails.selectedCarLevel || !this.destinationDetails.rentCar) {
                    this.validation.selectedCarLevel = true;
                } else {
                    this.validation.selectedCarLevel = false;
                }
                this.processValidationData();
                this.sendValidationToBase();

            },
            validateReserveAccommodation() {
                if (this.destinationDetails.reserveAccomodation &&
                    this.$t('packageDetails.typeHotel') === this.destinationDetails.selectedAccomodationType) {
                    this.validation.accommodationDetailsValidation = false;
                } else {
                    this.validation.accommodationDetailsValidation = true;
                }
                this.processValidationData();
                this.sendValidationToBase();
            },
            validateWholeAccommodationDetails() {
                // the false or the true that comes from the hotel component
                this.processValidationData();
                this.sendValidationToBase();
            },
            // validateRangePicker() {
            //     if (!this.destinationDetails.checkOutDate) {
            //         bus.$emit("validate-range-picker", false);
            //     } else {
            //         bus.$emit("validate-range-picker", true);
            //     }
            //     this.processValidationData();
            //     this.sendValidationToBase();
            // },
            processValidationData() {
                // process the data and get one property .. true or false for the whole destination
                for (let check in this.validation) {
                    if (!this.validation[check]) {
                        this.destinationDetailsValidation = false;
                        return;
                    }
                    this.destinationDetailsValidation = true;
                }
            },
            sendValidationToBase() {
                // send data to destination base
                bus.$emit(`per-destination-validation`,
                    this.destinationDetailsValidation);
                bus.$emit("any-input");
            },
            emptyOnAccommodationType() {
                if (this.destinationDetails.selectedAccomodationType === this.$t('packageDetails.typeHotel')) {
                    this.validation.accommodationDetailsValidation = false;
                } else {
                    this.validation.accommodationDetailsValidation = true;
                }
                this.processValidationData();
                this.sendValidationToBase();
                bus.$emit(`empty-accommodation-fields-${this.cityNumber}`);
            },
            clearRangeSelection() {
                // HDP~1
                bus.$emit("clear-selection"); // listen in hotelDatePicker
                this.destinationDetails.checkInDate = null;
                this.destinationDetails.checkOutDate = null;
                this.destinationDetails.nightsNum = 0;
            },
            setStartDate(date) {
                this.validateCheckInDate();
                if (date) {
                    date = new Date(date);
                    this.startRangeDate = date;
                    this.clearRangeSelection(); // this set checkIn and checkOut with null, call both validation
                    // HDP~2
                    bus.$emit("set-checkIn", date);
                    this.destinationDetails.checkInDate = date;
                    return;
                }
                this.destinationDetails.checkInDate = date;
                this.startRangeDate = date;

            },
            setEndDate(date) {
                this.validateCheckOutDate(date);
                if (!date) {
                    this.destinationDetails.checkOutDate = date;
                    return;
                }
                date = new Date(date);
                bus.$emit("set-checkOut", date);
            },
            accommodationTypeToEnglish() {
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
                    let pastCheckOutDate = window.packageDetails.destinationsDetails[pastCityNumber].checkOutDate;
                    if (!pastCheckOutDate) { // disable datePicker if !checkOut on the past destination
                        this.disableDatePicker = true; // hide datePicker
                        return;
                    }
                    this.disableDatePicker = false; // show datePicker
                    this.disableDatesBefore = new Date(pastCheckOutDate);
                    this.setStartDate(pastCheckOutDate);
                } else { // the case of : not the first time to pass on the destination
                    this.destinationDetails = window.packageDetails.destinationsDetails[currentCityNumber];
                    let currentCheckInDate = this.destinationDetails.checkInDate;
                    let currentCheckOutDate = this.destinationDetails.checkOutDate;
                    let beforeCurrentCityNumber = currentCityNumber - 1;
                    if (beforeCurrentCityNumber) {
                        var beforeCurrentCheckOutDate = window.packageDetails.destinationsDetails[beforeCurrentCityNumber].checkOutDate;
                    }
                    if (pastCityNumber > currentCityNumber) { // down
                        if (beforeCurrentCityNumber === 0) {
                            this.disableDatePicker = false;
                            this.disableDatesBefore = window.packageDetails.packageMainDetails.tripStartAt;
                            this.setStartDate(currentCheckInDate);
                            this.setEndDate(currentCheckOutDate);
                            return;
                        }
                        if(currentCheckInDate){ // currentCheckInDate existed
                            this.disableDatePicker = false; // show
                            this.disableDatesBefore = new Date(beforeCurrentCheckOutDate);
                            this.setStartDate(currentCheckInDate);
                            this.setEndDate(currentCheckOutDate);
                        }else{ // currentCheckInDate not existed
                            if(beforeCurrentCheckOutDate){ // set
                                this.disableDatePicker = false; // show
                                this.disableDatesBefore = new Date(beforeCurrentCheckOutDate);
                                this.setStartDate(beforeCurrentCheckOutDate);
                                this.setEndDate(null);
                            }else{ // unset
                                this.disableDatePicker = true; // hide
                            }
                        }
                    } else { // up
                        if (this.destinationDetails.checkInDate) { // currentCheckInDate existed
                            this.disableDatePicker = false; // show datePicker
                            this.disableDatesBefore = new Date(beforeCurrentCheckOutDate);
                            this.setStartDate(currentCheckInDate);
                            this.setEndDate(currentCheckOutDate);
                        } else { // currentCheckInDate not existed
                            if(beforeCurrentCheckOutDate){ // set
                                this.disableDatePicker = false; // show datePicker
                                this.disableDatesBefore = new Date(beforeCurrentCheckOutDate);
                                this.setStartDate(beforeCurrentCheckOutDate);
                                this.setEndDate(null);
                            }else{ // unset
                                this.disableDatePicker = true; // hide datePicker
                            }
                        }
                    }
                }
            },
            deep: true
        },
        computed: {
            hotelPickerLang: function () {
                if (this.$t("hotelPickerLang") === "ar") {
                    return this.i18n_ar
                }
                else {
                    return this.i18n_en
                }
            }
        }


    }
</script>

<style scoped>

</style>
