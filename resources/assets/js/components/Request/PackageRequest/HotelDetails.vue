<template>
    <div v-if="accomType === 'Hotel'">

        <div class="card pb-0">
            <div class="card-header card-title h5 text-center">
                عدد الغرف
            </div>
            <div class="card-body pb-0">
                <div class="form-group row">
                    <div class="col-8 offset-2">
                        <multiselect placeholder="عدد الغرف"
                                     tagPosition="bottom"
                                     openDirection="bottom"
                                     v-model="hotelDetails.roomsNum"
                                     :options="adultsRange"
                                     :multiple="false"
                                     @input="update()"
                                     :disabled="disableRoomNum"
                        ></multiselect>
                    </div>
                </div>

                <div v-if="show" role="tablist">
                    <div v-for="(index) in hotelDetails.roomsNum">
                        <b-card no-body class="mb-1 pb-0">
                            <b-card-header header-tag="header" class="p-1" role="tab">
                                <b-btn href="#" block v-b-toggle="`room_${index}`" variant="info">
                                    الغرفه {{index}}
                                </b-btn>
                            </b-card-header>

                            <b-collapse :id="`room_${index}`" :visible="index === 1" accordion="my-accordion"
                                        role="tabpanel">
                                <b-card-body>
                                    <div class="row form-group">
                                        <div class="col-6 offset-3">
                                            <multiselect placeholder=""
                                                         tagPosition="bottom" openDirection="bottom"
                                                         v-model="hotelDetails.selectedAdultsNum[index-1]"
                                                         :options="sortAdults[index-1]"
                                                         :multiple="false"
                                                         @input="updateAdultsNum(index ,index - 1)"
                                                         :disabled="adultsSelected.includes(index)">
                                            </multiselect>
                                        </div>

                                        <div class="col-form-label col-form-label-lg col-3 text-right"
                                             style="text-align:right">عدد
                                            البالغين
                                        </div>
                                    </div>
                                    <div class="row form-group">

                                        <div class="col-6 offset-3">
                                            <multiselect placeholder=""
                                                         tagPosition="bottom" openDirection="bottom"
                                                         v-model="hotelDetails.selectedChildrenNum[index-1]"
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
                                        <div class="col-form-label col-form-label-lg col-3 text-right"
                                             style="text-align:right">عدد
                                            الاطفال
                                        </div>
                                    </div>
                                </b-card-body>
                            </b-collapse>

                        </b-card>

                    </div>
                </div>
                <div v-if="show" class="row">
                    <div class="col-6">
                        <b-alert show variant="info d-flex justify-content-around rounded-0"
                                 style="margin-bottom: 0">
                            <div class="h6 text-danger d-inline-block">
                                ({{adultsNumberChosen}}) :البالغين<br>
                                ({{childrenNumberChosen}}) :الاطفال
                            </div>
                            <div class="h6 text-success d-inline-block">
                                ({{adultsNumber}}) :البالغين<br>
                                ({{childrenNumber}}) :الاطفال
                            </div>
                        </b-alert>
                    </div>

                    <b-alert show variant="light"
                             class="d-flex justify-content-center col-6 align-items-stretch"
                             style="margin-bottom: 0"

                    >
                        <button class="btn btn-light btn-block p-0" @click="editRoomsData">تعديل</button>
                    </b-alert>
                </div>

            </div>
        </div>

        <div class="mt-4">
            <div class="row form-group">
                <div class="col-6 offset-3">
                    <multiselect placeholder=""
                                 tagPosition="bottom" openDirection="bottom"
                                 v-model="hotelDetails.selectedRoomType"
                                 :options="roomType"
                                 :multiple="false"
                                 @input="validateSelectedRoomType"
                    ></multiselect>
                </div>
                <div class="col-form-label col-form-label-lg col-3 text-right">نوع الغرفة</div>
            </div>

            <div class="row form-group">
                <div class="col-6 offset-3">
                    <multiselect placeholder=""
                                 tagPosition="bottom" openDirection="bottom"
                                 v-model="hotelDetails.selectedRoomView"
                                 :options="roomView"
                                 :multiple="false"
                                 @input="validateSelectedRoomView"
                    ></multiselect>
                </div>
                <div class="col-form-label col-form-label-lg col-3 text-right">منظر الرؤيه للغرفة</div>
            </div>

            <div class="row form-group">
                <div class="col-6 offset-3">
                    <multiselect placeholder=""
                                 tagPosition="bottom" openDirection="bottom"
                                 v-model="hotelDetails.selectedStars"
                                 :options="stars"
                                 :multiple="false"
                                 @input="validateSelectedStars"
                    ></multiselect>
                </div>
                <div class="col-form-label col-form-label-lg col-3 text-right">عدد النجوم</div>
            </div>

            <div class="form-group row">
                <div class="col-6 offset-3">
                    <input type="text" placeholder="اسم الفندق"
                           v-model="hotelDetails.hotelName" style="text-align: right"
                           @input="validateHotelName"
                           class="form-control"/>
                </div>
                <div class="col-form-label col-form-label-lg col-3 text-right"> اسم الفندق</div>
            </div>

            <div class="form-group row">
                <div class="col-6 offset-3">
                    <input type="text" placeholder="المنطقة"
                           v-model="hotelDetails.area" style="text-align: right"
                           @input="validateHotelArea"
                           class="form-control"/>
                </div>
                <div class="col-form-label col-form-label-lg col-3 text-right">المنطقة</div>
            </div>
        </div>
    </div>
    <div v-else>


        <div class="form-group row">
            <div class="col-6 offset-3">
                <input type="text" placeholder="المنطقة"
                       v-model="hotelDetails.area" style="text-align: right"
                       @input="validateApartmentArea"
                       class="form-control"/>
            </div>
            <div class="col-form-label col-form-label-lg col-3 text-right">المنطقة</div>
        </div>
    </div>

