<template>
    <div id="detailsContainer">
        <div class="card">
            <div class="card-header">Package Request</div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <input type="text" placeholder="مكان البدايه"
                               v-model="package.packageMainDetails.startPlace"
                               style="text-align: right" class="form-control"/>
                    </div>
                    <label class="col-form-label col-form-label-lg col-3"> مكان البداية</label>
                </div>
                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <datepicker placeholder="تاريخ البدايه"
                                    input-class="text-right form-control form-control-lg"
                                    calendar-class="h5 w-100"
                                    :bootstrap-styling="true"
                                    :language="ar"
                                    :value="package.packageMainDetails.startDate"
                                    v-model="package.packageMainDetails.startDate"
                        >

                        </datepicker>
                    </div>
                    <label class="col-form-label col-form-label-lg col-3">تاريخ البدايه</label>
                </div>
                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <datepicker placeholder="تاريخ النهاية"
                                    input-class="text-right form-control form-control-lg"
                                    calendar-class="h5 w-100"
                                    :bootstrap-styling="true"
                                    :language="ar"
                                    v-model="package.packageMainDetails.endDate"
                        >

                        </datepicker>
                    </div>
                    <label class="col-form-label col-form-label-lg col-3">تاريخ النهايه</label>
                </div>

                <div class="row form-group">
                    <div class="col-6 offset-3">
                        <multiselect

                                v-model="package.packageMainDetails.selectedCountries"
                                placeholder="Type to search"
                                :options="countries"
                                label="en_short_name"
                                track-by="id"
                                :multiple="true"
                                :searchable="true"
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
                               v-model="package.packageMainDetails.placesNum"
                        />
                    </div>
                    <label class="col-form-label col-form-label-lg col-3">الاماكن</label>
                </div>

                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <toggle-button v-model="package.packageMainDetails.transfer" :value="false"

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
                               v-model="package.packageMainDetails.adultsNum"/>
                    </div>
                    <label class="col-form-label col-form-label-lg col-3">عدد البالغين</label>
                </div>
                <div class="form-group row">
                    <div class="col-6 offset-3">
                    </div>
                    <div class="col-6 offset-3">
                        <input type="text" placeholder="عدد الاطفال" style="text-align: right"
                               v-model="package.packageMainDetails.childrenNum"
                               class="form-control"
                               @change="updateChildAge"
                        />
                    </div>
                    <label class="col-form-label col-form-label-lg col-3">عدد الاطفال</label>
                </div>

                <div v-if="show">

                    <div v-for="(num,key) in package.packageMainDetails.childrenNum">
                        <div class="form-group row">
                            <div class="col-6 offset-3">
                            </div>
                            <div class="col-6 offset-3">
                                <input type="text" placeholder="عمر الطفل"
                                       v-model="package.childAge[key]"
                                       style="text-align: right"
                                       class="form-control"/>
                            </div>
                            <div class="col-form-label col-form-label-lg col-3"> عمر الطفل</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer">
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
                show: false,
                childAge: '',
                isLoading: false,
                countries: [
                    {id: '', en_short_name: ''}
                ],
                package: {
                    clientDetails: this.clientDetails,
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
        },
        mounted() {
            axios.get('/api/countries').then(response => {
                this.countries = response.data;
            });



        },
        computed: {},
        methods: {
            changeComponent() {
                this.$emit('change-component', {component: 'DestinationBase', package: this.package});
                // setTimeout(() => {
                //     bus.$emit("data-to-destination", this.package);
                // }, 1000);


            },
            updateChildAge() {
                this.package.packageMainDetails.childrenNum = parseInt(this.package.packageMainDetails.childrenNum);
                if (this.package.packageMainDetails.childrenNum > 0) {
                    this.show = true
                }
                else {
                    this.show = false
                }
            },
            countryFind(query) {
                this.isLoading = true;
                axios.post('/api/countries', {query: query}).then(response => {
                    this.countries = response.data;
                    this.isLoading = false

                });
            },
        },

    }
</script>

<style scoped>

</style>
