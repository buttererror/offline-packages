<template>
    <div>
        <component @change-component="changeComponent" v-bind:is="component"></component>
    </div>
</template>

<script>
    import JourneyStart from "./JourneyStart";
    import ClientDetails from './ClientDetails';
    import MultiSteps from './multiSteps/MultiSteps';
    import Accommodation from './Accommodation';
    import NewOrOldClient from './NewOrOldClient';

    export default {
        components: {
            JourneyStart,
            ClientDetails,
            MultiSteps,
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
