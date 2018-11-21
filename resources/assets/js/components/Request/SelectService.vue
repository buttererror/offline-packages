<i18n>
    {

        "ar":{
            "back":"السابق",
            "package": "باقة",
            "accommodation":"إقامة",
            "transfer":"انتقالات",
            "tours":"رحلات",
            "serviceSelection":"اختيار الخدمة",
            "dir": "rtl",
            "buttonDir": "text-right"
    },

        "en": {
            "back":"Back",
            "package": "PACKAGE",
            "accommodation":"ACCOMMODATION",
            "transfer":"TRANSFER",
            "tours":"TOURS",
            "serviceSelection":"Service Selection",
            "dir":"ltr",
            "buttonDir": "text-left"
        }
    }
</i18n>



<template>
    <div class="card" :dir="$t('dir')">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title text-center">{{$t("serviceSelection")}}</h4>
        </div>
        <div class="card-body text-white">
            <div class="d-flex flex-column justify-content-around" style="height: 50vh;">
                <div class="d-flex justify-content-around">
                    <div class="col-3 bg-secondary d-flex flex-column justify-content-center pointer box-height"
                         @click.prevent="nextComponent">
                        <h5 class="text-center">{{$t("package")}}</h5>
                    </div>
                    <div class="col-3 bg-secondary d-flex flex-column justify-content-center pointer box-height">
                        <h5 class="text-center text-nowrap">{{$t("accommodation")}}</h5>
                    </div>
                </div>
                <div class="d-flex justify-content-around">
                    <div class="col-3 bg-secondary d-flex flex-column justify-content-center pointer box-height">
                        <h5 class="text-center">{{$t("transfer")}}</h5>
                    </div>
                    <div class="col-3 bg-secondary d-flex flex-column justify-content-center pointer box-height">
                        <h5 class="text-center">{{$t("tours")}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer" :class="$t('buttonDir')">
            <button class="btn btn-primary" @click.prevent="previousComponent">{{$t('back')}}</button>
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
            nextComponent() {
                this.$emit('next-component', {
                    component: "PackageDetails",
                    step: "packageDetails"
                });
            },
            previousComponent() {
                this.$emit('previous-component', "SearchClients");
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
