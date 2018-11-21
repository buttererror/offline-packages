<i18n>
    {
    "ar":{
    "packageDetails":{
    "startPlace":"مكان البداية",
    "startEndJourney":"بداية ونهاية الرحلة",
    "countries":"البلاد",
    "placesNum":"عدد الاماكن",
    "transfer":"الانتقالات",
    "childrenNum":"عدد الاطفال",
    "adultsNum":"عدد البالغين",
    "childrenMaxNum":"اقصى عدد للاطفال",
    "childAge":"عمر الطفل",
    "roomsNum":"عدد الغرف",
    "room":"الغرفة",
    "children":"الاطفال",
    "adults":"البالغين",
    "roomType":"نوع الغرفة",
    "roomView":"منظر الرؤية للغرفة",
    "starsNum":"عدد النجوم",
    "hotelName":"اسم الفندق",
    "area":"المنطقة"


    },
    "next":"التالى",
    "back":"السابق",
    "male":"ذكر",
    "female":"مؤنث",
    "noResults":"لايوجد نتائج",
    "hotelPickerLang":"ar",
    "yes":"نعم",
    "no":"لا",
    "edit":"تعديل",
    "labelDir":"text-right",
    "adultsNumberLabel":"كبار",
    "childrenNumberLabel":"صغار"

    },


    "en": {
    "packageDetails":{
    "startPlace":"Start Place",
    "startEndJourney":"Start and End of Journey",
    "countries":"countries",
    "placesNum":"Number of Places",
    "transfer":"transfer",
    "childrenNum":"children Number",
    "adultsNum":"Adults Number",
    "childrenMaxNum":"children maximum number",
    "childAge":"Child Age",
    "roomsNum":"Room Number",
    "room":"Room",
    "children":"Children",
    "adults":"Adults",
    "roomType":"Room Type",
    "roomView":"Room View",
    "starsNum":"Stars Number",
    "hotelName":"Hotel Name",
    "area":"Area"

    },
    "next":"Next",
    "back":"Back",
    "male":"male",
    "female":"female",
    "noResults":"No Results",
    "hotelPickerLang":"en",
    "yes":"yes",
    "no":"no",
    "edit":"Edit",
    "labelDir":"text-left",
    "adultsNumberLabel":"Adults",
    "childrenNumberLabel":"Children"
    }
    }
</i18n>


