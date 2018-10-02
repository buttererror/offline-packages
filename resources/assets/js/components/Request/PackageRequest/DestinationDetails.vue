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
    "labelDir":"text-right"
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
    "labelDir":"text-left"
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
            <div class="col-6">

                <HotelDatePicker @checkInChanged="getCheckInDate"
                                 @checkOutChanged="getCheckOutDate"
                                 :startDate="tripStartAt"
                                 :minNights="1"
                                 format="DD/MM/YYYY"
                                 :hoveringTooltip="getNights"
                                 :startingDateValue="new Date(tripStartAt)"
                                 :i18n="hotelPickerLang"
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
    import HotelDatePicker from 'vue-hotel-datepicker';

    import {en, ar} from 'vuejs-datepicker/dist/locale'

    export default {
        name: "DestinationDetails",
        props: ["cities", "cityNumber"],
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
                updateCheckOutDate: '',
                show: false,
                showAccomodationType: false,
                carLevel: ['standard', 'premium'],
                accomodationType: [this.$t('typeHotel'), this.$t('typeApartment')],
                tripStartAt: window.packageDetails.packageMainDetails.tripStartAt,
                adultsNum: window.packageDetails.packageMainDetails.adultsNum,
                childrenNum: window.packageDetails.packageMainDetails.childrenNum,
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
                    selectedAccomodationType: 'Hotel',
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
            // console.log("mounting");
            this.setCheckInDate();
            bus.$on(`destination-details-${this.cityNumber}`, (hotelDetails) => {
                this.destinationDetails.hotelDetails = hotelDetails;
            });
            bus.$on(`next-destination-${this.cityNumber}`, (cityIndex) => {
                console.log("next-destination", cityIndex)
                window.packageDetails.destinationsDetails[cityIndex] = this.destinationDetails;
                console.log(window.packageDetails.destinationsDetails);
            });
            bus.$on(`previous-destination-${this.cityNumber}`, (cityIndex) => {
                console.log("previous-destination", cityIndex)
                window.packageDetails.destinationsDetails[cityIndex] = this.destinationDetails;
                console.log(window.packageDetails.destinationsDetails);
            });
            bus.$on(`next-component-${this.cityNumber}`, (cityIndex) => {
                console.log("next-component", cityIndex)
                window.packageDetails.destinationsDetails[cityIndex] = this.destinationDetails;
                console.log(window.packageDetails.destinationsDetails);
            });
            bus.$on(`hotel-validation-dest-${this.cityNumber}`, (validation) => {
                // console.log("hotelComponent validation", validation);
                this.validation.accommodationDetailsValidation = validation;
                this.validateWholeAccommodationDetails();
            });
            // trigger this event from inside hotel component to send data on input
            bus.$on(`send-validation-destination-from-nested-inputs-${this.cityNumber}`, () => {
                this.sendValidationToBase();
            });
        },

        methods: {
            setCheckInDate() {
                this.destinationDetails.checkInDate = this.tripStartAt;
                this.validateCheckInDate();
            },
            getNights(checkIn, checkOut) {
                return (new Date(checkOut) - new Date(checkIn)) / (1000 * 3600 * 24);
            },
            getCheckInDate(checkIn) {
                this.destinationDetails.checkInDate = checkIn;
                this.validateCheckInDate();
            },
            getCheckOutDate(checkOut) {
                this.destinationDetails.checkOutDate = checkOut;
                this.validateCheckOutDate();
                this.destinationDetails.nightsNum = this.getNights(this.destinationDetails.checkInDate, checkOut);
                console.log("this.destinationDetails", this.destinationDetails);

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
                if (this.destinationDetails.reserveAccomodation) {
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
                // console.log("empty");
                bus.$emit(`empty-accommodation-fields-${this.cityNumber}`);
            }
        },
        watch: {
            updateCheckOutDate: function () {
                let result = new Date(this.destinationDetails.startDate);
                result.setDate(result.getDate() + parseInt(Math.abs(this.updateCheckOutDate)));
                // destinationDetails.nightsNum = this.updateCheckOutDate;
                this.destinationDetails.endDate = result;
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
            }
        }


    }
</script>

<style scoped>

</style>
