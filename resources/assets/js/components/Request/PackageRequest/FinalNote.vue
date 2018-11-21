<i18n>
    {
    "ar":{
    "header":"ملاحظات اخيرة",
    "send":"إرسال الطلب",
    "back":"السابق",
    "enterSomething":"ملاحظات اخري"

    },

    "en": {
    "header":"Final Notes",
    "send":"Send Request",
    "back":"Back",
    "enterSomething":"Notes"
    }
    }
</i18n>
<template>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title text-center">{{$t('header')}}</h4>
        </div>

        <div class="card-body">
            <b-form-textarea id="note"
                             v-model="noteText"
                             :placeholder="$t('enterSomething')"
                             :rows="5">

            </b-form-textarea>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <button class="btn btn-primary" @click.prevent="previousComponent">{{$t('back')}}</button>
            <button class="btn btn-primary" @click.prevent="savePackage">{{$t('send')}}</button>
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
        methods: {
            savePackage() {
                axios.post('/api/package', {
                    'package_details': window.packageDetails.packageMainDetails,
                    'destination_details': window.packageDetails.destinationsDetails,
                    'client_details':window.packageDetails.clientDetails,
                    'user_id':localStorage.getItem('user_id'),
                    'note':this.noteText

                }).then(response => {
                    this.$toastr('info', response.data.success)

                })
            },
            previousComponent() {
                this.$emit('previous-component', "DestinationBase");
            }
        }

    }
</script>
