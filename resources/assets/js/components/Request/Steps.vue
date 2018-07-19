<template>
    <div>
        <journey-start></journey-start>
        <!--<client-details></client-details>-->
        <!--<accommodation></accommodation>-->
    </div>
</template>

<script>
    import JourneyStart from "./JourneyStart";
    import ClientDetails from './ClientDetails';
    import Accommodation from './Accommodation';

    export default {
        components: {
            JourneyStart,
            ClientDetails,
            Accommodation
        },
        name: "steps",

        data() {
            return {
                currentStep: 0
            }
        }
    }
</script>

<style scoped>

</style>