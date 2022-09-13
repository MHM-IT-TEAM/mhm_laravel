<template>
    <div class="container">
        <v-app>
            <div class="mt-6">
                <v-data-table
                    :headers="headers"
                    :items="list"
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
                            <v-toolbar-title>Lunch Orders </v-toolbar-title>
                            <v-toolbar-items class="ml-4">
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
                    </template>
                </v-data-table>
            </div>
            <v-dialog
                v-model="dialog"
                max-width="500"
            >
                <v-card>
                    <v-card-title class="text-h5">
                       Pay
                    </v-card-title>

                    <v-card-text>
                       <div class="row">
                          <div class="col">
                              <div class="form-group">
                                  <label>Menu</label>
                                  <input type="text"  class="form-control form-control-sm" v-model="editedItem.lunch_menu.name" disabled/>
                              </div>
                          </div>
                           <div class="col">
                               <div class="form-group">
                                   <label>Price</label>
                                   <input type="text"  class="form-control form-control-sm" v-model="editedItem.price" disabled/>
                               </div>
                           </div>
                           <div class="col">
                               <div class="form-group">
                                   <label>Qty</label>
                                   <input type="text" class="form-control form-control-sm" v-model="editedItem.qty" disabled/>
                               </div>
                           </div>
                           <div class="col">
                               <div class="form-group">
                                   <label>Value</label>
                                   <input type="text" class="form-control form-control-sm" v-model="editedItem.value" disabled/>
                               </div>
                           </div>
                           <div class="col">
                               <div class="form-group">
                                   <label>Paid</label>
                                   <input type="text" class="form-control form-control-sm" v-model="editedItem.paid"/>
                               </div>
                           </div>
                       </div>

                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn
                            color="green darken-1"
                            text
                            @click="dialog = false"
                        >
                            Disagree
                        </v-btn>

                        <v-btn
                            color="green darken-1"
                            text
                            @click="submit_payment"
                        >
                            Pay
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-app>
    </div>
</template>

<script>
export default {
    name: "cashier_lunch_payment_list",
    data(){
        return{
            dialog: false,
            search:'',
            dialogDelete: false,
            headers: [
                { text: 'Patient Id', value: 'admission.patient.id' },
                { text: 'First Name', value: 'admission.patient.firstName' },
                { text: 'Last Name', value: 'admission.patient.lastName' },
                { text: '', value: 'lunch_menu.name' },
                { text: 'Status',value:'status'},
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            list: [],
            editedIndex: -1,
            editedItem:{
                lunch_menu:{}
            },

        }
    },
    created(){
        this.initialize()
    },
    methods:{
        async initialize () {
            await axios.get('/api/v1/patient_system/cashier/lunch_orders').then(response=>{
                this.list=response.data
            })
        },

        async pay (item) {
            this.dialog=true
            this.editedItem={...item}
            // this.$router.push({name:'cashier_payment',params:{admission:item.admission,paid:check}})
        },
        async submit_payment(){
            await axios.post('/api/v1/patient_system/cashier/pay_lunch',this.editedItem).then(response=>{
                if(response.data.success) {
                    this.initialize()
                    this.editedItem={
                        lunch_menu:{}
                    }
                    this.dialog=false
                }
            })
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

}
</script>

<style scoped>

</style>
