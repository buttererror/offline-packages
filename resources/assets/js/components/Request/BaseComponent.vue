<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <steps></steps>
            </div>
        </div>

        <modal-popup></modal-popup>

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
            console.log(this.language)
            this.$i18n.locale= this.language;
        }
    }


</script>

<style scoped>

</style>
