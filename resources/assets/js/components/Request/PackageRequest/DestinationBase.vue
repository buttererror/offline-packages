<i18n>
   {

   "ar":{
   "packageDetails":{
   "countries":"البلاد",
   "placesNum":"عدد المدن",
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
   "nextcity":"المدينه القادمة",
   "prevcity":"المدينة السابقة",
   "buttonDir":"text-left"
   },

   "en": {
   "packageDetails":{
   "countries":"Countries",
   "placesNum":"Number of Cities",
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
   "nextcity":"Next City",
   "prevcity":"Previous City",
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
            <div v-for="destinationNumber in placesNum">
               <keep-alive>
                  <DestinationDetails v-if="destinationNumber === cityNumber"
                                      :cityNumber="destinationNumber" :cities="cities"
                                      :checkIn="everyCheckIn" :checkIns="checkIns"
                  >
                  </DestinationDetails>
               </keep-alive>
            </div>
         </div>

         <div class="text-center" style="user-select: none">
            <a href="#" @click.prevent="previousDestination"
               class="btn btn-link btn-outline-primary m-4" :class="{
               'disabled': cityNumber === 1}"
            >{{$t('prevcity')}}</a>
            <a href="#" @click.prevent="nextDestination"
               class="btn btn-link btn-outline-primary m-4" :class="{
               'disabled': placesNum === cityNumber || placesNum === 1}"
            >{{$t('nextcity')}}</a>
         </div>
         <div class="card-footer d-flex flex-row-reverse justify-content-between">
            <button class="btn btn-primary" @click.prevent="nextComponent"
                    :class="{'disabled': !activateNextBtn}"
            >{{$t('next')}}
            </button>
            <button class="btn btn-primary" @click.prevent="previousComponent">{{$t('back')}}</button>
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
            destinationsDetails: [],
            date: new Date(),
            destinationsValidation: [],
            activateNextBtn: false,
            updateListening: null,
            everyCheckIn: window.packageDetails.packageMainDetails.tripStartAt,
            checkIns: []
         }
      },
      mounted() {
         window.packageDetails.destinationsDetails = [];
         bus.$on(`per-destination-validation`, (destinationValidation) => {
            // console.log("per destination validation", destinationValidation);
            // console.log("index", this.cityNumber -1);
            this.destinationsValidation[this.cityNumber - 1] = destinationValidation;
         });
         bus.$on('go-back', (component) => {
            this.$emit('selected-component', component);
         });
         bus.$on("any-input", () => {
            this.activateNxtBtn();
            // console.log("destinations Validation", this.destinationsValidation);
         });
         // bus.$on("collect-destinations", (destinationDetails) => {
         //
         // });
         let selectedCountriesIds = [];
         this.selectedCountries.forEach(function (element) {
            selectedCountriesIds.push(element.id)
         });
         axios.post('/api/cities', {'country_ids': selectedCountriesIds, 'top_destination': 1}).then(response => {
            this.cities = response.data.cities;
         });
         bus.$on("checkout-date-destination", (rangeDate) => {
            console.log("on next destination:", this.cityNumber, rangeDate);
            this.everyCheckIn = rangeDate.checkOut;
            this.checkIns[this.cityNumber] = [];
            this.checkIns[this.cityNumber][0] = rangeDate.checkIn;
            this.checkIns[this.cityNumber][1] = rangeDate.checkOut;
         });
      },
      methods: {
         nextDestination() {
            bus.$emit(`next-destination-${this.cityNumber}`, this.cityNumber - 1);
            this.cityNumber++;
         },
         previousDestination() {
            bus.$emit("previous", this.cityNumber - 1);
            bus.$emit(`previous-destination-${this.cityNumber}`, this.cityNumber - 1);
            this.everyCheckIn = this.checkIns[this.cityNumber - 1][0];
            console.log("when back", this.everyCheckIn);
            this.cityNumber--;
         },
         nextComponent() {
            if (this.activateNextBtn) {
               bus.$emit(`next-component-${this.cityNumber}`, this.cityNumber - 1);
               this.$emit('next-component', {
                  component: 'FinalNote',
                  step: 'finalize'
               });

               console.log("package", window.packageDetails);
            }
         },
         previousComponent() {
            this.$emit('previous-component', "PackageDetails");
         },
         activateNxtBtn() {
            if (this.placesNum === this.destinationsValidation.length) {
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
      watch: {
         everyCheckIn() {

         }
      }
   }
</script>

<style scoped>

</style>
