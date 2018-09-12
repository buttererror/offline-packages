<template>
    <div id="destination_details">
        <div class="card">
            <div class="card-header">Destination Details</div>

            <div class="card-body">
                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <multiselect
                                v-model="destinationDetails.selectedCity"
                                placeholder="Type to search"
                                :options="destinationDetails.cities"
                                label="name"
                                track-by="id"
                                :multiple="false"
                                :searchable="true"

                        ></multiselect>
                    </div>
                    <div class="col-form-label col-form-label-lg col-3">المدينة</div>
                </div>

                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <datepicker placeholder=" تاريخ البداية" class="text-right"
                                    :bootstrap-styling="true"
                                    :value="packageDetails.startDate"
                                    v-model="destinationDetails.checkInDate"
                                    :language="ar"

                        ></datepicker>
                    </div>
                    <div class="col-form-label col-3 text-right">تاريخ البدايه</div>
                </div>


                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <input type="text" placeholder="عدد الليالى"
                               style="text-align: right"
                               class="form-control"
                               v-model="destinationDetails.updateCheckOutDate"
                        />
                    </div>
                    <div class="col-form-label col-3 text-right">عدد الليالى</div>
                </div>


                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <datepicker placeholder="ضع تاريخ النهاية" class="text-right"
                                    :bootstrap-styling="true"
                                    :language="ar"
                                    :value="destinationDetails.checkOutDate"
                                    v-model="destinationDetails.checkOutDate"

                        ></datepicker>
                    </div>
                    <div class="col-form-label col-3 text-right">تاريخ النهاية</div>
                </div>
                <div class="form-group row">
                    <div class="col-4 offset-3">
                        <div class="checkbox">
                            <label style="float:right;">
                                <input type="checkbox" v-model="destinationDetails.rentCar" @change="viewCarLevel">تاجير
                                سياره</label>
                        </div>
                    </div>
                    <div class="col-4 offset-3">
                        <div class="checkbox">
                            <label style="float:right;">
                                <input type="checkbox"
                                       v-model="destinationDetails.rentCarWithDriver"
                                       @change="viewCarLevel"
                                >تاجير
                                سياره مع سائق</label>
                        </div>
                    </div>
                    <div class="col-4 offset-3">
                        <div class="checkbox">
                            <label style="float:right;"><input type="checkbox" v-model="destinationDetails.needTours">الحاجة
                                لجولات</label>
                        </div>
                    </div>
                </div>

                <div v-if="show">
                    <div class="form-group">
                        <multiselect
                                v-model="destinationDetails.selectedCarLevel" :options="destinationDetails.carLevel"
                                tagPosition="bottom"
                                :preserveSearch="true" :showNoResults="false" selectLabel=""
                        >

                        </multiselect>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4 offset-3">
                        <div class="checkbox">
                            <label style="float:right;"><input type="checkbox"
                                                               v-model="destinationDetails.reserveAccomodation"
                                                               @change="updateAccomodationType"

                            >حجز اقامة</label>
                        </div>
                    </div>
                </div>
                <div v-if="showAccomodationType">
                    <multiselect
                            v-model="destinationDetails.selectedAccomodationType" :options="destinationDetails.accomodationType"
                            tagPosition="bottom"
                            :preserveSearch="true" :showNoResults="false" selectLabel=""
                    >

                    </multiselect>
                </div>

                <HotelDetail></HotelDetail>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary" @click.prevent="changeComponent">التالى</button>
            </div>
        </div>
    </div>
</template>

<script>

    import Datepicker from 'vuejs-datepicker';
    import Multiselect from 'vue-multiselect'
    import HotelDetail from './HotelDetails'

    import {en, ar} from 'vuejs-datepicker/dist/locale'

    export default {
        props: ['clickedNext', 'currentStep'],
        name: "DestinationDetails",
        components: {
            Datepicker,
            Multiselect,
            HotelDetail
        },
        data() {
            return {
                packageDetails: {},
                clientDetails: {},
                destinationDetails: {
                    cities:[],
                    selectedCity:''
                },
                updateCheckOutDate: '',
                show: false,
                ar,
                en,
                showAccomodationType: false
            }
        },

        created() {
            bus.$on("destination", (data) => {
                alert('haw');
                this.packageDetails = data;
                console.log(this.packageDetails)
            });
        },
        mounted() {
            bus.$on("data-to-destination", (data) => {
                this.packageDetails = data.packageDetails;
                let selectedCountries=this.packageDetails.selectedCountries;
                let selectedCountriesIds=[];
                selectedCountries.forEach(function (element) {
                    selectedCountriesIds.push(element.id)
                });
                axios.post('/api/cities',{'country_ids':selectedCountriesIds}).then(response=>{
                    this.destinationDetails.cities=response.data.cities;
                    console.log(this.destinationDetails.cities);

                });
            });



            $("#detailsContainer .previous").css({
                'border': '2px solid #3383c8',
                'box-shadow': '0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24)'
            });
        },

        methods: {
            changeComponent() {
                this.$emit('change-component', {component: 'FinalNote'});
            },
            viewCarLevel() {
                if (this.packageDetails.rentCar) {
                    this.show = true;
                }

            },
            updateAccomodationType() {
                if (this.packageDetails.reserveAccomodation) {

                    this.showAccomodationType = true;
                }
            }
        },
        watch: {
            updateCheckOutDate: function () {
                alert('haw');
                    let result = new Date(this.destinationDetails.checkInDate);
                    result.setDate(result.getDate() + parseInt(Math.abs(this.updateCheckOutDate)));
                // destinationDetails.nightsNum = this.updateCheckOutDate;
                    this.destinationDetails.checkOutDate = result;
                }
            }



    }
</script>

<style scoped>

</style>
