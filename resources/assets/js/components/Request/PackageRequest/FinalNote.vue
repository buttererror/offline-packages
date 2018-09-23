<template>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title text-center">Finalize</h4>
        </div>

        <div class="card-body">
            <b-form-textarea id="note"
                             v-model.trim="noteText"
                             placeholder="Enter something"
                             :rows="5">

            </b-form-textarea>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <button class="btn btn-primary" @click.prevent="savePackage">ارسال</button>
            <button class="btn btn-primary" @click.prevent="previousComponent">رجوع</button>
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
            savePackage(){
                axios.post('/api/package',{
                    'package_details':window.packageDetails.packageMainDetails,
                    'destination_details':window.packageDetails.destinationsDetails

                }).then(response=>{

                })
            },
            previousComponent() {
                this.$emit('previous-component', "DestinationBase");
            }
        }

    }
</script>
