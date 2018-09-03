<template>
    <v-container grid-list-md>
        <v-layout row wrap>
            <v-flex xs12 lg12>
                <v-menu
                        :close-on-content-click="false"
                        v-model="menu2"
                        :nudge-right="40"
                        lazy
                        transition="scale-transition"
                        offset-y
                        full-width
                >
                    <v-text-field
                            slot="activator"
                            v-model="computedDateFormatted"
                            label="Date (read only text field)"
                            hint="MM/DD/YYYY format"
                            persistent-hint
                            prepend-icon="event"
                            readonly
                    >

                    </v-text-field>
                    <v-date-picker v-model="date" no-title @input="menu2 = false"></v-date-picker>
                </v-menu>
            </v-flex>
        </v-layout>
    </v-container>
</template>

    <script>
        export default {
            data: () => ({
                date: null,
                dateFormatted: null,
                menu2: false
            }),

            computed: {
                computedDateFormatted () {
                    return this.formatDate(this.date)
                }
            },

            watch: {
                date (val) {
                    this.dateFormatted = this.formatDate(this.date)
                }
            },

            methods: {
                formatDate (date) {
                    if (!date) return null

                    const [year, month, day] = date.split('-')
                    return `${month}/${day}/${year}`
                },
                parseDate (date) {
                    if (!date) return null

                    const [month, day, year] = date.split('/')
                    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                }
            }
        }
    </script>

<style scoped>

</style>