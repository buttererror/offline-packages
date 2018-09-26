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
    "accomodationType":"نوع الاقامة"


    },
    "validations":{

    },
    "next":"التالى",
    "back":"السابق",
    "male":"ذكر",
    "female":"مؤنث",
    "noResults":"لايوجد نتائج",
    "save":"حفظ",
    "cancel":"الغاء",
    "addBirthDate":"ضع تاريخ ميلادك",
    "hotelPickerLang":"ar",
    "yes":"نعم",
    "no":"لا"
    },

    "en": {
    "packageDetails":{
    "startPlace":"Start Place",
    "startEndJourney":"Start and End of Journey",
    "countries":"countries",
    "placesNum":"Number of Places",
    "transfer":"transfer",
    "childrenNum":"children Number",
    "adultsNum":"Adults Number",
    "childrenMaxNum":"children maximum number",
    "childAge":"Child Age",
    "city":"city",
    "nightsNum":"number of nights",
    "rentCar":"rent a car",
    "withDriver":"With Driver",
    "carLevel":"Car Level",
    "toursNeed":" tours Need" ,
    "reserveAccomodation":"reserve Accomodation",
    "accomodationType":" Accomodation Type"
    },
    "validations":{

    },
    "next":"Next",
    "back":"Back",
    "male":"male",
    "female":"female",
    "noResults":"No Results",
    "save":"save",
    "cancel":"cancel",
    "addBirthDate":"Add your BirthDate",
    "hotelPickerLang":"en",
    "yes":"yes",
    "no":"no"
    }
    }
</i18n>


<template>
    <div>
        <div class="form-group row">
            <div class="col-6 offset-3">
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
            <div class="col-form-label col-form-label-lg col-3 text-right">{{$t('packageDetails.city')}}</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">

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
            <div class="col-form-label col-form-label-lg col-3 text-right">{{$t('packageDetails.startEndJourney')}}</div>
        </div>


        <div class="form-group row">
            <div class="col-6 offset-3">
                <input type="text" placeholder=""
                       class="form-control text-right" readonly
                       v-model="destinationDetails.nightsNum"
                />
            </div>
            <div class="col-form-label col-form-label-lg col-3 text-right">{{$t('packageDetails.nightsNum')}}</div>
        </div>

        <div class="form-group row">
            <div class="col-6 text-right offset-3">
                <toggle-button v-model="destinationDetails.rentCar" :value="false"
                               :sync="true"
                               :labels="{checked: $t('yes'), unchecked: $t('no')}"
                               :width="70"
                               :height="30"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="setArentedCar"
                />

            </div>
            <label class="col-form-label col-form-label-lg col-3 text-nowrap text-right">{{$t('packageDetails.rentCar')}}</label>
        </div>
        <div v-if="show">
            <div class="form-group row">
                <div class="col-6 text-right offset-3">
                    <toggle-button v-model="destinationDetails.rentCarWithDriver" :value="false"

                                   :sync="true"
                                   :labels="{checked: $t('yes'), unchecked: $t('no')}"
                                   :width="65"
                                   :height="25"
                                   switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                                   @change="setAcarWithAdriver"
                    />

                </div>
                <label class="col-form-label col-form-label-lg col-3 text-nowrap text-right">{{$t('packageDetails.withDriver')}}</label>
            </div>

            <div class="form-group row">
                <div class="col-6 offset-3">
                    <multiselect placeholder=""
                                 v-model="destinationDetails.selectedCarLevel"
                                 :options="carLevel" @input="validateCarLevel"
                                 tagPosition="bottom" openDirection="bottom"
                                 :preserveSearch="true" :showNoResults="false" selectLabel=""
                    >
                    </multiselect>
                </div>
                <label class="col-form-label col-form-label-lg text-nowrap col-3 text-right"> {{$t('packageDetails.carLevel')}}</label>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3 text-right">
                <toggle-button v-model="destinationDetails.needTours" :value="false"

                               :sync="true"
                               :labels="{checked: $t('yes'), unchecked: $t('no')}"
                               :width="70"
                               :height="30"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="goTours"
                />

            </div>
            <label class="col-form-label col-form-label-lg col-3 text-nowrap text-right">{{$t('packageDetails.toursNeed')}}</label>
        </div>


        <div class="form-group row">
            <div class="col-6 offset-3 text-right">
                <toggle-button v-model="destinationDetails.reserveAccomodation" :value="false"
                               :sync="true"
                               :labels="{checked:$t('yes'), unchecked:$t('no')}"
                               :width="70"
                               :height="30"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="updateAccomodationType"
                />
            </div>
            <label class="col-form-label col-form-label-lg col-3 text-nowrap text-right">{{$t('packageDetails.reserveAccomodation')}}</label>
        </div>
        <div class="form-group row" v-if="showAccomodationType">

            <div class="col-6 offset-3">

                <multiselect placeholder=""
                             v-model="destinationDetails.selectedAccomodationType"
                             :options="accomodationType" @input="emptyOnAccommodationType"
                             tagPosition="bottom" openDirection="bottom"
                             :preserveSearch="true" :showNoResults="false" selectLabel=""
                >

                </multiselect>
            </div>
            <div class="col-form-label col-form-label-lg col-3 text-right">{{$t('packageDetails.accomodationType')}}</div>

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
                accomodationType: ['Hotel', 'Apartment'],
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
                    'check-in': 'بداية الرحلة',
                    'check-out': 'نهاية الرحلة',
                    'month-names': ['يناير', 'فبراير', 'مارس', 'ابريل', 'مايو', 'يونيو', 'يوليو', 'اغسطس', 'سبتمبر', 'اكتوبر', 'نوفمبر', 'ديسمبر'],
                },
                i18n_en: {
                    night: 'Night',
                    nights: 'Nights',
                    'day-names': ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
                    'check-in': 'Check-in',
                    'check-out': 'Check-Out',
                    'month-names': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                }
            }
        },
        mounted() {
            // console.log("mounting");
            this.setCheckInDate();
            bus.$on(`destination-details-${this.cityNumber}`, (hotelDetails) => {
                this.destinationDetails.hotelDetails = hotelDetails;
                window.packageDetails.destinationsDetails.push(this.destinationDetails);
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
                return new Date(checkOut).getDate() - new Date(checkIn).getDate();
            },
            getCheckInDate(checkIn) {
                this.destinationDetails.checkInDate = checkIn;
                this.validateCheckInDate();
            },
            getCheckOutDate(checkOut) {
                this.destinationDetails.checkOutDate = checkOut;
                this.validateCheckOutDate();
                this.destinationDetails.nightsNum = this.getNights(this.destinationDetails.checkInDate, checkOut);

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
                console.log("validating city")
                if (this.destinationDetails.selectedCity) {
                    this.validation.city = true;
                } else {
                    this.validation.city = false;
                }
                this.processValidationData();
                this.sendValidationToBase();

            },
            validateCheckInDate() {
                console.log("checking in");
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
                if(this.destinationDetails.reserveAccomodation){
                    this.validation.accommodationDetailsValidation = false;
                }else{
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
        computed:{
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
