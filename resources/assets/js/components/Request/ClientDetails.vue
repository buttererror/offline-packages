<template>
    <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
            <h2 class="text-center">
                بيانات العميل
            </h2>
            <div class="row mt-4">
                <div class="col-6 offset-3">
                    <input class="form-control" dir="rtl">
                </div>
                <div class="col-3">الإسم</div>
            </div>
            <div class="row mt-4">
                <div class="col-6 offset-3">
                    <input class="form-control" dir="rtl">
                </div>
                <div class="col-3">رقم الجوال</div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary">التالي</button>
        </div>
    </div>

</template>

<script>
    export default {
        name: "client-details"
    }
</script>

<style scoped>

</style>