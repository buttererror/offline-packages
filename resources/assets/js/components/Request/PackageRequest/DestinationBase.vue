<template>
    <div id="destination_details">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title text-center">Destination Details</h4>
            </div>
            <div class="card-body">
                <div v-for="n in 3">
                    <keep-alive>
                        <DestinationDetails v-if="n === cityNumber" :cityNumber="n" :cities="cities">
                        </DestinationDetails>
                    </keep-alive>
                </div>
            </div>
            <div class="text-center">
                <a href="#" @click.prevent="nextDestination"
                   class="btn btn-link btn-outline-primary m-4"
                >المدينة القادمة</a>
                <a href="#" @click.prevent="previousDestination"
                   class="btn btn-link btn-outline-primary m-4 disabled"
                >المدينة السابقة</a>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button class="btn btn-primary" @click.prevent="nextComponent">التالى</button>
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
                packageMainDetails: window.packageDetails.packageMainDetails,
                destinationsDetails: window.packageDetails.destinationsDetails,
            }
        },
        mounted() {
            bus.$on('go-back', (component) => {
                this.$emit('selected-component', component);
            });
            window.packageDetails.destinationsDetails = [];
            let selectedCountries = this.packageMainDetails.selectedCountries;
            let selectedCountriesIds = [];
            selectedCountries.forEach(function (element) {
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
            nextComponent() {
                this.$emit('next-component', {
                    component: 'FinalNote',
                    step: 'Finalize'
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
