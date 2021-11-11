<template>
  <div class="container-fluid">
    <div v-if="accessory.row_update">
        <p class="alert alert-success">data updated</p>
    </div>
    <div class="row">
      <div class="col-2 d-md-none d-sm-none">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Item</li>
          </ol>
        </nav>
      </div>
        <div class="col-lg-8 col-sm-4 ">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{accessory.category_filter.name}}</button>
                    <ul class="dropdown-menu">
                        <li v-for="type in item_type">
                            <button type="button" class="dropdown-item btn btn-outline-primary" @click="setFilter(type)">{{type.name}}</button>
                        </li>
                    </ul>
                </div>
                <input type="text" class="form-control" v-model="accessory.search_text" @keyup="search"/>
                <span class="input-group-text"><font-awesome-icon icon="search"/></span>
            </div>
        </div>
      <div class="col-lg-2 col-sm-4">
        <div class="d-flex justify-content-end">
          <div class="d-inline-block btn-container">
            <button
              type="button"
              class="btn btn-sm btn-primary"
              @click="filter_table"
            >
              Filter &nbsp
              <font-awesome-icon icon="times" v-if="accessory.filter_status" />
              <font-awesome-icon
                icon="filter"
                v-if="!accessory.filter_status"
              />
            </button>
          </div>
          <div class="d-inline-block" v-if="is_admin">
            <button type="button" class="btn btn-sm btn-primary">
              <font-awesome-icon icon="plus" /><router-link
                to="create"
                class="text-white text-decoration-none"
                >&nbsp Add Item</router-link
              >
            </button>
          </div>
        </div>
      </div>
    </div>
    <transition name="fade">
        <div class="row filter mt-2" v-if="accessory.filter_status">
            <div class="form-group col-4">
                <label>Code</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="accessory.filter.code"
                />
            </div>
            <div class="form-group col-4">
                <label>Name</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="accessory.filter.description"
                />
            </div>
            <div class="form-group col-4">
                <label>Type</label>
                <select
                    class="form-control form-control-sm"
                    v-model="accessory.filter.type"
                >
                    <option v-for="type in item_type" :value="type.name">{{type.name}}</option>
                </select>
            </div>
        </div>
    </transition>
    <div class="table-responsive mt-4">
        <div class="row float-end">
            <div class="col">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" v-if="accessory.all_checked">
                        Action
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><button class="dropdown-item" @click="accessory.delete_modal=!accessory.delete_modal">Delete</button></li>
                    </ul>
                </div>
            </div>
        </div>
      <table class="table" id="item_table">
        <thead>
          <th style="width: 10%" @click="sort('code','desc')">Code</th>
          <th @click="sort('description','desc')" style="width: 15%">Description</th>
          <th @click="sort('type','desc')" style="width:5%">Type</th>
          <th style="width:5%">Unit</th>
          <th style="width:5%" v-if="is_admin">General</th>
          <th style="width:5%" v-if="is_admin || orderer_id===1">Grace</th>
          <th style="width:5%"v-if="is_admin || orderer_id===2">Stork</th>
          <th style="width:5%"v-if="is_admin || orderer_id===3">Block</th>
          <th style="width:5%"v-if="is_admin || orderer_id===4">Pink</th>
          <th style="width:5%"v-if="is_admin || orderer_id===5">Pediatric</th>
          <th style="width:5%"v-if="is_admin || orderer_id===6">Anesthesia</th>
          <th style="width:5%"v-if="is_admin || orderer_id===7">Ambulance</th>
          <th style="width:5%"v-if="is_admin || orderer_id===8">Office</th>
          <th style="width:5%"v-if="is_admin || orderer_id===9">Technical</th>
          <th style="width:5%"v-if="is_admin || orderer_id===10">Household</th>
          <th style="width:5%" v-if="!is_admin" >Min stock</th>
          <th style="width:5%" v-if="is_admin"></th>
        </thead>
        <tbody>
          <tr v-for="(item,index) in filtered_list">
