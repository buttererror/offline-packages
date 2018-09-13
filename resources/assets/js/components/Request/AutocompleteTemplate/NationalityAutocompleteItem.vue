<template>
    <div>
        <b>{{item.en_short_name}}</b>
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
