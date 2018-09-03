
<template>
    <v-layout>
        <v-flex>
            <v-menu
                ref="menu"
                :close-on-content-click="false"
                v-model="menu"
                :nudge-right="40"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                min-width="290px"
            >
                <v-text-field
                    slot="activator"
                    v-model="date"
                    label="تاريخ الميلاد"
                    prepend-icon="event"
                    readonly
                ></v-text-field>

                <v-date-picker
                    ref="picker"
                    v-model="date"
                    :max="new Date().toISOString().substr(0, 10)"
                    min="1950-01-01"
                    @change="getBirthDate"
                ></v-date-picker>
            </v-menu>
        </v-flex>
    </v-layout>
</template>

    <script>
        export default {
            data: () => ({
                date: null,
                dateFormatted: null,
                menu: false
            }),
            computed: {
                computedDateFormatted () {
                    return this.formatDate(this.date)
                }
            },

            watch: {
                // date (val) {
                //     this.dateFormatted = this.formatDate(this.date)
                // }s
                menu (val) {
                    val && this.$nextTick(() => (this.$refs.picker.activePicker = 'YEAR'))
                }
            },

            methods: {
                formatDate (date) {
                    if (!date) return null

                    const [year, month, day] = date.split('-')
                    return `${month}/${day}/${year}`
                },
                parseDate (date) {
                    if (!date) return null;
                    const [month, day, year] = date.split('/')
                    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
                },
                getBirthDate() {
                    console.log("datePicker " + this.computedDateFormatted);
                    bus.$emit("client-birthDate", this.computedDateFormatted);
                }
            }
        }
    </script>

<style scoped>

</style>
