<template>
    <div class="form-group row">
        <div class="col-6 offset-3">
            <datepicker placeholder="ضع تاريخ ميلادك" class="text-right"
                        :bootstrap-styling="true"
                        :language="ar" @selected="activateBtn"

            ></datepicker>
        </div>
        <div class="col-form-label col-3">تاريخ </div>
    </div>

</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import {en, ar} from 'vuejs-datepicker/dist/locale'


    export default {
        name: "PackageMainDetails",
        components: {
            Datepicker
        },
        data() {
            return {
                ar
            }
        },
        methods: {
            activateBtn () {
                this.$emit('can-continue', {value: true});
            }
        }
    }
</script>

<style scoped>

</style>
