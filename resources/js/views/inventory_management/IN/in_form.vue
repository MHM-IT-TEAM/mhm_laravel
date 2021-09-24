<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <h5 class="card-title">Item Entries: {{formData.code}}</h5>
                    </div>
                    <div class="col-6">
                           <h6 class="alert alert-success" v-if="accessory.operation_done">The inventory has been updated</h6>
                    </div>
                    <div class="col-2 d-flex flex-row-reverse justify-content-between">
                        <button class="btn btn-info text-white btn-circle" @click="validate">
                            <font-awesome-icon icon="check" class="fa-lg" />
                        </button>
                        <button class="btn add-btn" @click="accessory.add_item=true" v-if="!accessory.add_item"><font-awesome-icon icon="shopping-cart" class="fa-lg"/></button>
                        <button class="btn btn-warning text-white" @click="accessory.add_item=false" v-if="accessory.add_item"><font-awesome-icon icon="times" class="fa-lg"/></button>

                    </div>
                </div>
                <transition name="fade">
                    <div class="row mt-2" v-if="accessory.add_item">
                        <div class="col-8">
                            <multiselect v-model="accessory.search.item"  track-by="description" :id="'multiSelect'"
                                         placeholder="Type to search" open-direction="bottom" :options="accessory.temp_list"
                                         :searchable="true" :loading="accessory.search.loading" :internal-search="false" :clear-on-select="true"
                                         :close-on-select="true" options-limit="300" :limit="10" :limit-text="4" :max-height="600" :min-width="400" :show-no-results="false"
                                         :hide-selected="true" @search-change="fetchItem">

                            </multiselect>
                        </div>
                        <div class="col-2">
                            <input type="number" class="form-control" placehoder="quantity" v-model="accessory.search.quantity" @keypress.enter="add_item" />
                        </div>
                        <div class="col-2">
                            <button class="btn text-primary" @click="add_item"><font-awesome-icon icon="plus" class="fal-lg"/>&nbsp Add</button>
                        </div>
                    </div>
                </transition>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <th>#</th>
                        <th>code</th>
                        <th>Description</th>
                        <th style="width:10%">quantity</th>
                        <th></th>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in formData.details" :key="row.quantity">
                                <td>{{index}}</td>
                                <td>{{row.item.code}}</td>
                                <td>{{row.item.description}}</td>
                                <td>
                                    <input
                                        type="number"
                                        class="form-control"
                                        v-model="row.quantity"
                                    />
                                </td>
                                <td>
                                    <button class="btn" @click="remove_item(item,index)"><font-awesome-icon icon="trash"/></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="submit-container">
                    <button class="btn submit-btn" @click.prevent="submit" v-if="accessory.form_status==='new'">Submit</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "in_form",
    data(){
        return{
            formData:{
                details:[],
                code:'',
                id:'',
                status:'',
                created_at:''
            },
            accessory:{
                search:{
                    item:'',
                    loading:false,
                    quantity:''
                },
                temp_list:[],
                add_item:false,
                edit:false,
                form_status:null,
                operation_done:false
            }
        }
    },
    created(){
        this.init()
    },
    watch:{
        'accessory.edit':{
            handler(val){
                if(this.accessory.form_status==='edit')this.updateForm()
            },
            deep:true
        }
    },
    methods:{
        async init(){
            //if the form status is edit
            if(this.$route.params.id !==null && this.$route.params.id !==undefined ){
                this.formData.id=this.$route.params.id
                this.accessory.form_status='edit'
                await axios.get(`/api/v1/inventory_system/in/${this.$route.params.id}`)
                    .then(response=>{
                        this.formData.code=response.data.code
                        this.formData.details=response.data.in_detail
                        this.formData.created_at=response.data.created_at
                    })
            }else{
                this.accessory.form_status='new'
                this.fetch_last_code()
            }

        },
        async fetch_last_code(){
            let date= new Date()
            axios.get('/api/v1/inventory_system/in/lastCode').then(response=>{
                if(response.data.msg !=='no data')this.formData.code=this.pad(response.data)
                else this.formData.code='IN-'+date.getFullYear()+'-'+'00001'
            })
        },
        remove_item(item,index){
            this.formData.details.splice(index,1)
            this.accessory.edit=true
        },
        async fetchItem(code){
            this.accessory.search.temp_list=[]
            this.accessory.search.loading=true
            await axios.get('/api/v1/inventory_system/item',{params:{search_text:code}})
                .then(response=>{
                    let data= response.data.data
                    data.forEach(item=>{
                        this.accessory.temp_list.push({
                            label:`[${item.code}] ${item.description}`,
                            description:item.description,
                            value:{
                                id:item.id,
                                code:item.code,
                                description:item.description,
                            }
                        })
                    })
                    this.accessory.search.loading=false
                })
        },
        add_item(){
            if(this.accessory.search.item !=='' && this.accessory.search.quantity !==''){
                this.formData.details.push({
                    item:{
                        id:this.accessory.search.item.id,
                        code:this.accessory.search.item.code,
                        description:this.accessory.search.item.description,
                    },
                    quantity:this.accessory.search.quantity
                })
                this.accessory.search.item=''
                this.accessory.search.quantity=''
                this.accessory.edit=true
            }
        },
        async updateForm(){
            this.formData.status=2
            await axios.put(`/api/v1/inventory_system/in/${this.formData.id}`,this.formData)
                .then(response=>{
                    this.$wkToast('Data saved');
                })
            this.accessory.edit=false
        },
        async submit(){
            await axios.post('/api/v1/inventory_system/in',{code:this.formData.code,details:this.formData.details,status:1})
                .then(response=>{
                    this.$swal('data submitted')
                    this.$router.push({name:'in_list'})
                })
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
            return 'IN-'+date.getFullYear()+'-'+zero+intPart
        },
        async validate(){
            let self=this
            await axios.patch(`/api/v1/inventory_system/in/validate/${this.formData.id}`,this.formData).then(response=>{
                if(response.data.success){
                    setTimeout(()=>{self.accessory.operation_done=true})
                    setTimeout(()=>{self.$router.push({name:'in_list'})},1000)
                }
            })
        }
    }
}
</script>

<style scoped>
.container{
    height:100%;
}
.card{
    height:100%;
}
.card-title{
    color:#e47911;
}
.add-btn{
    background-color: #e47911;
    position:relative;
    color:white;
    border-radius: 50%;
    line-height: 45px;
    width:47px;
    height:45px;
    text-align: center !important;
    vertical-align: middle !important;
    padding:0;
}
.fa-lg{
    padding-bottom: 1px;
    padding-right:2px;
}
table thead{
    color:#577178;
}
.submit-container{
    position:absolute;
    right:15px;
    bottom:5px;
}
.submit-btn{
    background-color: #e47911;
    color:white;
}
.btn-circle {
    width: 47px;
    height: 47px;
    padding: 6px 0px;
    border-radius: 25px;
    text-align: center;
    font-size: 16px;
    line-height: 1.42857;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity .7s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
