<template>
<div class="item-wrapper">
    <div class="card">
       <div class="card-body">
           <h5 class="card-title"> Items</h5>
            <div class="list-group">
                <div class="list-group-item border-0">
                    <div class="row">
                        <div class="col">
                           <font-awesome-icon icon="pills" size="lg"></font-awesome-icon> Medicines:
                        </div>
                        <div class="col">
                            <div class="float-end" ><span class="badge badge-sm bg-primary mr-0">{{item_type_count.medicines}}</span></div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item border-0">
                    <div class="row">
                        <div class="col">
                            <font-awesome-icon icon="spray-can" size="lg"></font-awesome-icon> Consumables:
                        </div>
                        <div class="col">
                            <div class="float-end"><span class="badge badge-sm bg-warning mr-0">{{item_type_count.consummables}}</span></div>
                        </div>
                    </div>

                </div>
                <div class="list-group-item border-0">
                    <div class="row">
                        <div class="col">
                            <font-awesome-icon icon="tools" size="lg"></font-awesome-icon> Equipments:
                        </div>
                        <div class="col">
                            <div class="float-end"><span class="badge badge-sm bg-info mr-0">{{item_type_count.equipments}}</span></div>
                        </div>
                    </div>

                </div>
            </div>
       </div>
    </div>
    <div class="card  low-stock">
        <div class="card-body">
            <h5 class="card-title"> Low Stock</h5>
            <div class="list-group">
                <div class="list-group-item border-0">
                    <div class="row">
                        <div class="col">
                            <font-awesome-icon icon="pills" size="lg"></font-awesome-icon> Medicines:
                        </div>
                        <div class="col ">
                            <div class="float-end"><router-link :to="{name:'low_stock',params:{type:1}}" class="btn"><span class="badge badge-sm bg-primary mr-0">{{low_stock.medicines}}</span></router-link></div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item border-0">
                    <div class="row">
                        <div class="col">
                            <font-awesome-icon icon="spray-can" size="lg"></font-awesome-icon> Consumables:
                        </div>
                        <div class="col ">
                            <div class="float-end"><router-link :to="{name:'low_stock',params:{type:2}}" class="btn"> <span class="badge badge-sm bg-warning mr-0">{{low_stock.consumables}}</span></router-link></div>
                        </div>
                    </div>

                </div>
                <div class="list-group-item border-0">
                    <div class="row">
                        <div class="col">
                            <font-awesome-icon icon="tools" size="lg"></font-awesome-icon> Equipments:
                        </div>
                        <div class="col ">
                            <div class="float-end"><span class="badge badge-sm bg-info mr-0">{{low_stock.equipments}}</span></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="card overflow-auto order">
        <div class="card-body">
            <h5 class="card-title"> Pending Out Orders</h5>
            <div class="list-group border-0">
                <div class="list-group-item" v-for="row in pending_list">
                    <div class="row">
                        <div class="col">
                            <router-link :to="{name:'out_create', params:{id:row.id}}" class="dropdown-item"><span class="badge bg-primary text-white rounded-circle">{{sigle(findDepartment(row.orderer_id))}}</span>
                            <span class="m-2 text-warning text-bold" >{{findDepartment(row.orderer_id)}}</span></router-link>
                        </div>
                        <div class="col">
                            <div class="float-end">{{row.out_details.length}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="card overflow-auto">-->
<!--        <div class="card-body">-->
<!--            <h5 class="card-title">Item location</h5>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="card overflow-auto">-->
<!--        <div class="card-body">-->
<!--            <h5 class="card-title">Orderers</h5>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="card overflow-auto">-->
<!--        <div class="card-body">-->
<!--            <h5 class="card-title">Suppliers</h5>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="card overflow-auto">-->
<!--        <div class="card-body">-->
<!--            <h5 class="card-title">Orderers</h5>-->
<!--        </div>-->
<!--    </div>-->
</div>
</template>

<script>
import {mapGetters,mapActions} from "vuex";

export default {
    name: "inventory_dashboard",
    data(){
        return{
            item_type_count:{}
        }
    },
    created(){
       this.init()
    },
    methods:{
        ...mapActions('low_stock',['fetch_low_stock_list']),
        ...mapActions('item',['fetch_count_per_type']),
        ...mapActions('department',['fetch_orderers']),
        async init(){
            await this.fetch_low_stock_list()
            await this.fetch_count_per_type()
            await this.fetch_orderers()
            this.item_type_count= {...this.count_per_type}
        },
        findDepartment(id){

            if(this.orderer_list.length>0){
                let filter=this.orderer_list.find(depart=>depart.id===id)
                return filter.name
            }else return ''
        },
        sigle(text){
            return text.charAt(0).toUpperCase()
        },
    },
    computed:{
        ...mapGetters('item',['count_per_type']),
        ...mapGetters('low_stock',['low_stock_list']),
        ...mapGetters('department',['department_list','orderer_list']),
        ...mapGetters('out_order',['pending_list']),

        low_stock(){
            return {
                medicines:this.low_stock_list.medicines.length,
                consumables:this.low_stock_list.consumables.length,
                equipment:this.low_stock_list.equipments.length,
            }
        }
    },
}
</script>

<style scoped>
.item-wrapper{
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    grid-template-rows: repeat(auto-fit,1fr);
    grid-column-gap: 25px;
}
.card-body{
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23) !important;
}
.order{
    max-height: 250px;
}

</style>
