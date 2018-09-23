<template>
   <div id="detailsContainer">
      <div class="card">
         <div class="card-header bg-primary text-white">
            <h4 class="card-title text-center">Package Details</h4>
         </div>
         <div class="card-body">
            <div class="form-group row">
               <div class="col-6 offset-3">
                  <input type="text" placeholder="مكان البدايه"
                         v-model="packageMainDetails.startPlace"
                         style="text-align: right" class="form-control"/>
               </div>
               <label class="col-form-label col-form-label-lg col-3 text-right"> مكان البداية</label>
            </div>
            <div class="form-group row">
               <div class="col-6 offset-3">
                  <HotelDatePicker @checkInChanged="getCheckInDate"
                                   @checkOutChanged="getCheckOutDate"
                                   :startDate="new Date()"
                                   :minNights="1"
                                   format="DD/MM/YYYY"
                  >


                  </HotelDatePicker>
               </div>
               <label class="col-form-label col-form-label-lg col-3 text-right">بداية ونهاية الرحلة</label>
            </div>

            <div class="row form-group">
               <div class="col-6 offset-3">
                  <multiselect
                        v-model="packageMainDetails.selectedCountries"
                        placeholder="يمكنك البحث" tagPosition="bottom"
                        :options="countries" openDirection="bottom"
                        label="en_short_name"
                        track-by="id"
                        :multiple="true"
                        :close-on-select="false"
                        :hide-selected="true"
                        :loading="isLoading"
                        @search-change="countryFind"

                  ></multiselect>
               </div>
               <label class="col-form-label col-form-label-lg col-3 text-right">المدن</label>
            </div>

            <div class="form-group row">
               <div class="col-6 offset-3">
                  <input type="number" placeholder="عدد الاماكن"
                         style="text-align: right"
                         class="form-control"
                         v-model="packageMainDetails.placesNum"
                  />
               </div>
               <label class="col-form-label col-form-label-lg col-3 text-right">الاماكن</label>
            </div>

            <div class="form-group row">
               <div class="col-3 offset-6 text-right">
                  <toggle-button @change="setTransferRequest"
                        v-model="packageMainDetails.transfer" :value="false"
                        :sync="true"
                        :labels="{checked: 'نعم', unchecked: 'لا'}"
                        :width="70"
                        :height="30"
                        switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                  />
               </div>
               <label class="col-form-label col-form-label-lg col-3 text-nowrap text-right">الانتقالات</label>
            </div>


            <div class="form-group row">
               <div class="col-6 offset-3">
               </div>
               <div class="col-6 offset-3">
                  <input type="number" placeholder="عدد البالغين" style="text-align: right" class="form-control"
                         v-model="packageMainDetails.adultsNum" min="1"/>
               </div>
               <label class="col-form-label col-form-label-lg col-3 text-right">عدد البالغين</label>
            </div>
            <div class="form-group row">
               <div class="col-6 offset-3">
               </div>
               <div class="col-6 offset-3">
                  <input type="number" placeholder="عدد الاطفال" style="text-align: right"
                         v-model="packageMainDetails.childrenNum"
                         class="form-control" min="0"
                         @input="updateChildAge"
                  />
               </div>
               <label class="col-form-label col-form-label-lg col-3 text-right">عدد الاطفال</label>
            </div>

            <div v-if="show">

               <div v-for="(num, key) in packageMainDetails.childrenNum">
                  <div class="form-group row">
                     <div class="col-6 offset-3">
                     </div>
                     <div class="col-6 offset-3">
                        <input type="number" placeholder="عمر الطفل" min="1"
                               v-model="packageMainDetails.childAge[key]"
                               style="text-align: right"
                               class="form-control"/>
                     </div>
                     <div class="col-form-label col-form-label-lg col-3 text-right"> عمر الطفل</div>
                  </div>
               </div>

            </div>
         </div>
         <div class="card-footer d-flex justify-content-between">
            <button class="btn btn-primary" @click.prevent="nextComponent">التالى</button>
            <button class="btn btn-primary" @click.prevent="previousComponent">رجوع</button>
         </div>
      </div>
   </div>

</template>

<script>

   import Datepicker from 'vuejs-datepicker';
   import {en, ar} from 'vuejs-datepicker/dist/locale';
   import Multiselect from 'vue-multiselect';
   import DestinationDetails from './DestinationDetails';
   import HotelDatePicker from 'vue-hotel-datepicker'


   export default {
      name: 'PackageDetails',
      components: {
         Datepicker,
         Multiselect,
         DestinationDetails,
         HotelDatePicker
      },
      data() {
         return {
            ar,
            en,
            show: false,
            isLoading: false,
            countries: [
               {id: '', en_short_name: ''}
            ],
            validation: {
               startPlace: false,
               tripStartAt: false,
               tripEndAt: false,
               selectedCountries: false,
               adultsNum: false,
               childrenNum: false,
               childAge: false
            },
            packageMainDetails: {
               startPlace: '',
               tripStartAt: null,
               tripEndAt: null,
               selectedCountries: [],
               placesNum: null,
               transfer: false,
               adultsNum: null,
               childrenNum: null,
               childAge: [],
            },

         }
      }
      ,
      mounted() {
         bus.$on('go-back', (component) => {
            this.$emit('selected-component', component);
         });
         axios.get('/api/countries').then(response => {
            this.countries = response.data;
         });
      },
      methods: {
         setTransferRequest(transfer) {
            this.packageMainDetails.transfer = transfer.value;
         },
         getCheckInDate(checkIn) {
            this.packageMainDetails.tripStartAt = checkIn;
            console.log("checkIn", checkIn);
         },
         getCheckOutDate(checkOut) {
            this.packageMainDetails.tripEndAt = checkOut;
            console.log("checkOut", checkOut);
         },
         nextComponent() {
            window.packageDetails.packageMainDetails = this.packageMainDetails;
            this.$emit('next-component', {
               component: 'DestinationBase',
               step: 'Destination Details'
            });
         },
         previousComponent() {
            this.$emit('previous-component', "SelectService");
         },
         updateChildAge() {
            console.log(this.packageMainDetails.childrenNum);
            this.packageMainDetails.childrenNum = parseInt(this.packageMainDetails.childrenNum);
            if (this.packageMainDetails.childrenNum > 0) {
               this.show = true
            }
            else {
               this.show = false
            }
         }
         ,
         countryFind(query) {
            this.isLoading = true;
            axios.post('/api/countries', {query: query}).then(response => {
               this.countries = response.data;
               this.isLoading = false

            });
         }
         ,
      }
      ,

   }
</script>

<style scoped>

</style>
