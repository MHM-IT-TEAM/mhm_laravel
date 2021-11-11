<template>
    <div>
        <div class="d-flex align-items-end flex-column mb-4">
            <button @click="$router.push({name:'out_create'})">NEW ORDER</button>
        </div>
        <div class="row wrapper">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="card-title">Pending Order</h5>
                        </div>
                        <div class="col-6 d-flex align-items-end flex-column">
                            <button
                                type="button"
                                class="btn btn-sm btn-primary"
                                @click="setFilter('pending')"

                            >
                                Filter &nbsp
                                <font-awesome-icon icon="times" v-if="accessory.filter_status.pending" />
                                <font-awesome-icon
                                    icon="filter"
                                    v-if="!accessory.filter_status.pending"
                                />
                            </button>
                        </div>
                    </div>
                    <div class="table-responsible mt-2">
                        <table class="table" v-if="accessory.filter_status.pending">
                            <tr>
                                <td style="width:10%"><input type="text" placeholder="id" v-model="accessory.filter.pending_list.code" class="form-control"/></td>
                                <td><input type="date" v-model="accessory.filter.pending_list.created_at" class="form-control"/></td>
                                <td>
                                    <select v-model="accessory.filter.pending_list.orderer_id" class="form-control" @change="fetchCollector">
                                        <option v-for="depart in orderer_list" :value="depart.id.toString()">{{depart.name}}</option>
                                    </select>
                                </td>
                                <td>
                                    <select  v-model="accessory.filter.pending_list.collector_id" class="form-control" :disabled="accessory.collector_list.length<=0">
                                        <option v-for="collector in accessory.collector_list" :value="collector.id.toString()">{{collector.name}}</option>
                                    </select>
                                </td>
                                <td>*</td>
                            </tr>
                        </table>
                    </div>
                    <table class="table" id="pending_table">
                            <thead>
                                <th>Id</th>
                                <th>Date</th>
                                <th>Department</th>
                                <th>Collector</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr v-for="list in filtered_list.pending_result">
                                    <td>{{list.code}}</td>
                                    <td>{{list.created_at}}</td>
                                    <td>{{findDepartment(list.orderer_id)}}</td>
                                    <td>{{list.collector.name}}</td>
                                    <td>
                                        <div class="btn-group dropstart">
                                            <button
                                                type="button"
                                                class="btn"
                                                id="dropdownMenuOffset_1"
                                                data-toggle="dropdown"
                                            >
                                                <font-awesome-icon icon="ellipsis-h" size="lg" />
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuOffset_1">
                                                <li>
                                                    <router-link class="dropdown-item" :to="{name:'out_create',params:{id:list.id}}"><font-awesome-icon icon="edit"/>&nbsp Edit / Deliver</router-link>
                                                </li>
                                                <li><button class="dropdown-item" @click="delete_order(list.id)"><font-awesome-icon icon="trash"/>&nbsp Delete</button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <pagination v-if="filtered_list.pending_result.length>0"
                        v-model="accessory.current_page.pending"
                        :records="pending_pagination.total"
                        :per-page="pending_pagination.per_page"
                        @paginate="nextPage('pending')"
                    />
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="card-title">Delivered Order</h5>
                        </div>
                        <div class="col-6 d-flex align-items-end flex-column">
                            <button
                                type="button"
                                class="btn btn-sm btn-primary"
                                @click="setFilter('delivered')"

                            >
                                Filter &nbsp
                                <font-awesome-icon icon="times" v-if="accessory.filter_status.delivered" />
                                <font-awesome-icon
                                    icon="filter"
                                    v-if="!accessory.filter_status.delivered"
                                />
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="table-responsible mt-2">
                            <table class="table" v-if="accessory.filter_status.delivered">
                                <tr>
                                    <td style="width:10%"><input type="text" placeholder="id" v-model="accessory.filter.delivered_list.code" class="form-control"/></td>
                                    <td><input type="date" v-model="accessory.filter.delivered_list.created_at" class="form-control"/></td>
                                    <td>
                                        <select v-model="accessory.filter.delivered_list.orderer_id" class="form-control" @change="fetchCollector">
                                            <option v-for="depart in orderer_list" :value="depart.id.toString()">{{depart.name}}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select  v-model="accessory.filter.delivered_list.collector_id" class="form-control" :disabled="accessory.collector_list.length<=0">
                                            <option v-for="collector in accessory.collector_list" :value="collector.id.toString()">{{collector.name}}</option>
                                        </select>
                                    </td>
                                    <td>*</td>
                                </tr>
                            </table>
                        </div>
                        <table class="table" id="delivered_table">
                            <thead>
                            <th>Id</th>
                            <th>Date</th>
                            <th>Department</th>
                            <th>Collector</th>
                            <th></th>
                            </thead>
                            <tbody>
                            <tr v-for="list in filtered_list.delivered_result">
                                <td>{{list.code}}</td>
                                <td>{{list.created_at}}</td>
                                <td>{{findDepartment(list.orderer_id)}}</td>
                                <td>{{list.collector.name}}</td>
                                <td>
                                    <button
                                        class="btn btn-danger text-white btn-circle"
                                        @click="getPdf(list.id)"
                                    >
                                        <font-awesome-icon icon="file-pdf" />
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <pagination v-if="filtered_list.delivered_result.length>0"
                                    v-model="accessory.current_page.delivered"
                                    :records="filtered_list.delivered_result.length"
                                    :per-page="delivered_pagination.per_page"
                                    @paginate="nextPage('delivered')"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapActions, mapGetters} from 'vuex'
