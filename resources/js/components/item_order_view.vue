<template>
    <div class="container">
        <h2 class="text-center title"> Order for medicines & consumables [{{get_orderer_name}}-{{order_code}}]</h2>
        <div class="border table-container position-relative">
            <div class="form-group col-3">
                <label>Collector</label>
                <select class="form-control" :class="{'is-invalid':$v.formData.collector_id.$error}" v-model="formData.collector_id">
                    <option v-for="collector in accessory.collectors" :value="collector.id">{{collector.name}}</option>
                </select>
                <div class="invalid-feedback" v-if="$v.formData.collector_id.$error">
                    You must choose a collector.
                </div>
            </div>
            <table class="table table-sm table-borderless" id="out_details">
                <thead>
                <th colspan="2" style="width:60%">Item</th>
                <th>Quantity in Stock</th>
                <th>Quantity to order</th>
                </thead>
                <tbody>
                <tr v-for="(line,i) in formData.order_details" v-if="formData.order_details.length>0">
                    <td colspan="2">
                        [ &nbsp {{line.item.code}} &nbsp] {{line.item.description}}
                    </td>
                    <td>
                        {{line.item.inventory[get_orderer_name]}}
                    </td>
                    <td>
                        {{line.quantity}}
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="remark p-2">
                <div class="form-group">
                    <label>Remark</label>
                    <textarea class="form-control" v-model="formData.remark"/>
                </div>
            </div>
            <div class="text-right position-absolute submit-container">
                <v-btn
                    @click="submit"
                    :color="accessory.form_submitted ? 'success' : 'warning'"
                    x-small
                    v-if="!accessory.form_submitted"
                    :loading="accessory.form_is_submitting"
                >
                    Submit
                </v-btn>
                <v-chip
                    class="ma-2"
                    color="green"
                    text-color="white"
                    v-if="accessory.form_submitted"
                >
                    Submitted
                </v-chip>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters,mapActions} from "vuex";
import { validationMixin } from "vuelidate";
const {
    required,
    requiredIf,
    minLength,
    email,
    url,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "item_order",
    props:['orderer_id','is_overview','data_src'],
    mixins: [validationMixin],
    data(){
        return{
            formData:{
                orderer_id:'',
                order_details:[],
                remark:'',
                collector_id:''
            },
            accessory:{
                line:{
                    item:{inventory:{}},
                    quantity:'',
                },
                medicines_temp_list: [],
                form_is_submitting: false,
                form_submitted:false,
                collectors:[]
            }
        }
    },
    validations:{
        formData:{
            collector_id:{required}
        }
    },
    created(){
        this.formData.orderer_id=this.orderer_id
        this.fetch_departments()
        this.fetch_orderers()
        this.get_collector()
        this.fetch_last_code()
        this.get_data()
    },
    methods:{
        ...mapActions('department',['fetch_orderers','fetch_departments']),
        ...mapActions('out_order',['new_out_order','edit_out_order','fetch_last_code']),
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
        get_data(){

        },
        get_collector(){
            axios.get(`/api/v1/inventory_system/collector/${this.orderer_id}`).then(response=>{
                this.accessory.collectors=response.data
                if(this.accessory.collectors.length===1) this.formData.collector_id= this.accessory.collectors[0].id
            })

        }


    },
    computed:{
        ...mapGetters('out_order',['last_code']),
        ...mapGetters('department',['orderer_list']),
        order_code(){
            return pad(this.last_code)
        },
        get_orderer_name(){
            if(this.orderer_list.length>0){
                return this.orderer_list.find(orderer=>orderer.id===this.orderer_id).name
            }else{
                return ''
            }

        }
    }
}
function pad(code){
    let date =new Date()
    if(code.length===0)return 'OUT-'+date.getFullYear()+'-00001'
    //code should follow the format OUT-2021-00001
    let intPart= parseInt(code.split('-')[2])
    intPart++
    let zero=''
    let intPart_length= intPart.toString().length
    for(let i=0;i<5-intPart_length;i++){
        zero+='0'
    }
    return 'OUT-'+date.getFullYear()+'-'+zero+intPart
}
</script>

<style scoped>
.title{
    color:white;
    background-color: #1390C6;
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
.table-container{
    min-height: 90vh;
}
.submit-container{
    bottom:10px;
    right:10px;
}
</style>
