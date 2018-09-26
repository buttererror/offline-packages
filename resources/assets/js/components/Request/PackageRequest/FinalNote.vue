<i18n>
    {
    "ar":{
    "finalize":"انهاء",
    "next":"التالى",
    "back":"السابق",
    "male":"ذكر",
    "female":"مؤنث",
    "noResults":"لايوجد نتائج",
    "save":"حفظ",
    "cancel":"الغاء",
    "addBirthDate":"ضع تاريخ ميلادك",
    "hotelPickerLang":"ar",
    "yes":"نعم",
    "no":"لا",
    "edit":"تعديل",
    "enterSomething":"ادخل شىء ما"

    },

    "en": {
    "finalize":"finish",
    "next":"Next",
    "back":"Back",
    "male":"male",
    "female":"female",
    "noResults":"No Results",
    "save":"save",
    "cancel":"cancel",
    "addBirthDate":"Add your BirthDate",
    "hotelPickerLang":"en",
    "yes":"yes",
    "no":"no",
    "edit":"edit",
    "enterSomething":"Enter Something"
    }
    }
</i18n>
<template>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title text-center">{{$t('finalize')}}</h4>
        </div>

        <div class="card-body">
            <b-form-textarea id="note"
                             v-model.trim="noteText"
                             :placeholder="$t('enterSomething')"
                             :rows="5">

            </b-form-textarea>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <button class="btn btn-primary" @click.prevent="savePackage">{{$t('finalize')}}</button>
            <button class="btn btn-primary" @click.prevent="previousComponent">{{$t('back')}}</button>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                noteText: ''
            }
        },
        mounted() {
            bus.$on('go-back', (component) => {
                this.$emit('selected-component', component);
            });
        },
        methods: {
            savePackage() {
                axios.post('/api/package', {
                    'package_details': window.packageDetails.packageMainDetails,
                    'destination_details': window.packageDetails.destinationsDetails

                }).then(response => {

                })
            },
            previousComponent() {
                this.$emit('previous-component', "DestinationBase");
            }
        }

    }
</script>
