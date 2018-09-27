<i18n>
   {

   "ar":{
   "searchClients":"بحث العملاء",
   "serviceSelection":"اختيار الخدمة",
   "packageDetails":"تفاصيل البتاعة",
   "destinationDetails":"تفاصيل الاماكن",
   "finalize":""
   },

   "en": {
   "searchClients":"Search Clients",
   "serviceSelection":"Service Selection",
   "packageDetails":"Package Details",
   "destinationDetails":"Destination Details",
   "finalize":"Finalize"

   }
   }
</i18n>

<template>
   <div>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li v-for="(crumb, order) in breadcrumbs" class="breadcrumb-item"
                aria-current="page" :class="{active: breadcrumbs.length -1 === order}">
               <span v-if="breadcrumbs.length -1 === order">{{$t(crumb.step)}}</span>
               <a href="#" @click.prevent="removeCrumb(crumb)" v-else>{{$t(crumb.step)}}</a>
            </li>
         </ol>
      </nav>
      <keep-alive>
         <component v-if="component !== 'DestinationBase'" @next-component="nextComponent" @selected-component="goToSelected"
                    @previous-component="previousComponent" v-bind:is="component">

         </component>
      </keep-alive>
      <component v-if="component === 'DestinationBase'" @next-component="nextComponent" @selected-component="goToSelected"
                 @previous-component="previousComponent" v-bind:is="component">

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
                  step: 'searchClients',
                  component: 'NewOrOldClient'
               }
            ],
            isActive: true,
            notActive: false
         }
      },
      methods: {
         nextComponent(data) {
             console.log("data", data);
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

</style>
