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
        props: ['clickedNext', 'currentStep'],
        name: "DestinationDetails",
        components: {

        },
        mounted() {
            bus.$on("data-to-destination", (data) => {
                console.log("inside destination", data);
                 this.data = data;
            });
            $("#detailsContainer .previous").css({
                'border': '2px solid #3383c8',
                'box-shadow': '0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24)'
            });
            this.$emit('can-continue', {value: true});
        },
        data() {
            return {
                data: null
            }
        }


   }
</script>

<style scoped>

</style>
