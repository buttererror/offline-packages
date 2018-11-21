<template>
    <div class="container">
        <b-link  class="js-top goTop" href='#app' ><i class="fas fa-angle-left"></i></b-link>
        <div class="row justify-content-center">
            <div class="form-group ">
                <div class="sticky-search">
                    Search
                    <b-form-input class="mb-2 mr-sm-2 mb-sm-0" placeholder="Search" @input="filterRequests"
                                  v-model="filter_data"></b-form-input>
                </div>
            </div>
            <br>

            <div class="col-md-8">
                <div v-for="request in tempRequests">
                    <div v-show="request.id">
                        <b-card  class="request-card">
                            <div class="card-title">
                                {{request.title}}
                                <div class="client-name">
                                    Client: &nbsp
                                    <b-link v-b-modal.client_data variant="primary" @click="showData(request)">{{request.client.name}}</b-link>
                                </div>
                            </div>
                            <div class="body-content">
                                <ul>
                                    <li class="card-text"><span  class="col-md-4">Start Date </span>{{request.start_date}}</li>
                                    <li class="card-text"><span  class="col-md-4">Adults </span>{{request.adults}}</li>
                                    <li class="card-text"><span  class="col-md-4">Children Count </span>{{request.children_count}}</li>
                                    <li class="card-text"><span  class="col-md-4">Number of Destinations </span>{{request.number_of_destinations}}</li>
                                    <li class="card-text"><span  class="col-md-4">Children </span>{{request.children}}</li>
                                    <li class="card-text"><span  class="col-md-4">Status </span>{{request.status}}</li>
                                    <li class="card-text" >
                                        <span  class="col-md-4"> City  Name:</span>
                                        <ul>
                                            <li v-for="destination in request.accommodation_requests">
                                                <b-link v-b-modal.destination_data variant="primary" @click="showDestination(destination)">{{destination.city.name}}</b-link>
                                            </li>
                                        </ul>
                                   </li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <div v-if='role==="operator" && request.status==="new"'>
                                    <b-button variant="default" @click="updateRequestStatus(request,'received')">Receive
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
                            </div>
                        </b-card>
                    </div>
                    <br>
                </div>
                <br>
                <div v-if="tempRequests.length>0">
                    <b-pagination size="md" :total-rows="totalRows" v-model="currentPage" :per-page="5"
                                  @input="updateRequests"  align="center">
                    </b-pagination>
                </div>
                <div v-else>
                    <b-alert variant="danger" show>No Results Found</b-alert>
                </div>
            </div>

            <b-modal id="client_data" size="lg" :title="'Client Name: '+selectedClient.name">
                <!--<div><span class="col-md-3">Client Name:  </span>{{selectedClient.name}}</div>-->
                <ul>
                    <li class="modal-text"><span  class="col-md-3">Client Age: </span> {{selectedClient.age}}</li>
                    <li class="modal-text"><span  class="col-md-3">Client email:</span>{{selectedClient.email}}</li>
                    <li class="modal-text"><span  class="col-md-3">Client mobile: </span> {{selectedClient.mobile}}</li>
                </ul>
            </b-modal>

            <b-modal id="destination_data" size="lg" title="destination Data">
                    <!--<div><span  class="col-md-3">chick in: </span> {{destination.chickin}}</div>-->
                <ul class="title">
                    <li class="modal-text"><span class="col-md-3">chick in:</span>{{selectedDestination.checkin}}</li>
                    <li class="modal-text"><span class="col-md-3">chick out:</span>{{selectedDestination.checkout}}</li>
                    <li class="modal-text"><span class="col-md-3">city name:</span>{{destination_city_name}}</li>
                    <li class="modal-text"><span class="col-md-3">country name:</span>{{destination_country_name}}</li>
                    <li class="modal-text"><span class="col-md-3">number of nights:</span>{{selectedDestination.nights}}</li>
                    <li class="modal-text" v-if="selectedDestination.accommodation_type!=null">
                        <span class="col-md-3" >
                                  accommodation_type:
                        </span>
                        {{selectedDestination.accommodation_type}}
                    </li>
                    <li class="modal-text"> <span class="col-md-3">Rooms Number:</span>  {{destination_rooms.length}}</li>
                    <li  class="rooms-detail " v-if="selectedDestination.accommodation_type=='hotel'">
                        <template  v-if="destination_rooms&&destination_rooms.length>0">
                            <ul v-for="destination_room in destination_rooms">
                                <li  class="modal-text ">
                                    <div class="col-md-4">
                                        <span >room_number :</span > {{destination_room.room_number}}
                                    </div>
                                     <div class="col-md-4">
                                         <span >adults :</span> {{destination_room.adults}}
                                     </div>
                                 <div class="col-md-4">
                                     <span >children :</span>
                                     <span v-for="child  in destination_room.children ">{{child.age}}</span>
                                 </div>
                                </li>
                            </ul>
                        </template>

                    </li>
                    <!--<li class="modal-text"><span class="col-md-3">chick in:</span>{{selectedDestination.}}</li>-->
                </ul>

            </b-modal>

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
                filter_data: '',
                selectedClient:'',
                selectedDestination:'',
                destination_city_name:'',
                destination_rooms:'',
                destination_country_name:''
            }

        },
        mounted(){
            console.log(this.tempRequests);
        },
        created() {
        },
        props: [
            'requestsData', 'role', 'category'
        ],
        methods: {
            showData(request){
                console.log(request)
                this.selectedClient=request.client;
            },
            showDestination(destination){
                    this.selectedDestination =destination;
                    this.destination_rooms=JSON.parse(destination.rooms);

//                   for(let r=0;r<this.destination_rooms.length;r++){
//                       console.log (this.destination_rooms[r].children);
//                       for(let c=0;c<this.destination_rooms[r].children.length;c++){
//
//                       }
//
//                   }
                    this.destination_city_name=this.selectedDestination.city.name;
                    this.destination_country_name=this.selectedDestination.country.en_short_name;
            },
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
                this.currentPage=1;
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
            },
        }
    }
</script>

<style  lang="scss" >

</style>