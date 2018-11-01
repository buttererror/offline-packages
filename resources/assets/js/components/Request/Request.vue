<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="form-group">
                Search
                <b-input class="mb-2 mr-sm-2 mb-sm-0" placeholder="Search" @input="filterRequests" v-model="filter_data"/>
            </div>
            <br>

            <div class="col-md-8">
                <div v-for="request in requests">
                    <div v-show="request.id">
                        <b-card :title="request.title">
                            <p class="card-text">Start Date :{{request.start_date}}</p>
                            <p class="card-text">Adults :{{request.adults}}</p>
                            <p class="card-text">Children Count :{{request.children_count}}</p>
                            <p class="card-text">Number of Destinations :{{request.number_of_destinations}}</p>
                            <p class="card-text">Children :{{request.children}}</p>
                            <p class="card-text">Status :{{request.status}}</p>
                            <div v-if='role==="operator" && request.status==="new"'>
                                <b-button variant="primary" @click="updateRequestStatus(request,'received')">Receive
                                    Request
                                </b-button>
                            </div>
                            <div v-if='role==="operator" && request.status==="received"'>
                                <b-button variant="warning" @click="updateRequestStatus(request,'workingon')">Working on
                                    it
                                </b-button>
                            </div>
                            <div v-if='role==="operator" && request.status==="workingon"'>
                                <b-button variant="primary" @click="updateRequestStatus(request,'done')">Done
                                </b-button>
                                <b-button variant="danger" @click="updateRequestStatus(request,'failed')">Failed
                                </b-button>
                            </div>
                        </b-card>
                    </div>
                    <br>
                </div>
                <br>
                <div v-if="requests.length>0">
                    <b-pagination size="lg" :total-rows="requestsData.total" v-model="currentPage" :per-page="5"
                                  @change="updateRequests">
                    </b-pagination>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        name: "Request",
        data() {
            return {
                requests: this.requestsData.data,
                currentPage: 1,
                userRole: this.role,
                filter_data:''
            }

        },
        created() {
        },
        props: [
            'requestsData', 'role', 'category'
        ],
        mounted() {
            console.log(this.role);
        },
        methods: {
            updateRequests() {
                axios.get(`/get/requests/${this.category}/?page=${this.currentPage}`).then((response) => {
                    console.log(response.data.requests);
                    this.requests = response.data.requests.data;
                });
            },
            updateRequestStatus(request, status) {
                axios.post('/update/request/status', {'id': request.id, 'status': status}).then(() => {
                    request.id = false;

                });
            },
            filterRequests(){
                this.requests.filter(request=>request.name===this.filter_data);
                console.log(this.requests);
            }
        }

    }
</script>

<style scoped>

</style>