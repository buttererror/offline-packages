<template>
    <div>
        <b>{{item.name}}</b>
        <abbr>{{item.mobile}} {{item.email ? ' - '+ item.email: ''}}</abbr>
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