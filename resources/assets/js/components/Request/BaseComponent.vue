<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <steps></steps>
            </div>
        </div>
        <modal-popup></modal-popup>
    </div>
</template>

<script>
    import Steps from './Steps';
    import ModalPopup from './ModalPopup';
    export default {
        name: "base-component",
        components: {
            Steps,
            ModalPopup
        }
    }
</script>

<style scoped>

</style>
