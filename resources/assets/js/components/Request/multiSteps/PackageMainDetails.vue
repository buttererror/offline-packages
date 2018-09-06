<template>
    <div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input type="text" placeholder="مكان البدايه" style="text-align: right" class="form-control"/>
            </div>
            <div class="col-form-label col-form-label-lg col-3"> مكان البداية</div>

        </div>
        <div class="form-group row">
            <div class="col-6 offset-3">
                <datepicker placeholder="تاريخ البدايه"
                            input-class="text-right form-control form-control-lg"
                            calendar-class="h5 w-100"
                            :bootstrap-styling="true"
                            :language="ar" @selected="activateBtn">

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
                            :language="ar" @selected="activateBtn">

                </datepicker>
            </div>
            <div class="col-form-label col-form-label-lg col-3">تاريخ النهايه</div>
        </div>

        <div class="row form-group">
            <div class="col-6 offset-3">
                <multiselect
                        v-model="selectedCountries"
                        :options="countries"
                        :multiple="true"
                ></multiselect>
            </div>
            <div class="col-form-label col-form-label-lg col-3">المدن</div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <input type="text" placeholder="عدد الاماكن" style="text-align: right" class="form-control"/>
            </div>
            <div class="col-form-label col-form-label-lg col-3">
                الاماكن
            </div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-3">
                <div class="checkbox">
                    <label style="float:right;"><input type="checkbox" value="">هل تحتاج لسياره تنقل</label>
                </div>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-6 offset-3">
            </div>
            <div class="col-6 offset-3">
                <input type="text" placeholder="عدد البالغين" style="text-align: right" class="form-control"/>
            </div>
            <div class="col-form-label col-form-label-lg col-3">عدد البالغين</div>
        </div>
        <div class="form-group row">
            <div class="col-6 offset-3">
            </div>
            <div class="col-6 offset-3">
                <input type="text" placeholder="عدد الاطفال" style="text-align: right"
                       v-model="childrenNum"
                       class="form-control"
                       @change="updateChildAge"
                />
            </div>
            <div class="col-form-label col-form-label-lg col-3">عدد الاطفال</div>
        </div>

        <div v-if="show">

            <div v-for="num in childrenNum">
                <div class="form-group row">
                    <div class="col-6 offset-3">
                    </div>
                    <div class="col-6 offset-3">
                        <input type="text" placeholder="عمر الطفل"
                               v-model="childAge"
                               style="text-align: right"
                               class="form-control"/>
                    </div>
                    <div class="col-form-label col-form-label-lg col-3"> عمر الطفل</div>
                </div>
            </div>

        </div>


    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import {en, ar} from 'vuejs-datepicker/dist/locale'
    import Multiselect from 'vue-multiselect'


    export default {
        name: "PackageMainDetails",
        components: {
            Datepicker,
            Multiselect
        },
        data() {
            return {
                ar,
                countries: ['Egypt', 'Angola', 'france', "Ethiopia"],
                selectedCountries: '',
                show: false,
                childrenNum: '',
                childAge: ''
            }
        },
        methods: {
            activateBtn() {
                this.$emit('can-continue', {value: true});
            },
            updateChildAge() {
                this.childrenNum=parseInt(this.childrenNum)
                if (this.childrenNum > 0) {
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
