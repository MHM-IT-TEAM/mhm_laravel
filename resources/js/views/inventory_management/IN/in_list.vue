<template>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h5 class="card-title">Pending Entry list <font-awesome-icon icon="dolly-flatbed"/></h5>
                            </div>
<!--                            <div class="col-2 d-flex flex-row-reverse">-->
<!--                                <button class="btn text-info" @click="$router.push({name:'cart_form'})"><font-awesome-icon icon="plus" class="fa-lg"/>&nbspNew</button>-->
<!--                            </div>-->
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <th>#</th>
                                <th>Code</th>
                                <th>Date</th>
                                <th>*</th>
                                </thead>
                                <tbody>
                                <tr v-for="(item,index) in list">
                                    <td>{{index}}</td>
                                    <td>
                                        {{item.code}}
                                        <span class="ml-2 badge rounded-pill bg-danger">
                                            {{item.in_detail.length}}
                                        </span>
                                    </td>
                                    <td>{{item.created_at}}</td>
                                    <td>
                                        <div class="dropdown me-1">
                                            <button
                                                type="button"
                                                class="btn"
                                                id="dropdownMenuOffset"
                                                data-toggle="dropdown"
                                                aria-expanded="false"
                                                data-bs-offset="10,20"
                                            >
                                                <font-awesome-icon icon="ellipsis-h" size="lg" />
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                                <li>
                                                    <router-link
                                                        class="dropdown-item"
                                                        :to="{ name: 'in_form', params: { id: item.id } }"
                                                    >Edit/register</router-link
                                                    >
                                                </li>
                                                <li><a class="dropdown-item" href="#" @click="delete_item(item.id,index)">Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h5> Registered Entry Documents</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>*</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in registered_list">
                                        <td>{{item.code}}&nbsp<span class="ml-2 badge rounded-pill bg-success">
                                            {{item.in_detail.length}}
                                        </span></td>
                                        <td>{{item.created_at}}</td>
                                        <td>
                                            <button
                                                class="btn btn-danger text-white btn-circle"
                                                @click="getPdf(item.id)"
                                            >
                                                <font-awesome-icon icon="file-pdf" />
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "cart_list",
    data(){
        return{
            list:[],
            registered_list:[]
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get('/api/v1/inventory_system/in').then(response=>{
                response.data.forEach(item=>{
                    parseInt(item.status)===1?this.list.push(item):this.registered_list.push(item)
                })
            })
        },
        delete_item(id,index){
            this.$swal({
                title:'Are you sure you want to delete the order?',
                showDenyButton: true,
                confirmButtonText: `delete`,
                denyButtonText: `Don't delete`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`api/v1/inventory_system/cart/${id}`)
                    this.$swal.fire('cart deleted', '', 'success')
                    this.list.splice(index,1)
                } else if (result.isDenied) {
                    this.$swal.fire('operation aborted', '', 'info')
                }
            })
        },
        getPdf(id){
            window.location.href = `../pdf/stock_entry/${id}`;
        }
    },

}
</script>

<style scoped>
.card{
    height:90vh;
}
.table-responsive{
    height:100% !important;
}
.card-title{
    color:#e47911;
}
</style>
