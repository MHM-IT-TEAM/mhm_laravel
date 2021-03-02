<template>
  <div class="p-4 card">
      <div class="card-body">
          <section class="mb-1" id="patInfo">
              <div class="form-row">
                  <div class="col-sm-6 border">
                      <div class="form-row">
                          <div class="col-sm-3 form-group">
                              <label >Patient Id</label>
                              <input type="text"
                                     class="form-control form-control-sm"
                                     @change="changePat"
                                     v-model="formData.patId"
                              />

                          </div>
                          <div class="col-sm-6 form-group">

                              <label >Type of consultation</label>
                              <select
                                  class="form-control form-control-sm"
                                  v-model="formData.type_consult"
                                  @change="changeConsult"
                              >
                                  <option>Choose</option>
                                  <option v-for="option in typeConsult_list" :value="option.id">{{option.name}}</option>
                              </select>

                          </div>
                          <div class="col-sm-3">
                              <div class="form-group">
                                  <label>payment history</label>
                                  <div>
                                      <center><a href="#" class="nav-link"
                                                 data-toggle="modal" data-target="#view_paymentModal"
                                      ><i class="fas fa-eye"></i></a></center>
                                  </div>

                              </div>

                          </div>
                      </div>

                  </div>
                  <div class="col-sm-6 border">
                      <div class="form-row">
                          <div class="col-sm-8 form-group">
                              <label for="patName"> Fullname</label>
                              <input type="text" name="patName" disabled id="patName" v-model="patient.firstName +' '+ patient.lastName " class="form-control form-control-sm"/>
                          </div>
                          <div class="col-sm-4 form-group">
                              <label for="patAdress"> Adress</label>
                              <input type="text" name="patAdress" disabled id="patAdress" v-model="patient.adress" class="form-control form-control-sm"
                                     :class="{'text-white bg-success':patientSector}"
                              />
                              <input type="hidden" name="age" id="age"/>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
          <section>
              <vital-sign :readyToSend="readyToSend" :reset="childReset" @dataSent="getVitalSignData($event)" @priority="checkPriority($event)"></vital-sign>
          </section>
          <section id="invoice" class="mt-1">
              <div class="row">
                  <div class="col-sm-6">
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
                          <tr v-if="servicePrice.length>0" v-for="(row,index) in formData.item">
                              <td>
                                  <select v-model="row.id" @change="changeItem($event,index)" class="form-control" >
                                      <option v-for="option in servicePrice" :key="option.id" :value="option.id" :data-price="option.price"  >{{option.name}}</option>
                                  </select>
                              </td>
                              <td>
                                  <input type="text" class="form-control" disabled v-model="row.price" />
                              </td>
                              <td>
                                  <input type="number" @change="changeQty(index)" class="form-control" v-model="row.quantity"/>
                              </td>
                              <td>
                                  <input type="text" class="form-control" disabled v-model="row.totLine" />
                              </td>
                              <td>
                                  <button type="button" class="btn btn-sm " @click="removeRow(index)"><i class="fas fa-trash"></i></button>
                              </td>

                          </tr>
                          </tbody>
                      </table>

                  </div>
                  <div class="col-sm-6">
                      <div class="row">
                          <div class="col-4">
                              <div class="form-group">
                                  <label for="subTotal" class="label">Subtotal</label>
                                  <input type="text" name="subTotal" id="subTotal" disabled class="form-control form-control-sm" v-model="formData.itemSubTotal"/>

                              </div>
                          </div>
                          <div class="col-4">
                              <div class="form-group">
                                  <label for="lastDue" class="label">Last Due</label>
                                  <input type="text" name="lastDue" id="lastDue" v-model="patient_last_due" disabled class="form-control form-control-sm" />
                                  <input type="hidden" name="lastDues" id="lastDues"  class="form-control form-control-sm"/>
                              </div>
                          </div>
                          <div class="col-4">
                              <div class="form-group">
                                  <label for="total" class="label">Total</label>
                                  <input type="text" name="total" id="total" v-model="formData.itemTotal" disabled class="form-control form-control-sm"/>
                              </div>
                          </div>

                      </div><!--row-->
                  </div>
              </div>

          </section>
          <v-btn
              color="blue-grey"
              class="ma-2 white--text"
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
      </div>
      <div class="chat">

          <queue></queue>
      </div>
  </div>
