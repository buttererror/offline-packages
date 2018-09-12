<template>
    <div id="destination_details">
        <div class="card">
            <div class="card-header">Destination Details</div>
            <div class="card-body">
                <div v-for="n in 3">
                    <keep-alive>
                        <DestinationDetails v-if="n === cityNumber" :cities="cities">
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
            <div class="card-footer">
                <button class="btn btn-primary" @click.prevent="changeComponent">التالى</button>
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
                package: {
                    clientDetails: {},
                    packageMainDetails: {},
                    destinations: [],
                }
            }
        },
        mounted() {
            // this.$on("change-component", (data) => {
                console.log('parent');
                console.log(this.data);
                this.package.clientDetails = this.data.clientDetails;
                this.package.packageMainDetails = this.data.packageMainDetails;
                let selectedCountries = this.package.packageMainDetails.selectedCountries;
                let selectedCountriesIds = [];
                selectedCountries.forEach(function (element) {
                    selectedCountriesIds.push(element.id)
                });
                axios.post('/api/cities', {'country_ids': selectedCountriesIds}).then(response => {
                    this.cities = response.data.cities;
                    console.log("axios", this.cities);
                    // bus.$emit("destination-details", this.cities);
                });
            // });
            // bus.$on(`destination-details-${this.cityNumber}`, (data) => {
            //
            // });
        },
        methods: {
            nextDestination() {
                // setTimeout(() => {
                //     bus.$emit("destination-details", this.cities);
                // }, 1000);
                this.cityNumber++;
            },
            changeComponent() {
                this.$emit('change-component', {component: 'FinalNote'});
            },
        }
    }
</script>

<style scoped>

</style>
