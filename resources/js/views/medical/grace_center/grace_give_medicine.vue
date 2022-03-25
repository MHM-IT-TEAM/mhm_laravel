<template>
    <div class="container">
     <v-app>
         <patient_information :patient_id="formData.transaction.admission.patient_id"/>
         <h5 class="title pl-2"><v-icon class="text-white" >mdi-stethoscope</v-icon> &nbsp B) Today's action</h5>
         <div class="table-responsive border">
             <table class="table table-sm table-borderless">
                <tr>
                    <th>Medicine</th>
                    <th>Morning</th>
                    <th>Noon</th>
                    <th>Evening</th>
                    <th>To give</th>
                    <th>Given</th>
                </tr>
                 <tr v-for="(line,i) in formData.transaction.grace_csb_transaction_detail">
                     <td>
<!--                         [ &nbsp {{line.item.code}} &nbsp] {{line.item.description}}-->
                         <multiselect
                             v-model="line.item"
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
                             @search-change="fetchMedicine"
                             class="multiSelect"
                             autocomplete="off"
                             :disabled="formData.transaction.done===1"
                         >
                         </multiselect>
                     </td>
                     <td>{{line.breakfast}}</td>
                     <td>{{line.lunch}}</td>
                     <td>{{line.dinner}}</td>
                     <td>{{line.to_give}}</td>
                     <td>
                         <input type="number" class="form-control form-control-sm" v-model="line.given" :readonly="formData.transaction.done===1" @change="check_given(i)"/>
                     </td>
                 </tr>
                 <tr>
                     <td>Remark</td>
                 </tr>
                 <tr>
                     <td colspan="6">
                         <textarea class="form-control form-control-sm" v-model="formData.remark" :readonly="formData.transaction.done===1"/>
                     </td>
                 </tr>
             </table>
             <div class="text-right">
                 <v-btn
                     @click="submit"
                     color="warning"
                     x-small
                     :disabled="accessory.form_submitted || formData.transaction.done===1 || accessory.error"
                 >
                     <span v-if="!accessory.form_submitted">Submit</span>
                     <span v-if="accessory.form_submitted">Submitted</span>
                 </v-btn>
             </div>
         </div>
     </v-app>
    </div>
</template>

<script>
import Patient_information from "../../../components/patient_information";
export default {
    name: "grace_give_medicine",
    components: {Patient_information},
    data(){
        return{
            formData:{
                transaction:null,
                remark:''
            },
            accessory:{
                form_submitted:false,
                medicines_temp_list: [],
                error:false
            }
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            if(this.$route.params.transaction){
                this.formData.transaction=this.$route.params.transaction
            }
        },
        async submit(){
            await axios.post('/api/v1/patient_system/grace_center/store',this.formData).then(response=>{
                if(response.data.success){
                    this.accessory.form_submitted= !! response.data.success
                    this.$toast.open({
                        message: `data successfully saved `,
                        position: "top-right",
                    });
                }else{
                    let items=''
                    response.data.low_stock_items.forEach(item=>{
                        items += item.item.description+ ", "
                    })
                    this.$toast.open({
                        message: ` the items ${items} do not have enough stock ! `,
                        position: "top-right",
                        type:'error'
                    });
                    this.accessory.error=true
                }
            })
        },
        async fetchMedicine(code) {
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
        check_given(i){
            if(parseInt(this.formData.transaction.grace_csb_transaction_detail[i].given)>parseInt(this.formData.transaction.grace_csb_transaction_detail[i].to_give)){
                this.$toast.open({position: 'top-right', type: 'error', message: "The quantity should not exceed the prescribed medicine"})
                this.formData.transaction.grace_csb_transaction_detail[i].given=''
            }
        }

    }
}
</script>

<style scoped>
.title{
    color:white;
    background-color: #1390C6;
    font-size: 13px !important;
    font-weight:bold;
}
.subtitle{
    color:#1390C6;
    font-weight: bold;
}
.btn{
    color:white;
    background-color: #1390C6;
}
.result{
    width:50px;
}
.form-title{
    font-family: 'Enriqueta', arial, serif;
    line-height: 1.25;
    margin: 0 0 10px; font-size: 40px;
    font-weight: bold;
    color: #7c795d;
}
</style>
