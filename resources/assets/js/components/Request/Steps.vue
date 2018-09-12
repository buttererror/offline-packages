<template>
    <div>
        <component @change-component="changeComponent" v-bind:is="clientDetails.component"
                   :clientDetails="clientDetails.data"

        >

        </component>
    </div>
</template>

<script>
    import PackageDetails from './PackageRequest/PackageDetails';
    import NewOrOldClient from './NewOrOldClient';
    import DestinationDetails from './PackageRequest/DestinationDetails';
    import FinalNote from './PackageRequest/FinalNote';

    export default {
        components: {
            PackageDetails,
            NewOrOldClient,
            DestinationDetails,
            FinalNote
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
