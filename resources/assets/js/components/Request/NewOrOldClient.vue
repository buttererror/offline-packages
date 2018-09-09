<template>
    <div class="card" v-if="show">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
            <h2 class="text-center">
                اختار العميل
            </h2>
            <div class="row mt-4">
                <div class="col-6 offset-3">
                    <autocomplete dir="rtl" :items="clients" v-model="client" :get-label="getLabel"
                                  :component-item='clientTemplate'
                                  @update-items="updateItems" :min-len="0">
                    </autocomplete>
                </div>
            </div>
            <div class="row mt-4 text-center">
                <div class="col-12">
                    أو أدخل بيانات عميل جديد من
                    <a href="#" @click.prevent="handleNewClientClicked">
                        هنا
                    </a>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-primary" @click.prevent="changeComponent(client)">التالي</button>
        </div>

    </div>
</template>

<script>
    import Autocomplete from 'v-autocomplete';
    import ClientAutocompleteItem from './AutocompleteTemplate/ClientAutocompleteItem';

    export default {
        components: {
            Autocomplete,
        },
        mounted() {
            bus.$on('new-client-saved', (client) => {
                this.client = client;
            });
        },
        data() {
            return {
                clients: [],
                client: null,
                clientTemplate: ClientAutocompleteItem,
                nextComponent: "PackageDetails",
                show: true
            }
        },
        methods: {
            getLabel(client) {
                if (client) {
                    return client.name
                }
                return ''
            },
            updateItems(text) {
                if (!text) {
                    this.clients = [];
                    return;
                }
                axios.get('api/client/search', {
                    params: {
                        searchText: text
                    }
                }).then(response => {
                    this.clients = response.data;
                });
            },
            handleNewClientClicked() {
                bus.$emit('new-client-clicked');
            },
            changeComponent(client) {
                this.$emit('change-component', {component: this.nextComponent, clientDetails: client});
            }
        }

    }
</script>

<style>
    .v-autocomplete .v-autocomplete-input-group .v-autocomplete-input {
        font-size: 1.5em;
        padding: 10px 15px;
        box-shadow: none;
        border: 1px solid #157977;
        width: calc(100% - 32px);
        outline: none;
        background-color: #eee;
    }

    .v-autocomplete .v-autocomplete-input-group.v-autocomplete-selected .v-autocomplete-input {
        color: #008000;
        background-color: #f2fff2;
    }

    .v-autocomplete .v-autocomplete-list {
        width: 100%;
        text-align: left;
        border: none;
        border-top: none;
        max-height: 400px;
        overflow-y: auto;
        border-bottom: 1px solid #157977;
        z-index: 999;
    }

    .v-autocomplete-input-group .v-autocomplete-input {
        display: block;
        width: 100% !important;
        margin: 0;
    }

    .v-autocomplete .v-autocomplete-list .v-autocomplete-list-item {
        cursor: pointer;
        background-color: #fff;
        padding: 10px;
        border-bottom: 1px solid #157977;
        border-left: 1px solid #157977;
        border-right: 1px solid #157977;
    }

    .v-autocomplete .v-autocomplete-list .v-autocomplete-list-item:last-child {
        border-bottom: none;
    }

    .v-autocomplete .v-autocomplete-list .v-autocomplete-list-item:hover {
        background-color: #eee;
    }

    .v-autocomplete .v-autocomplete-list .v-autocomplete-list-item abbr {
        opacity: 0.8;
        font-size: 0.8em;
        display: block;
        font-family: sans-serif;
    }

    .v-autocomplete pre {
        text-align: left;
        white-space: pre-wrap;
        background-color: #eee;
        border: 1px solid #c0c0c0;
        padding: 20px !important;
        border-radius: 10px;
        font-family: monospace !important;
    }

    .v-autocomplete .left {
        text-align: left;
    }

    .v-autocomplete .note {
        border-left: 5px solid #ccc;
        padding: 10px;
    }
</style>