export default{
    name:'out_list',
    data(){
        return{
            pending_order:[],
            delivered_order:[],
            accessory:{
                current_page:{
                    pending:1,
                    delivered:1
                },
                filter:{
                    pending_list:{code:'',created_at:'',orderer_id:'',collector_id:''},
                    delivered_list: {code:'',created_at:'',orderer_id:'',collector_id:''},
                },
                filter_status:{
                    pending:false,
                    delivered:false
                },
                collector_list:[]
            },

        }
    },
    created(){
        this.fetch_orderers()
        this.pending_order=this.pending_list
        this.delivered_order=this.delivered_list
        this.fetch_out_order()
    },
    watch:{
        pending_list(val){
            this.pending_order=[]
            this.pending_order=val
        },
        delivered_list(val){
            this.delivered_order=[]
            this.delivered_order=val
        }
    },
    methods:{
        ...mapActions('out_order',['fetch_out_order','fetch_pending_order','fetch_delivered_order','delete_out_order']),
        ...mapActions('department',['fetch_orderers']),
        findDepartment(id){
            if(this.orderer_list.length>0)return this.orderer_list.find(depart=>depart.id===id).name
            else return ''

        },
        delete_item(id){

        },
        nextPage(type){
            type==='pending'? this.fetch_pending_order(this.accessory.current_page.pending):this.fetch_pending_order(this.accessory.current_page.delivered)
        },
        async fetchCollector(){
            await axios.get('/api/v1/inventory_system/collector/'+this.accessory.filter.pending_list.orderer_id).then(response=>this.accessory.collector_list=response.data)
        },
        setFilter(type){
            if(type==='pending')this.accessory.filter_status.pending=!this.accessory.filter_status.pending
            else this.accessory.filter_status.delivered=!this.accessory.filter_status.delivered
            if(this.accessory.filter_status.pending===false)this.accessory.filter.pending_list={}
            if(this.accessory.filter_status.delivered===false)this.accessory.filter.delivered_list={}
        },
        delete_order(id){
            this.$swal({
                title:'Are you sure you want to delete the order?',
                showDenyButton: true,
                confirmButtonText: `delete`,
                denyButtonText: `Don't delete`,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.delete_out_order(id)
                    this.$swal.fire('data deleted', '', 'success')
                } else if (result.isDenied) {
                    this.$swal.fire('operation aborted', '', 'info')
                }
            })
        },
        getPdf(id){
            window.location.href = `../pdf/delivered_out/${id}`;
        }
    },
    computed:{
        ...mapGetters('department',['orderer_list']),
        ...mapGetters('out_order',['delivered_list','delivered_pagination','pending_list','pending_pagination']),
        filtered_list() {
            let pending_filter = this.accessory.filter.pending_list;
            let delivered_filter = this.accessory.filter.delivered_list;
            const pending_keys = Object.keys(pending_filter);
            const delivered_keys = Object.keys(delivered_filter);
            let pending_result=this.pending_order.filter((item) => {
                return pending_keys.every((key) => {
                    if (!pending_filter[key].length) return true;
                    return item[key].toString().toLowerCase().includes(pending_filter[key].toString().toLowerCase())

                });
            });
            let delivered_result=this.delivered_order.filter((item) => {
                return delivered_keys.every((key) => {
                    if (!delivered_filter[key].length) return true;
                    return item[key].toString().toLowerCase().includes(delivered_filter[key].toString().toLowerCase())

                });
            });
            return {pending_result,delivered_result}
        },
    }
}
</script>
<style scoped>
.wrapper{
    display:grid;
    grid-template-columns: repeat(2,1fr);
    grid-column-gap: 10px;
}
.card{
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    min-height:75vh;
    height:75vh;
}
table  th{
    color:lightgrey !important;
}
.table-responsive{
    min-height:100% !important;
}
</style>
