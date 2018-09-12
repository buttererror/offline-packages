<template>
    <div id="detailsContainer">
        <div class="card">
            <div class="card-header">Package Request</div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <input type="text" placeholder="مكان البدايه" v-model="packageDetails.startPlace"
                               style="text-align: right" class="form-control"/>
                    </div>
                    <div class="col-form-label col-form-label-lg col-3"> مكان البداية</div>
                </div>
                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <datepicker placeholder="تاريخ البدايه"
                                    input-class="text-right form-control form-control-lg"
                                    calendar-class="h5 w-100"
                                    :bootstrap-styling="true"
                                    :language="ar"
                                    :value="packageDetails.startDate"
                                    v-model="packageDetails.startDate"
                        >

                        </datepicker>
                    </div>
                    <div class="col-form-label col-form-label-lg col-3">تاريخ البدايه</div>
                </div>
                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <datepicker placeholder="تاريخ النهاية"
                                    input-class="text-right form-control form-control-lg"
                                    calendar-class="h5 w-100"
                                    :bootstrap-styling="true"
                                    :language="ar"
                                    v-model="packageDetails.endDate"
                        >

                        </datepicker>
                    </div>
                    <div class="col-form-label col-form-label-lg col-3">تاريخ النهايه</div>
                </div>

                <div class="row form-group">
                    <div class="col-6 offset-3">
                        <multiselect

                                v-model="selectedCountries"
                                placeholder="Type to search"
                                :options="packageDetails.countries"
                                label="en_short_name"
                                track-by="id"
                                :multiple="true"
                                :searchable="true"
                                :loading="isLoading"
                                @search-change="countryFind"

                        ></multiselect>
                    </div>
                    <div class="col-form-label col-form-label-lg col-3">المدن</div>
                </div>

                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <input type="text" placeholder="عدد الاماكن"
                               style="text-align: right"
                               class="form-control"
                               v-model="packageDetails.placesNum"
                        />
                    </div>
                    <div class="col-form-label col-form-label-lg col-3">
                        الاماكن
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <!--<input class="form-control" type="checkbox" v-model="packageDetails.transfer">-->
                        <toggle-button v-model="packageDetails.transfer" :value="false"

                                       :sync="true"
                                       :labels="{checked: 'نعم', unchecked: 'لا'}"
                                       :width="80"
                                       :height="35"
                                       switchColor="{checked: '#25EF02', unchecked: 'linear-gradient(red, yellow)'}"
                        />
                    </div>
                    <div class="col-form-label col-form-label-lg col-3 text-nowrap">
                        <label>الانتقالات</label>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-6 offset-3">
                    </div>
                    <div class="col-6 offset-3">
                        <input type="text" placeholder="عدد البالغين" style="text-align: right" class="form-control"
                               v-model="packageDetails.adultsNum"/>
                    </div>
                    <div class="col-form-label col-form-label-lg col-3">عدد البالغين</div>
                </div>
                <div class="form-group row">
                    <div class="col-6 offset-3">
                    </div>
                    <div class="col-6 offset-3">
                        <input type="text" placeholder="عدد الاطفال" style="text-align: right"
                               v-model="packageDetails.childrenNum"
                               class="form-control"
                               @change="updateChildAge"
                        />
                    </div>
                    <div class="col-form-label col-form-label-lg col-3">عدد الاطفال</div>
                </div>

                <div v-if="show">

                    <div v-for="(num,key) in packageDetails.childrenNum">
                        <div class="form-group row">
                            <div class="col-6 offset-3">
                            </div>
                            <div class="col-6 offset-3">
                                <input type="text" placeholder="عمر الطفل"
                                       v-model="packageDetails.childAge[key]"
                                       style="text-align: right"
                                       class="form-control"/>
                            </div>
                            <div class="col-form-label col-form-label-lg col-3"> عمر الطفل</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary" @click.prevent="changeComponent">التالى</button>
            </div>
        </div>
    </div>

</template>

<script>

    import Datepicker from 'vuejs-datepicker';
    import {en, ar} from 'vuejs-datepicker/dist/locale';
    import Multiselect from 'vue-multiselect';
    import DestinationDetails from './DestinationDetails'

    export default {
        name: 'PackageDetails',
        props: {
            clientDetails: Object
        },
        components: {
            Datepicker,
            Multiselect,
            DestinationDetails
        },
        data() {
            return {
                ar,
                en,
                selectedCountries: '',
                show: false,
                childrenNum: '',
                childAge: '',
                isLoading: false,
                packageDetails: {
                    startPlace: '',
                    startDate: '',
                    endDate: '',
                    countries: [
                        {id: '', en_short_name: ''}
                    ],
                    selectedCountries: [],
                    city: [],
                    placesNum: null,
                    transfer: false,
                    adultsNum: null,
                    childrenNum: null,
                    childAge: [],
                    checkInDate: '',
                    checkOutDate: '',
                    nightsNum: '',
                    rentCar: false,
                    rentCarWithDriver: false,
                    needTours: false,
                    carLevel: ['standard', 'premium'],
                    reserveAccomodation: false,
                    accomodationType: ['hotel', 'appartment']
                }

            }
        },
        mounted() {
            axios.get('/api/countries').then(response => {
                this.packageDetails.countries = response.data;
            });



        },
        computed: {},
        methods: {
            changeComponent() {
                this.$emit('change-component', {component: 'DestinationDetails'});
                setTimeout(() => {
                    bus.$emit("data-to-destination", {
                        clientDetails: this.clientDetails,
                        packageDetails: this.packageDetails
                    });
                }, 1000);


            },
            updateChildAge() {
                this.packageDetails.childrenNum = parseInt(this.packageDetails.childrenNum);
                if (this.packageDetails.childrenNum > 0) {
                    this.show = true
                }
                else {
                    this.show = false
                }
            },
            countryFind(query) {
                this.isLoading = true;
                axios.post('/api/countries', {query: query}).then(response => {
                    this.packageDetails.countries = response.data;
                    this.isLoading = false

                });
            },
        },

    }
</script>

<style scoped>

</style>
