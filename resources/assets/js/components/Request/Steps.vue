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
                    @selected-component="goToSelected"
                    @previous-component="previousComponent" v-bind:is="component"
         >

         </component>
      </keep-alive>
      <component v-if="component === 'DestinationBase'" @next-component="nextComponent"
                 @selected-component="goToSelected"
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
            ],
            isActive: true,
            notActive: false
         }
      },
      methods: {
         nextComponent(data) {
            this.component = data.component;
            this.breadcrumbs.push(data);
         },
         previousComponent(component) {
            this.component = component;
            this.breadcrumbs.pop();
         },
         removeCrumb(crumb) {
            bus.$emit('go-back', crumb.component);
            for (let i = 0; i < this.breadcrumbs.length; i++) {
               if (this.breadcrumbs[i].component === this.component) {
                  var startRemovingFrom = i;
               }
               if (i > startRemovingFrom) this.breadcrumbs.splice(i);
            }
         },
         goToSelected(component) {
            this.component = component;
         }
      }
   }
</script>

<style scoped>
    .breadcrumb-item-right::before{
        padding-left: 0.5rem !important;
        padding-right: 0 !important;
    }
    .breadcrumb-item-right{
        padding-right: 0.5rem !important;
        padding-left: 0 !important;
    }
    .breadcrumb-item-left::before{
            padding-right: 0.5rem !important;
            padding-left: 0 !important;
    }
    .breadcrumb-item-left{
        padding-left: 0.5rem !important;
        padding-right: 0 !important;
    }

</style>
