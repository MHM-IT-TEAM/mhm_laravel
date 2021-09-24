<template>
  <div class="container" id="to_print">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <h5 class="card-title">Cart Nº: {{ formData.code }}</h5>
          </div>
            <div class="col-4">
                <button  type="button" class="btn btn-outline-primary" @click="transform"
                         data-bs-placement="left"
                         v-if="accessory.form_status ==='edit'"
                         data-bs-toggle="tooltip" data-bs-html="true" title="Transform into Stock-Entry">
                    <font-awesome-icon icon="cog" class="fa-lg"/>
                    Transform into Entry Doc
                </button> &nbsp
                <transition name="faded">
                    <span class="alert alert-success" v-if="accessory.transformation_done">Operation saved</span>
                </transition>

            </div>
          <div class="col-2 d-flex flex-row-reverse justify-content-between">
<!--            <button class="btn btn-info text-white btn-circle" @click="print">-->
<!--              <font-awesome-icon icon="print" class="fa-lg" />-->
<!--            </button>-->
            <button
              class="btn btn-danger text-white btn-circle"
              @click="getPdf"
              v-if="accessory.form_status ==='edit'"
            >
              <font-awesome-icon icon="file-pdf" />
            </button>
            <button
              class="btn add-btn"
              @click="accessory.add_item = true"
              v-if="!accessory.add_item"
            >
              <font-awesome-icon icon="shopping-cart" class="fa-lg" />
            </button>
            <button
              class="btn btn-warning text-white"
              @click="accessory.add_item = false"
              v-if="accessory.add_item"
            >
              <font-awesome-icon icon="times" class="fa-lg" />
            </button>
          </div>
        </div>
        <transition name="fade">
          <div class="row mt-2" v-if="accessory.add_item">
            <div class="col-8">