<template>
    <div v-if="accomType === 'Hotel' || accomType === 'فندق'">

        <div class="card pb-0">
            <div class="card-header card-title h5 text-center">
                {{$t('packageDetails.roomsNum')}}
            </div>
            <div class="card-body pb-0">
                <div class="form-group row">
                    <div class="offset-2"></div>
                    <div class="col-8">
                        <multiselect :placeholder="$t('packageDetails.roomsNum')"
                                     tagPosition="bottom"
                                     openDirection="bottom"
                                     v-model="accommodationDetails.roomsNum"
                                     :options="adultsRange"
                                     :multiple="false"
                                     @input="putRoomsNum()"
                                     :disabled="disableRoomNum"
                        ></multiselect>
                    </div>
                </div>

                <div v-if="Number(accommodationDetails.roomsNum)" role="tablist">
                    <div v-for="(index) in accommodationDetails.roomsNum">
                        <b-card no-body class="mb-1 pb-0">
                            <b-card-header header-tag="header" class="p-1" role="tab">
                                <b-btn href="#" block v-b-toggle="`room_${index}`" variant="info">
                                    {{$t('room')}} {{index}}
                                </b-btn>
                            </b-card-header>

                            <b-collapse :id="`room_${index}`" :visible="index === 1" accordion="my-accordion"
                                        role="tabpanel">
                                <b-card-body>
                                    <div class="row form-group">
                                        <label class="col-form-label col-form-label-lg col-3"
                                               :class="$t('labelDir')"
                                        >{{$t('packageDetails.adultsNum')}}
                                        </label>
                                        <div class="col-6">
                                            <multiselect placeholder=""
                                                         tagPosition="bottom" openDirection="bottom"
                                                         v-model="accommodationDetails.selectedAdultsNum[index-1]"
                                                         :options="sortAdults[index-1]"
                                                         :multiple="false"
                                                         @input="updateAdultsNum(index ,index - 1)"
                                                         :disabled="adultsSelected.includes(index)">
                                            </multiselect>
                                        </div>

                                    </div>
                                    <div class="row form-group">

                                        <label class="col-form-label col-form-label-lg col-3"
                                               :class="$t('labelDir')"
                                        >{{$t('packageDetails.childrenNum')}}
                                        </label>
                                        <div class="col-6">
                                            <multiselect placeholder=""
                                                         tagPosition="bottom" openDirection="bottom"
                                                         v-model="accommodationDetails.selectedChildrenNum[index-1]"
                                                         :options="childrenOptions"
                                                         label="age"
                                                         :multiple="true"
                                                         :closeOnSelect="false"
                                                         trackBy="id"
                                                         @select="updateChildrenNum"
                                                         :disabled="childrenSelectDisabled"
                                                         :max="maxChildrenPerRoom"
                                                         @remove="removeChildrenOption"

                                            ></multiselect>
                                        </div>
                                    </div>
                                </b-card-body>
                            </b-collapse>

                        </b-card>

                    </div>
                </div>
                <div v-if="Number(accommodationDetails.roomsNum)" class="row">
                    <b-alert show variant="light"
                             class="d-flex justify-content-center col-6 align-items-stretch"
                             style="margin-bottom: 0"

                    >
                        <button class="btn btn-light btn-block p-0" @click="editRoomsData">{{$t('edit')}}</button>
                    </b-alert>
                    <div class="col-6">
                        <b-alert show variant="info d-flex justify-content-around rounded-0"
                                 style="margin-bottom: 0">
                            <div class="h6 text-danger d-inline-block">
                                 {{$t('packageDetails.adults')}} : ({{adultsNumberChosen}})<br>
                                {{$t('packageDetails.children')}} : ({{childrenNumberChosen}})
                            </div>
                            <div class="h6 text-success d-inline-block">
                                {{$t('packageDetails.adults')}} : ({{adultsNumber}})<br>
                                {{$t('packageDetails.children')}} : ({{childrenNumber}})
                            </div>
                        </b-alert>
                    </div>

                </div>

            </div>
        </div>

        <div class="mt-4">
            <div class="row form-group">
                <label class="col-form-label col-form-label-lg col-3"
                       :class="$t('labelDir')"
                >{{$t('packageDetails.roomType')}}</label>
                <div class="col-6">
                    <multiselect placeholder=""
                                 tagPosition="bottom" openDirection="bottom"
                                 v-model="accommodationDetails.selectedRoomType"
                                 :options="roomType"
                                 :multiple="false"
                    ></multiselect>
                </div>
            </div>

            <div class="row form-group">
                <label class="col-form-label col-form-label-lg col-3"
                       :class="$t('labelDir')"
                >{{$t('packageDetails.roomView')}}</label>
                <div class="col-6">
                    <multiselect placeholder=""
                                 tagPosition="bottom" openDirection="bottom"
                                 v-model="accommodationDetails.selectedRoomView"
                                 :options="roomView"
                                 :multiple="false"
                    ></multiselect>
                </div>
            </div>

            <div class="row form-group">
                <label class="col-form-label col-form-label-lg col-3"
                       :class="$t('labelDir')"
                >{{$t('packageDetails.starsNum')}}</label>
                <div class="col-6">
                    <multiselect placeholder=""
                                 tagPosition="bottom" openDirection="bottom"
                                 v-model="accommodationDetails.selectedStars"
                                 :options="stars"
                                 :multiple="false"
                    ></multiselect>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-form-label-lg col-3"
                       :class="$t('labelDir')"
                > {{$t('packageDetails.hotelName')}}</label>
                <div class="col-6">
                    <input type="text" :placeholder="$t('packageDetails.hotelName')"
                           v-model="accommodationDetails.hotelName"
                           class="form-control"/>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-form-label-lg col-3"
                       :class="$t('labelDir')"
                >{{$t('packageDetails.area')}}</label>
                <div class="col-6">
                    <input type="text" :placeholder="$t('packageDetails.area')"
                           v-model="accommodationDetails.area"
                           class="form-control"/>
                </div>
            </div>
        </div>
    </div>
    <div v-else>


        <div class="form-group row">
            <label class="col-form-label col-form-label-lg col-3"
                   :class="$t('labelDir')"
            >{{$t('packageDetails.area')}}</label>
            <div class="col-6">
                <input type="text" :placeholder="$t('packageDetails.area')"
                       v-model="accommodationDetails.area"
                       class="form-control"/>
            </div>
        </div>
    </div>

