
<i18n>
    {
        "ar":{
            "client": {
                "add": "اضافة عميل جديد",
                "choose":"اختار العميل",
                "newData":"اضافة بيانات عميل جديد",
                "search":"بحث العملاء",
                "here":"هنا"

            },
            "next":"التالى",
            "class": {
                "footerDir": "text-left"
            }
        },

        "en": {
            "client": {
                "add": "Add new Client",
                "choose":"Choose Client",
                "newData":"Add new Client Data",
                "search":"Search Clients",
                "here":"here"
            },
            "next":"next",
            "class": {
                "footerDir": "text-right"
            }
        }
    }
</i18n>

<template>
    <div id="searchClients">
        <div class="card" v-if="show">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title text-center">
                    {{ $t("client.search") }}
                </h4>
            </div>

            <div class="card-body">
                <h2 class="text-center">
                    {{ $t("client.choose") }}

                </h2>
                <div class="row mt-4">
                    <div class="offset-3"></div>
                    <div class="col-6">

                        <multiselect v-model="client" :options="clients" label="name"
                                     tagPosition="bottom" openDirection="bottom"
                                     placeholder="" id="select_input"
                                     @focus.native.capture="validateSearchBox('focus')"
                                     @blur.native.capture="validateSearchBox"
                                     @search-change="getClient"
                                     @input="validateSearchBox"
                                     @remove="validateSearchBox"
                                     @keyup.native.capture.enter="nextComponent(client)"

                                     :class="{'select': searchBoxState === 'normal',
                                     'is-valid': searchBoxState === 'valid'}"

                        >


                        </multiselect>
                    </div>
                </div>
                <div class="row mt-4 text-center">
                    <div class="col-12">
                        {{ $t("client.newData") }}
                        <a href="#" @click.prevent="handleNewClientClicked">
                            {{ $t("client.here") }}

                        </a>
                    </div>
                </div>
            </div>

            <div class="card-footer" :class="$t('class.footerDir')">
                <button class="btn btn-primary" @click.prevent="nextComponent(client)"
                        :class="{'disabled': disableSaveBtn}"
                >{{$t("next")}}
                </button>
            </div>

        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        name: 'AutocompleteTrigger',
        components: {
            Multiselect
        },
        mounted() {
            // document.getElementById("select_input").autofocus = true;
            let $selectBtn = document.getElementsByClassName("multiselect__select")[0];
            document.getElementsByClassName("multiselect")[0].removeChild($selectBtn);
            document.getElementsByClassName("multiselect__tags")[0].classList.add("select_tags");
            // document.getElementById("select_input").nextElementSibling.children[0].classList.add("select_single");
            bus.$on('new-client-saved', (client) => {
                this.client = client;
            });
        },
        data() {
            return {
                clients: [],
                client: null,
                show: true,
                searchBoxState: null,
                disableSaveBtn: true,
            }
        },
        methods: {
            getClient(text) {
                axios.get('/api/client/search', {
                    params: {
                        searchText: text
                    }
                }).then(response => {
                    this.clients = response.data;
                }).catch(e=>{
                    axios.post('/logout').then(response => {

                     window.location.href="/login";
                    });
                });
            },
            handleNewClientClicked() {
                bus.$emit('new-client-clicked');
            },
            nextComponent(client) {
                // console.log("here");
                if (!this.disableSaveBtn) {
                    window.packageDetails.clientDetails = client;
                    this.$emit('next-component', {
                        component: "SelectService",
                        step: "serviceSelection"
                    });
                }
            },
            validateSearchBox(eventType) {
                // console.log(this.client)
                if (eventType === 'focus') {
                    this.client = null;
                    this.disableSaveBtn = true;
                    return this.searchBoxState = "normal";
                }
                if (this.client) {
                    this.searchBoxState = "valid";
                    this.disableSaveBtn = false;
                    return;
                }
                this.searchBoxState = null;
            }
        }

    }
</script>

<style>
    .is-valid {
        border: 1px solid #28a745;
        border-radius: 5px;
    }

    .is-valid:focus {
        border: 1px solid #28a745 !important;
        border-radius: 5px;
    }

    .select_tags {
        min-height: 55px;
        padding: 8px 8px 0 8px;
    }

    #select_input {
        display: block !important;
        min-height: 37px;
        margin-bottom: 0;
        vertical-align: middle;
        font-size: 20px;
        font-weight: 200;
    }

    #searchClients .select {
        color: #495057 !important;
        background-color: #fff !important;
        border: 1px solid #80bdff !important;
        border-radius: 5px;
        outline: 0 !important;
        -webkit-box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
    }

    .select_single {
        position: absolute;
        width: 95%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 23px;
        font-weight: 200;
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-bottom: 0;
        min-height: 51px;
        padding: 0;
        vertical-align: unset;
    }

    #searchClients .multiselect__single {
        position: absolute;
        width: 95%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 23px;
        font-weight: 200;
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-bottom: 0;
        min-height: 51px;
        padding: 0;
        vertical-align: unset;
    }
</style>