<!--              <multiselect-->
<!--                v-model="accessory.search.item"-->
<!--                track-by="description"-->
<!--                :id="'multiSelect'"-->
<!--                placeholder="Type to search"-->
<!--                open-direction="bottom"-->
<!--                :options="accessory.temp_list"-->
<!--                :searchable="true"-->
<!--                :loading="accessory.search.loading"-->
<!--                :internal-search="false"-->
<!--                :clear-on-select="true"-->
<!--                :close-on-select="true"-->
<!--                :limit="10"-->
<!--                :limit-text="4"-->
<!--                :max-height="600"-->
<!--                :min-width="400"-->
<!--                :show-no-results="false"-->
<!--                :hide-selected="true"-->
<!--                @search-change="fetchItem"-->
<!--              >-->
<!--              </multiselect>-->
                <multiselect v-model="accessory.search.item" id="ajax"
                             label="label"
                             track-by="description"
                             placeholder="Type to search" open-direction="bottom"
                             :options="accessory.temp_list"  :searchable="true"
                             :loading="accessory.search.loading" :internal-search="false" :clear-on-select="false"
                             :close-on-select="true" :options-limit="300" :limit="3"
                             :max-height="600" :show-no-results="false" :hide-selected="true"
                             @search-change="fetchItem">
                </multiselect>
            </div>
            <div class="col-2">
              <input
                type="number"
                class="form-control"
                placehoder="quantity"
                v-model="accessory.search.quantity"
                @keypress.enter="add_item"
              />
            </div>
            <div class="col-2">
              <button class="btn text-primary" @click="add_item">
                <font-awesome-icon icon="plus" class="fal-lg" />&nbsp Add
              </button>
            </div>
          </div>
        </transition>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <th>#</th>
              <th>code</th>
              <th>Description</th>
              <th style="width: 10%">quantity</th>
              <th></th>
            </thead>
            <tbody>
                <tr v-for="(row, index) in formData.details" :key="row.quantity">
                  <td>{{ index }}</td>
                  <td>{{ row.item.code }}</td>
                  <td>{{ row.item.description }}</td>
                  <td>
                    <input
                      type="number"
                      class="form-control"
                      v-model="row.quantity"
                    />
                  </td>
                  <td>
                    <button class="btn" @click="remove_item(item, index)">
                      <font-awesome-icon icon="trash" />
                    </button>
                  </td>
                </tr>
            </tbody>
          </table>
        </div>
        <div class="submit-container">
          <button
            class="btn submit-btn"
            @click.prevent="submit"
            v-if="accessory.form_status === 'new'"
            :disabled="formData.details.length===0"
          >
            Submit
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "cart_form",
  data() {
    return {
      formData: {
        details: [],
        code: "",
        id: "",
        status: "",
        created_at: "",
      },
      accessory: {
        search: {
          item: "",
          loading: false,
          quantity: "",
        },
        temp_list: [],
        add_item: false,
        edit: false,
        form_status: null,
        transformation_done:false
      },
    };
  },
  created() {
    this.init();
  },
  watch: {
    "accessory.edit": {
      handler(val) {
        if (this.accessory.form_status === "edit") this.updateForm();
      },
      deep: true,
    },
  },
  methods: {
    async init() {
      //if the form status is edit
      if (
        this.$route.params.id !== null &&
        this.$route.params.id !== undefined
      ) {
        this.formData.id = this.$route.params.id;
        this.accessory.form_status = "edit";
        await axios
          .get(`/api/v1/inventory_system/cart/${this.$route.params.id}`)
          .then((response) => {
            this.formData.details = response.data.cart_details;
            this.formData.code = response.data.code;
            this.formData.id = response.data.id;
            this.formData.created_at = response.data.created_at;
          });
      } else {
        this.fetch_last_code();
        this.accessory.form_status = "new";
      }
    },
    async fetch_last_code() {
      let date = new Date();
      axios.get("/api/v1/inventory_system/cart/lastCode").then((response) => {
        if (response.data.msg !== "no data")
          this.formData.code = this.pad(response.data);
        else this.formData.code = "SHOP-" + date.getFullYear() + "-" + "00001";
      });
    },
    async fetch_in_last_code(){
          let date= new Date()
         let response= await axios.get('/api/v1/inventory_system/in/lastCode')
          if(response.data.msg !=='no data')return this.in_pad(response.data)
          else return 'IN-'+date.getFullYear()+'-'+'00001'
      },
    remove_item(item, index) {
      this.formData.details.splice(index, 1);
      this.accessory.edit = true;
    },
    async fetchItem(code) {
      this.accessory.search.temp_list = [];
      this.accessory.search.loading = true;
      await axios
        .get("/api/v1/inventory_system/item", { params: { search_text: code } })
        .then((response) => {
          let data = response.data.data;
          data.forEach((item) => {
            this.accessory.temp_list.push({
              label: `[${item.code}] ${item.description}`,
              description: item.description,
              value: {
                id: item.id,
                code: item.code,
                description: item.description,
              },
            });
          });
          this.accessory.search.loading = false;
        });
    },
    add_item() {
      if (
        this.accessory.search.item !== "" &&
        this.accessory.search.quantity !== ""
      ) {
        this.formData.details.push({
          item: {
            id: this.accessory.search.item.value.id,
            code: this.accessory.search.item.value.code,
            description: this.accessory.search.item.value.description,
          },
          quantity: this.accessory.search.quantity,
        });
        this.accessory.search.item = "";
        this.accessory.search.quantity = "";
        this.accessory.edit = true;
      }
    },
    async updateForm() {
      this.formData.status = 2;
      await axios
        .put(`/api/v1/inventory_system/cart/${this.formData.id}`, this.formData)
        .then((response) => {
            this.$toast.open({message:response.data.msg,position:'top-right',type:'data updated'})
        });
      this.accessory.edit = false;
    },
    async submit() {
      await axios
        .post("/api/v1/inventory_system/cart", {
          code: this.formData.code,
          details: this.formData.details,
          status: 1,
        })
        .then((response) => {
          this.$toast.open({message:response.data.msg,position:'top-right',type:'data submitted'})
          this.$router.push({ name: "cart_list" });
        });
    },
    pad(code) {
      let date = new Date();
      let intPart = parseInt(code.split("-")[2]);
      intPart++;
      let zero = "";
      let intPart_length = intPart.toString().length;
      for (let i = 0; i < 5 - intPart_length; i++) {
        zero += "0";
      }
      return "SHOP-" + date.getFullYear() + "-" + zero + intPart;
    },
    getPdf() {
      window.location.href = `../pdf/shopping_list/${this.formData.id}`;
    },
    async transform(){
        [this.formData.code,this.formData.status]=[await this.fetch_in_last_code(),1]
        let self=this
        await axios.post('/api/v1/inventory_system/in',this.formData).then(response=>{
            if(response.data.success){
                this.accessory.transformation_done=true
                setTimeout(()=>{self.accessory.transformation_done=false},2000)
            }
        })
        await axios.delete(`/api/v1/inventory_system/cart/${this.formData.id}`).then(response=>{
            response.data.success?setTimeout(()=>{self.$router.push({name:'in_list'})},1000):''
        })

    },
    in_pad(code){
      let date =new Date()
      let intPart= parseInt(code.split('-')[2])
      intPart++
      let zero=''
      let intPart_length= intPart.toString().length
      for(let i=0;i<5-intPart_length;i++){
          zero+='0'
      }
      return 'IN-'+date.getFullYear()+'-'+zero+intPart
    }
  },
};
</script>

<style scoped>
.container {
  height: 100%;
}
.card {
  height: 100%;
}
.card-title {
  color: #e47911;
}
.add-btn {
  background-color: #e47911;
  position: relative;
  color: white;
  border-radius: 50%;
  line-height: 45px;
  width: 47px;
  height: 45px;
  text-align: center !important;
  vertical-align: middle !important;
  padding: 0;
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
.fa-lg {
  padding-bottom: 1px;
  padding-right: 2px;
}
table thead {
  color: #577178;
}
.submit-container {
  position: absolute;
  right: 15px;
  bottom: 5px;
}
.submit-btn {
  background-color: #e47911;
  color: white;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.7s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
