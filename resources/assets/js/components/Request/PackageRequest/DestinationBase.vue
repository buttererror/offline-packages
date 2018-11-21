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
                <h5 class="card-subtitle text-center">{{$t('destination')}} #{{cityNumber + 1}}</h5>
            </div>
            <div class="card-body">
                <DestinationDetails :cityNumber="cityNumber" :cities="cities"
                >
                </DestinationDetails>
            </div>

            <div class="text-center" style="user-select: none">
                <button @click.prevent="previousDestination"
                   class="btn btn-link btn-outline-primary m-4" :disabled="cityNumber === 0">
                    {{$t('prevCity')}}
                </button>
                <button @click.prevent="nextDestination"
                   class="btn btn-link btn-outline-primary m-4"
                   :disabled="citiesNumber === cityNumber || citiesNumber === 0">
                    {{$t('nextCity')}}
                </button>
            </div>
            <div class="card-footer d-flex flex-row-reverse justify-content-between">
                <button class="btn btn-primary" @click.prevent="nextComponent" :disabled="citiesNumber !== cityNumber">
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
                cityNumber: 0,
                cities: [],
                selectedCountries: window.packageDetails.packageMainDetails.selectedCountries,
                citiesNumber: Number(window.packageDetails.packageMainDetails.citiesNumber),
                selectedCountriesIds: [],
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
                this.$root.$data.hasErrors = false;
                // Validate required fields
                bus.$emit("validate-destination-details");
                // validate children ages fields
                if(this.$root.$data.hasErrors){
                    return;
                }

                bus.$emit("next-destination");
                this.cityNumber++;
            },
            previousDestination() {
                // fixed : ~ 1
                this.cityNumber--;
                bus.$emit("previous-destination");
            },
            nextComponent() {
                // save the data of the final destination
                bus.$emit("next-destination");
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
