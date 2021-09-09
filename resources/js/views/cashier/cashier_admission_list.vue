<template>
    <div class="container w-75">
        <v-app>
            <v-data-table
                :headers="headers"
                :items="filtered_list"
                :search="search"
                sort-by="id"
                class="elevation-1"
            >
                <template v-slot:item.service_activity="{ item }">
                    <v-chip
                        :color="serviceColor(item.id)"
                        dark
                    >
                        {{ item.name }}
                    </v-chip>
                </template>
                <template v-slot:item.payment_status="{ item }">
                    <v-chip
                        :color="doneColor(item.payment_status)"
                        dark
                    >
                        {{ item.payment_status }}
                    </v-chip>
                </template>
                <template v-slot:top>
                    <v-toolbar
                        flat
                    >
                        <v-toolbar-title>List of admissions </v-toolbar-title>
                        <v-toolbar-items class="ml-4">
                            <v-select
                                :items="filters"
                                label="Filter"
                                solo
                                v-model="page_filter"
                            ></v-select>
                        </v-toolbar-items>
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
<!--                        <v-dialog-->
<!--                            v-model="dialog"-->
<!--                            max-width="100vw"-->
<!--                        >-->
<!--                            <v-card>-->
<!--                                <v-card-text>-->
<!--                                    <v-container>-->
<!--                                        <admission-->
<!--                                            :reference="childRef"-->
<!--                                            :edit="childEdit"-->
<!--                                            @updated="refreshList"-->
<!--                                        ></admission>-->
<!--                                    </v-container>-->
<!--                                </v-card-text>-->

<!--                                <v-card-actions>-->
<!--                                    <v-spacer></v-spacer>-->
<!--                                    <v-btn-->
<!--                                        color="blue darken-1"-->
<!--                                        text-->
<!--                                        @click="close"-->
<!--                                    >-->
<!--                                        Cancel-->
<!--                                    </v-btn>-->

<!--                                </v-card-actions>-->
<!--                            </v-card>-->
<!--                        </v-dialog>-->
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
                        @click="pay(item)"
                    >
                        mdi-cash
                    </v-icon>
<!--                    <v-icon-->
<!--                        small-->
<!--                        @click="deleteItem(item)"-->
<!--                    >-->
<!--                        mdi-delete-->
<!--                    </v-icon>-->
                </template>
            </v-data-table>
        </v-app>
    </div>
</template>

<script>
export default {
    name: "cashier_admission_list",
    data(){
        return{
            dialog: false,
            search:'',
            dialogDelete: false,
            headers: [
                { text: 'Patient Id', value: 'patient_id' },
                { text: 'First Name', value: 'patient.firstName' },
                { text: 'Last Name', value: 'patient.lastName' },
                { text: 'Service', value: 'service_activity.name' },
                { text: 'Status',value:'payment_status'},
                {text:'Remark',value:'remark'},
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            list: [],
            editedIndex: -1,
            editedItem:"",
            filters:[
                {value:1,text:'All'},
                {value:2,text:'Unpaid'},
                {value:3,text:'Paid'}
            ],
            page_filter:''
        }
    },
    created(){
        this.initialize()
    },
    methods:{
        async initialize () {
            await axios.get('/api/v1/patient_system/admission/list_today').then(response=>{
                this.list=response.data
                this.list.forEach(item=>{
                    if(item.payment_status===null) item.payment_status='NOT PAID'
                })
            })
        },

        async pay (item) {
            this.editedIndex =this.list.indexOf(item)
            let check
            if(item.payment_status==='PAID')check=1
            else check=0
            this.$router.push({name:'cashier_payment',params:{admission:item,paid:check}})
        },

        deleteItem (item) {
            this.editedIndex = this.list.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            this.list.splice(this.editedIndex, 1)
            this.closeDelete()
            axios.delete(`/api/v1/patient_system/admission/admission/${this.editedItem.id}`)
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
            if(status==='PAID'){
                return 'green'
            }else{
                return 'grey'
            }
        },
        refreshList(){
            this.close()
            this.initialize()
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
        },
    },
    computed:{
        filtered_list(){
            switch (this.page_filter){
                case '':
                    return this.list.filter(item=>item.payment_status==='NOT PAID')
                break;
                case 1:
                    return this.list
                    break;
                case 2:
                    return this.list.filter(item=>item.payment_status==='NOT PAID')
                    break;
                case 3:
                    return this.list.filter(item=>item.payment_status==='PAID')
                    break;
            }
        }
    }
}
</script>

<style scoped>
    .container{
        margin-top: 60px;
    }
</style>
