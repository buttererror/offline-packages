<i18n>
    {

    "ar":{
    "next":"التالى",
    "back":"السابق",
    "male":"ذكر",
    "female":"مؤنث",
    "noResults":"لايوجد نتائج",
    "save":"حفظ",
    "cancel":"الغاء",
    "addBirthDate":"ضع تاريخ ميلادك",
    "hotelPickerLang":"ar",
    "yes":"نعم",
    "no":"لا",
    "destination":"مكان",
    "destinations_details":"تفاصيل الاماكن",
    "nextcity":"المدينه القادمة",
    "prevcity":"المدينة السابقة"
    },

    "en": {

    "next":"Next",
    "back":"Back",
    "male":"male",
    "female":"female",
    "noResults":"No Results",
    "save":"save",
    "cancel":"cancel",
    "addBirthDate":"Add your BirthDate",
    "hotelPickerLang":"en",
    "yes":"yes",
    "no":"no",
    "destination":"Destination",
    "destinations_details":"Destinations Details",
    "nextcity":"Next City",
    "prevcity":"Previous City"
    }
    }
</i18n>



<template>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title text-center">Service Selection</h4>
        </div>
        <div class="card-body text-white">
            <div class="d-flex flex-column justify-content-around" style="height: 50vh;">
                <div class="d-flex justify-content-around">
                    <div class="col-3 bg-secondary d-flex flex-column justify-content-center pointer box-height"
                         @click.prevent="nextComponent">
                        <h5 class="text-center">PACKAGE</h5>
                    </div>
                    <div class="col-3 bg-secondary d-flex flex-column justify-content-center pointer box-height">
                        <h5 class="text-center text-uppercase">Accomodation</h5>
                    </div>
                </div>
                <div class="d-flex justify-content-around">
                    <div class="col-3 bg-secondary d-flex flex-column justify-content-center pointer box-height">
                        <h5 class="text-center text-uppercase">Transfer</h5>
                    </div>
                    <div class="col-3 bg-secondary d-flex flex-column justify-content-center pointer box-height">
                        <h5 class="text-center text-uppercase">Tours</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary" @click.prevent="previousComponent">{{$t('back')}}</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SelectService",
        data() {
            return {

            }
        },
        mounted() {
            bus.$on('go-back', (component) => {
                this.$emit('selected-component', component);
            });
        },
        methods: {
            nextComponent() {
                this.$emit('next-component', {
                    component: "PackageDetails",
                    step: "packageDetails"
                });
            },
            previousComponent() {
                this.$emit('previous-component', "NewOrOldClient");
            }
        }
    }
</script>

<style scoped>
    .pointer {
        cursor: pointer;
    }
    .box-height {
        min-height: 100px;
        max-height: 150px;
    }
</style>
