<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <steps></steps>
            </div>
        </div>
    </div>
</template>

<script>
    import Steps from './Steps';
    export default {
        name: "base-component",
        components: {
            Steps
        }
    }
</script>

<style scoped>

</style>