</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        name: "accommodationDetails",
        props: ["cityNumber", "accomType"],
        components: {
            Multiselect
        },
        data() {
            return {
                roomType: ['Standard', 'Deluxe'],
                roomView: ['Sea View', 'Garden View'],
                stars: [1, 2, 3, 4, 5],
                adultsSelected: [],
                disableRoomNum: false,
                childrenSelectDisabled: false,
                childrenOptions: [],
                remainingAdults: '',
                remainingRooms: '',
                adultsRange: [],
                adultsNumber: window.packageDetails.packageMainDetails.adultsNum,
                childrenNumber: window.packageDetails.packageMainDetails.childrenNumber,
                childrenAges: window.packageDetails.packageMainDetails.childrenAges,
                sortAdults: [],
                maxNumOfAdultsPerRoom_1: null,
                maxNumOfAdultsPerRoom_2: null,
                maxNumOfAdultsPerRoom: null,
                adultsNumberChosen: 0,
                childrenNumberChosen: 0,
                minRooms: 0,
                maxRooms: 0,
                maxPerRoom: 6,
                maxChildrenPerRoom: 4,
                validation: {
                    roomsNum: {
                        message: null,
                        required: true
                    },
                    selectedRoomType: {
                        message: null,
                        required: true
                    },
                    selectedStars: {
                        message: null,
                        required: true
                    },
                    selectedAdultsNum: [],
                    selectedChildrenNum: [],
                    hotelName: {
                        message: null,
                        required: false
                    },
                    area: {
                        message: null,
                        required: false
                    }
                },
                accommodationDetails: {
                    roomsNum: '', //number of rooms
                    selectedRoomType: '',
                    selectedRoomView: '',
                    selectedStars: '',
                    selectedAdultsNum: [],
                    selectedChildrenNum: [],
                    hotelName: '',
                    area: '',
                }
            }
        },
        mounted() {
            bus.$on("empty-accommodation-fields", () => {
                this.emptyOnAccommodationType();
            });
            this.remainingAdults = this.adultsNumber;
            this.minRooms = Math.ceil(this.adultsNumber / this.maxPerRoom);
            this.maxRooms = this.adultsNumber <= 10 ? this.adultsNumber : 10;
            for (let i = this.minRooms; i <= this.maxRooms; i++) {
                this.adultsRange.push(this.minRooms);
                this.minRooms++;
            }
            // childrenOptions = [{age: 12, id: 1}, ....]
            this.fillChildrenOptions();

            bus.$on("next-destination", () => {
                // save the data on next destination pressed
                window.packageDetails.destinationsDetails[this.cityNumber].accommodationDetails =
                    JSON.parse(JSON.stringify(this.accommodationDetails));
            });
            // bus.$on("validate-destination-details", () => {
            //     for (let property in this.validation) {
            //         if (this.validation[property].required && !this.accommodationDetails[property]) {
            //             this.validation[property].message = this.$t('field.required');
            //             this.$root.$data.hasErrors = true;
            //         } else {
            //             this.validation[property].message = null;
            //         }
            //     }
            //
            // });
        },
        watch: {
            accomType() {
                if (this.accomType === "Apartment" || this.accomType === "شقة") {
                    this.editRoomsData();
                }
            }
        },
        methods: {
            fillChildrenOptions() {
                this.childrenOptions = [];
                for (let i = 0; i < this.childrenNumber; i++) {
                    this.childrenOptions.push({age: `child -${this.childrenAges[i]} years`, id: i})
                }
            },
            putRoomsNum() {
                // console.log("updating rooms number");
                for (let i = 0; i < this.accommodationDetails.roomsNum; i++) {
                    this.sortAdults.push([]);
                }
                this.maxNumOfAdultsPerRoom_1 = Math.ceil(this.adultsNumber / this.accommodationDetails.roomsNum);
                this.maxNumOfAdultsPerRoom_2 = this.adultsNumber - (this.accommodationDetails.roomsNum - 1);
                this.maxNumOfAdultsPerRoom = this.maxNumOfAdultsPerRoom_1 > this.maxNumOfAdultsPerRoom_2 ? this.maxNumOfAdultsPerRoom_1 : this.maxNumOfAdultsPerRoom_2;
                if (this.maxNumOfAdultsPerRoom > 6) this.maxNumOfAdultsPerRoom = 6;
                this.fillRoom(0);
                this.disableRoomNum = true;
            },
            fillRoom(index) {
                if (this.sortAdults[index]) {
                    for (let i = 1; i <= this.maxNumOfAdultsPerRoom; i++) {
                        this.sortAdults[index].push(i);
                    }
                }
            },
            updateAdultsNum(pastRooms, index) {
                // console.log("updating adults Number");
                this.adultsSelected.push(index + 1); // disable after input
                this.remainingAdults = Math.ceil(this.remainingAdults - this.accommodationDetails.selectedAdultsNum[index]);
                this.remainingRooms = this.accommodationDetails.roomsNum - pastRooms;
                this.maxNumOfAdultsPerRoom_1 = Math.ceil(this.remainingAdults / this.remainingRooms);
                this.maxNumOfAdultsPerRoom_2 = this.remainingAdults - this.remainingRooms;
                this.maxNumOfAdultsPerRoom = this.maxNumOfAdultsPerRoom_1 > this.maxNumOfAdultsPerRoom_2 ? this.maxNumOfAdultsPerRoom_1 : this.maxNumOfAdultsPerRoom_2;
                this.maxNumOfAdultsPerRoom = this.remainingAdults - (this.remainingRooms - 1);
                if (this.maxNumOfAdultsPerRoom > 6) this.maxNumOfAdultsPerRoom = 6;
                this.adultsNumberChosen += this.accommodationDetails.selectedAdultsNum[index];
                this.fillRoom(index + 1);
            },
            updateChildrenNum(value) {
                this.childrenOptions.splice(this.childrenOptions.indexOf(value), 1);
                this.childrenNumberChosen++;
            },
            removeChildrenOption(option) {
                this.childrenOptions.push(option);
                this.childrenNumberChosen--;
                },
            editRoomsData() {
                this.disableRoomNum = false;
                this.adultsSelected = [];
                this.accommodationDetails.selectedAdultsNum = [];
                this.sortAdults = [];
                this.remainingAdults = this.adultsNumber;
                this.adultsNumberChosen = 0;
                this.childrenNumberChosen = 0;

                this.accommodationDetails.selectedChildrenNum = [];
                this.accommodationDetails.roomsNum = '';
                this.fillChildrenOptions();
            },
            emptyOnAccommodationType() {
                // console.log("empty inside accommodationDetails component");
                this.accommodationDetails.selectedRoomType = '';
                this.accommodationDetails.selectedRoomView = '';
                this.accommodationDetails.selectedStars = '';
                this.accommodationDetails.hotelName = '';
                this.accommodationDetails.area = '';
                this.editRoomsData();
            }
        }

    }
</script>

<style scoped>

</style>
