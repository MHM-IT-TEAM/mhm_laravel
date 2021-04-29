<template>
    <div>
        <v-app>
            <v-data-table
                :headers="headers"
                :items="list"
                :search="search"
                sort-by="calories"
                class="elevation-1"
            >
                <template v-slot:item.name="{ item }">
                    <v-chip
                        :color="serviceColor(item.name)"
                        dark
                    >
                        {{ item.type_consult.name }}
                    </v-chip>
                </template>
                <template v-slot:item.careDetails.status="{ item }">
                    <v-chip
                        :color="doneColor(item.careDetails.status)"
                        dark
                    >
                        {{ item.careDetails.status }}
                    </v-chip>
                </template>
                <template v-slot:top>
                    <v-toolbar
                        flat
                    >
                        <v-toolbar-title>List of consultations </v-toolbar-title>
                        <v-divider
                            class="mx-4"
                            inset
                            vertical
                        ></v-divider>
                        <v-spacer></v-spacer>

                        <v-text-field
                            v-model="search"
                            label="Search"
                            append-icon="mdi-magnify"
                            single-line
                            hide-details
                        ></v-text-field>
                        <v-dialog
                            v-model="dialog"
                            max-width="100vw"
                        >
                            <v-card>
                                <v-card-title>
                                    <span class="headline">{{ formTitle }}</span>

                                </v-card-title>

                                <v-card-text>
                                    <v-container>
                                        <consultation
                                            :editData="childEditData"
                                            :edit="childEdit"
                                        ></consultation>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="close"
                                    >
                                        Cancel
                                    </v-btn>

                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="dialogDelete" max-width="500px">
                            <v-card>
                                <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                    <v-spacer></v-spacer>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="editItem(item)"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        small
                        @click="deleteItem(item)"
                    >
                        mdi-delete
                    </v-icon>
                </template>
                <template v-slot:no-data>
                    <v-btn
                        color="primary"
                        @click="initialize"
                    >
                        Reset
                    </v-btn>
                </template>
            </v-data-table>
        </v-app>
    </div>

</template>
<script>
    import consultation from "./consultation";
    import {mapGetters,mapActions} from 'vuex';
    export default {
        components: {consultation},
        data: () => ({
            dialog: false,
            search:'',
            dialogDelete: false,
            headers: [
                { text: 'Patient Id', value: 'patient.id' },
                { text: 'firstName', value: 'patient.firstName' },
                { text: 'lastName', value: 'patient.lastName' },
                { text: 'Service', value: 'careDetails.type_consult_name' },
                { text: 'status',value:'careDetails.status'},
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            list: [],
            editedIndex: -1,
            editedItem:"",
            defaultItem: {
            },
            childEditData:"",
            childEdit:false
        }),

        computed: {
            ...mapGetters('consultation',['consultations']),

            formTitle () {
                return this.editedIndex === -1 ? 'New Consultation' : 'Edit Consultation'
            },
        },

        watch: {
            dialog (val) {
                val || this.close()
            },
            dialogDelete (val) {
                val || this.closeDelete()
            },
            consultations(newValue){
                return this.list= [...newValue]
            }
        },

        created () {
            this.initialize()

        },

        methods:{
            ...mapActions('consultation',['fetchTodayConsultations']),
            async initialize () {
                await this.fetchTodayConsultations()
                this.list=[...this.consultations]
            },

            async editItem (item) {
                this.editedIndex =this.consultations.indexOf(item)
               this.childEditData= Object.assign({}, item)
                this.childEdit=true
                this.dialog = true
            },

            deleteItem (item) {
                this.editedIndex = this.consultations.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialogDelete = true
            },

            deleteItemConfirm () {
                this.consultations.splice(this.editedIndex, 1)
                this.closeDelete()
                axios.delete(`/api/consultation/${this.editedItem.consult_id}`, this.editedItem)
            },

            close () {
                this.dialog = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },

            closeDelete () {
                this.dialogDelete = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },

            save () {
                if (this.editedIndex > -1) {
                    Object.assign(this.consultations[this.editedIndex], this.editedItem)
                } else {
                    this.consultations.push(this.editedItem)
                }
                this.close()
            },
            serviceColor(service){
                switch (service) {
                    case 'Generalist':
                       return 'blue'
                    break;
                    case 'Dentist':
                        return 'orange'
                    break;
                }
            },
            doneColor(status){
                if(status==='DONE'){
                    return 'green'
                }else{
                    return 'grey'
                }
            }
        },
    }
</script>