<!--            <td><input type="checkbox" v-model="item.checked" /></td>-->
            <td>{{ item.code }}</td>
            <td>{{ item.description }}</td>
            <td><small>{{ item.item_type.name }}</small></td>
            <td><small>{{ item.item_unit.name }}</small></td>
            <td v-if="is_admin"><strong><input type="number" :disabled="!is_admin" v-model="item.inventory.general" class="form-control form-control-sm gl edit-input" @change="update(index,'general')"/></strong></td>
            <td v-if="is_admin || orderer_id===1" ><strong><input type="number" v-model="item.inventory.graceCenter"  class="form-control form-control-sm gl edit-input" :class="{'text-danger':item.inventory[orderer_name(orderer_id)]<item.min_stock[orderer_name(orderer_id)]}" @change="update(index,'graceCenter')"/></strong></td>
            <td v-if="is_admin || orderer_id===2"><strong><input type="number" v-model="item.inventory.storkCenter" class="form-control form-control-sm gl edit-input" @change="update(index,'storkCenter')" :class="{'text-danger':item.inventory[orderer_name(orderer_id)]<item.min_stock[orderer_name(orderer_id)]}"/></strong></td>
            <td v-if="is_admin || orderer_id===3"><strong><input type="number" v-model="item.inventory.block" class="form-control form-control-sm gl edit-input" @change="update(index,'bloc')" :class="{'text-danger':item.inventory[orderer_name(orderer_id)]<item.min_stock[orderer_name(orderer_id)]}"/></strong></td>
            <td v-if="is_admin || orderer_id===4"><strong><input type="number" v-model="item.inventory.midPink" class="form-control form-control-sm gl edit-input" @change="update(index,'midPink')" :class="{'text-danger':item.inventory[orderer_name(orderer_id)]<item.min_stock[orderer_name(orderer_id)]}"/></strong></td>
            <td v-if="is_admin || orderer_id===5"><strong><input type="number" v-model="item.inventory.pediatric" class="form-control form-control-sm gl edit-input" @change="update(index,'pediatric')" :class="{'text-danger':item.inventory[orderer_name(orderer_id)]<item.min_stock[orderer_name(orderer_id)]}"/></strong></td>
            <td v-if="is_admin || orderer_id===6"><strong><input type="number" v-model="item.inventory.anesthetist" class="form-control form-control-sm gl edit-input" @change="update(index,'anesthetist')" :class="{'text-danger':item.inventory[orderer_name(orderer_id)]<item.min_stock[orderer_name(orderer_id)]}"/></strong></td>
            <td v-if="is_admin || orderer_id===7"><strong><input type="number" v-model="item.inventory.ambulance" class="form-control form-control-sm gl edit-input" @change="update(index,'ambulance')" :class="{'text-danger':item.inventory[orderer_name(orderer_id)]<item.min_stock[orderer_name(orderer_id)]}"/></strong></td>
            <td v-if="is_admin || orderer_id===8"><strong><input type="number" v-model="item.inventory.office" class="form-control form-control-sm gl edit-input" @change="update(index,'office')" :class="{'text-danger':item.inventory[orderer_name(orderer_id)]<item.min_stock[orderer_name(orderer_id)]}"/></strong></td>
            <td v-if="is_admin || orderer_id===9"><strong><input type="number" v-model="item.inventory.technical" class="form-control form-control-sm gl edit-input" @change="update(index,'technical')" :class="{'text-danger':item.inventory[orderer_name(orderer_id)]<item.min_stock[orderer_name(orderer_id)]}"/></strong></td>
            <td v-if="is_admin || orderer_id===10"><strong><input type="number" v-model="item.inventory.houseHold" class="form-control form-control-sm gl edit-input" @change="update(index,'houseHold')" :class="{'text-danger':item.inventory[orderer_name(orderer_id)]<item.min_stock[orderer_name(orderer_id)]}"/></strong></td>
            <td v-if="!is_admin">
                <span class="text-center mt-4"></span>
                <input type="number" class="form-control form-control-sm gl edit-input" disabled :value="item.min_stock[orderer_name(orderer_id)]"/>
<!--                {{orderer_name(orderer_id)}}-->
            </td>
            <td v-if="is_admin">
<!--              <div class="dropdown me-1">-->
<!--                <button-->
<!--                  type="button"-->
<!--                  class="btn"-->
<!--                  id="dropdownMenuOffset"-->
<!--                  data-bs-toggle="dropdown"-->
<!--                  aria-expanded="false"-->
<!--                  data-bs-offset="10,20"-->
<!--                >-->
<!--                  <font-awesome-icon icon="ellipsis-h" size="lg" />-->
<!--                </button>-->
<!--                <ul class="dropdown-menu" aria-labelledby="dropdownMenuOffset">-->
<!--                  <li>-->
<!--                    <router-link-->
<!--                      class="dropdown-item"-->
<!--                      :to="{ name: 'item_create', params: { id: item.id } }"-->
<!--                      >Edit</router-link-->
<!--                    >-->
<!--                  </li>-->
<!--                  <li><a class="dropdown-item" href="#" @click="delete_item(item.id)">Delete</a></li>-->
<!--                </ul>-->
<!--              </div>-->
                <div class="dropdown">
                    <button class="btn btn-action dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <font-awesome-icon icon="ellipsis-h" size="lg" />
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <router-link
                            class="dropdown-item"
                            :to="{ name: 'item_create', params: { id: item.id } }"
                        >Edit</router-link
                        >
                        <a class="dropdown-item" href="#" @click="delete_item(item.id)">Delete</a>
                    </div>
                </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination v-if="items.length>0"
      v-model="accessory.pages.active"
      :records="accessory.total"
      :per-page="accessory.perPage"
      @paginate="fetchData"
    />
      <modal :active="accessory.delete_modal" @proceed="proceed_action($event)">
          <template v-slot:content>
             <h5>Do you want to proceed?</h5>
          </template>
      </modal>

  </div>
