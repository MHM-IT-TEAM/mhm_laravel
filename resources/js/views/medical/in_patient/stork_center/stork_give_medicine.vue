<template>
    <div class="container">
        <v-card>
            <v-card-text>
                <h1 class="title">MEDICAL PRESCRIPTION</h1>
                <patient_information :patient_id="$route.params.stork_admission.patient_id"/>
                <table class="table table-sm mt-2">
                    <tr>
                        <td style="width:15%">
                           {{moment().format("MMM Do YY")}}
                        </td>
                        <td>
                            <input class="form-control" type="time" v-model="accessory.medication.time"/>
                        </td>
                        <td>
                            <multiselect
                                v-model="accessory.medication.item"
                                :custom-label="nameWithCode"
                                track-by="description"
                                placeholder="search medicines here"
                                :options="accessory.avalaible_medicines"
                                :hide-selected="true"
                                class="multiSelect"
                                autocomplete="off"
                            >
                            </multiselect>
                        </td>
                        <td style="width:10%">
                            <input type="number" class="form-control" v-model="accessory.medication.given"/>
                        </td>
                        <td style="width:10%">
                            <v-btn x-small text @click="add_medication" class="table-title">Add</v-btn>
                        </td>
                    </tr>
                    <tr v-for="row in formData.list">
                        <td>
                            {{row.date}}
                        </td>
                        <td>
                            {{row.time}}
                        </td>
                        <td>
                            {{`${row.item.code} - [${row.item.description}]`}}
                        </td>
                        <td>{{row.given}}</td>
                    </tr>
                </table>
                <button class="btn btn-sm btn-primary mr-0" @click="submit">Submit</button>
                <h3 class="title">Data in the system</h3>
                <v-data-table
                    :headers="headers"
                    :items="accessory.data_in_system"
                    :items-per-page="5"
                    class="elevation-1"
                ></v-data-table>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import Patient_information from "../../../../components/patient_information";
import moment from "moment";
export default {
    name: "stork_give_medicine",
    components: {Patient_information},
    data(){
        return{
            formData:{
                list:[]
            },
            accessory:{
                medication: {
                    item: null,
                    given:null,
                    date:moment().format("MMM Do YY, h:mm:ss a"),
                    time:''
                },
                data_in_system: [],
                avalaible_medicines:[]
            },
            headers: [
                {
                    text: 'Date',
                    align: 'start',
                    sortable: false,
                    value: 'created_at',
                },
                {text:'Time',value:'time'},
                { text: 'Medicine', value: 'item.description' },
                { text: 'Quantity', value: 'qty' },
                {text:'User',value:'user'}
            ],
        }
    },
    created(){
        this.init()
    },
    methods:{
        async fetchItem(code) {
            this.accessory.medicines_temp_list = [];
            if (code.length > 2) {
                await axios({
                    method: 'GET',
                    url: '/api/v1/inventory_system/item',
                    params: {search_text: code},
                }).then((response) => {
                    this.accessory.medicines_temp_list = response.data.data
                });
            }
        },
        add_medication(){
            if(this.accessory.medication.item===null)return
                this.formData.list.push(this.accessory.medication)
                this.accessory.medication = {
                    item: null,
                    time:"",
                    given:null,
                    date:moment().format("MMM Do YY, h:mm:ss a")
            }
        },
        async init(){
            this.load_medicines()
            this.load_data_in_system()
        },
        async load_medicines(){
            await axios.get('/api/v1/inventory_system/item/authorized_service/stork').then(response=>{
                this.accessory.avalaible_medicines=response.data
            })
        },
        async load_data_in_system(){
            await axios.get(`/api/v1/patient_system/in_patient/stork/show_medicine/${this.$route.params.admission_id}`).then(
                response=>{
                    this.accessory.data_in_system=response.data
                    this.accessory.data_in_system.forEach(data=>{
                        data.created_at= this.date_format(data.created_at)
                    })
                }
            )

        },
        nameWithCode ({ code, description }) {
            return `${code} — [${description}]`
        },
        submit(){
            this.formData.stork_admission_id= this.$route.params.admission_id
            this.formData.user = window.auth.user.name
            axios.post('/api/v1/patient_system/in_patient/stork/give_medicine',this.formData).then(()=>{
                this.load_data_in_system()
                this.formData.list=[]
            })

        },
        date_format(date){
            return moment(date).format("MMM Do YY");
        }
    }
}
</script>

<style scoped>
.title{
    font-weight: bold;
    color:#1390c6;
}
.table-title {
    background-color: #1390C6;
    color: white;
}
</style>
