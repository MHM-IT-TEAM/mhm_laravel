<template>
  <div>
      <h4 class="text-center">ITEM FORM</h4>
    <div class="row p-6">
      <div class="col-lg-6 col-md-12">
        <form @submit.prevent="submit">
          <div class="form-container">
            <div class="row">
              <div class="form-group col-6">
                <label>Barcode</label>
                <input
                  type="text"
                  class="form-control form-control-sm"
                  v-model="formData.barcode"
                  disabled
                />
              </div>
              <div class="form-group col-6">
                <label>Code</label>
                <input
                  type="text"
                  class="form-control form-control-sm"
                  disabled
                  v-model="formData.code"
                />
              </div>
            </div>
              <div class="row">
                  <div class="form-group col-6">
                      <label>Type</label><span class="text-danger">*</span>
                      <select class="form-control form-control-sm" v-model="formData.item_type_id" @change="formData.description=''">
                          <option v-for="type in item_type" :value="type.id">{{type.name}}</option>
                      </select>
                  </div>
              </div>
            <div class="form-group">
              <label>Name</label><span class="text-danger">*</span>
              <input
                type="text"
                class="form-control form-control-sm"
                name="description"
                autocomplete="off"
                v-model="formData.description"
                @change="getCode"
                :disabled="formData.item_type_id===''"
              />
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label>Price</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        v-model="formData.price"
                    />
                </div>
                <div class="col-6">
                    <label>Location</label>
                    <select type="text" class="form-control" v-model="formData.location_id">
                        <option v-for="location in locations" :value="location.id">{{location.name}}</option>
                    </select>
                </div>
            </div>
            <div class="row">

              <div class="form-group col-6">
                <label>Unit</label>
                <select class="form-control form-control-sm" v-model="formData.item_unit_id" >
                    <option v-for="unit in item_unit" :value="unit.id">{{unit.name}}</option>
                </select>
              </div>
            </div>
              <div class="row" v-if="formData.item_type_id===1">
                  <div class="form-group col-4">
                      <label>DCI</label>
                      <input type="text" class="form-control" v-model="formData.dci"/>
                  </div>
                  <div class="form-group col-4">
                      <label>Administration</label>
                      <select type="text" class="form-control" v-model="formData.administration_id">
                          <option v-for="admn in item_administration" :value="admn.id">{{admn.name}}</option>
                      </select>
                  </div>
                  <div class="form-group col-4">
                      <label>Qty per Unit</label>
                      <input type="number" class="form-control" v-model="formData.perUnit"/>
                  </div>
              </div>
              <hr>
              <div class="row" v-if="!accessory.edit">
                <div class="col-4">
                    <div class="form-group">
                        <label>Item quantity</label><span class="text-danger">*</span>
                        <input type="number" class="form-control" v-model="formData.entry_qty"/>
                    </div>
                </div>
                  <div class="col-4">
                      <div class="form-group">
                          <label>Min Stock for GL Storage</label>
                          <input type="number" class="form-control" v-model="formData.gl_min_stock"/>
                      </div>
                  </div>
              </div>

            <div class="submit-container">
              <button type="submit" class="btn btn-sm btn-primary" >
                Submit
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-6 col-md-12">
        <div class="img-container">
<!--          <img-->
<!--            src="/storage/assets/media/system/images/test.jpg"-->
<!--            class="rounded"-->
<!--          />-->
            <h6>Purpose of use</h6>
            <textarea class="form-control" rows="15" v-model="formData.purpose_of_use"></textarea>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions,mapGetters} from 'vuex'
export default {
  name: "create",
    data(){
      return{
          formData:{
              code:'',
              barcode:'',
              description:'',
              price:'',
              item_type_id:'',
              item_unit_id:'',
              location_id:'',
              administration_id:'',
              dci:'',
              perUnit:'',
              entry_qty:'',
              gl_min_stock:'',
              purpose_of_use:''
          },
          defaultData:{
              code:'',
              barcode:'',
              description:'',
              price:'',
              item_type_id:'',
              item_unit_id:'',
              location_id:'',
              administration_id:'',
              dci:'',
              perUnit:'',
              purpose_of_use:''
          },
          accessory:{
              edit:false,
              item_type:[{id:1,name:'Medicine'},{id:2,name:'Consumable'}],
          }
      }
    },
    methods:{
        init(){
            this.$barcodeScanner.init(this.onBarcodeScanned)
            //check if the route has edit params
            let id= this.$route.params.id
            if(id !==null && id !== undefined){
                this.accessory.edit=true
                this.fetchData(id )
            }
        },
        async fetchData(id){
            let response= await axios.get('/api/v1/inventory_system/item/'+id)
            this.formData={...response.data}
        },
        async submit(){
            if(this.accessory.edit===true){
               await axios.put(`/api/v1/inventory_system/item/${this.$route.params.id}`,this.formData)

            }else{
                await axios.post('/api/v1/inventory_system/item',this.formData)
            }
            this.resetForm()
        },
        resetForm(){
            this.formData= Object.assign({},this.defaultData)
        },
        async getCode(){
            let descr = this.formData.description
            if(descr.length>4){
                descr=descr.substring(0,5)
                await axios.get(`/api/v1/inventory_system/item/code`,{params:{code:descr,type:this.formData.item_type_id}})
                .then(response=>{
                    if(this.formData.item_type_id===1){
                        if(response.data.length>0){
                            let split= response.data[0].split('-')
                            let rank= parseInt(split[1])+1
                            let newRank
                            if(rank<100 && rank>10){
                                newRank='0'+rank
                            }else if (rank<10){
                                newRank='00'+rank
                            }else{
                                newRank=rank
                            }
                            this.formData.code=split[0]+'-'+newRank

                        }else{
                            this.formData.code= descr.toUpperCase()+'-'+'01'
                        }
                    } else{
                        if(response.data.length>0){
                            let split= response.data[0].split('-')
                            let rank= parseInt(split[2])+1
                            let newRank
                            if(rank<100 && rank>10){
                                newRank='0'+rank
                            }else if (rank<10){
                                newRank='00'+rank
                            }else{
                                newRank=rank
                            }
                            this.formData.code= "C-"+split[1]+'-'+newRank

                        }else{
                            this.formData.code= "C-"+descr.toUpperCase()+'-'+'01'
                        }
                    }


                })
            }
        },
        async onBarcodeScanned(barcode){
            axios.get(`/api/v1/inventory_system/item/get_by_barcode/${barcode}`).then(response=>{
                if(response.data.data.length>0){
                    this.$toast.open({
                        message:"This product code is already in the database",
                        type:"error",
                        position:"top-right"
                    })
                }else{
                    this.formData.barcode=barcode
                }
            })
        }

    },
    created(){
        this.init()
    },
    computed:{
      ...mapGetters('item',['item_unit','item_type','item_administration','locations']),
    }

};
</script>

<style scoped>
form {
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
  padding: 20px;
  height: 70vh;
}
.form-container {
  position: relative;
  height: 100%;
}
.submit-container {
  position: absolute;
  bottom: 0;
  right: 0;
}
.img-container {
  width: 100%;
  height: 100%;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
  padding: 20px;
}
.img-container img {
  max-width: 100% !important;
  max-height: 100% !important;
}
</style>
