<template>
    <div>
        <div class="row list-wrapper">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="item-list">Low Stock {{accessory.form_type}}</h4>
                            </div>
<!--                            <div class="col-3">-->
<!--                                <select class="form-control form-control-sm" v-model="accessory.filter_type">-->
<!--                                    <option value="">Filter</option>-->
<!--                                    <option value="1">Medicines</option>-->
<!--                                    <option value="2">Consumables</option>-->
<!--                                    <option value="3">Equipments</option>-->
<!--                                </select>-->
<!--                            </div>-->
                            <div class="col-6">
                                <input type="text"  placeholder="search here" class="filter_input" v-model="accessory.filter_search" />
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Min Stock</th>
                                <th>Avalaible</th>
                                <th>*</th>
                                </thead>
                                <tbody>
                                <tr v-for="(item,index) in filtered_list" :class="{'text-white bg-success':item.selected}">
                                    <td>{{item.code}}</td>
                                    <td>{{item.description}}</td>
                                    <td>{{item.minStock}}</td>
                                    <td>{{item.avalaible}}</td>
                                    <td>

                                        <button class="btn text-warning" @click="select_item(item,index)" v-if="!item.selected"><font-awesome-icon icon="plus"></font-awesome-icon></button>
                                        <span v-if="item.selected"><font-awesome-icon icon="check"></font-awesome-icon></span>
                                        <button class="btn text-danger" @click="deselect_item(item,index)" v-if="item.selected"><font-awesome-icon icon="times"></font-awesome-icon></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-container" v-if="filtered_list.length>0">
                            <pagination
                                v-model="accessory.pagination.current_page"
                                :records="accessory.pagination.total"
                                :per-page="accessory.pagination.per_page"
                                @paginate="fetch_low_stock"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title shopping-list">Shopping List &nbsp {{code}}</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>code</th>
                                    <th>Description</th>
                                    <th>quantity</th>
                                    <th>*</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in cart">
                                        <td>{{index}}</td>
                                        <td>{{item.item.code}}</td>
                                        <td>{{item.item.description}}</td>
                                        <td><input type="number" v-model="item.quantity" class="item-qty" /></td>
                                        <td>
                                            <button class="btn text-danger btn-sm" @click="cart_unselect(item.item,index)"><font-awesome-icon icon="times"/></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="validate">
                            <button class="btn btn-sm validate-btn" @click="validate">Validate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters,mapActions} from 'vuex'
export default {
    name: "low_stock",
    data(){
        return{
            list:[],
            cart:[],
            code:'',
            accessory:{
                filter_type:'',
                filter_search:'',
                pagination:{
                    current_page:1,
                    total:0,
                    per_page:0
                },
                form_type:''
            },

        }
    },
    created(){
        this.init()
    },
    watch:{
        filtered_list(val){return val}
    },
    methods:{
        ...mapActions('low_stock',['fetch_low_stock_list']),
        async init(){
            this.accessory.form_type=parseInt(this.$route.params.type)===1?'Medicines':'Consumables'
            // await axios.get(`/api/low_stock/${this.$route.params.type}`).then(response=>this.populate_data(response))
            if(parseInt(this.$route.params.type)===1){
                this.list= Object.assign([],[...this.low_stock_medicines])
            }else{
                this.list=Object.assign([],[...this.low_stock_consumables])
            }
            this.fetch_last_code()
          this.list.forEach(list=>list.selected=false)
        },
        async fetch_last_code(){
            let date= new Date()
            axios.get('/api/v1/inventory_system/cart/lastCode').then(response=>{
                if(response.data.msg !=='no data')this.code=this.pad(response.data)
                else this.code='SHOP-'+date.getFullYear()+'-'+'00001'
            })
        },
        populate_data(response){
            this.list=response.data.data
            this.accessory.pagination={
                current_page:response.data.current_page,
                total:response.data.total,
                per_page:response.data.per_page
            }
            this.list.forEach(src=>{
                let check=this.cart.findIndex(x=>x.item.id===src.id)
                check!==-1?src.selected=true:''
            })

        },
        async select_item(item,index){
            const {value:quantity}= await this.$swal({
                title: 'Enter the quantity to be ordered',
                input: 'text',
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to write the quantity'
                    }
                }
            })
            let check=this.cart.findIndex(row=>row.item.id===item.id)
            if(check !==-1)this.$swal('the item is already Chosen')
            if(quantity){
                this.cart.push({item,quantity:quantity})
                this.list[index].selected=true
            }
        },
        async deselect_item(item,index){
            this.list[index].selected=false
            let cart_index =this.cart.findIndex(list=>list.item.id===item.id)
            cart_index!==-1?this.cart.splice(cart_index,1):''
        },
        async cart_unselect(item,index){
            this.cart.splice(index,1)
            let list_index= this.list.findIndex(i=>i.id===item.id)
            list_index!==-1?this.list[list_index].selected=false:''
        },
        async fetch_low_stock(){
            await axios.get(`/api/v1/inventory_system/item/low_stock/${this.$route.params.type}?page=`+this.accessory.pagination.current_page).then(response=>this.populate_data(response))
        },
        async validate(){
            await axios.post('/api/v1/inventory_system/cart',{code:this.code,details:this.cart,status:1})
            .then(response=>response.data.success===true?this.$router.push({name:'cart_list'}):true)
        },
        pad(code){
            let date =new Date()
            let intPart= parseInt(code.split('-')[2])
            intPart++
            let zero=''
            let intPart_length= intPart.toString().length
            for(let i=0;i<5-intPart_length;i++){
                zero+='0'
            }
            return 'SHOP-'+date.getFullYear()+'-'+zero+intPart
        }
    },
    computed:{
        ...mapGetters('low_stock',['low_stock_medicines','low_stock_consumables']),
        filtered_list(){
            return this.list.filter(item=>item.description.toLowerCase().includes(this.accessory.filter_search.toLowerCase()))
        }
    }
}
</script>

<style scoped>
.list-wrapper{
    height:90vh
}
.card{
    height:90%;
}
.shopping-list{
    color:#e47911;
}
.item-list{
    color:#147891;
}
table thead{
    color:#577178;
}
.validate, .pagination-container{
    position:absolute;
    bottom: 5px;
    right:5px;
}
.validate-btn{
    background-color:#6f42c1 !important ;
    color:white !important;
}
.item-qty{
    width:45px;
    border:none;
    padding:0
}
.filter_input{
    border: none;
    border-bottom: 1px solid #CCC;
    background-color: transparent;
    width:100%;
    outline:none;
}
.filter_input:hover{
    border-bottom: 1px solid #28a2a2;
}
</style>
