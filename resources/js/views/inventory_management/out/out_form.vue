
<template>
   <div class="container-fluid">
       <v-app>
           <div>
               <form @submit.prevent="submit">
                   <div>
                       <h4 class="form_title">{{formData.code}}</h4>
                   </div>
                   <div class="row">
                       <div class="col">
                           <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" >
                               <ol class="breadcrumb">
                                   <li class="breadcrumb-item"><a href="#">Home</a></li>
                                   <li class="breadcrumb-item " aria-current="page">Order</li>
                                   <li class="breadcrumb-item active" aria-current="page">Out</li>
                               </ol>
                           </nav>
                       </div>
                       <div class="col d-flex justify-content-end ">
                           <button class="btn btn-sm" id="saveBtn" type="submit">
                               <div class="spinner-border text-info spinner-border-sm" role="status" v-if="accessory.submitting">
                                   <span class="sr-only">Loading...</span>
                               </div>
                               <span v-if="accessory.form_status==='new'">Save Order</span>
                               <span v-if="accessory.form_status==='edit'">Deliver</span>
                           </button>
                       </div>
                   </div>
                   <section class="header mt-2">
                       <div class="row">
                           <div class="col-6">
                               <div class="row">
                                   <div class="form-group col-6">
                                       <label>Orderer<span class="text-danger">*</span></label>
                                       <select class="form-control" v-model="formData.orderer_id" @change="fetchCollector">
                                           <option v-for="department in orderer_list" :value="department.id">{{department.name}}</option>
                                       </select>
                                       <div class="text-danger" v-if="$v.formData.orderer_id.$error.length">
                                           please choose a Orderer
                                       </div>

                                   </div>
                                   <div class="form-group col-6">
                                       <label>Collector<span class="text-danger">*</span></label>
                                       <select class="form-control" :disabled="formData.orderer_id===null" v-model="formData.collector_id">
                                           <option v-for="collector in accessory.collector_list" :value="collector.id">{{collector.name}}</option>
                                       </select>
                                       <!--                                <div class="text-danger" v-if="$v.formData.collector.$error.length">-->
                                       <!--                                    please choose a collector-->
                                       <!--                                </div>-->
                                   </div>
                               </div>
                           </div>
                           <div class="col-6">
                               <div class="row">
                                   <div class="form-group col-6">
                                       <label>Order Date<span class="text-danger">*</span></label>
                                       <input type="date" class="form-control" v-model="formData.order_date" @change="formData.code=order_code" :disabled="accessory.form_status==='edit'"/>
                                       <div class="text-danger" v-if="$v.formData.order_date.$error.length">
                                           please choose the date of order
                                       </div>
                                   </div>
                                   <div class="form-group col-6">
                                       <label>Due Date<span class="text-danger">*</span></label>
                                       <input type="date" class="form-control" v-model="formData.due_date"/>
                                   </div>
                               </div>

                           </div>
                       </div>
                   </section>
                   <section class="body mt-2">
                       <table class="table" id="out_details">
                           <thead>
                           <th colspan="2" style="width:60%">Item</th>
                           <th>Quantity in Stock</th>
                           <th>Quantity to order</th>
                           <th>Action</th>
                           </thead>
                           <tbody>
                           <tr v-for="(row,index) in formData.order_details">
                               <td colspan="2">
                                   <multiselect v-model="row.item" :id="'multiselect'+index" label="label"  track-by="description" class="multiSelect"
                                                placeholder="Type to search" open-direction="bottom" :options="accessory.temp_item_list"
                                                :searchable="true" :loading="accessory.search_loading" :internal-search="false" :clear-on-select="true"
                                                :close-on-select="true"  :limit="10"  :max-height="600" :min-width="400" :show-no-results="false"
                                                :hide-selected="true" @search-change="fetchCode">

                                   </multiselect>
                                   <!--                            <input type="text" class="form-control" :id="'label-'+index"  :value="row.item.label" v-if="accessory.form_status==='edit'"/>-->
                               </td>
                               <td>
                                   <input type="text" class="form-control" v-model="row.item.in_stock" readonly="true"/>
                               </td>
                               <td>
                                   <input type="number" class="form-control" v-model="row.quantity" @keydown.enter.prevent="checkStock(index)" @change="checkStock(index)"/>
                               </td>
                               <td>
                                   <button class="btn" type="button" @click.prevent="removeRow(index)">
                                       <font-awesome-icon icon="trash"/>
                                   </button>
                               </td>

                           </tr>
                           <tr>
                               <td colspan="5" style="text-align: center" >
                                   <div class="add_item_container">
                                       <button type="button" class="btn" @click.prevent="addRow()"><font-awesome-icon icon="shopping-cart" /> &nbsp Add an item</button>
                                   </div>
                               </td>
                           </tr>
                           </tbody>
                       </table>
                       <div class="row w-100">
                           <div class="col form-group">
                               <label>Notes</label>
                               <textarea class="form-control" rows="4" v-model="formData.remark"></textarea>
                           </div>
                       </div>
                   </section>
               </form>
               <v-dialog
                   v-model="accessory.error_dialog"
                   max-width="900"
                   persistent
               >
                   <v-card>
                       <v-card-title>
                           <v-alert
                               border="right"
                               colored-border
                               type="error"
                               elevation="2"
                           >
                               Inventory Error <small>(The elements below do not have enough stock)</small>
                           </v-alert>
                       </v-card-title>
                       <div class="table-responsive">
                           <table class="table table-sm">
                               <tr>
                                   <td>Id</td>
                                   <td>Description</td>
                                   <td>Difference</td>
                               </tr>
                               <tr v-for="row in accessory.low_stock_items">
                                   <td>{{row.item.id}}</td>
                                   <td>{{row.item.description}}</td>
                                   <td>{{row.diff}}</td>
                               </tr>
                           </table>
                       </div>
                       <v-card-text>

                       </v-card-text>

                       <v-card-actions>
                           <v-spacer></v-spacer>

                           <v-btn
                               color="green darken-1"
                               text
                               @click="reset_inventory_error_array"
                           >
                               Ok
                           </v-btn>
                       </v-card-actions>
                   </v-card>
               </v-dialog>

           </div>
       </v-app>
   </div>
