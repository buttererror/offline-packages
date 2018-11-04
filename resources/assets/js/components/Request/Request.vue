<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="form-group">
                Search
                <b-form-input class="mb-2 mr-sm-2 mb-sm-0" placeholder="Search" @input="filterRequests"
                              v-model="filter_data"></b-form-input>
            </div>
            <br>

            <div class="col-md-8">
                <div v-for="request in tempRequests">
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
                                <b-button variant="warning" @click="updateRequestStatus(request,'workingon')">
                                    Working on
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
                <div v-if="tempRequests.length>0">
                    <b-pagination size="lg" :total-rows="totalRows" v-model="currentPage" :per-page="5"
                                  @input="updateRequests">
                    </b-pagination>
                </div>
                <div v-else>
                    <b-alert variant="danger" show>No Results Found</b-alert>


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
                tempRequests: this.requestsData.data,
                totalRows: this.requestsData.total,
                currentPage: 1,
                userRole: this.role,
                filter_data: ''
            }

        },
        created() {
        },
        props: [
            'requestsData', 'role', 'category'
        ],
        methods: {
            updateRequests() {
                if (this.filter_data == '') {
                    axios.get(`/get/requests/${this.category}/?page=${this.currentPage}`).then((response) => {
                        this.tempRequests = response.data.requests.data;
                    });
                }
                else{
                    axios.post(`/search/request/?page=${this.currentPage}`, {
                        'query': this.filter_data,
                        'category': this.category
                    }).then(response => {
                        this.tempRequests = response.data.requests.data;
                        this.totalRows = response.data.requests.total;
                    });
                }
            },
            updateRequestStatus(request, status) {
                axios.post('/update/request/status', {'id': request.id, 'status': status}).then(() => {
                    request.id = false;
                });
            },
            filterRequests() {
                if (this.filter_data == '') {
                    this.tempRequests = this.requests;
                    this.totalRows = this.requestsData.total;

                }
                else {
                    axios.post('/search/request', {
                        'query': this.filter_data,
                        'category': this.category
                    }).then(response => {
                        this.tempRequests = response.data.requests.data;
                        this.totalRows = response.data.requests.total;

                    });
                }


            }
        }

    }
</script>

<style scoped>

</style>