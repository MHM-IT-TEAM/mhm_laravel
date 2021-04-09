<template>
    <div class="p-4">
        <div class="card card-body">
            <v-row>
                <v-col cols="12" sm="9">
                    <section class="mb-2" id="patInfo">
                        <v-row>
                            <v-col cols="12" sm="6">
                                <v-card class="rounded-xl p-2">
                                    <h4 class="mt-2">Consultation info</h4>
                                    <div class="form-row">
                                        <div class="col-sm-3 form-group ">
                                            <label class="mb-0" >Patient Id</label>
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   @change="changePat"
                                                   v-model="formData.patient.id"
                                            />

                                        </div>
                                        <div class="col-sm-6 form-group ">
                                            <label class="mb-0">Type of consultation</label>
                                            <select
                                                class="form-control form-control-sm"
                                                v-model="formData.careDetails.type_consult"
                                                @change="changeConsult"
                                            >
                                                <option>Choose</option>
                                                <option v-for="option in accessories.typeConsult_list" :value="option.id">{{option.name}}</option>
                                            </select>

                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label class="mb-0">payment history</label>
                                            <div>
                                                <center><a href="#" class="nav-link"
                                                           data-toggle="modal" data-target="#view_paymentModal"
                                                ><i class="fas fa-eye"></i></a></center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                            <div class="col-sm-3 form-group mt-0">
                                                <label for="patAdress" class="mb-0"> Adress</label>
                                                <input type="text" name="patAdress" disabled id="patAdress" v-model="formData.patient.adress" class="form-control form-control-sm"
                                                       :class="{'text-white bg-success':formData.patient.sector}"
                                                />
                                                <input type="hidden" name="age" id="age"/>
                                            </div>
                                            <div class="col-sm-9 form-group mt-0">
                                                <label for="patName" class="mb-0"> Fullname</label>
                                                <input type="text" name="patName" disabled id="patName" v-model="formData.patient.firstName +' '+ formData.patient.lastName " class="form-control form-control-sm"/>
                                            </div>
                                    </div>
                                </v-card>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-card class="rounded-xl p-2">
                                    <h4 class="mt-2">Vital sign</h4>
                                    <vital-sign
                                        :formData.sync="formData.careDetails.vitalSign"
                                    >
                                    </vital-sign>
                                </v-card>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-card class="rounded-xl p-2">
                                    <table id="invoiceTable" class="table table-bordered">
                                        <thead>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>
                                            <v-btn
                                                class="mx-2 float-right"
                                                fab
                                                dark
                                                x-small
                                                color="indigo"
                                                @click="addRow"
                                            >
                                                <v-icon dark> mdi-plus </v-icon>
                                            </v-btn>
                                        </th>
                                        </thead>
                                        <tbody>
                                        <tr v-if="accessories.servicePrice.length>0" v-for="(row,index) in formData.careDetails.care_line">
                                            <td>
                                                <select v-model="row.id" @change="changeItem($event,index)" class="form-control" >
                                                    <option v-for="option in accessories.servicePrice" :key="option.id" :value="option.id" :data-price="option.price"  >{{option.name}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" disabled v-model="row.price" />
                                            </td>
                                            <td>
                                                <input type="number" @change="changeQty(index)" class="form-control" v-model="row.quantity"/>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" disabled :value="row.totLine" />
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm " @click="removeRow(index)"><i class="fas fa-trash"></i></button>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </v-card>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-card class="rounded-xl p-2">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="subTotal" class="label">Subtotal</label>
                                                    <input type="text" name="subTotal" id="subTotal" disabled class="form-control form-control-sm" :value="formData.careDetails.itemSubTotal"/>

                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="lastDue" class="label">Last Due</label>
                                                    <input type="text" name="lastDue" id="lastDue"
                                                           :value="formData.patient.last_due"
                                                           :class="checkLastDue"
                                                           disabled class="form-control form-control-sm"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="total" class="label">Total</label>
                                                    <input type="text" name="total" id="total" :value="formData.careDetails.itemTotal" disabled class="form-control form-control-sm"/>
                                                </div>
                                            </div>
                                        </div><!--row-->
                                </v-card>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-btn
                                    color="blue-grey"
                                    class="ma-2 mt-2 white--text"
                                    @click="submit"
                                >
                                    Submit
                                    <v-icon
                                        right
                                        dark
                                    >
                                        mdi-cloud-upload
                                    </v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </section>
                </v-col>
                <v-col cols="12" sm="3">
<!--                    <v-card class="rounded-xl p-2">-->
<!--                        <queue-side-bar></queue-side-bar>-->
<!--                    </v-card>-->
                </v-col>
            </v-row>
        </div>
    </div>
</template>
<script>
    import vitalSign from "../../../components/nurseStation/vitalSign";
    //import queueSideBar from "./queueSideBar";
    import {mapActions, mapGetters} from 'vuex';


    export default {
        name: "consultation",
        props:{
            editData:{
                type:Object,
                default:null
            },
            edit:false
        },
        components:{vitalSign},
        data(){
          return{
              formData:{
                  consult_id:"",
                  patient:  {
                      id:"",
                      firstName:"",
                      lastName:"",
                      adress:"",
                      sector:false,
                      last_due:0,
                  },
                  careDetails:{
                      type_consult:"",
                      priority:"",
                      status:"RUNNING",
                      care_line:[
                          {id:0,quantity:"",price:"",totLine:""}
                      ],
                      itemSubTotal:0,
                      itemTotal:0,
                      vitalSign:{
                          temp:"",
                          pulse:"",
                          taSysto:"",
                          taDia:"",
                          weight:"",
                          remark:""
                      },
                  },
              },
              accessories:{
                  servicePrice:[],
                  typeConsult_list:[]
              }

          }
        },
        created(){
            this.init()
        },
        mounted() {
           this.data
        },
        methods:{
          ...mapActions('consultation',['fetch_type_consult','newConsultation']),
          async init(){
              await this.fetch_type_consult()
             this.accessories.typeConsult_list=  [...this.getTypeConsult]
              //this.update
          },
            async changePat(){
                let patData= await axios.get(`/api/patients/${this.formData.patient.id}/edit`)
                this.formData.patient.firstName=patData.data.patient.firstName
                this.formData.patient.lastName= patData.data.patient.lastName
                this.formData.patient.adress= patData.data.patient.adress
                this.formData.patient.last_due= (patData.data.dueSum.length>0)?patData.data.dueSum[0].amount:0
                let adress= this.formData.patient.adress.toLowerCase()
                adress= adress.split(' ')
                let arg=['ambovo','rangaina','mahazo','tanjondroa']
                let check=false
                adress.forEach(ad=>{
                     if(arg.indexOf(ad) !== -1){
                        check=true
                     }
                })
                this.formData.patient.sector=check
            },
            checkPriority(priority){
              this.formData.careDetails.priority=priority
            },
            changeConsult(){
                this.fetch_service_price()
            },
            async fetch_service_price(){
                let servicePrice= await axios.get('/api/servicePrice',{
                    params:{
                        type_consult:this.formData.careDetails.type_consult,
                        sector:this.formData.patient.sector
                    }
                })
                return this.accessories.servicePrice=servicePrice.data
            },
            changeItem(e,rowId){
                var table=document.getElementById('invoiceTable');
                let rowPrice=  e.target.options[e.target.options.selectedIndex].dataset.price
                this.formData.careDetails.care_line[rowId].price= rowPrice
            },
            changeQty(index){
              return this.formData.careDetails.care_line[index].totLine=  this.formData.careDetails.care_line[index].price * this.formData.careDetails.care_line[index].quantity
            },
            addRow(){
              var count= this.formData.careDetails.care_line.length;
              count++
              this.formData.careDetails.care_line.push({id:count,quantity:"",price:"",totLine:""})
            },
            removeRow(rowId){
              return this.formData.careDetails.care_line.splice(rowId,1)
            },
            async submit(e){
                e.preventDefault()
                if(this.edit===true){
                    await axios.put(`/api/consultation/${this.formData.consult_id}`,this.formData)
                }else{
                    await this.newConsultation(this.formData)
                }
                this.resetForm()
                this.$toast.open({
                    message: "Data submited",
                    position: "top-right",
                });
                this.accessories.typeConsult_list=  [...this.getTypeConsult]
            },
            resetForm(){
                Object.assign(this.$data, this.$options.data.call(this));
            },

        },
        watch:{
          subTotal(val){
              return val
          },
          total(val){
              return val
          },
          editData:{
              handler(newVal,oldVal){
                  this.formData=Object.assign({},newVal)
                  this.update
              },
              deep:true
          },
          'formData.careDetails.type_consult':function(val){
             this.changeConsult()
          },
          'formData.patient.id':function(val){
              this.changePat()
          },
        },

        computed:{
          ...mapGetters('consultation',['getTypeConsult']),
            subTotal(){
              var result=0
                this.formData.careDetails.care_line.forEach(val=>result+= val.totLine)
                return this.formData.careDetails.itemSubTotal= result
            },
            total(){
              return this.formData.careDetails.itemTotal= parseInt(this.formData.careDetails.itemSubTotal) + parseInt(this.formData.patient.last_due)
            },
            data(){
              if(this.editData !== null){
                  return this.formData= {...this.editData}
              }
            },
            checkLastDue(){
              return this.formData.patient.last_due>0?'text-white bg-danger':''
            },
            async update(){
                let vitalSign= await axios.get(`/api/patients/vitalSign/${this.formData.patient.id}`)
                this.formData.careDetails.vitalSign.pulse= vitalSign.data[0].pulse
                this.formData.careDetails.vitalSign.temp= vitalSign.data[0].temp
                this.formData.careDetails.vitalSign.taSysto= vitalSign.data[0].TaSysto
                this.formData.careDetails.vitalSign.taDia= vitalSign.data[0].taDia
                this.formData.careDetails.vitalSign.weight= vitalSign.data[0].weight
            }

        }
    }
</script>
<style scoped>

</style>
