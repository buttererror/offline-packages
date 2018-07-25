<template>
    <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
            <h2 class="text-center">
                بداية الرحلة
            </h2>
            <div class="row mt-4 form-group">
                <div class="col-6 offset-3">
                    <input class="form-control" dir="rtl" id="journey_start_destination">
                </div>
                <label class="col-3 col-form-label" for="journey_start_destination">مكان الوصول</label>
            </div>
            <div class="row mt-4 form-group">
                <div class="col-6 offset-3">
                    <input class="form-control" dir="rtl">
                </div>
                <label class="col-3 col-form-label">تاريخ الوصول</label>
            </div>
        </div>
        <div class="card-footer">
            <button @click="handleClicked" class="btn btn-primary">التالي</button>
            <button class="btn btn-secondary">تخطي</button>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            handleClicked() {
                this.$emit('changeComponent','Accommodation');
            }
        }
    }
</script>

<style scoped>

</style>