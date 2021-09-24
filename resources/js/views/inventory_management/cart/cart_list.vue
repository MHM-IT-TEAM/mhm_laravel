<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <h5 class="card-title">Shopping List</h5>
                    </div>
                    <div class="col-2 d-flex flex-row-reverse">
                        <button class="btn text-info" @click="$router.push({name:'cart_form'})"><font-awesome-icon icon="plus" class="fa-lg"/>&nbspNew</button>
                    </div>
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
                                    {{item.cart_details.length}}
                                  </span>
                            </td>
                            <td>{{item.created_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn  dropdown-toggle btn-sm" type="button" aria-haspopup="true"
                                            id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                                        <font-awesome-icon icon="ellipsis-h" size="lg" />
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <router-link
                                                class="dropdown-item"
                                                :to="{ name: 'cart_form', params: { id: item.id } }"
                                            >Edit</router-link
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
</template>

<script>
export default {
    name: "cart_list",
    data(){
        return{
           list:[]
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get('/api/v1/inventory_system/cart').then(response=>{
                this.list=response.data
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
                    axios.delete(`api/cart/${id}`)
                    this.$swal.fire('cart deleted', '', 'success')
                    this.list.splice(index,1)
                } else if (result.isDenied) {
                    this.$swal.fire('operation aborted', '', 'info')
                }
            })
        },
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
