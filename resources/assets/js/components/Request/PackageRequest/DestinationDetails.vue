<template>
    <div>
        <div class="form-group row">
            <div class="col-6 offset-3">
                <multiselect
                        v-model="destinationDetails.selectedCity"
                        placeholder="Type to search"
                        :options="cities"
                        label="name"
                        track-by="id"
                        group-values="cities"
                        group-label="target"
                        :group-select="false"
                        :multiple="false"
                        :searchable="true"

                >

                </multiselect>
            </div>
            <div class="col-form-label col-form-label-lg col-3">المدينة</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <datepicker placeholder=" تاريخ البداية" class="text-right"
                            :bootstrap-styling="true"
                            :value="destinationDetails.startDate"
                            v-model="destinationDetails.startDate"
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
                       v-model="updateCheckOutDate"
                />
            </div>
            <div class="col-form-label col-3 text-right">عدد الليالى</div>
        </div>


        <div class="form-group row">
            <div class="col-6 offset-3">
                <datepicker placeholder="ضع تاريخ النهاية" class="text-right"
                            :bootstrap-styling="true"
                            :value="destinationDetails.endDate"
                            :language="ar"
                            v-model="destinationDetails.endDate"

                ></datepicker>
            </div>
            <div class="col-form-label col-3 text-right">تاريخ النهاية</div>
        </div>
        <div class="form-group row">
            <div class="col-4 offset-3">
                <toggle-button v-model="destinationDetails.rentCar" :value="false"

                               :sync="true"
                               :labels="{checked: 'نعم', unchecked: 'لا'}"
                               :width="80"
                               :height="35"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="viewCarLevel"
                />
                <label class="col-form-label col-form-label-lg col-3 text-nowrap">تاجير سياره</label>

            </div>
            <div class="col-4 offset-3">
                <toggle-button v-model="destinationDetails.rentCarWithDriver" :value="false"

                               :sync="true"
                               :labels="{checked: 'نعم', unchecked: 'لا'}"
                               :width="80"
                               :height="35"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="viewCarLevel"
                />
                <label class="col-form-label col-form-label-lg col-3 text-nowrap">تاجير سياره مع سائق</label>

            </div>
            <div class="col-4 offset-3">
                <toggle-button v-model="destinationDetails.needTours" :value="false"

                               :sync="true"
                               :labels="{checked: 'نعم', unchecked: 'لا'}"
                               :width="80"
                               :height="35"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="viewCarLevel"
                />
                <label class="col-form-label col-form-label-lg col-3 text-nowrap">الحاجة لجولات</label>

            </div>
        </div>


        <div v-if="show">
            <div class="col-6 offset-3">
                <multiselect
                        v-model="destinationDetails.selectedCarLevel"
                        :options="carLevel"
                        tagPosition="bottom"
                        :preserveSearch="true" :showNoResults="false" selectLabel=""
                >

                </multiselect>
                <div class="col-form-label col-form-label-lg col-3"> مستوى السياره</div>

            </div>
        </div>
        <div class="form-group row">
            <div class="col-4 offset-3">
                <toggle-button v-model="destinationDetails.reserveAccomodation" :value="false"

                               :sync="true"
                               :labels="{checked: 'نعم', unchecked: 'لا'}"
                               :width="80"
                               :height="35"
                               switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                               @change="updateAccomodationType"
                />
                <label class="col-form-label col-form-label-lg col-3 text-nowrap">حجز اقامة</label>
            </div>
        </div>
        <div v-if="showAccomodationType">
            <div class="form-group row">

                <div class="col-4 offset-3">

                    <multiselect
                            v-model="destinationDetails.selectedAccomodationType"
                            :options="accomodationType"
                            tagPosition="bottom"
                            :preserveSearch="true" :showNoResults="false" selectLabel=""
                    >

                    </multiselect>
                </div>
            </div>
            <div class="col-form-label col-form-label-lg col-3">نوع الاقامة</div>

        </div>

        <HotelDetail :n="cityNumber"></HotelDetail>
    </div>

</template>

<script>

    import Datepicker from 'vuejs-datepicker';
    import Multiselect from 'vue-multiselect'
    import HotelDetail from './HotelDetails'

    import {en, ar} from 'vuejs-datepicker/dist/locale'

    export default {
        name: "DestinationDetails",
        props: ["cities", "cityNumber"],
        components: {
            Datepicker,
            Multiselect,
            HotelDetail
        },
        data() {
            return {
                ar,
                en,
                updateCheckOutDate: '',
                show: false,
                showAccomodationType: false,
                carLevel: ['standard', 'premium'],
                accomodationType: ['hotel', 'appartment'],
                destinationDetails: {
                    startDate: null,
                    endDate: null,
                    selectedCity: '',
                    rentCar: false,
                    rentCarWithDriver: false,
                    reserveAccomodation: false,
                    selectedCarLevel: '',
                    selectedAccomodationType: '',
                    needTours: false,
                    nightsNum: '',
                    hotelDetails: {}
                },
            }
        },
        mounted() {

            bus.$on(`destination-details-${this.cityNumber}`, (hotelDetails) => {
                this.destinationDetails.hotelDetails = hotelDetails;
                window.packageDetails.destinationsDetails.push(this.destinationDetails);
            });
            $("#detailsContainer .previous").css({
                'border': '2px solid #3383c8',
                'box-shadow': '0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24)'
            });
        },

        methods: {
            viewCarLevel() {
                if (this.destinationDetails.rentCar) {
                    this.show = true;
                }

            },
            updateAccomodationType() {
                if (this.destinationDetails.reserveAccomodation) {

                    this.showAccomodationType = true;
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
