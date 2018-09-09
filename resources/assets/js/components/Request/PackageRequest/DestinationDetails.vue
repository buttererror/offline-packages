<template>
    <div>
        <div class="form-group row">
            <div class="col-6 offset-3">
                <select class="form-control">
                    <option>الاسكندرية</option>
                    <option>القاهرة</option>
                    <option>اسيوط</option>
                </select>
            </div>
            <div class="col-form-label col-form-label-lg col-3">المدينة</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <datepicker placeholder=" تاريخ البداية" class="text-right"
                            :bootstrap-styling="true"
                            :value="packageDetails.startDate"
                            v-model="packageDetails.checkInDate"
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
                            :language="ar"
                            :value="packageDetails.checkOutDate"
                            v-model="packageDetails.checkOutDate"

                ></datepicker>
            </div>
            <div class="col-form-label col-3 text-right">تاريخ النهاية</div>
        </div>
        <div class="form-group row">
            <div class="col-4 offset-3">
                <div class="checkbox">
                    <label style="float:right;"><input type="checkbox" v-model="packageDetails.rentCar">تاجير
                        سياره</label>
                </div>
            </div>
            <div class="col-4 offset-3">
                <div class="checkbox">
                    <label style="float:right;"><input type="checkbox" v-model="packageDetails.rentCarWithDriver">تاجير
                        سياره مع سائق</label>
                </div>
            </div>
            <div class="col-4 offset-3">
                <div class="checkbox">
                    <label style="float:right;"><input type="checkbox" v-model="packageDetails.needTours">الحاجة لجولات</label>
                </div>
            </div>
        </div>

        <div v-if="show">
            <div class="form-group">
                <multiselect
                        v-model="selected" :options="packageDetails.carLevel" tagPosition="bottom"
                        :preserveSearch="true" :showNoResults="false" selectLabel=""
                >

                </multiselect>
            </div>
        </div>

    </div>
</template>

<script>

    import Datepicker from 'vuejs-datepicker';
    import Multiselect from 'vue-multiselect'

    import {en, ar} from 'vuejs-datepicker/dist/locale'

    export default {
        props: ['clickedNext', 'currentStep'],
        name: "DestinationDetails",
        components: {
            Datepicker,
            Multiselect
        },
        created() {
            bus.$on("data-to-destination", (data) => {
                this.packageDetails = data;
                console.log(this.packageDetails)
            });
        },
        mounted() {
            bus.$on('change-back', () => {
                $("#detailsContainer .stepper-button-top.next").show();
            });
            bus.$on('change-next', () => {
                console.log("send to hotels");
                let {clientDetails} = this.clientDetails;
                let {packageDetails} = this.packageDetails;
                bus.$emit('data-to-hotels', {
                    clientDetails: clientDetails,
                    packageDetails: packageDetails,
                    destinationDetails: this.destinationDetails
                });
            });

            $("#detailsContainer .previous").css({
                'border': '2px solid #3383c8',
                'box-shadow': '0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24)'
            });
            this.$emit('can-continue', {value: true});
        },
        data() {
            return {
                packageDetails: {},
                clientDetails: {},
                destinationDetails: {},
                updateCheckOutDate: '',
                show:false,
                ar,
                en
            }
        },
        watch: {
            updateCheckOutDate: function () {
                if (this.updateCheckOutDate !== '') {
                    let result = new Date(this.packageDetails.checkInDate);
                    result.setDate(result.getDate() + parseInt(Math.abs(this.updateCheckOutDate)));
                    packageDetails.nightsNum = this.updateCheckOutDate;
                    this.packageDetails.checkOutDate = result;
                }
            }
        }


    }
</script>

<style scoped>

</style>
