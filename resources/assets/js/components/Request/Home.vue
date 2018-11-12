<i18n>
    {
        "ar":{
            "dir":"rtl"
        },
        "en":{
            "dir":"ltr"
        }
    }
</i18n>
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <steps :dir="$t('dir')"></steps>
            </div>
        </div>
    </div>
</template>

<script>
    import Steps from './Steps';
    export default {
        // root component
        name: "Home",
        components: {
            Steps
        }
    }


</script>

<style scoped>

</style>
