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
                                                         :max="4"
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
                                ({{adultsChosen.number}}) :البالغين<br>
                                ({{childrenChosen.number}}) :الاطفال
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
                    ></multiselect>
                </div>
                <div class="col-form-label col-form-label-lg col-3 text-right">عدد النجوم</div>
            </div>

            <div class="form-group row">
                <div class="col-6 offset-3">
                    <input type="text" placeholder="اسم الفندق"
                           v-model="hotelDetails.hotelName" style="text-align: right"
                           class="form-control"/>
                </div>
                <div class="col-form-label col-form-label-lg col-3 text-right"> اسم الفندق</div>
            </div>
        </div>
    </div>
    <div v-else>


        <div class="form-group row">
            <div class="col-6 offset-3">
                <input type="text" placeholder="المنطقة"
                       v-model="hotelDetails.area" style="text-align: right"
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
        props: ["destinationNumber", "accomType"],
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
                adultsChosen: {
                    number: 0,
                    valid: false
                },
                childrenChosen: {
                    number: 0,
                    invalid: false
                },
                hotelDetails: {
                    maxPerRoom: [1, 2, 3, 4, 5, 6],
                    maxChildrenPerRoom: [1, 2, 3, 4],
                    roomsNum: '', //number of rooms
                    selectedRoomType: '',
                    selectedRoomView: '',
                    selectedStars: '',
                    hotelName: '',
                    area: '',
                    selectedAdultsNum: [],
                    selectedChildrenNum: [],
                    minRooms: 0,
                    maxRooms: 0
                }
            }
        },
        mounted() {
            this.remainingAdults = this.adultsNumber;
            this.hotelDetails.minRooms = Math.ceil(this.adultsNumber / this.hotelDetails.maxPerRoom.length);
            this.hotelDetails.maxRooms = this.adultsNumber <= 10 ? this.adultsNumber : 10
            for (let i = this.hotelDetails.minRooms; i <= this.hotelDetails.maxRooms; i++) {
                this.adultsRange.push(this.hotelDetails.minRooms);
                this.hotelDetails.minRooms++;
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
                this.sendValidationToDestination();
            },
            fillRoom(index) {
                if(this.sortAdults[index]){
                    for (let i = 1; i <= this.maxNumOfAdultsPerRoom; i++) {
                        this.sortAdults[index].push(i);
                    }
                }
            },
            updateAdultsNum(pastRooms, index) {
                this.adultsSelected.push(index + 1); // disable after input
                this.remainingAdults = Math.ceil(this.remainingAdults - this.hotelDetails.selectedAdultsNum[index]);
                this.remainingRooms = this.hotelDetails.roomsNum - pastRooms;
                this.maxNumOfAdultsPerRoom_1 = Math.ceil(this.remainingAdults / this.remainingRooms);
                this.maxNumOfAdultsPerRoom_2 = this.remainingAdults - this.remainingRooms;
                this.maxNumOfAdultsPerRoom = this.maxNumOfAdultsPerRoom_1 > this.maxNumOfAdultsPerRoom_2 ? this.maxNumOfAdultsPerRoom_1 : this.maxNumOfAdultsPerRoom_2;
                this.maxNumOfAdultsPerRoom = this.remainingAdults - (this.remainingRooms - 1);
                if (this.maxNumOfAdultsPerRoom > 6) this.maxNumOfAdultsPerRoom = 6;
                this.adultsChosen.number += this.hotelDetails.selectedAdultsNum[index];
                this.fillRoom(index + 1);
                this.sendValidationToDestination();
            },
            sendValidationToDestination() {
                if (Number(this.adultsNumber) !== this.adultsChosen.number) {
                    this.adultsChosen.valid = false;
                }else{
                    this.adultsChosen.valid = true;
                }
                bus.$emit(`hotel-validation-dest-${this.destinationNumber}`, {
                    selectedAdultsNum: this.adultsChosen.valid,
                    selectedChildrenNum: this.childrenChosen.valid
                });
            },
            updateChildrenNum(value) {
                this.childrenOptions.splice(this.childrenOptions.indexOf(value), 1);
                this.childrenChosen.number++;
                console.log("childrenChosen", this.childrenChosen.number);


            },
            removeChildrenOption(option) {
                this.childrenOptions.push(option);
                this.childrenChosen.number--;
                console.log("childrenChosen", this.childrenChosen.number);
            },
            editRoomsData() {
                this.disableRoomNum = false;
                this.adultsSelected = [];
                this.show = false;
                this.hotelDetails.selectedAdultsNum = [];
                this.sortAdults = [];
                this.adultsChosen.valid = false;
                this.remainingAdults = this.adultsNumber;
                this.adultsChosen.number = 0;
                this.childrenChosen.number = 0;

                this.hotelDetails.selectedChildrenNum = [];
                this.hotelDetails.roomsNum = '';

            }
        }

    }
</script>

<style scoped>

</style>
