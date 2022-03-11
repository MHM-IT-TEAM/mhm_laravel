<template>
<div class="container w-75">
    <v-card>
        <v-card-title>
           Pages
            <v-spacer></v-spacer>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
            ></v-text-field>
        </v-card-title>
        <v-data-table
            :search="search"
            :headers="headers"
            :items="users"
            sort-by="calories"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <v-dialog
                        v-model="dialog"
                        max-width="500px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                color="primary"
                                dark
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                                small
                            >
                                New Page
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="text-h5">{{ formTitle }}</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col
                                            cols="12"
                                        >
                                            <v-text-field
                                                v-model="editedItem.description"
                                                label="Description"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="editedItem.link"
                                                label="Password"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>

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
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="save"
                                >
                                    Save
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="text-h5">Are you sure you want to delete this page?</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <v-dialog
                        v-model="edit_page_dialog"
                    >
                        <v-card>
                            <v-container>
<!--                                <user_page :user_page="chosenPage.pages" :user_id="chosenPage.id"/>-->
                            </v-container>
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
    </v-card>
</div>
</template>

<script>
import moment from "moment";

export default {
    name: "pages",
    data(){
        return{
            search:'',
            dialog: false,
            edit_page_dialog:false,
            dialogDelete: false,
            show_description:false,
            headers: [
                { text: 'Id', value: 'id',sortable: true },
                { text: 'Link', value: 'link' },
                { text: 'Description', value: 'description' },
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            users: [],
            editedIndex: -1,
            editedItem: {
                id:'',
                description:'',
                link:''
            },
            chosenPage:{},
            defaultItem: {
                name: '',
                calories: 0,
                fat: 0,
                carbs: 0,
                protein: 0,
            },

        }
    },
    created() {
        this.initialize()
    },
    methods:{
        initialize(){
            axios.get('/api/v1/admin/pages').then(response=>{
                this.users=response.data
            })
        },
        editItem (item) {
            this.editedIndex = this.users.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        view_pages (item) {
            this.editedIndex = this.users.indexOf(item)
            this.chosenPage = Object.assign({}, item)
            this.edit_page_dialog = true
        },
        deleteItem (item) {
            this.editedIndex = this.users.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            this.users.splice(this.editedIndex, 1)
            axios.delete(`/api/v1/admin/pages/${this.editedItem.id}`)
            this.closeDelete()
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
                Object.assign(this.users[this.editedIndex], this.editedItem)
                axios.put(`/api/v1/admin/pages/${this.editedItem.id}`,this.editedItem)
            } else {
                this.users.push(this.editedItem)
                axios.post("/api/v1/admin/pages",this.editedItem)
            }
            this.close()
        },
    },
    computed:{
        formTitle () {
            return this.editedIndex === -1 ? 'New page' : 'Edit page'
        },
    },
    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },
    },
}
</script>

<style scoped>

</style>
