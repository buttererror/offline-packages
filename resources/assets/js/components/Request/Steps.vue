<template>
    <div>
        <component @change-component="changeComponent" v-bind:is="clientDetails.component"
                   :clientDetails="clientDetails.data"

        >

        </component>
    </div>
</template>

<script>
    import JourneyStart from "./JourneyStart";
    import ClientDetails from './ClientDetails';
    import PackageRequest from './PackageRequest/PackageRequest';
    import Accommodation from './Accommodation';
    import NewOrOldClient from './NewOrOldClient';

    export default {
        components: {
            JourneyStart,
            ClientDetails,
            PackageRequest,
            Accommodation,
            NewOrOldClient
        },
        mounted(){

        },
        data() {
            return {
                clientDetails: {
                    component: 'NewOrOldClient',
                    data: {}
                }
            }
        },
        methods: {
            changeComponent(clientDetails){
                this.clientDetails.component = clientDetails.component;
                this.clientDetails.data = clientDetails.clientDetails;
            }
        }
    }
</script>

<style scoped>

</style>
