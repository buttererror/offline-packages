<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li v-for="(crumb, order) in breadcrumbs" class="breadcrumb-item"
                    aria-current="page" :class="{active: breadcrumbs.length -1 === order}">
                    <span v-if="breadcrumbs.length -1 === order">{{crumb.step}}</span>
                    <a href="#" @click.prevent="removeCrumb(crumb)" v-else>{{crumb.step}}</a>
                </li>
            </ol>
        </nav>

        <component @change-component="changeComponent" @rechange-component="reChangeComponent" v-bind:is="component">

        </component>
    </div>
</template>

<script>
    import NewOrOldClient from './NewOrOldClient';
    import SelectService from './SelectService';
    import PackageDetails from './PackageRequest/PackageDetails';
    import DestinationBase from './PackageRequest/DestinationBase';
    import FinalNote from './PackageRequest/FinalNote';

    export default {
        components: {
            NewOrOldClient,
            SelectService,
            PackageDetails,
            DestinationBase,
            FinalNote
        },
        data() {
            return {
                clientDetails: {},
                component: 'NewOrOldClient',
                breadcrumbs: [
                    {
                        step: "Search Clients",
                        component: 'NewOrOldClient'
                    }
                ],
                isActive: true,
                notActive: false
            }
        },
        methods: {
            changeComponent(data) {
                console.log(data.component)
                this.component = data.component;
                this.breadcrumbs.push(data);
            },
            removeCrumb(crumb) {
                console.log("before", this.component)
                bus.$emit('go-back', crumb.component);
                console.log("after", this.component)
                for(let i = 0; i < this.breadcrumbs.length; i++){
                    if(this.breadcrumbs[i].component === this.component) {
                        continue;
                    }
                    this.breadcrumbs.splice(i);
                }
            },
            reChangeComponent(component) {
                console.log("changing");
                this.component = component;
            }
        }
    }
</script>

<style scoped>

</style>