</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        name: "HotelDetails",
        props: ["destinationNumber", "accomType", "emptyOnSelected"],
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
                show: false,
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
                    hotel: {
                        selectedAdultsNum: false,
                        selectedChildrenNum: false,
                        selectedRoomType: false,
                        selectedRoomView: false,
                        selectedStars: false,
                        hotelName: false,
                        area: false
                    },
                    apartment: {
                        area: false,
                    }
                },
                accommodationDetailsValidation: false,
                hotelDetails: {
                    roomsNum: '', //number of rooms
                    selectedRoomType: '',
                    selectedRoomView: '',
                    selectedStars: '',
                    hotelName: '',
                    area: '',
                    selectedAdultsNum: [],
                    selectedChildrenNum: [],
                }
            }
        },
        mounted() {
            bus.$on(`empty-accommodation-fields-${this.destinationNumber}`, () => {
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
            for (let i = 0; i < this.childrenNumber; i++) {
                this.childrenOptions.push({age: `child -${this.childrenAges[i]} years`, id: i})
            }
            bus.$on("next-destination", () => {
                bus.$emit(`destination-details-${this.destinationNumber}`, this.hotelDetails);
            });
            bus.$on("package-completed", () => {
                // axios
            });
        },
        watch: {
            accomType() {
                if (this.accomType === "Apartment") {
                    this.editRoomsData();
                }
            }
        },
        methods: {
            update() {
                console.log("updating rooms number");
                for (let i = 0; i < this.hotelDetails.roomsNum; i++) {
                    this.sortAdults.push([]);
                }
                this.maxNumOfAdultsPerRoom_1 = Math.ceil(this.adultsNumber / this.hotelDetails.roomsNum);
                this.maxNumOfAdultsPerRoom_2 = this.adultsNumber - (this.hotelDetails.roomsNum - 1);
                this.maxNumOfAdultsPerRoom = this.maxNumOfAdultsPerRoom_1 > this.maxNumOfAdultsPerRoom_2 ? this.maxNumOfAdultsPerRoom_1 : this.maxNumOfAdultsPerRoom_2;
                if (this.maxNumOfAdultsPerRoom > 6) this.maxNumOfAdultsPerRoom = 6;
                this.fillRoom(0);
                this.disableRoomNum = true;
                if (this.hotelDetails.roomsNum > 0) {
                    this.show = true
                }
                else {
                    this.show = false
                }
                this.validateAdultsNum();
                this.sendValidationToDestination();
            },
            fillRoom(index) {
                if (this.sortAdults[index]) {
                    for (let i = 1; i <= this.maxNumOfAdultsPerRoom; i++) {
                        this.sortAdults[index].push(i);
                    }
                }
            },
            updateAdultsNum(pastRooms, index) {
                console.log("updating adults Number");
                this.adultsSelected.push(index + 1); // disable after input
                this.remainingAdults = Math.ceil(this.remainingAdults - this.hotelDetails.selectedAdultsNum[index]);
                this.remainingRooms = this.hotelDetails.roomsNum - pastRooms;
                this.maxNumOfAdultsPerRoom_1 = Math.ceil(this.remainingAdults / this.remainingRooms);
                this.maxNumOfAdultsPerRoom_2 = this.remainingAdults - this.remainingRooms;
                this.maxNumOfAdultsPerRoom = this.maxNumOfAdultsPerRoom_1 > this.maxNumOfAdultsPerRoom_2 ? this.maxNumOfAdultsPerRoom_1 : this.maxNumOfAdultsPerRoom_2;
                this.maxNumOfAdultsPerRoom = this.remainingAdults - (this.remainingRooms - 1);
                if (this.maxNumOfAdultsPerRoom > 6) this.maxNumOfAdultsPerRoom = 6;
                this.adultsNumberChosen += this.hotelDetails.selectedAdultsNum[index];
                this.fillRoom(index + 1);
                this.validateAdultsNum();
                this.sendValidationToDestination();
            },
            validateAdultsNum() {
                if (Number(this.adultsNumber) !== this.adultsNumberChosen) {
                    this.validation.hotel.selectedAdultsNum = false;
                } else {
                    this.validation.hotel.selectedAdultsNum = true;
                }
            },
            validateChildrenNum() {
                if (Number(this.childrenNumber) !== this.childrenNumberChosen) {
                    this.validation.hotel.selectedChildrenNum = false;
                } else {
                    this.validation.hotel.selectedChildrenNum = true;
                }
            },
            validateSelectedRoomType() {
                if (this.hotelDetails.selectedRoomType) {
                    this.validation.hotel.selectedRoomType = true;
                } else {
                    this.validation.hotel.selectedRoomType = false;
                }
                this.processValidationBeforeSend();
                this.sendValidationToDestination();
            },
            validateSelectedRoomView() {
                if (this.hotelDetails.selectedRoomView) {
                    this.validation.hotel.selectedRoomView = true;
                } else {
                    this.validation.hotel.selectedRoomView = false;
                }
                this.processValidationBeforeSend();
                this.sendValidationToDestination();

            },
            validateSelectedStars() {
                if (this.hotelDetails.selectedStars) {
                    this.validation.hotel.selectedStars = true;
                } else {
                    this.validation.hotel.selectedStars = false;
                }
                this.processValidationBeforeSend();
                this.sendValidationToDestination();
            },
            validateHotelName() {
                if (this.hotelDetails.hotelName) {
                    this.validation.hotel.hotelName = true;
                } else {
                    this.validation.hotel.hotelName = false;
                }
                this.processValidationBeforeSend();
                this.sendValidationToDestination();

            },
            validateHotelArea() {
                if (this.hotelDetails.area) {
                    this.validation.hotel.area = true;
                } else {
                    this.validation.hotel.area = false;
                }
                this.processValidationBeforeSend();
                this.sendValidationToDestination();

            },
            validateApartmentArea() {
                console.log("validating apartment area");
                console.log("apartmentArea", this.hotelDetails.area);
                if (this.hotelDetails.area) {
                    this.validation.apartment.area = true;
                } else {
                    this.validation.apartment.area = false;
                }
                console.log("apartmentArea validation", this.validation.apartment.area);
                this.processValidationBeforeSend();
                this.sendValidationToDestination();

            },
            processValidationBeforeSend() {
                if (this.accomType === 'Hotel') {
                    // loop and the result either true or false
                    for (let checkHotel in this.validation.hotel) {
                        if (!this.validation.hotel[checkHotel]) {
                            this.accommodationDetailsValidation = false;
                            return;
                        }
                        this.accommodationDetailsValidation = true;
                    }
                } else if (this.accomType === 'Apartment') {
                    // loop and the result either true or false
                    if (!this.validation.apartment.area) {
                        this.accommodationDetailsValidation = false;
                    }else{
                        this.accommodationDetailsValidation = true;
                    }
                }
            },
            sendValidationToDestination() {
                bus.$emit(`hotel-validation-dest-${this.destinationNumber}`,
                    this.accommodationDetailsValidation);
                this.sendValidationToBaseOnInput(); // this, that duplicate the destinations validation
            },
            sendValidationToBaseOnInput() {
                bus.$emit(`send-validation-destination-from-nested-inputs-${this.destinationNumber}`);
            },
            updateChildrenNum(value) {
                this.childrenOptions.splice(this.childrenOptions.indexOf(value), 1);
                this.childrenNumberChosen++;
                this.validateChildrenNum();
                this.sendValidationToDestination();
                // console.log("childrenChosen", this.childrenNumberChosen);


            },
            removeChildrenOption(option) {
                this.childrenOptions.push(option);
                this.childrenNumberChosen--;
                this.validateChildrenNum();
                this.sendValidationToDestination();
                // console.log("childrenChosen", this.childrenNumberChosen);
            },
            editRoomsData() {
                this.disableRoomNum = false;
                this.adultsSelected = [];
                this.show = false;
                this.hotelDetails.selectedAdultsNum = [];
                this.sortAdults = [];
                this.remainingAdults = this.adultsNumber;
                this.adultsNumberChosen = 0;
                this.childrenNumberChosen = 0;

                this.hotelDetails.selectedChildrenNum = [];
                this.hotelDetails.roomsNum = '';

            },
            emptyOnAccommodationType() {
                console.log("empty inside hotelDetails component");
                this.hotelDetails.selectedRoomType = '';
                this.hotelDetails.selectedRoomView = '';
                this.hotelDetails.selectedStars = '';
                this.hotelDetails.hotelName = '';
                if (this.accomType === 'Apartment' || this.accomType === 'Hotel') {
                    this.hotelDetails.area = '';
                }
            }
        }

    }
</script>

<style scoped>

</style>
