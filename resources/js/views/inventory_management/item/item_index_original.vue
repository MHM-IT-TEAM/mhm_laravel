<template>
  <div>
    <div class="row">
      <div class="col-6">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Item</li>
          </ol>
        </nav>
      </div>
      <div class="col-6">
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
          <div class="d-inline-block">
            <button type="button" class="btn btn-sm btn-primary">
              <font-awesome-icon icon="plus" /><router-link
                to="/item/create"
                class="text-white text-decoration-none"
                >&nbsp Add Item</router-link
              >
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="row filter" v-if="accessory.filter_status">
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
          <option>choose</option>
          <option value="M">M</option>
          <option value="C">C</option>
        </select>
      </div>
    </div>
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
          <th>
            <div class="ml-2">
              <input
                type="checkbox"
                @change="check_all"
                v-model="accessory.all_checked"
              />
            </div>
          </th>
          <th style="width: 15%" @click="sort('code','desc')">Code</th>
          <th @click="sort('description','desc')">Description</th>
          <th @click="sort('type','desc')">Type</th>
          <th>Unit</th>
          <th></th>
        </thead>
        <tbody>
          <tr v-for="item in filtered_list">
            <td><input type="checkbox" v-model="item.checked" /></td>
            <td>{{ item.code }}</td>
            <td>{{ item.description }}</td>
            <td>{{ item.item_type.name }}</td>
            <td>{{ item.item_unit.name }}</td>
            <td>
              <div class="dropdown me-1">
                <button
                  type="button"
                  class="btn"
                  id="dropdownMenuOffset"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                  data-bs-offset="10,20"
                >
                  <font-awesome-icon icon="ellipsis-h" size="lg" />
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                  <li>
                    <router-link
                      class="dropdown-item"
                      :to="{ name: 'item_create', params: { id: item.id } }"
                      >Edit</router-link
                    >
                  </li>
                  <li><a class="dropdown-item" href="#" @click="delete_item(item.id)">Delete</a></li>
                </ul>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination
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
import Modal from "../../component/modal";
import {mapActions,mapGetters} from 'vuex';
import {item_unit} from "../../store/modules/item/getters";
export default {
  name: "item_index",
    components: {Modal},
    data() {
    return {
      items: [],
      filtered_items:[],
      accessory: {
        all_checked: false,
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
          selected_item_id:null
      },
    };
  },
  created() {
    //this.fetch_items_list(1)
      this.fetchData()
  },
  methods: {
    ...mapActions('item',['fetch_items_list']),
    async fetchData() {
      await axios
        .get("/api/item?page=" + this.accessory.pages.active)
        .then((response) => {
          this.items = response.data.data;
          this.accessory.current_page = response.data.current_page;
          this.accessory.from = response.data.from;
          this.accessory.to = response.data.to;
          this.accessory.total = response.data.total;
          this.accessory.perPage = response.data.per_page;
          console.log(response);
        });
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
    // setPages() {
    //   let numberOfPages = Math.round(
    //     this.accessory.total / this.accessory.perPage
    //   );
    //   for (let i = 1; i <= numberOfPages; i++) {
    //     this.accessory.pages.list.push(i);
    //   }
    // },
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
          await axios.delete(`/api/item/${id}`)
          .then(response=>console.log(response.data))
      }
  },
  watch: {
    // items: {
    //   handler(val) {
    //     this.setPages();
    //   },
    //   deep: true,
    // },
  },
  computed: {
      ...mapGetters('item',['item_list','item_unit']),
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
#item_table th {
  color: lightsteelblue !important;
}
.filter {
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
  padding: 20px;
}
#dropdownMenuOffset {
  color: mediumslateblue;
}
</style>
