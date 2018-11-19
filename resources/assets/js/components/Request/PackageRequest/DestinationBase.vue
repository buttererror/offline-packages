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
                <DestinationDetails :cityNumber="cityNumber" :cities="cities"
                >
                </DestinationDetails>
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
                <button class="btn btn-primary" @click.prevent="nextComponent">
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
                selectedCountriesIds: []
            }
        },
        mounted() {
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
        },
        methods: {
            nextDestination() {
                bus.$emit("next-destination");
                this.cityNumber++;
            },
            previousDestination() {
                bus.$emit("previous-destination");
                // fixed : ~ 1
                this.cityNumber--;
            },
            nextComponent() {
                // this event for the breadcurmbs
                this.$emit('next-component', {
                    component: 'FinalNote',
                    step: 'finalize'
                });
            },
            previousComponent() {
                this.$emit('previous-component', "PackageDetails");
            }
        }
    }
</script>

<style scoped>

</style>
