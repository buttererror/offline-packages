<template>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title text-center">Service Selection</h4>
        </div>
        <div class="card-body text-white">
            <div class="d-flex flex-column justify-content-around" style="height: 50vh;">
                <div class="d-flex justify-content-around">
                    <div class="col-3 bg-secondary d-flex flex-column justify-content-center pointer box-height"
                         @click.prevent="changeComponent">
                        <h5 class="text-center">PACKAGE</h5>
                    </div>
                    <div class="col-3 bg-secondary d-flex flex-column justify-content-center pointer box-height">
                        <h5 class="text-center text-uppercase">Accomodation</h5>
                    </div>
                </div>
                <div class="d-flex justify-content-around">
                    <div class="col-3 bg-secondary d-flex flex-column justify-content-center pointer box-height">
                        <h5 class="text-center text-uppercase">Transfer</h5>
                    </div>
                    <div class="col-3 bg-secondary d-flex flex-column justify-content-center pointer box-height">
                        <h5 class="text-center text-uppercase">Tours</h5>
                    </div>
                </div>
            </div>
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
        mounted() {
            bus.$on('go-back', (component) => {
                this.$emit('rechange-component', component);
            });
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
    .pointer {
        cursor: pointer;
    }
    .box-height {
        min-height: 100px;
        max-height: 150px;
    }
</style>
