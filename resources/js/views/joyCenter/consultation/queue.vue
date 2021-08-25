<template>
    <div class="container w-75">
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
                                <v-card-text>
                                    <v-container>
                                        <consultation
                                            :reference="childRef"
                                            :edit="childEdit"
                                            @updated="close"
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
                { text: 'Patient Id', value: 'patient_id' },
                { text: 'First Name', value: 'patient.firstName' },
                { text: 'Last Name', value: 'patient.lastName' },
                { text: 'Service', value: 'type_consult.name' },
                { text: 'Status',value:'status'},
                {text:'Remark',value:'remark'},
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            list: [],
            editedIndex: -1,
            editedItem:"",
            defaultItem: {
            },
            childRef:"",
            childEdit:false,
        }),

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
            async initialize () {
                await axios.get('/api/consultation/today/0').then(response=>{
                    this.list=response.data
                })
            },

            async editItem (item) {
                this.editedIndex =this.list.indexOf(item)
               this.childRef=item.id
                this.childEdit=true
                this.dialog = true
            },

            deleteItem (item) {
                this.editedIndex = this.list.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialogDelete = true
            },

            deleteItemConfirm () {
                this.list.splice(this.editedIndex, 1)
                this.closeDelete()
                axios.delete(`/api/consultation/${this.editedItem.id}`)
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
