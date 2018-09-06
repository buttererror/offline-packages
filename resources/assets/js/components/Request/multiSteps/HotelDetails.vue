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

        <div v-if="show">

            <div v-for="(room,key) in roomsNum">

                    <b-card title="الغرفة ">
                        <p class="card-text">

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


                    </b-card>
                <br/>

            </div>

        </div>

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
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        name: "HotelDetails",
        data() {
            return {
                selectedRoomType: '',
                roomType: ['standard', 'deluxe'],
                selectedRoomView: '',
                roomView: ['seeview', 'gardenview'],
                selectedStars: '',
                stars: [1, 2, 3, 4, 5],
                hotelName: '',
                area: '',
                roomsNum: '',
                adultsNum: ['adult 1','adult 2','adult 3'],
                childrenNum: ['child 1','child 2','child 3'],
                show: false,
                selectedAdultsNum:'',
                selectedChildrenNum:''


            }
        },
        components: {
            Multiselect
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