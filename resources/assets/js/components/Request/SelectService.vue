<template>
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h4 class="card-title text-center">Service Selection</h4>
        </div>
        <div class="card-body" style="height: 500px">
            <div class="row mt-5 h-50 text-white">
                <h5 class="offset-2 col-3 h-50 bg-dark text-center">Package</h5>
                <h5 class="offset-2 col-3 h-50 bg-dark text-center">Accomodation</h5>
            </div>
            <div class="row h-50 text-white">
                <h5 class="offset-2 col-3 h-50 bg-dark text-center">Transfer</h5>
                <h5 class="offset-2 col-3 h-50 bg-dark text-center">Tours</h5>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" @click.prevent="changeComponent(client)">التالي</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SelectService",
        data() {
            return {

            }
        },
        methods: {
            changeComponent() {
                this.$emit('change-component', {
                    component: "PackageDetails",
                    step: "Package Details"
                });
            }
        }
    }
</script>

<style scoped>

</style>
