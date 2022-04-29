<template>
    <div class="container">
        <v-card>
            <v-card-text>
                <h1 class="title">MEDICAL PRESCRIPTION</h1>
                <patient_information patient_id="10900"/>
                <table class="table table-sm mt-2">
                    <tr>
                        <td style="width:15%">
                           {{moment().format("MMM Do YY")}}
                        </td>
                        <td>
                            <multiselect
                                v-model="accessory.medication.item"
                                label="description"
                                track-by="description"
                                :id="'multiSelect'"
                                open-direction="above"
                                :options="accessory.medicines_temp_list"
                                :searchable="true"
                                :internal-search="false"
                                :clear-on-select="true"
                                :close-on-select="true"
                                :show-no-results="false"
                                :hide-selected="true"
                                @search-change="fetchItem"
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
                            {{row.item.description}}
                        </td>
                        <td>{{row.given}}</td>
                    </tr>
                </table>
                <button class="btn btn-sm btn-primary mr-0">Submit</button>
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
                    date:moment().format("MMM Do YY, h:mm:ss a")
                },
                medicines_temp_list: [],
            },
        }
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
                    given:null,
                    date:moment().format("MMM Do YY, h:mm:ss a")
            }
        },
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
