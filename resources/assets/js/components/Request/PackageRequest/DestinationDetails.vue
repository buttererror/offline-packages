<template>
    <div>
        <div class="form-group row">
            <div class="col-6 offset-3">
                <multiselect
                    v-model="destinationDetails.selectedCity"
                    tagPosition="bottom" openDirection="bottom"
                    placeholder="يمكنك البحث"
                    :options="cities"
                    label="name"
                    track-by="id"
                    group-values="cities"
                    group-label="target"
                    :group-select="false"
                    :multiple="false"
                    :searchable="true"
                    @input="validateCity"

                >

                </multiselect>
            </div>
            <div class="col-form-label col-form-label-lg col-3 text-right">المدينة</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">

                <HotelDatePicker @checkInChanged="getCheckInDate"
                                 @checkOutChanged="getCheckOutDate"
                                 :startDate="tripStartAt"
                                 :minNights="1"
                                 format="DD/MM/YYYY"
                                 :hoveringTooltip="getNights"
                                 :startingDateValue="new Date(tripStartAt)"
                >


                </HotelDatePicker>

                <!--<datepicker placeholder=" تاريخ البداية" class="text-right"-->
                <!--:bootstrap-styling="true"-->
                <!--:value="destinationDetails.startDate"-->
                <!--v-model="destinationDetails.startDate"-->
                <!--:language="ar"-->

                <!--&gt;</datepicker>-->
            </div>
            <div class="col-form-label col-form-label-lg col-3 text-right">فترة الرحلة</div>
        </div>


        <div class="form-group row">
            <div class="col-6 offset-3">
                <input type="text" placeholder=""
                       class="form-control text-right" readonly
                       v-model="destinationDetails.nightsNum"
                />
            </div>
            <div class="col-form-label col-form-label-lg col-3 text-right">عدد الليالى</div>
        </div>


        <!--<div class="form-group row">-->
        <!--<div class="col-6 offset-3">-->
        <!--<datepicker placeholder="ضع تاريخ النهاية" class="text-right"-->
        <!--:bootstrap-styling="true"-->
        <!--:value="destinationDetails.endDate"-->
        <!--:language="ar"-->
        <!--v-model="destinationDetails.endDate"-->

        <!--&gt;</datepicker>-->
        <!--</div>-->
        <!--<div class="col-form-label col-form-label-lg col-3 text-right">تاريخ النهاية</div>-->
        <!--</div>-->
        <div class="form-group row">
            <div class="col-6 text-right offset-3">
                <toggle-button v-model="destinationDetails.rentCar" :value="false"
                               :sync="true"
                               :labels="{checked: 'نعم', unchecked: 'لا'}"
                               :width="70"
                               :height="30"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="setArentedCar"
                />

            </div>
            <label class="col-form-label col-form-label-lg col-3 text-nowrap text-right">تاجير سياره</label>
        </div>
        <div v-if="show">
            <div class="form-group row">
                <div class="col-6 text-right offset-3">
                    <toggle-button v-model="destinationDetails.rentCarWithDriver" :value="false"

                                   :sync="true"
                                   :labels="{checked: 'نعم', unchecked: 'لا'}"
                                   :width="65"
                                   :height="25"
                                   switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                                   @change="setAcarWithAdriver"
                    />

                </div>
                <label class="col-form-label col-form-label-lg col-3 text-nowrap text-right">مع سائق</label>
            </div>

            <div class="form-group row">
                <div class="col-6 offset-3">
                    <multiselect placeholder=""
                                 v-model="destinationDetails.selectedCarLevel"
                                 :options="carLevel" @input="validateCarLevel"
                                 tagPosition="bottom" openDirection="bottom"
                                 :preserveSearch="true" :showNoResults="false" selectLabel=""
                    >
                    </multiselect>
                </div>
                <label class="col-form-label col-form-label-lg text-nowrap col-3 text-right"> مستوى السياره</label>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3 text-right">
                <toggle-button v-model="destinationDetails.needTours" :value="false"

                               :sync="true"
                               :labels="{checked: 'نعم', unchecked: 'لا'}"
                               :width="70"
                               :height="30"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="goTours"
                />

            </div>
            <label class="col-form-label col-form-label-lg col-3 text-nowrap text-right">الحاجة لجولات</label>
        </div>


        <div class="form-group row">
            <div class="col-6 offset-3 text-right">
                <toggle-button v-model="destinationDetails.reserveAccomodation" :value="false"
                               :sync="true"
                               :labels="{checked: 'نعم', unchecked: 'لا'}"
                               :width="70"
                               :height="30"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="updateAccomodationType"
                />
            </div>
            <label class="col-form-label col-form-label-lg col-3 text-nowrap text-right">حجز اقامة</label>
        </div>
        <div class="form-group row" v-if="showAccomodationType">

            <div class="col-6 offset-3">

                <multiselect placeholder=""
                             v-model="destinationDetails.selectedAccomodationType"
                             :options="accomodationType"
                             tagPosition="bottom" openDirection="bottom"
                             :preserveSearch="true" :showNoResults="false" selectLabel=""
                >

                </multiselect>
            </div>
            <div class="col-form-label col-form-label-lg col-3 text-right">نوع الاقامة</div>

        </div>
        <div v-if="destinationDetails.reserveAccomodation">
            <HotelDetail :n="cityNumber" :accomType="destinationDetails.selectedAccomodationType">
            </HotelDetail>
        </div>
    </div>

