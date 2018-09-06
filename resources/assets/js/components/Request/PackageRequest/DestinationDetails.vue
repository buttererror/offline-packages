<template>
    <div class="form-group row">
        <div class="col-6 offset-3">
            <select class="form-control">
                <option>Alexandria</option>
                <option>Cairo</option>
                <option>Asyout</option>
                <option>Elsemplyeen</option>
            </select>
        </div>
        <div class="col-form-label col-form-label-lg col-3">المدينة</div>
    </div>
</template>

<script>



    export default {
        name: "DestinationDetails",
        components: {

        },
        mounted() {
            this.$emit('can-continue', {value: true});
        },
        data() {
            return {

            }
        }


   }
</script>

<style scoped>

</style>
