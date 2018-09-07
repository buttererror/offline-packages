<template>
    <div id="detailsContainer">
        <div class="card">
            <div class="card-header">Package Request</div>

            <div class="card-body">
                <section class="section" style="padding-top: .5rem">
                    <div>
                        <horizontal-stepper :steps="steps" @completed-step="completeStep"
                                            :top-buttons="true"
                                            @active-step="isStepActive"
                                            @stepper-finished="alert"
                                            @clicking-back="stepBack"
                        >

                        </horizontal-stepper>
                    </div>
                </section>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary" @click.prevent="changeComponent">رجوع</button>
            </div>
        </div>
    </div>

</template>

<script>
    import HorizontalStepper from 'vue-stepper/src/HorizontalStepper.vue';

    import  PackageMainDetails from './PackageMainDetails';
    import  DestinationDetails from './DestinationDetails';
    import HotelDetails from './HotelDetails';

    // import StepOne from './StepOne.vue';
    // import StepTwo from './StepTwo.vue';
    // const teamUrl = 'https://github.com/PygmySlowLoris';
    // const repoUrl = 'https://github.com/PygmySlowLoris/vue-stepper';
    import StepTwo from './StepTwo.vue';
    export default {
        name: 'PackageRequest',
        props: {
            clientDetails: Object
        },
        components: {
            HorizontalStepper,
        },
        data() {
            return {
                steps: [
                    {
                        icon: 'info',
                        name: 'PackageMainDetails',
                        title: 'Package Main Details',
                        subtitle: '',
                        component: PackageMainDetails,
                        completed: false
                    },
                    {
                        icon: 'place',
                        name: 'DestinationDetails',
                        title: 'Destination Details',
                        subtitle: '',
                        component: DestinationDetails,
                        completed: false
                    },
                    // {
                    //     icon: 'report_problem',
                    //     name: 'second',
                    //     title: 'Sample title 2',
                    //     subtitle: 'Subtitle sample',
                    //     component: StepTwo,
                    //     completed: false
                    // },
                    {
                        icon: 'location_city',
                        name: 'HotelDetails',
                        title: 'Hotel Details Selection',
                        component: HotelDetails,
                        completed: false
                    }
                ],
                activeStep: 0,
                show: false,
                packageDetails:{
                    startPlace:'',
                    startDate:'',
                    endDate:''
                }
            }
        },
        mounted() {
            bus.$emit("data-to-main", this.clientDetails);
            $("#detailsContainer .content").css({
                'overflow': 'visible',
                'margin-top': '5%'
            });
            $("#detailsContainer .stepper-box").css({
                'box-shadow': 'none',
                '-webkit-box-shadow': 'none'
            });
            $("#detailsContainer .next").css({
                'border': '2px solid rgb(51, 131, 200)',
                'background-color': 'white',
                'color': 'black',
                'box-shadow': '0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24)'
            });

        },
        computed: {},
        methods: {
            completeStep(payload) {
                this.steps.forEach((step) => {
                    if (step.name === payload.name) {
                        step.completed = true;
                        console.log("step completed");
                        setTimeout(() => {
                            bus.$emit('change-next');
                        }, 2000);
                    }
                });

            },
            isStepActive(payload) {
                this.steps.forEach((step) => {
                    if (step.name === payload.name) {
                        if (step.completed === true) {
                            step.completed = false;
                        }
                    }
                })
            },
            stepBack() {
                // setTimeout(() => {
                    bus.$emit("change-back");
                // }, 2000);
            },
            alert(payload) {
                bus.$emit("package-completed");
            },
            changeComponent() {
                this.$emit('change-component', {component: 'NewOrOldClient'});
            }
        }
    }
</script>

<style scoped>

</style>
