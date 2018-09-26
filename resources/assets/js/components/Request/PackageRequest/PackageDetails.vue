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
                               @input="validateStartPlace"
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
                            @input="validateCountries"

                        ></multiselect>
                    </div>
                    <label class="col-form-label col-form-label-lg col-3 text-right">البلاد</label>
                </div>

                <div class="form-group row">
                    <div class="col-6 offset-3">
                        <input type="number" placeholder="عدد الاماكن" min="0"
                               style="text-align: right"
                               class="form-control"
                               v-model="packageMainDetails.placesNum"
                               @input="validatePlacesNum"
                        />
                    </div>
                    <label class="col-form-label col-form-label-lg col-3 text-right">عدد المدن</label>
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
                        <div class="col-3 d-flex align-items-center justify-content-end text-right
                                    rounded"
                             style="background-color: rgba(91,192,222, .8);"
                         v-if="packageMainDetails.adultsNum">
                        اقصي عدد للاطفال {{maxChildrenNum}}
                    </div>
                    <div v-else class="col-3"></div>
                    <div class="col-6 d-flex align-items-center">
                        <input type="number" placeholder="عدد البالغين" style="text-align: right" class="form-control"
                               v-model="packageMainDetails.adultsNum" min="1" @input="validateAdultsNum"/>
                    </div>
                    <label class="col-form-label col-form-label-lg col-3 text-right">عدد البالغين</label>
                </div>
                <div class="form-group row">
                    <div class="col-6 offset-3 d-flex align-items-center">
                        <input type="number" placeholder="عدد الاطفال" style="text-align: right"
                               v-model="packageMainDetails.childrenNumber"
                               class="form-control" min="0"
                               @input="updateChildAge"
                        />
                    </div>
                    <label class="col-form-label col-form-label-lg col-3 text-right">عدد الاطفال</label>
                </div>

                <div v-if="show">

                    <div v-for="(num, key) in packageMainDetails.childrenNumber">
                        <div class="form-group row">
                            <div class="col-6 offset-3">
                                <multiselect placeholder="عمر الطفل"
                                             v-model="packageMainDetails.childrenAges[key]"
                                             :options="staticChildrenAges"
                                             tagPosition="top"
                                             @input="validateChildrenAge"
                                >

                                </multiselect>
                                <!--<input type="number" placeholder="عمر الطفل" min="1"-->
                                <!--v-model="packageMainDetails.childrenAges[key]"-->
                                <!--style="text-align: right"-->
                                <!--class="form-control"/>-->
                            </div>
                            <div class="col-form-label col-form-label-lg col-3 text-right"> عمر الطفل</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button class="btn btn-primary" @click.prevent="nextComponent"
                        :class="{'disabled': !activateNextBtn}"
                >التالى
                </button>
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
                staticChildrenAges: ["< 1", 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                activateNextBtn: false,
                maxChildrenNum: null,
                maxChildrenPerRoom: 4,
                validation: {
                    startPlace: false,
                    tripStartAt: false,
                    tripEndAt: false,
                    selectedCountries: false,
                    adultsNum: false,
                    placesNum: false,
                    childrenNumber: true,
                    childrenAges: true
                },
                packageMainDetails: {
                    startPlace: '',
                    tripStartAt: null,
                    tripEndAt: null,
                    selectedCountries: [],
                    placesNum: null,
                    transfer: false,
                    adultsNum: null,
                    childrenNumber: 0,
                    childrenAges: [],
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
            activateNxtBtn() {
                for (let check in this.validation) {
                    if (!this.validation[check]) {
                        this.activateNextBtn = false;
                        return;
                    }
                    this.activateNextBtn = true;
                }
            },
            validateStartPlace() {
                if (this.packageMainDetails.startPlace) {
                    this.validation.startPlace = true;
                } else this.validation.startPlace = false;
                console.log(this.validation.startPlace);
                this.activateNxtBtn();

            },
            validateCountries() {
                if (this.packageMainDetails.selectedCountries.length) {
                    this.validation.selectedCountries = true;
                } else this.validation.selectedCountries = false;
                this.activateNxtBtn();
            },
            validateAdultsNum() {
                this.maxChildrenNum = this.packageMainDetails.adultsNum * this.maxChildrenPerRoom;
                this.validateChildrenNum();
                if (this.packageMainDetails.adultsNum) {
                    this.validation.adultsNum = true;
                } else this.validation.adultsNum = false;
                this.activateNxtBtn();

            },
            validatePlacesNum() {
                console.log(this.packageMainDetails.placesNum);
                if (Number(this.packageMainDetails.placesNum)) {
                    this.validation.placesNum = true;
                } else this.validation.placesNum = false;
                this.activateNxtBtn();
            },
            validateChildrenAge() {
                console.log("validating children ages");
                console.log("childrenNumber", this.packageMainDetails.childrenNumber);
                console.log("childrenAges", this.packageMainDetails.childrenAges);
                if(this.packageMainDetails.childrenNumber === this.packageMainDetails.childrenAges.length){
                    for (let i = 0; i < this.packageMainDetails.childrenAges.length; i++) {
                        if (!this.packageMainDetails.childrenAges[i]) {
                            this.validation.childrenAges = false;
                            break;
                        }
                        this.validation.childrenAges = true;
                    }
                }else if(this.packageMainDetails.childrenNumber < this.packageMainDetails.childrenAges.length){
                   this.removeChildrenAges();
                }else if(this.packageMainDetails.childrenNumber > this.packageMainDetails.childrenAges.length){
                    this.validation.childrenAges = false;
                }
                this.activateNxtBtn();
            },
            validateChildrenNum() {
                // validate the max children number allowed
                if(Number(this.packageMainDetails.childrenNumber) <= Number(this.maxChildrenNum)){
                    this.validation.childrenNumber = true;
                }else{
                    this.validation.childrenNumber = false;
                }
                //
                if(Number(this.packageMainDetails.childrenNumber) === 0){
                    this.removeChildrenAges();
                    this.validation.childrenNumber = true;
                    this.validation.childrenAges = true;
                }else{
                    this.validateChildrenAge();
                    return;
                }
                this.activateNxtBtn();
            },
            removeChildrenAges(){ // remove from childrenAges until it's equal to childrenNumber
                while(this.packageMainDetails.childrenAges.length !== this.packageMainDetails.childrenNumber){
                    this.packageMainDetails.childrenAges.pop();
                }
            },
            setTransferRequest(transfer) {
                this.packageMainDetails.transfer = transfer.value;
            },
            getCheckInDate(checkIn) {
                this.packageMainDetails.tripStartAt = checkIn;
                if (this.packageMainDetails.tripStartAt) {
                    this.validation.tripStartAt = true;
                } else {
                    this.validation.tripStartAt = false;
                }
                this.activateNxtBtn();
            },
            getCheckOutDate(checkOut) {
                this.packageMainDetails.tripEndAt = checkOut;
                if (this.packageMainDetails.tripStartAt) {
                    this.validation.tripEndAt = true;
                } else {
                    this.validation.tripEndAt = false;
                }
                this.activateNxtBtn();
            },
            nextComponent() {
                if (this.activateNextBtn) {
                    window.packageDetails.packageMainDetails = this.packageMainDetails;
                    this.$emit('next-component', {
                        component: 'DestinationBase',
                        step: 'Destination Details'
                    });
                }
            },
            previousComponent() {
                this.$emit('previous-component', "SelectService");
            },
            updateChildAge() {
                this.packageMainDetails.childrenNumber = parseInt(this.packageMainDetails.childrenNumber);
                this.validateChildrenNum();
                if (this.packageMainDetails.childrenNumber > 0) {
                    this.show = true
                } else {
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
