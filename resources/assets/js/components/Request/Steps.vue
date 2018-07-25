<template>
    <div>
        <component @changeComponent="changeComponent" v-bind:is="component"></component>
    </div>
</template>

<script>
    import JourneyStart from "./JourneyStart";
    import ClientDetails from './ClientDetails';
    import Accommodation from './Accommodation';
    import NewOrOldClient from './NewOrOldClient';

    export default {
        components: {
            JourneyStart,
            ClientDetails,
            Accommodation,
            NewOrOldClient
        },
        mounted(){

        },
        data() {
            return {
                component: 'NewOrOldClient'
            }
        },
        methods: {
            changeComponent(component){
                this.component = component;
            }
        }
    }
</script>

<style scoped>

</style>