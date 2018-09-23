<template>
   <div id="destination_details">
      <div class="card">
         <div class="card-header bg-primary text-white">
            <h4 class="card-title text-center">Destinations Details</h4>
            <h5 class="card-subtitle text-center">Destination #{{cityNumber}}</h5>
         </div>
         <div class="card-body">
            <div v-for="n in packageMainDetails.selectedCountries.length">
               <keep-alive>
                  <DestinationDetails v-if="n === cityNumber" :cityNumber="n" :cities="cities">
                  </DestinationDetails>
               </keep-alive>
            </div>
         </div>
         <div class="text-center" style="user-select: none">
            <a href="#" ref="nextDestinationBtn" @click.prevent="nextDestination"
               class="btn btn-link btn-outline-primary m-4"
            >المدينة القادمة</a>
            <a href="#" ref="previousDestinationBtn" @click.prevent="previousDestination"
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
            if (this.packageMainDetails.selectedCountries.length === this.cityNumber) {
               this.$refs.nextDestinationBtn.classList.add("disabled");
            }else if(this.cityNumber === 2) {
               this.$refs.previousDestinationBtn.classList.remove("disabled");

            }
         },
         previousDestination() {
            this.cityNumber--;
            bus.$emit(`destination-details-${this.cityNumber}`);
            if(this.cityNumber === 1) {
               this.$refs.previousDestinationBtn.classList.add("disabled");
            }else if (this.packageMainDetails.selectedCountries.length - 1 === this.cityNumber) {
               this.$refs.nextDestinationBtn.classList.remove("disabled");
            }
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
