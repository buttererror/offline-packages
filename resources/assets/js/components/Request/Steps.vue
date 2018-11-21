<i18n>
    {

    "ar":{
    "searchClients":"بحث العملاء",
    "serviceSelection":"اختيار الخدمة",
    "packageDetails":"تفاصيل الباقة",
    "destinationDetails":"تفاصيل الاماكن",
    "finalize":"ملاحظات اخيرة",
    "dir":"rtl"
    },

    "en": {
    "searchClients":"Search Clients",
    "serviceSelection":"Service Selection",
    "packageDetails":"Package Details",
    "destinationDetails":"Destination Details",
    "finalize":"Final Notes",
    "dir":"ltr"

    }
    }
</i18n>

<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" :dir="$t('dir')">
                <li v-for="(crumb, order) in breadcrumbs" class="breadcrumb-item"
                    aria-current="page" :class="{active: breadcrumbs.length -1 === order,
                'breadcrumb-item-right': $t('dir') === 'rtl',
                'breadcrumb-item-left': $t('dir') === 'ltr'}">
                    <span v-if="breadcrumbs.length -1 === order">{{$t(crumb.step)}}</span>
                    <a href="#" @click.prevent="removeCrumb(crumb)" v-else>{{$t(crumb.step)}}</a>
                </li>
            </ol>
        </nav>
        <keep-alive>
            <component v-if="component !== 'DestinationBase'" @next-component="nextComponent"
                       @previous-component="previousComponent" v-bind:is="component"
            >

            </component>
        </keep-alive>
        <component v-if="component === 'DestinationBase'" @next-component="nextComponent"
                   @previous-component="previousComponent" v-bind:is="component">

        </component>

    </div>
</template>

<script>
    import SearchClients from './SearchClients';
    import SelectService from './SelectService';
    import PackageDetails from './PackageRequest/PackageDetails';
    import DestinationBase from './PackageRequest/DestinationBase';
    import FinalNote from './PackageRequest/FinalNote';

    export default {
        // child of Home component
        name: "Steps",
        components: {
            SearchClients,
            SelectService,
            PackageDetails,
            DestinationBase,
            FinalNote
        },
        data() {
            return {
                clientDetails: {},
                component: 'SearchClients',
                breadcrumbs: [
                    {
                        step: 'searchClients',
                        component: 'SearchClients'
                    }
                ]
            }
        },
        methods: {
            nextComponent(data) {
                // @next-component
                // change the current component
                this.component = data.component;
                // add the next step to the breadcrumbs
                this.breadcrumbs.push(data);
            },
            previousComponent(component) {
                // @previous-component
                // change the current component
                this.component = component;
                // remove the previous step from the breadcrumbs
                this.breadcrumbs.pop();
            },
            removeCrumb(crumb) {
                // @click on crumb
                /* this function is put on every clickable crumb to remove the crumbs after the
                clicked one from the breadcrumbs array
                 */
                this.component = crumb.component;
                for (let i = 0; i < this.breadcrumbs.length; i++) {
                    if (this.breadcrumbs[i].component === this.component) {
                        /* remove all the crumbs from the breadcrumbs array starting from
                        the next component
                         */
                        let startRemovingFrom = i + 1;
                        this.breadcrumbs.splice(startRemovingFrom);
                        return;
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .breadcrumb-item-right::before {
        padding-left: 0.5rem !important;
        padding-right: 0 !important;
    }

    .breadcrumb-item-right {
        padding-right: 0.5rem !important;
        padding-left: 0 !important;
    }

    .breadcrumb-item-left::before {
        padding-right: 0.5rem !important;
        padding-left: 0 !important;
    }

    .breadcrumb-item-left {
        padding-left: 0.5rem !important;
        padding-right: 0 !important;
    }

</style>
