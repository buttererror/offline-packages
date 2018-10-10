<i18n>
    {
        "ar":{
            "dir":"rtl"
        },
        "en":{
            "dir":"ltr"
        }
    }
</i18n>

<template>
    <div class="container">
        <!--<div class="row justify-content-center">-->
            <!--<div class="col-md-8">-->
                <!--<steps :dir="$t('dir')"></steps>-->
            <!--</div>-->
        <!--</div>-->

        <!--<modal-popup :dir="$t('dir')"></modal-popup>-->
        <HotelDatePicker :startDate="startingDate"
                         :startingDateValue="startingDate"
                         :minNights="1"
                         format="DD/MM/YYYY"
                         :showYear="true"
                         dir="ltr" :cityNumber="1"
        >


        </HotelDatePicker>

    </div>
</template>

<script>
    import Steps from './Steps';
    import ModalPopup from './ModalPopup';

    import HotelDatePicker from './vue-datepicker/HotelDatePicker.vue';

    export default {
        name: "base-component",
        props: ['language'],
        components: {
            Steps,
            ModalPopup,
            HotelDatePicker
        },
        data(){
            return{
                'lang':'ar',
                startingDate: new Date('2018-11-11 05:00'),
                checkInDate: null,
                checkOutDate: null,
                nightsNum: 0
            }
        },
        mounted() {
            this.checkInDate = this.startingDate;
            this.collectDates();
            window.changeStartDate = this.changeStartDate;
            // this.lang = this.language;
        },
        watch : {
            lang(){
                // this.$i18n.locale= this.lang;
            }
        },
        methods: {
            changeStartDate(date){
                bus.$emit('clear-selection-1');
                bus.$emit('set-checkIn-1', new Date(date));
                this.startingDate = new Date(date);
            },
            collectDates() {
                this.checkInDate = this.startingDate;
                bus.$on('checkInChanged-1', (date) => {
                    this.checkInDate = date;
                    this.checkInDate.setHours(0,0,0,0);
                    this.checkOutDate.setHours(0,0,0,0);
                    this.nightsNum = (this.checkOutDate - this.checkInDate) / 1000 / 60 / 60 / 24;
                    if(this.nightsNum < 0){
                        this.nightsNum = 0;
                    }
                });
                bus.$on('checkOutChanged-1', (date) => {
                    this.checkOutDate = date;
                    this.checkInDate.setHours(0,0,0,0);
                    this.checkOutDate.setHours(0,0,0,0);
                    this.nightsNum = (this.checkOutDate - this.checkInDate) / 1000 / 60 / 60 / 24;
                    if(this.nightsNum < 0){
                        this.nightsNum = 0;
                    }
                });
            }
        }
    }


</script>

<style scoped>

</style>
