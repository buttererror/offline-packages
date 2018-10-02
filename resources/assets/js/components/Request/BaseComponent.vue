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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <steps :dir="$t('dir')"></steps>
            </div>
        </div>

        <modal-popup :dir="$t('dir')"></modal-popup>

    </div>
</template>

<script>
    import Steps from './Steps';
    import ModalPopup from './ModalPopup';
    export default {
        name: "base-component",
        props: ['language'],
        components: {
            Steps,
            ModalPopup
        },
        data(){
            return{
                'lang':'ar'
            }
        },
        mounted() {
            // this.lang = this.language;
        },
        watch : {
            lang(){
                // this.$i18n.locale= this.lang;
            }
        }
    }


</script>

<style scoped>

</style>
