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
            <div class="col-6 bg-white text-center d-flex flex-column justify-content-center" style="height: 48px" v-if="disable">{{$t("rangeDateMessage")}}</div>
            <div class="col-6" v-else>

                <HotelDatePicker :startDate="startRangeDate"
                                 :minNights="1"
                                 format="DD/MM/YYYY"
                                 :hoveringTooltip="getNights"
                                 :i18n="hotelPickerLang"
                                 :showYear="true"
                                 :startingDateValue="startRangeDate"
                                 dir="ltr" :cityNumber="cityNumber"
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
            <HotelDetail :destinationNumber="cityNumber"
                         :accomType="destinationDetails.selectedAccomodationType"
            >
            </HotelDetail>
        </div>
    </div>

</template>

<script>

    import Datepicker from 'vuejs-datepicker';
    import Multiselect from 'vue-multiselect';
    import HotelDetail from './HotelDetails';
    // import HotelDatePicker from 'vue-hotel-datepicker';
    import HotelDatePicker from '../vue-datepicker/HotelDatePicker.vue';


    import {en, ar} from 'vuejs-datepicker/dist/locale'

    export default {
        name: "DestinationDetails",
        props: ["cities", "cityNumber", "disableBefore", "disable"],
        components: {
            Datepicker,
            Multiselect,
            HotelDetail,
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
                    this.$t('packageDetails.typeApartment')],
                tripStartAt: window.packageDetails.packageMainDetails.tripStartAt,
                adultsNum: window.packageDetails.packageMainDetails.adultsNum,
                childrenNum: window.packageDetails.packageMainDetails.childrenNum,
                startRangeDate: this.disableBefore,
                nextStartDate: null,
                validation: {
                    city: false,
                    checkInDate: false,
                    checkOutDate: false,
                    selectedCarLevel: true,
                    accommodationDetailsValidation: true,
                },
                destinationDetailsValidation: false,
                destinationDetails: {
                    checkInDate: null,
                    checkOutDate: null,
                    selectedCity: '',
                    rentCar: false, // optional
                    rentCarWithDriver: false, // optional
                    reserveAccomodation: false, // optional but has mandatory
                    selectedCarLevel: '', // mandatory if optional selected
                    selectedAccomodationType: this.$t('packageDetails.typeHotel'),
                    needTours: false, // optional
                    nightsNum: 0, // readonly
                    hotelDetails: {} // collected in one value
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
            bus.$on(`clear-and-set-${this.cityNumber}`, (newValue) => {
                console.log("clearing clearing");
                this.startRangeDate = newValue;
                this.clearRangeSelection(); // this set checkIn and checkOut with null, call both validation
                this.clearNextRangesSelection();
                this.setStartDate(newValue); // this call checkIn validation
            });
            bus.$on(`checkInChanged-${this.cityNumber}`, (checkIn) => {
                this.getCheckInDate(checkIn);
                this.clearNextRangesSelection();
            });
            bus.$on(`checkOutChanged-${this.cityNumber}`, (checkOut) => {
                this.getCheckOutDate(checkOut);
            });
            this.setCheckInDate();
            bus.$on(`destination-details-${this.cityNumber}`, (hotelDetails) => {
                this.destinationDetails.hotelDetails = hotelDetails;
            });
            bus.$on(`next-destination-${this.cityNumber}`, (cityIndex) => {
                // console.log("disable", this.disable);
                this.accommodationTypeToEnglish();
                window.packageDetails.destinationsDetails[cityIndex] = this.destinationDetails;
                // console.log("nextStartDate", this.nextStartDate);
                // console.log("checkInDate", this.destinationDetails.checkInDate);
                // console.log("before send to base", {checkIn: this.destinationDetails.checkInDate, checkOut: this.nextStartDate})
                bus.$emit("next-start-date", {
                    startDate: this.disableBefore,
                    checkOut: this.nextStartDate
                });
                // TODO: bug in range date picker validation
                this.validateRangePicker();
            });
            bus.$on(`previous-destination-${this.cityNumber}`, (cityIndex) => {
                window.packageDetails.destinationsDetails[cityIndex] = this.destinationDetails;
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
            setCheckInDate() {
                this.destinationDetails.checkInDate = this.disableBefore;
                this.validateCheckInDate();
            },
            getNights(checkIn, checkOut) {
                return (new Date(checkOut) - new Date(checkIn)) / (1000 * 3600 * 24);
            },
            getCheckInDate(checkIn) {
                // console.log("------------------------");
                // console.log("changing checkIn");
                // console.log("checkIn", checkIn);
                // console.log("this.checkIn", this.checkIn);
                // console.log("------------------------");
                this.destinationDetails.checkInDate = checkIn;
                this.validateCheckInDate();
            },
            getCheckOutDate(checkOut) {
                console.log("------------------------");
                console.log("changing checkOut");
                console.log("checkout", checkOut);
                this.destinationDetails.checkOutDate = checkOut;
                if (checkOut || !this.destinationDetails.checkInDate && !checkOut) {
                    this.nextStartDate = checkOut;
                    this.destinationDetails.nightsNum = this.getNights(this.destinationDetails.checkInDate, checkOut);
                } else {
                    this.destinationDetails.nightsNum = 0;
                }
                // console.log("nightsNum", this.destinationDetails.nightsNum);
                // console.log("------------------------");
                this.validateCheckOutDate();
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
                // console.log("validating city")
                if (this.destinationDetails.selectedCity) {
                    this.validation.city = true;
                } else {
                    this.validation.city = false;
                }
                this.processValidationData();
                this.sendValidationToBase();

            },
            validateCheckInDate() {
                // console.log("checking in");
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
            validateRangePicker(){
                if(!this.destinationDetails.checkOutDate){
                    bus.$emit("validate-range-picker", false);
                }else{
                    bus.$emit("validate-range-picker", true);
                }
                this.processValidationData();
                this.sendValidationToBase();
            },
            processValidationData() {
                // process the data and get one property .. true or false for the whole destination
                for (let check in this.validation) {
                    if (!this.validation[check]) {
                        // console.log("check", check);
                        this.destinationDetailsValidation = false;
                        return;
                    }
                    this.destinationDetailsValidation = true;
                }
            },
            sendValidationToBase() {
                // send data to destination base
                // console.log("inDestinationDetails cityNumber", this.cityNumber);
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
                // console.log("----------");
                // console.log("clear-selection");
                bus.$emit(`clear-selection-${this.cityNumber}`); // listen in hotelDatePicker
                this.destinationDetails.checkInDate = null;
                this.destinationDetails.checkOutDate = null;
                this.destinationDetails.nightsNum = this.getNights(this.destinationDetails.checkInDate, this.destinationDetails.checkOutDate);
                // console.log("checkInDate, checkOutDate ~ data");
                // console.log(this.destinationDetails.checkInDate, this.destinationDetails.checkOutDate);
                // console.log("----------");
            },
            clearNextRangesSelection(){
                bus.$emit("clear-next-ranges-selection");
            },
            setStartDate(date) {
                // console.log("setting checkIn");
                this.setCheckInDate(); // set checkInDate with the new value
                bus.$emit(`set-checkIn-${this.cityNumber}`, date);
            },
            setEndDate(date) {
                // console.log("setting checkOut");
                bus.$emit(`set-checkOut-${this.cityNumber}`, date);
            },
            accommodationTypeToEnglish() {
                if(this.destinationDetails.selectedAccomodationType === "فندق"){
                    this.destinationDetails.selectedAccomodationType = "Hotel";
                }else if(this.destinationDetails.selectedAccomodationType === "شقة"){
                    this.destinationDetails.selectedAccomodationType = "Apartment";
                }
            }
        },
        watch: {
            "destinationDetails.checkOutDate"(newValue) { // trigger when the start date changes
                console.log("setting new value");
                console.log("cityNumber", this.cityNumber);
                bus.$emit(`clear-and-set-${this.cityNumber + 1}`, newValue);
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
