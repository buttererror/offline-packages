<template>
    <div>
        <b>{{item.name}}</b>
    </div>

</template>

<script>
    export default {
        props: {
            item: {required: true},
            searchText: {required: true}
        }
    }
</script>

<style scoped>

</style>
