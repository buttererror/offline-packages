<template>
    <div>
        <div class="form-group row">

            <div class="col-6 offset-3">
                <input type="text" placeholder="عدد الغرف" v-model="roomsNum" style="text-align: right"
                       class="form-control"
                       @change="update()"
                />
            </div>
            <div class="col-form-label col-form-label-lg col-3">عدد الغرف</div>

        </div>

        <div v-if="show" role="tablist">
                <div v-for="(index) in roomsNum">
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-btn href="#" block v-b-toggle="`room_${index}`" variant="info">
                                الغرفه  {{index}}
                            </b-btn>
                        </b-card-header>

                        <b-collapse :id="`room_${index}`" :visible="index === 1" accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <div class="row form-group">
                                    <div class="col-12">
                                        <multiselect
                                            v-model="selectedAdultsNum"
                                            :options="adultsNum"
                                            :multiple="false"
                                        ></multiselect>
                                    </div>

                                    <div class="col-form-label col-form-label-lg col-6" style="text-align:right">عدد البالغين</div>
                                </div>
                                <div class="row form-group">

                                    <div class="col-12 ">
                                        <multiselect
                                            v-model="selectedChildrenNum"
                                            :options="childrenNum"
                                            :multiple="true"
                                        ></multiselect>
                                    </div>
                                    <div class="col-form-label col-form-label-lg col-6" style="text-align:right">عدد الاطفال</div>
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
                        v-model="selectedRoomType"
                        :options="roomType"
                        :multiple="false"
                    ></multiselect>
                </div>
                <div class="col-form-label col-form-label-lg col-3">نوع الغرفة</div>
            </div>

            <div class="row form-group">
                <div class="col-6 offset-3">
                    <multiselect
                        v-model="selectedRoomView"
                        :options="roomView"
                        :multiple="false"
                    ></multiselect>
                </div>
                <div class="col-form-label col-form-label-lg col-3">منظر الرؤيه للغرفة</div>
            </div>

            <div class="row form-group">
                <div class="col-6 offset-3">
                    <multiselect
                        v-model="selectedStars"
                        :options="stars"
                        :multiple="false"
                    ></multiselect>
                </div>
                <div class="col-form-label col-form-label-lg col-3">عدد النجوم</div>
            </div>

            <div class="form-group row">
                <div class="col-6 offset-3">
                    <input type="text" placeholder="اسم الفندق" v-model="hotelName" style="text-align: right"
                           class="form-control"/>
                </div>
                <div class="col-form-label col-form-label-lg col-3"> اسم الفندق</div>
            </div>

            <div class="form-group row">
                <div class="col-6 offset-3">
                    <input type="text" placeholder="المنطقة" v-model="area" style="text-align: right" class="form-control"/>
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
        components: {
            Multiselect
        },
        props: ['currentStep'],
        data() {
            return {
                selectedRoomType: '',
                roomType: ['Standard', 'Deluxe'],
                selectedRoomView: '',
                roomView: ['Sea View', 'Garden View'],
                selectedStars: '',
                stars: [1, 2, 3, 4, 5],
                hotelName: '',
                area: '',
                roomsNum: '',
                adultsNum: ['adult 1', 'adult 2', 'adult 3'],
                childrenNum: ['child 1', 'child 2', 'child 3'],
                show: false,
                selectedAdultsNum: '',
                selectedChildrenNum: ''


            }
        },
        mounted() {
            console.log(this.currentStep);
        },

        methods: {
            update() {
                this.roomsNum = parseInt(this.roomsNum)
                if (this.roomsNum > 0) {
                    this.show = true
                }
                else {
                    this.show = false

                }
            }
        }

    }
</script>

<style scoped>

</style>