</template>

<script>
import {mapGetters,mapActions} from "vuex";
import { validationMixin } from "vuelidate";
import {fetch_collectors} from "../../../store/modules/department/actions";
const {
    required,
    requiredIf,
    minLength,
    email,
    url,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "out_form",
    data(){
        return{
            formData:{
                id:'',
                code:'',
                order_date:null,
                due_date:null,
                orderer_id:null,
                collector:null,
                remark:null,
                order_details:[
                    {
                        item:[],
                        quantity:''
                    }
                ],
                storage_responsible_id:''
            },
            defaultData:{
                id:'',
                code:'',
                order_date:null,
                due_date:null,
                orderer_id:null,
                collector:null,
                remark:null,
                order_details:[
                    {
                        item:[],
                        quantity:''
                    }
                ]
            },
            accessory:{
                search_loading:false,
                collector_list:[],
                temp_item_list:[],
                submitting:false,
                errors:{
                    order_date:'',
                    department:'',
                    collector:''
                },
                form_status:'new',
                hide_multiselect_input:true,
                order_edit_no:'',
                low_stock_items:[],
                error_dialog:false
            }
        }
    },
    validations(){
        return{
            formData:{
                orderer_id:{required},
                order_date:{required}
            }
        }
    },
    created(){
        this.init()
    },
    methods:{
        ...mapActions('out_order',['new_out_order','edit_out_order','fetch_last_code']),
        async init(){
            this.fetch_last_code()
            //check form_status
            if(Object.keys(this.$route.params).length>0){
                this.accessory.form_status='edit'
               await this.fetch_edited_order()
            }

        },
        async fetchCode(code){
            this.accessory.item_list=[]
            this.accessory.search_loading=true
            await axios.get('/api/v1/inventory_system/item',{params:{search_text:code}})
            .then(response=>{
                let data= response.data.data

                data.forEach(item=>{
                    this.accessory.temp_item_list.push({
                        label:`[${item.code}] ${item.description}`,
                        description:item.description,
                        value:{
                            id:item.id,
                            code:item.code,
                            description:item.description,
                            in_stock: item.inventory !==null?item.inventory.general:0
                        }
                    })
                })
                this.accessory.search_loading=false
            })
        },
        async fetch_edited_order(){
            let src= await axios.get(`/api/v1/inventory_system/out/${this.$route.params.id}/edit`)
            this.populate_form(src.data)
        },
         fetchCollector(){
            axios.get('/api/v1/inventory_system/collector/'+this.formData.orderer_id).then(response=>this.accessory.collector_list=response.data)
        },
        addRow(){
            this.formData.order_details.push({item:[],quantity:''})
        },
        removeRow(index){
            this.formData.order_details.splice(index,1)
        },
        hide_text_input(i){
            document.getElementById('label-'+i).classList.add('d-none')
            document.getElementById('multiselect'+i).classList.remove('d-none')

        },
        checkStock(index){
            if(this.formData.order_details[index].quantity> this.formData.order_details[index].item.in_stock){
                alert("Not enough Stock! please check the inventory before proceeding")
                this.formData.order_details[index].quantity=''
            }
            if(this.formData.order_details[index].quantity<=0){
                alert('you must select a value above 0')
                this.formData.order_details[index].quantity=''
            }
        },
        async submit(){
            this.$v.formData.$touch();
            if (this.$v.$invalid) {
                return true;
            }
            //check the stock avalaibility
            this.formData.order_details.forEach((item,i)=>{
                if(item.quantity>item.item.in_stock){
                    this.accessory.low_stock_items.push({
                        item:item.item,
                        diff:item.item.in_stock-item.quantity
                    })
                    this.accessory.error_dialog=true
                }
            })
            //submit to the out_table
            if(this.accessory.low_stock_items.length===0){
                this.accessory.submitting=true
                this.accessory.form_status==='new'?await this.new_out_order(this.formData):await this.edit_out_order(this.formData)
                this.$swal('Data saved')
                this.resetForm()
                this.accessory.submitting=false
                this.$router.push({name:'out_list'})
            }


        },
        reset_inventory_error_array(){
            this.accessory.low_stock_items=[]
            this.accessory.error_dialog=false
        },
        resetForm(){
            this.formData= Object.assign({},this.defaultData)
            this.$v.$reset()
        },
        async populate_form(data){
            this.formData.id=data.id
            this.formData.order_date=data.created_at
            this.formData.due_date=data.due_date
            this.formData.code=data.code
            this.formData.orderer_id=data.orderer_id
            this.formData.storage_responsible_id=data.storage_responsible_id
            this.formData.remark=data.remark
            this.accessory.order_edit_no=data.code
            await this.fetchCollector()
            this.formData.collector_id=data.collector_id
            this.formData.order_details=[]
            data.out_details.forEach(detail=>{
                this.formData.order_details.push({
                    item:{
                        label:`[${detail.item.code}] ${detail.item.description}`,
                        code:detail.item.code,
                        description:detail.item.description,
                        id:detail.item.id,
                        in_stock:detail.item.inventory !==null?detail.item.inventory.general:0,
                    },
                    quantity:detail.quantity
                })
            })
        }
    },
    computed:{
        ...mapGetters('department',['department_list','orderer_list']),
        ...mapGetters('out_order',['last_code']),
        order_code(){
            return pad(this.last_code)
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
<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped>
.form_title{
    font-weight: bold;
}
#saveBtn{
    background-color:#6f42c1 !important ;
    color:white !important;
}
.header, .body{
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    padding: 20px;
}
.body{
    min-height:100vh;
}
.table-responsive{
    height:100% !important;
}
/*#out_details{*/
/*    height:100%;*/
/*}*/
.add_item_container button{
    color:#6f42c1 !important;
    background-color:#f2f3fa;
    width:100%;
}
</style>

