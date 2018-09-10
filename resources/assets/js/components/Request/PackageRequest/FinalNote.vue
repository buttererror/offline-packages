<template>
    <div class="card">
        <div class="card-header">Final Note</div>

        <div class="card-body">
            <b-form-textarea id="note"
                             state="invalid"
                             v-model.trim="noteText"
                             placeholder="Enter something"
                             :rows="5">

            </b-form-textarea>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary" @click.prevent="changeComponent">حفظ</button>

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
        changeComponent(){

        }
    }
</script>
