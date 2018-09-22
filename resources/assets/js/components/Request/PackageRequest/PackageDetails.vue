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
               <label class="col-form-label col-form-label-lg col-3"> مكان البداية</label>
            </div>
            <div class="form-group row">
               <div class="col-6 offset-3">
                  <flat-pickr
                        v-model="date"
                        :config="config"
                        id="firstRangeInput"
                        class="flatpickr text-right form-control form-control-lg"
                        name="date">
                  </flat-pickr>
               </div>
               <label class="col-form-label col-form-label-lg col-3">تاريخ بداية الرحلة</label>
            </div>
            <div class="form-group row">

               <div class="col-6 offset-3">
                  <flat-pickr
                        v-model="date"
                        :config="config"
                        id="secondRangeInput"
                        class="flatpickr text-right form-control form-control-lg"
                        name="date">
                  </flat-pickr>
               </div>
               <label class="col-form-label col-form-label-lg col-3">تاريخ نهاية الرحلة</label>
            </div>
            <!--<div class="form-group row">-->
            <!--<div class="col-6 offset-3">-->
            <!--<datepicker placeholder="تاريخ البدايه"-->
            <!--input-class="text-right form-control form-control-lg"-->
            <!--calendar-class="h5 w-100"-->
            <!--:bootstrap-styling="true"-->
            <!--:language="ar"-->
            <!--:value="packageMainDetails.startDate"-->
            <!--v-model="packageMainDetails.startDate"-->
            <!--&gt;-->

            <!--</datepicker>-->
            <!--</div>-->
            <!--<label class="col-form-label col-form-label-lg col-3">تاريخ البدايه</label>-->
            <!--</div>-->
            <!--<div class="form-group row">-->
            <!--<div class="col-6 offset-3">-->
            <!--<datepicker placeholder="تاريخ النهاية"-->
            <!--input-class="text-right form-control form-control-lg"-->
            <!--calendar-class="h5 w-100"-->
            <!--:bootstrap-styling="true"-->
            <!--:language="ar"-->
            <!--v-model="packageMainDetails.endDate"-->
            <!--&gt;-->

            <!--</datepicker>-->
            <!--</div>-->
            <!--<label class="col-form-label col-form-label-lg col-3">تاريخ النهايه</label>-->
            <!--</div>-->

            <div class="row form-group">
               <div class="col-6 offset-3">
                  <multiselect

                        v-model="packageMainDetails.selectedCountries"
                        placeholder="Type to search"
                        :options="countries"
                        label="en_short_name"
                        track-by="id"
                        :multiple="true"
                        :searchable="true"
                        :close-on-select="false"
                        :hide-selected="true"
                        :loading="isLoading"
                        @search-change="countryFind"

                  ></multiselect>
               </div>
               <label class="col-form-label col-form-label-lg col-3">المدن</label>
            </div>

            <div class="form-group row">
               <div class="col-6 offset-3">
                  <input type="text" placeholder="عدد الاماكن"
                         style="text-align: right"
                         class="form-control"
                         v-model="packageMainDetails.placesNum"
                  />
               </div>
               <label class="col-form-label col-form-label-lg col-3">الاماكن</label>
            </div>

            <div class="form-group row">
               <div class="col-6 offset-3">
                  <toggle-button v-model="packageMainDetails.transfer" :value="false"

                                 :sync="true"
                                 :labels="{checked: 'نعم', unchecked: 'لا'}"
                                 :width="80"
                                 :height="35"
                                 switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                  />
               </div>
               <label class="col-form-label col-form-label-lg col-3 text-nowrap">الانتقالات</label>
            </div>


            <div class="form-group row">
               <div class="col-6 offset-3">
               </div>
               <div class="col-6 offset-3">
                  <input type="text" placeholder="عدد البالغين" style="text-align: right" class="form-control"
                         v-model="packageMainDetails.adultsNum"/>
               </div>
               <label class="col-form-label col-form-label-lg col-3">عدد البالغين</label>
            </div>
            <div class="form-group row">
               <div class="col-6 offset-3">
               </div>
               <div class="col-6 offset-3">
                  <input type="text" placeholder="عدد الاطفال" style="text-align: right"
                         v-model="packageMainDetails.childrenNum"
                         class="form-control"
                         @input="updateChildAge"
                  />
               </div>
               <label class="col-form-label col-form-label-lg col-3">عدد الاطفال</label>
            </div>

            <div v-if="show">

               <div v-for="(num, key) in packageMainDetails.childrenNum">
                  <div class="form-group row">
                     <div class="col-6 offset-3">
                     </div>
                     <div class="col-6 offset-3">
                        <input type="text" placeholder="عمر الطفل"
                               v-model="packageMainDetails.childAge[key]"
                               style="text-align: right"
                               class="form-control"/>
                     </div>
                     <div class="col-form-label col-form-label-lg col-3"> عمر الطفل</div>
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
   import flatPickr from 'vue-flatpickr-component';
   import flatpickr from 'flatpickr';
   import 'flatpickr/dist/flatpickr.css';
   import 'flatpickr/dist/themes/material_blue.css';
   import rangePlugin from 'flatpickr/dist/plugins/rangePlugin';

   // import {Arabic} from 'flatpickr/dist/l10n/ar';
   const myInput = document.querySelectorAll(".flatpickr");

   const fp = flatpickr(myInput, {}); // flatpickr


   export default {
      name: 'PackageDetails',
      components: {
         Datepicker,
         Multiselect,
         DestinationDetails,
         flatPickr
      },
      data() {
         return {
            // Initial value
            date: null,
            // Get more form https://chmln.github.io/flatpickr/options/
            config: {
               mode: "single",
               dateFormat: "l-d-F-Y",
               plugins: [
                  new rangePlugin({input: "#secondRangeInput"}),
               ]
            },
            ar,
            en,
            show: false,
            isLoading: false,
            countries: [
               {id: '', en_short_name: ''}
            ],
            packageMainDetails: {
               startPlace: '',
               startDate: '',
               endDate: '',
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
      }
      ,
      computed: {}
      ,
      methods: {
         nextComponent() {
            window.packageDetails.packageMainDetails = this.packageMainDetails;
            this.$emit('next-component', {
               component: 'DestinationBase',
               step: 'Destination Details'
            });
            // setTimeout(() => {
            //     bus.$emit("data-to-destination", this.package);
            // }, 1000);


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
