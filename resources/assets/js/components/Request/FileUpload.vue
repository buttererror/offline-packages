<template>
    <div>
        <file-upload :url='url' :thumb-url='thumbUrl' @change="onFileChange"></file-upload>
        <input type="hidden" name="file_id" :value="file_id"/>
    </div>
</template>

<script>
    import Vue from 'vue'
    import FileUpload from 'v-file-upload'

    Vue.use(FileUpload)

    export default {
        name: "UploadFile",
        data() {
            return {
                url: '/api/save_file',
                filesUploaded: [],
                file_id: null
            }
        },
        methods: {
            thumbUrl(file) {
                this.file_id = file.file_id;
                bus.$emit("client-passport", this.file_id);
                return file.myThumbUrlProperty
            },
            onFileChange(file) {
                // Handle files like:
                this.fileUploaded = file;
            }
        }
    }
</script>