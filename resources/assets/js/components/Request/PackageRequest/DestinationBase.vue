<template>
    <div id="destination_details">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title text-center">Destinations Details</h4>
                <h5 class="card-subtitle text-center">Destination #{{cityNumber}}</h5>
            </div>
            <div class="card-body">
                <div v-for="destinationNumber in placesNum">
                    <keep-alive>
                        <DestinationDetails v-if="destinationNumber === cityNumber"
                                            :cityNumber="destinationNumber" :cities="cities"
                        >
                        </DestinationDetails>
                    </keep-alive>
                </div>
            </div>

            <div class="text-center" style="user-select: none">
                <a href="#" @click.prevent="nextDestination"
                   class="btn btn-link btn-outline-primary m-4" :class="{
               'disabled': placesNum === cityNumber || placesNum === 1}"
                >المدينة القادمة</a>
                <a href="#" @click.prevent="previousDestination"
                   class="btn btn-link btn-outline-primary m-4" :class="{
               'disabled': cityNumber === 1}"
                >المدينة السابقة</a>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button class="btn btn-primary" @click.prevent="nextComponent"
                        :class="{'disabled': !activateNextBtn}"
                >التالى</button>
                <button class="btn btn-primary" @click.prevent="previousComponent">رجوع</button>
            </div>
        </div>
    </div>
</template>

<script>
    import DestinationDetails from "./DestinationDetails";


    export default {
        name: "DestinationBase",
        props: ["data"],
        components: {
            DestinationDetails,
        },
        data() {
            return {
                cityNumber: 1,
                cities: [],
                selectedCountries: window.packageDetails.packageMainDetails.selectedCountries,
                placesNum: Number(window.packageDetails.packageMainDetails.placesNum),
                destinationsDetails: window.packageDetails.destinationsDetails,
                date: new Date(),
                destinationsValidation: [],
                activateNextBtn: false,
                updateListening: null
            }
        },
        mounted() {
            bus.$on(`per-destination-validation`, (destinationValidation) => {
                console.log("per destination validation", destinationValidation);
                console.log("index", this.cityNumber -1);
                this.destinationsValidation[this.cityNumber - 1] = destinationValidation;
            });
            bus.$on('go-back', (component) => {
                this.$emit('selected-component', component);
            });
            bus.$on("any-input", () => {
                this.activateNxtBtn();
                console.log("destinations Validation", this.destinationsValidation);
            });
            window.packageDetails.destinationsDetails = [];
            let selectedCountriesIds = [];
            this.selectedCountries.forEach(function (element) {
                selectedCountriesIds.push(element.id)
            });
            axios.post('/api/cities', {'country_ids': selectedCountriesIds, 'top_destination': 1}).then(response => {
                this.cities = response.data.cities;
            });
        },
        methods: {
            nextDestination() {
                bus.$emit(`destination-details-${this.cityNumber}`);
                this.cityNumber++;
            },
            previousDestination() {
                this.cityNumber--;
                bus.$emit(`destination-details-${this.cityNumber}`);
            },
            nextComponent() {
                if(this.activateNextBtn){
                    this.$emit('next-component', {
                        component: 'FinalNote',
                        step: 'Finalize'
                    });

                }
            },
            previousComponent() {
                this.$emit('previous-component', "PackageDetails");
            },
            activateNxtBtn() {
                if(this.placesNum === this.destinationsValidation.length){
                    for(let i = 0; i < this.destinationsValidation.length; i++){
                        if(!this.destinationsValidation[i]){
                            this.activateNextBtn = false;
                            break;
                        }
                        this.activateNextBtn = true;
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