</template>
<script>
    import {mapGetters,mapActions} from 'vuex';
    import vitalSign from "../../../components/nurseStation/vitalSign";
    import {fetchTodayConsultations} from "../../../store/modules/consultation/actions";
    import Queue from "./queue";


export default {
  name: "consultation",
    components:{Queue,vitalSign},
    data(){
      return{
          typeConsult_list:[],
          patientSector:false,
          formData:{
              patId:"",
              type_consult:"",
              priority:"",
              item:[
                  {id:0,quantity:"",price:"",totLine:""}
              ],
              itemSubTotal:0,
              itemTotal:0,
              vitalSign:"",
              priority:""
          },
          readyToSend:false,
          patient:
              {
                  firstName:"",
                  lastName:"",
                  adress:""
              }
          ,
          patient_last_due:0,
          servicePrice:[],
          defaultFormData:{
              patId:"",
              type_consult:"",
              priority:"",
              item:[
                  {id:0,quantity:"",price:"",totLine:""}
              ],
              itemSubTotal:0,
              itemTotal:0,
              vitalSign:"",
          },
          childReset:false
      }
    },
    created(){
        this.init()
    },
    methods:{
      ...mapActions('consultation',['fetch_type_consult','newConsultation','fetchTodayConsultations']),
        ...mapActions('patient',['fetchPatient']),
      async init(){
          await this.fetch_type_consult()
          this.typeConsult_list=  this.getTypeConsult
          await this.fetchTodayConsultations()
      },
        async changePat(){
           await this.fetchPatient(this.formData.patId)
            let patData= await this.getPatients
            this.patient= patData.patient
            this.patient_last_due= (patData.dueSum.length>0)?patData.dueSum[0].amount:0
            let adress= this.patient.adress.toLowerCase()
            adress= adress.split(' ')
            let arg=['ambovo','rangaina','mahazo','tanjondroa']
            let check=false
            adress.forEach(ad=>{
                 if(arg.indexOf(ad) !== -1){
                    check=true
                 }
            })
            this.patientSector=check
        },
        getVitalSignData(data){
          this.formData.vitalSign=data
        },
        checkPriority(priority){
          this.formData.priority=priority
        },
        async changeConsult(){
            let servicePrice= await axios.get('/api/servicePrice',{
                params:{
                    type_consult:this.formData.type_consult,
                    sector:this.patientSector
                }
            })
            this.servicePrice=servicePrice.data
        },
        changeItem(e,rowId){
            var table=document.getElementById('invoiceTable');
            let rowPrice=  e.target.options[e.target.options.selectedIndex].dataset.price
            this.formData.item[rowId].price= rowPrice

        },
        changeQty(index){
          return this.formData.item[index].totLine=  this.formData.item[index].price * this.formData.item[index].quantity
        },
        addRow(){
          var count= this.formData.item.length;
          count++
          this.formData.item.push({id:count,quantity:"",price:"",totLine:""})
        },
        removeRow(rowId){
          return this.formData.item.splice(rowId,1)
        },
        async submit(e){
            e.preventDefault()
            this.readyToSend=true
           await this.newConsultation(this.formData)
            this.resetForm()
            this.formData.patId=""
            this.formData.type_consult=""
        },
        resetForm(){
            this.formData= this.defaultFormData
            this.patient={
                firstName:"",
                lastName:"",
                adress:""
            }
            this.patient_last_due=0
            this.readyToSend=false
            this.servicePrice=[]
            this.patientSector=false
            this.childReset=true
        }
    },
    watch:{
      subTotal(val){
          return val
      },
      total(val){
          return val
      }
    },


    computed:{
      ...mapGetters('consultation',['getTypeConsult']),
        ...mapGetters('patient',['getPatients']),
        subTotal(){
          var result=0
            this.formData.item.forEach(val=>result+= val.totLine)
            return this.formData.itemSubTotal= result
        },
        total(){
          return this.formData.itemTotal= parseInt(this.formData.itemSubTotal) + parseInt(this.patient_last_due)
        }
    }
};
</script>
<style scoped>
    .chat{
        width:200px;
        color:red
    }
</style>
