<template>
    <div>
        <div class="form-group row">

            <div class="col-6 offset-3">
                <input type="number" :min="minRooms" :max="adultsNum" placeholder="عدد الغرف"
                       @keypress="onlyNumbers"
                       v-model="hotelDetails.roomsNum" style="text-align: right"
                       class="form-control"
                       @input="update()"
                />
            </div>
            <div class="col-form-label col-form-label-lg col-3">عدد الغرف</div>

        </div>

        <div v-if="show" role="tablist">
            <div v-for="(index) in hotelDetails.roomsNum">
                <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                        <b-btn href="#" block v-b-toggle="`room_${index}`" variant="info">
                            الغرفه {{index}}
                        </b-btn>
                    </b-card-header>

                    <b-collapse :id="`room_${index}`" :visible="index === 1" accordion="my-accordion" role="tabpanel">
                        <b-card-body>
                            <div class="row form-group">
                                <div class="col-6 offset-3">
                                    <multiselect
                                            v-model="hotelDetails.selectedAdultsNum[index-1]"
                                            :options="hotelDetails.maxPerRoom"
                                            :multiple="false"
                                            @input="updateAdultsNum($event,index)"
                                            :disabled="adultsSelected.includes(index)"
                                    ></multiselect>
                                </div>

                                <div class="col-form-label col-form-label-lg col-3" style="text-align:right">عدد
                                    البالغين
                                </div>
                            </div>
                            <div class="row form-group">

                                <div class="col-6 offset-3">
                                    <multiselect
                                            v-model="hotelDetails.selectedChildrenNum[index-1]"
                                            :options="childrenNum"
                                            :multiple="true"
                                            @input="checkChildrenNumber"
                                            @select="updateChildrenNum"
                                            :disabled="childrenSelectDisabled"

                                    ></multiselect>
                                </div>
                                <div class="col-form-label col-form-label-lg col-3" style="text-align:right">عدد
                                    الاطفال
                                </div>
                            </div>
                        </b-card-body>
                    </b-collapse>

                </b-card>
            </div>
        </div>
        <div class="mt-4">
            <div class="row form-group">
                <div class="col-6 offset-3">
                    <multiselect
                            v-model="hotelDetails.selectedRoomType"
                            :options="roomType"
                            :multiple="false"
                    ></multiselect>
                </div>
                <div class="col-form-label col-form-label-lg col-3">نوع الغرفة</div>
            </div>

            <div class="row form-group">
                <div class="col-6 offset-3">
                    <multiselect
                            v-model="hotelDetails.selectedRoomView"
                            :options="roomView"
                            :multiple="false"
                    ></multiselect>
                </div>
                <div class="col-form-label col-form-label-lg col-3">منظر الرؤيه للغرفة</div>
            </div>

            <div class="row form-group">
                <div class="col-6 offset-3">
                    <multiselect
                            v-model="hotelDetails.selectedStars"
                            :options="stars"
                            :multiple="false"
                    ></multiselect>
                </div>
                <div class="col-form-label col-form-label-lg col-3">عدد النجوم</div>
            </div>

            <div class="form-group row">
                <div class="col-6 offset-3">
                    <input type="text" placeholder="اسم الفندق"
                           v-model="hotelDetails.hotelName" style="text-align: right"
                           class="form-control"/>
                </div>
                <div class="col-form-label col-form-label-lg col-3"> اسم الفندق</div>
            </div>

            <div class="form-group row">
                <div class="col-6 offset-3">
                    <input type="text" placeholder="المنطقة"
                           v-model="hotelDetails.area" style="text-align: right"
                           class="form-control"/>
                </div>
                <div class="col-form-label col-form-label-lg col-3">المنطقة</div>
            </div>
        </div>

    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        name: "HotelDetails",
        props: ["n"],
        components: {
            Multiselect
        },
        data() {
            return {
                roomType: ['Standard', 'Deluxe'],
                roomView: ['Sea View', 'Garden View'],
                stars: [1, 2, 3, 4, 5],
                adultsSelected: [],
                childrenSelectDisabled: false,
                adultsNum: [], //number of adults
                childrenNum: [],
                show: false,
                remainingRooms: '',
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
                    selectedChildrenNum: []
                }
            }
        },
        computed: {

            minRooms: function () {
                console.log(this.adultsNum.length / this.hotelDetails.maxPerRoom.length);
                return Math.ceil(this.adultsNum.length / this.hotelDetails.maxPerRoom.length)
            }

        },
        mounted() {
            let adultsNumber = parseInt(window.packageDetails.packageMainDetails.adultsNum);
            let childrenNumber = parseInt(window.packageDetails.packageMainDetails.childrenNum);
            let childrenAges = window.packageDetails.packageMainDetails.childAge;

            for (let n = 0; n < adultsNumber; n++) {
                this.adultsNum.push(`${n + 1}`)
            }
            for (let i = 0; i < childrenNumber; i++) {
                this.childrenNum.push(`child -${childrenAges[i]} years`)
            }

            bus.$on("next-destination", () => {
                bus.$emit(`destination-details-${n}`, this.hotelDetails);
            });
            bus.$on("package-completed", () => {
                // axios
            });
        },

        methods: {
            onlyNumbers(event) {
                return null;
                // console.log(event);
                // return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57
            },
            update() {
                this.hotelDetails.roomsNum = parseInt(this.hotelDetails.roomsNum)
                if (this.hotelDetails.roomsNum > 0) {
                    this.hotelDetails.maxPerRoom = [];
                    this.remainingRooms = this.hotelDetails.roomsNum;
                    for (let i = 1; i <= Math.ceil(this.adultsNum.length / this.remainingRooms); i++) {
                        this.hotelDetails.maxPerRoom.push(i);
                    }
                    this.show = true
                }
                else {
                    this.show = false
                }
            },
            updateAdultsNum(value, index) {
                this.adultsNum.splice(-value);
                this.adultsSelected.push(index);
                this.remainingRooms = this.hotelDetails.roomsNum - 1;
                if (this.adultsNum.length <= this.hotelDetails.maxPerRoom.length) {
                    this.hotelDetails.maxPerRoom = [];
                    for (let i = 1; i <= Math.ceil(this.adultsNum.length / this.remainingRooms); i++) {
                        this.hotelDetails.maxPerRoom.push(i);
                    }
                }
            },
            checkChildrenNumber(values) {
                console.log(values.length);
                console.log(this.hotelDetails.maxChildrenPerRoom.length);
                if (values.length == this.hotelDetails.maxChildrenPerRoom.length) {
                    this.childrenSelectDisabled = true
                }
            },
            updateChildrenNum(value) {
                this.childrenNum.splice(this.childrenNum.indexOf(value), 1);
                console.log(this.childrenNum);


            }
        },
        watch: {
            'hotelDetails.roomsNum'() {
                console.log(this.minRooms);
                if (this.hotelDetails.roomsNum < Math.ceil(this.adultsNum.length / this.hotelDetails.maxPerRoom.length) || this.hotelDetails.roomsNum > 10) {
                    this.hotelDetails.roomsNum = Math.ceil(this.adultsNum.length / this.hotelDetails.maxPerRoom.length);
                }

            }

        }

    }
</script>

<style scoped>

</style>