</template>

<script>
import Modal from "../component/modal"
import {mapActions,mapGetters} from 'vuex';
import {item_unit} from "../../../store/modules/item/getters";
import {isInt} from "@fullcalendar/vue";
export default {
  name: "item_index",
    props:{
      is_admin:{
          type:Boolean,
          default:true
      },
        orderer_id:{
          type:Number
        }
    },
    components: {Modal},
    data() {
    return {
      items: [],
      filtered_items:[],
      accessory: {
        all_checked: false,
        category_filter:{id:'', name:'All'},
        search_text:null,
        filter: { id: "", code: "", description: "", type: "" },
        filter_status: false,
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
        delete_modal:false,
        continue_action:false,
        selected_item_id:null,
        search_timeout:null,
        row_update:false
      },
    };
  },
  created() {
      this.fetch_orderers()
  },
  methods: {
    ...mapActions('item',['fetch_items_list']),
    ...mapActions('department',['fetch_orderers']),
    async fetchData() {
      await axios
        .get("/api/v1/inventory_system/item?page=" + this.accessory.pages.active,{params:{category:this.accessory.category_filter.id,search_text:this.accessory.search_text}})
        .then((response) => {
          this.items = response.data.data;
          this.accessory.current_page = response.data.current_page;
          this.accessory.from = response.data.from;
          this.accessory.to = response.data.to;
          this.accessory.total = response.data.total;
          this.accessory.perPage = response.data.per_page;
        });
    },
    async search(){
        clearTimeout(this.accessory.search_timeout)
        let self=this
        this.accessory.search_timeout= setTimeout(()=>{this.fetchData()},1000)
    },
    check_all() {
      if (this.accessory.all_checked === true) {
        this.items.forEach((item) => (item.checked = true));
      } else {
        this.items.forEach((item) => (item.checked = false));
      }
    },
    filter_table() {
      this.accessory.filter_status = !this.accessory.filter_status;
      if (this.accessory.filter_status === false)
        this.accessory.filter = { id: "", code: "", description: "", type: "" };
    },
    setFilter(type){
        this.accessory.category_filter.id=type.id
        this.accessory.category_filter.name=type.name
    },
    paginate(items) {
      return items.slice(this.accessory.from, this.accessory.to);
    },
    sort(col){
        this.accessory.sortDir= - this.accessory.sortDir
        if(this.accessory.sortDir===1){
            this.items.sort((a,b)=> a[col] < b[col]? 1: -1)
        }else{
            this.items.sort((a,b)=> a[col] > b[col] ? 1 : -1)
        }
    },
      proceed_action($event){
        if($event===true)this.confirm_delete(this.accessory.selected_item_id)
      },
      delete_item(id){
        this.accessory.delete_modal=!this.accessory.delete_modal;
        this.accessory.selected_item_id=id
      },
      async confirm_delete(id){
          let index= this.items.findIndex(item=>item.id===id)
          this.items.splice(index,1)
          await axios.delete(`/api/v1/inventory_system/item/${id}`)
          .then(response=>console.log(response.data))
      },
      async update(index,col){
        let self=this
        let params={
            id:this.items[index].id,
            col:col,
            quantity:this.items[index].inventory[col]
        }
        await axios.post('/api/v1/inventory_system/item/inventory/update',params).then(response=>{
            if(response.data.success){
                this.accessory.row_update=true
                setTimeout(()=>{this.accessory.row_update=false},2000)
            }
        })
      },
      orderer_name(id){
        if(this.orderer_list.length>0 && isInt(this.orderer_id) ) return this.orderer_list.find(orderer=>orderer.id===id).name
          else return ''

      },
  },
  computed: {
      ...mapGetters('item',['item_list','item_unit','item_type']),
      ...mapGetters('department',['orderer_list']),

    filtered_list() {
      let filter = this.accessory.filter;
      const filter_keys = Object.keys(filter);
      return this.items.filter((item) => {
        return filter_keys.every((key) => {
          if (!filter[key].length) return true;
          return item[key].toLowerCase().includes(filter[key].toLowerCase());
        });
      });
    },
  },
};
</script>

<style scoped>
.btn-container {
  margin-right: 20px;
}
.table-responsive {
  min-height: 70vh;
}
#item_table td{
    font-size: 10px;
}
.gl{
    font-size: 10px;
}
#item_table th {
  color: lightsteelblue !important;
    font-size: 11px;
}
.filter {
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
  padding: 20px;
}
.btn-action {
  color: mediumslateblue;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
.edit-input{
    border: none;
    background-color: transparent;
    width:100%;
    outline:none;
}
.edit-input:focus{
    border-bottom: 1px solid #28a2a2;
}
</style>
