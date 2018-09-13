<template>
    <div>
        <component @change-component="changeComponent" v-bind:is="component">

        </component>
    </div>
</template>

<script>
    import PackageDetails from './PackageRequest/PackageDetails';
    import NewOrOldClient from './NewOrOldClient';
    import DestinationBase from './PackageRequest/DestinationBase';
    import FinalNote from './PackageRequest/FinalNote';

    export default {
        components: {
            PackageDetails,
            NewOrOldClient,
            DestinationBase,
            FinalNote
        },
        mounted(){

        },
        data() {
            return {
                component: 'NewOrOldClient',
                package: {}
            }
        },
        methods: {
            changeComponent(data){
                this.component = data.component;
                this.package = data.package;
            }
        }
    }
</script>

<style scoped>

</style>
