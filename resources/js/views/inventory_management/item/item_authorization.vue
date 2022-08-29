<template>
    <div class="container">
        <div class="input-group mb-4">
            <input type="text" class="form-control" v-model="search_text" @keyup="search"/>
            <span class="input-group-text"><font-awesome-icon icon="search"/></span>
        </div>
        <div class="table-responsive">
            <table class="table table-sm" id="item_table">
                <tr>
                    <td>Code</td>
                    <td>Description</td>
                    <td v-for="orderer in orderer_list">{{orderer.name}}</td>
                </tr>
                <tr v-for="(item,index) in items">
                    <td>{{item.code}}</td>
                    <td>{{item.description}}</td>
                    <td v-for="orderer in orderer_list">
                        <input type="checkbox" @change="update_item(item,orderer)" v-model="item[orderer.name]"/>
                    </td>
                </tr>
            </table>
        </div>
        <pagination v-if="items.length>0"
                    v-model="accessory.pages.active"
                    :records="accessory.total"
                    :per-page="accessory.perPage"
                    @paginate="fetchData"
        />
    </div>
</template>

<script>
import {mapActions,mapGetters} from 'vuex';
export default {
    name: "item_authorization",
    data(){
        return{
            search_text:'',
            search_timeout: '',
            items:[],
            accessory:{
                current_page: "",
                perPage: "",
                from: "",
                to: "",
                total: "",
                pages: {
                    active: 1,
                    list: [],
                },
                sortBy:'',
                sortDir:1,
                category_filter:{id:'', name:'All'},
            }
        }
    },
    created(){
        this.fetch_orderers()
    },
    methods:{
        ...mapActions('department',['fetch_orderers']),
        ...mapActions('item',['fetch_items_list']),
        async search(){
            clearTimeout(this.search_timeout)
            let self=this
            this.search_timeout= setTimeout(()=>{this.fetchData()},1000)
        },
        async fetchData() {
            axios
                .get("/api/v1/inventory_system/item?page=" + this.accessory.pages.active,{params:{category:this.accessory.category_filter.id,search_text:this.search_text}})
                .then((response) => {
                    this.items = response.data.data;
                    this.accessory.current_page = response.data.current_page;
                    this.accessory.from = response.data.from;
                    this.accessory.to = response.data.to;
                    this.accessory.total = response.data.total;
                    this.accessory.perPage = response.data.per_page;
                });
        },
        update_item(item,orderer){
                let formData={
                    item:item,
                    orderer:orderer
                }
                axios.post('/api/v1/inventory_system/item/update_auth',formData)
        }

    },
    computed:{
        ...mapGetters('department',['orderer_list']),
    }
}
</script>

<style scoped>
#item_table td{
    font-size: 10px;
}
#item_table th {
    color: lightsteelblue !important;
    font-size: 11px;
}
</style>
