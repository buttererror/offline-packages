<i18n>
    {

    "ar":{
    "packageDetails":{
    "countries":"البلاد",
    "citiesNumber":"عدد المدن",
    "transfer":"الانتقالات",
    "childrenNum":"عدد الاطفال",
    "adultsNum":"عدد البالغين",
    "childrenMaxNum":"اقصى عدد للاطفال",
    "childAge":"عمر الطفل"
    },
    "next":"التالى",
    "back":"السابق",
    "hotelPickerLang":"ar",
    "yes":"نعم",
    "no":"لا",
    "destination":"مكان",
    "destinations_details":"تفاصيل الاماكن",
    "nextCity":"المدينه القادمة",
    "prevCity":"المدينة السابقة",
    "buttonDir":"text-left"
    },

    "en": {
    "packageDetails":{
    "countries":"Countries",
    "citiesNumber":"Number of Cities",
    "childrenNum":"Children Number",
    "adultsNum":"Adults Number",
    "childrenMaxNum":"Children maximum number",
    "childAge":"Child Age"
    },
    "next":"Next",
    "back":"Back",
    "hotelPickerLang":"en",
    "yes":"yes",
    "no":"no",
    "destination":"Destination",
    "destinations_details":"Destinations Details",
    "nextCity":"Next City",
    "prevCity":"Previous City",
    "buttonDir":"text-right"
    }
    }
</i18n>


<template>
    <div id="destination_details">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title text-center">{{$t('destinations_details')}}</h4>
                <h5 class="card-subtitle text-center">{{$t('destination')}} #{{cityNumber}}</h5>
            </div>
            <div class="card-body">
                <div v-for="destinationNumber in citiesNumber">
                    <keep-alive>
                        <!-- for every destination in the loop
                        cityNumber: Number, unique for every destination
                        cities: Array, constant
                        disableDatesBefore: Date, changes
                        disableDatePicker: Boolean, changes
                        -->
                        <DestinationDetails v-if="destinationNumber === cityNumber"
                                            :cityNumber="destinationNumber" :cities="cities"
                                            :disableDatesBefore="startDate"
                                            :disableDatePicker="disableRangeDate"
                        >
                        </DestinationDetails>
                    </keep-alive>
                </div>
            </div>

            <div class="text-center" style="user-select: none">
                <a href="#" @click.prevent="previousDestination"
                   class="btn btn-link btn-outline-primary m-4"
                   :class="{'disabled': cityNumber === 1}">
                    {{$t('prevCity')}}
                </a>
                <a href="#" @click.prevent="nextDestination"
                   class="btn btn-link btn-outline-primary m-4"
                   :class="{'disabled': citiesNumber === cityNumber || citiesNumber === 1}">
                    {{$t('nextCity')}}
                </a>
            </div>
            <div class="card-footer d-flex flex-row-reverse justify-content-between">
                <button class="btn btn-primary" @click.prevent="nextComponent"
                        :class="{'disabled': !activateNextBtn}">
                    {{$t('next')}}
                </button>
                <button class="btn btn-primary" @click.prevent="previousComponent">
                    {{$t('back')}}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import DestinationDetails from "./DestinationDetails";

    export default {
        name: "DestinationBase",
        components: {DestinationDetails},
        data() {
            return {
                cityNumber: 1,
                cities: [],
                selectedCountries: window.packageDetails.packageMainDetails.selectedCountries,
                citiesNumber: Number(window.packageDetails.packageMainDetails.citiesNumber),
                destinationsDetails: [],
                date: new Date(),
                destinationsValidation: [],
                activateNextBtn: false,
                updateListening: null,
                startDate: window.packageDetails.packageMainDetails.tripStartAt,
                // array of arrays, every array contains the start and the end date of every city
                citiesStartDates: [],
                rangesDatesCheckList: [],
                disableRangeDate: false,
                selectedCountriesIds: []
            }
        },
        mounted() {
            window.packageDetails.destinationsDetails = [];
            // collect the selected countries ids to request the belonged cities
            this.selectedCountries.forEach((element) => {
                this.selectedCountriesIds.push(element.id)
            });
            // get the all the cities of the selected countries
            axios.post('/api/cities', {
                'country_ids': this.selectedCountriesIds,
                'top_destination': 1
            }).then(response => {
                this.cities = response.data.cities;
            });

            bus.$on(`per-destination-validation`, (destinationValidation) => {
                this.destinationsValidation[this.cityNumber - 1] = destinationValidation;
            });
            bus.$on("any-input", () => {
                this.activateNxtBtn();
            });
            // next-start-date emitted at every checkOutDate changes
            bus.$on("next-start-date", (rangeDate) => {
                this.startDate = rangeDate.checkOut; // next city start date
                this.citiesStartDates[this.cityNumber] = [];
                this.citiesStartDates[this.cityNumber][0] = rangeDate.startDate;
                this.citiesStartDates[this.cityNumber][1] = rangeDate.checkOut;
            });
            bus.$on("validate-range-picker", (mark) => {
                this.rangesDatesCheckList[this.cityNumber - 1] = mark;
            });
            bus.$on("clear-selection", () => {
                // set next destination validation with false
                let nextCityIndex = this.cityNumber;
                for (let i = nextCityIndex; i < this.destinationsValidation.length; i++) {
                    this.destinationsValidation[i] = false;
                }
            });
        },
        methods: {
            multipleRangePickersValidation(length) {
                if (!length) return this.disableRangeDate = false;
                for (let i = 0; i < length; i++) {
                    if (!this.rangesDatesCheckList[i]) {
                        this.disableRangeDate = true;
                        return;
                    }
                }
                this.disableRangeDate = false;
            },
            nextDestination() {
                bus.$emit(`next-destination-${this.cityNumber}`, this.cityNumber - 1);
                this.multipleRangePickersValidation(this.cityNumber);
                this.cityNumber++;
            },
            previousDestination() {
                bus.$emit(`previous-destination-${this.cityNumber}`, this.previousCityNumber);
                // bug : ~ 1
                if(this.citiesStartDates[this.previousCityNumber]){
                    this.startDate = this.citiesStartDates[this.previousCityNumber][0]; // previous city start date
                }
                this.cityNumber--;
                this.multipleRangePickersValidation(this.cityNumber - 1);
            },
            nextComponent() {
                if (this.activateNextBtn) {
                    bus.$emit(`next-component-${this.cityNumber}`, this.cityNumber - 1);
                    this.$emit('next-component', {
                        component: 'FinalNote',
                        step: 'finalize'
                    });
                }
            },
            previousComponent() {
                this.$emit('previous-component', "PackageDetails");
            },
            activateNxtBtn() {
                if (this.citiesNumber === this.destinationsValidation.length) {
                    for (let i = 0; i < this.destinationsValidation.length; i++) {
                        if (!this.destinationsValidation[i]) {
                            this.activateNextBtn = false;
                            break;
                        }
                        this.activateNextBtn = true;
                    }
                }
            }
        },
        computed: {
            previousCityNumber() {
                return this.cityNumber - 1;
            }
        }
    }
</script>

<style scoped>

</style>
