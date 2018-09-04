<template>
    <v-app>

        <v-content>

            <v-container>
                <v-stepper v-model="step" vertical>

                    <v-stepper-header>

                        <v-stepper-step step="1" :complete="step > 1">Your Information</v-stepper-step>
                        <v-divider></v-divider>

                        <v-stepper-step step="2" :complete="step > 2">Your Address</v-stepper-step>
                        <v-divider></v-divider>

                        <v-stepper-step step="3">Misc Info</v-stepper-step>

                    </v-stepper-header>

                    <v-stepper-items>

                        <v-stepper-content step="1">

                            <v-text-field label="Name" v-model="user.name" required></v-text-field>
                            <v-text-field label="Email" v-model="user.email" required></v-text-field>

                            <v-btn color="primary" @click.native="step = 2">Continue</v-btn>
                        </v-stepper-content>

                        <v-stepper-content step="2">

                            <v-text-field label="Street" v-model="user.street" required></v-text-field>
                            <v-text-field label="City" v-model="user.city" required></v-text-field>
                            <v-text-field label="State" v-model="user.state" required></v-text-field>

                            <v-btn flat @click.native="step = 1">Previous</v-btn>
                            <v-btn color="primary" @click.native="step = 3">Continue</v-btn>

                        </v-stepper-content>


                        <v-stepper-content step="3">

                            <v-text-field label="favourite hobby" type="text"
                                          v-model="user.hobby" required></v-text-field>

                            <v-btn flat @click.native="step = 2">Previous</v-btn>
                            <v-btn color="primary" @click.prevent="submit">Save</v-btn>

                        </v-stepper-content>

                    </v-stepper-items>

                </v-stepper>

            </v-container>

        </v-content>

    </v-app>


</template>
<script>
    export default {
        data() {
            return {
                e1: 0,
                user: {
                    name: '',
                    email: '',
                    password: '',
                    teacher: '',
                    hobby: '',
                    street: '',
                    city: '',
                    state: '',
                },
                step: 1
            }
        },
        methods: {
            submit() {
                alert('This is the post. Blah');
            }
        }
    }
</script>