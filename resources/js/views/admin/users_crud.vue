<template>
    <div class="container w-75">
        <v-card>
            <v-card-title>
                Users
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
                                    New User
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
                                                sm="6"
                                                md="4"
                                            >
                                                <v-text-field
                                                    v-model="editedItem.employee_id"
                                                    label="Employee ID"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="4"
                                            >
                                                <v-text-field
                                                    v-model="editedItem.name"
                                                    label="Username"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field
                                                    v-model="editedItem.password"
                                                    label="Password"
                                                    :append-icon="show_password ? 'mdi-eye' : 'mdi-eye-off'"
                                                    :type="show_password ? 'text' : 'password'"
                                                    hint="At least 8 characters"
                                                    :rules="[password_rule.min]"
                                                    counter
                                                    @click:append="show_password = !show_password"
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
                                <v-card-title class="text-h5">Are you sure you want to delete this user?</v-card-title>
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
                                    <user_page :user_page="chosenUser.pages" :user_id="chosenUser.id"/>
                                </v-container>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                </template>
                <template v-slot:item.view_page="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="view_pages(item)"
                    >
                        mdi-pencil
                    </v-icon>
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
import User_page from "./user_page";
export default {
    name: "users_crud",
    components: {User_page},
    data(){
        return{
            search:'',
            dialog: false,
            edit_page_dialog:false,
            dialogDelete: false,
            show_password:false,
            headers: [
                { text: 'Employee id', value: 'employee_id',sortable: true },
                { text: 'Username', value: 'name' },
                { text: 'Registration date', value: 'created_at' },
                { text: 'Pages', value: 'view_page' },
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            users: [],
            editedIndex: -1,
            editedItem: {
                id:'',
                employee_id:'',
                password:''
            },
            chosenUser:{},
            defaultItem: {
                name: '',
                calories: 0,
                fat: 0,
                carbs: 0,
                protein: 0,
            },
            password_rule:{
                min: v => v.length >= 8 || 'Min 8 characters'
            }
        }
    },
    created() {
        this.initialize()
    },
    methods:{
        initialize(){
            axios.get('/api/v1/admin/users').then(response=>{
                this.users=response.data
                this.users.forEach(user=>{
                    user.created_at= moment(user.created_at).format("DD-MMM-YYYY")
                    user.name= user.name.toUpperCase()
                })
            })
        },
        editItem (item) {
            this.editedIndex = this.users.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        view_pages (item) {
            this.editedIndex = this.users.indexOf(item)
            this.chosenUser = Object.assign({}, item)
            this.edit_page_dialog = true
        },
        deleteItem (item) {
            this.editedIndex = this.users.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            this.users.splice(this.editedIndex, 1)
            axios.delete(`/api/v1/admin/users/${this.editedItem.id}`)
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
                axios.put(`/api/v1/admin/users/${this.editedItem.id}`,this.editedItem)
            } else {
                this.users.push(this.editedItem)
                axios.post("/api/v1/admin/users",this.editedItem)
            }
            this.close()
        },
    },
    computed:{
        formTitle () {
            return this.editedIndex === -1 ? 'New user' : 'Edit user'
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