</template>

<script>

    import Datepicker from 'vuejs-datepicker';
    import Multiselect from 'vue-multiselect';
    import HotelDetail from './HotelDetails';
    import HotelDatePicker from 'vue-hotel-datepicker';

    import {en, ar} from 'vuejs-datepicker/dist/locale'

    export default {
        name: "DestinationDetails",
        props: ["cities", "cityNumber"],
        components: {
            Datepicker,
            Multiselect,
            HotelDetail,
            HotelDatePicker
        },
        data() {
            return {
                ar,
                en,
                updateCheckOutDate: '',
                show: false,
                showAccomodationType: false,
                carLevel: ['standard', 'premium'],
                accomodationType: ['Hotel', 'Apartment'],
                tripStartAt: window.packageDetails.packageMainDetails.tripStartAt,
                adultsNum: window.packageDetails.packageMainDetails.adultsNum,
                childrenNum: window.packageDetails.packageMainDetails.childrenNum,
                validation: {
                    city: false,
                    checkInDate: false,
                    checkOutDate: false,
                    selectedCarLevel: true,
                    hotel: {
                        roomsNum: false,
                        selectedAdultsNum: false
                    },
                    apartment: {

                    }
                },
                destinationDetails: {
                    checkInDate: null,
                    checkOutDate: null,
                    selectedCity: '',
                    rentCar: false,
                    rentCarWithDriver: false,
                    reserveAccomodation: false,
                    selectedCarLevel: '',
                    selectedAccomodationType: 'Hotel',
                    needTours: false,
                    nightsNum: 0,
                    hotelDetails: {}
                },
            }
        },
        mounted() {
            bus.$on(`destination-details-${this.cityNumber}`, (hotelDetails) => {
                this.destinationDetails.hotelDetails = hotelDetails;
                window.packageDetails.destinationsDetails.push(this.destinationDetails);
            });
        },

        methods: {
            getNights(checkIn, checkOut) {
                return new Date(checkOut).getDate() - new Date(checkIn).getDate();
            },
            getCheckInDate(checkIn) {
                if (checkIn) this.validation.checkInDate = true;
                else this.validation.checkInDate = false;
                this.updateValidationData();
                this.destinationDetails.checkInDate = checkIn;
            },
            getCheckOutDate(checkOut) {
                if (checkOut) this.validation.checkOutDate = true;
                else this.validation.checkOutDate = false;
                this.updateValidationData();
                this.destinationDetails.checkOutDate = checkOut;
                this.destinationDetails.nightsNum = this.getNights(this.destinationDetails.checkInDate, checkOut);

            },
            setArentedCar(car) {
                this.destinationDetails.rentCar = car.value;
                this.show = car.value;
                if (!this.destinationDetails.rentCar) {
                    this.destinationDetails.rentCarWithDriver = false;
                    this.destinationDetails.selectedCarLevel = '';
                }
                this.validateCarLevel();
            },
            setAcarWithAdriver(driver) {
                this.destinationDetails.rentCarWithDriver = driver.value;
            },
            goTours(tours) {
                this.needTours = tours.value;
            },
            updateAccomodationType(accommodationNeed) {
                this.showAccomodationType = accommodationNeed.value;
            },
            updateValidationData() {
                // send data to destination base
            },
            validateCity() {
                console.log("validating city")
                if (this.destinationDetails.selectedCity) {
                    this.validation.city = true;
                } else {
                    this.validation.city = false;
                }
                this.updateValidationData()
            },
            validateCarLevel() {
                if (this.destinationDetails.selectedCarLevel || !this.destinationDetails.rentCar) {
                    this.validation.selectedCarLevel = true;
                } else {
                    this.validation.selectedCarLevel = false;
                }
            }
        },
        watch: {
            updateCheckOutDate: function () {
                let result = new Date(this.destinationDetails.startDate);
                result.setDate(result.getDate() + parseInt(Math.abs(this.updateCheckOutDate)));
                // destinationDetails.nightsNum = this.updateCheckOutDate;
                this.destinationDetails.endDate = result;
            }
        }


    }
</script>

<style scoped>

</style>
