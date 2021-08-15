<template>
    <div class="container w-75">
        <h1 class="text-center form-title">CONSULTATION FORM</h1>
        <table class="table table-sm">
            <tr>
                <th class="table-title" colspan="3"><v-icon>mdi-account-circle</v-icon> Personal information</th>
            </tr>
            <tr>
                <td style="width:20%"><span class="text-danger">*</span>Id</td>
                <td style="width:40%">First name</td>
                <td style="width:40%">Last name</td>
            </tr>
            <tr>
                <td>
                    <input type="number" class="border required" v-model="formData.patient.id" @change="changePat"/>
                </td>
                <td class="required">
                    {{formData.patient.firstName}}
                </td>
                <td class="required">
                    {{formData.patient.lastName}}
                </td>
            </tr>
            <tr>
                <td>Date of birth</td>
                <td>Address</td>
                <td>Tel</td>
            </tr>
            <tr>
                <td class="required">{{formData.patient.birthDate}}</td>
                <td class="required" :class="{'text-white bg-success':formData.patient.sector===true}">{{formData.patient.adress}}</td>
                <td class="required">{{formData.patient.tel}}</td>
            </tr>
        </table>
        <table class="table table-sm">
            <tr>
                <th class="table-title" colspan="5"> <v-icon>mdi-stethoscope</v-icon>Medical data</th>
            </tr>
            <tr>
                <td>
                    <select class="required" v-model="formData.type_consult_id" @change="changeConsult">
                        <option value=""><span class="text-danger">*</span>Type of consultation</option>
                        <option v-for="item in accessory.type_consultation" :value="item.id">{{item.name}}</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Temp</td>
                <td>Weight</td>
                <td>Blood Pressure</td>
                <td>Pulse</td>
                <td>Spo2</td>
            </tr>
            <tr>
                <td>
                    <input type="number" class="required"  v-model="formData.vitalSign.temp"/>
                </td>
                <td>
                    <input type="number" class="required"  v-model="formData.vitalSign.weight"/>
                </td>
                <td>
                    <input type="number" class="required"  v-model="formData.vitalSign.taSysto"/> /
                    <input type="number" class="required"  v-model="formData.vitalSign.taDia"/>
                </td>
                <td>
                    <input type="number" class="required" v-model="formData.vitalSign.pulse" />
                </td>
                <td>
                    <input type="number" class="required" v-model="formData.vitalSign.spo2" />
                </td>
            </tr>
        </table>
        <table class="table table-sm">
            <tr>
                <th class="table-title">
                    <v-icon>mdi-calendar-check</v-icon>
                    Remarks:
                </th>
            </tr>
            <tr>
               <td>
                   <textarea class="form-control form-control-sm" v-model="formData.remark"></textarea>
               </td>
            </tr>
        </table>
        <table class="table table-sm">
            <tr>
                <th class="table-title">
                    <v-icon>mdi-cash</v-icon>
                    Payment
                </th>
            </tr>
        </table>
        <div class="row">
            <div class="col-6">
                <table class="table table-sm" v-if="formData.type_consult_id!==''">
                    <tr>
                        <td>
                            <select class="required" v-model="accessory.temp_care_line.care">
                                <option v-for="item in accessory.servicePrice" :value="item">{{item.name}}</option>
                            </select>
                        </td>
                        <td>
                            {{accessory.temp_care_line.care.price}}
                        </td>
                        <td>
                            <input type="number" class="required" @keypress.enter="add_care_line" v-model="accessory.temp_care_line.qty"/>
                        </td>
                        <td>
                            {{accessory.temp_care_line.qty * accessory.temp_care_line.care.price }}
                        </td>
                    </tr>
                    <tr v-for="(line,i ) in formData.careDetails.care_line">
                        <td>{{line.care.name}}</td>
                        <td>{{line.care.price}}</td>
                        <td>{{line.qty}}</td>
                        <td>{{line.qty * line.care.price}}</td>
                        <td>
                            <v-btn
                                x-small
                                icon
                                @click="delete_care_line(i)"
                            >
                                <v-icon> mdi-delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table class="table table-sm">
                    <tr>
                        <td>In debt</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Subtotal</td>
                        <td>{{subTotal}}</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "consultation",
        props: {
            editData: {
                type: Object,
                default: null
            },
            edit: false
        },
        data() {
            return {
                formData: {
                    consult_id: "",
                    type_consult_id:'',
                    priority: "",
                    status: "RUNNING",
                    patient: {
                        id: "",
                        firstName: "",
                        lastName: "",
                        adress: "",
                        tel:"",
                        sector: false,
                        last_due: 0,
                    },
                    remark:'',
                    careDetails: {
                        care_line: [
                            // {id: 0, quantity: "", price: "", totLine: ""}
                        ],
                        itemSubTotal: 0,
                        itemTotal: 0,
                    },
                    vitalSign: {
                        temp: "",
                        pulse: "",
                        taSysto: "",
                        taDia: "",
                        weight: "",
                        remark: "",
                        spo2:''
                    },
                },
                defaultData:{
                    consult_id: "",
                    type_consult_id:'',
                    priority: "",
                    status: "RUNNING",
                    patient: {
                        id: "",
                        firstName: "",
                        lastName: "",
                        adress: "",
                        tel:"",
                        sector: false,
                        last_due: 0,
                    },
                    remark:'',
                    careDetails: {
                        care_line: [
                            // {id: 0, quantity: "", price: "", totLine: ""}
                        ],
                        itemSubTotal: 0,
                        itemTotal: 0,
                    },
                    vitalSign: {
                        temp: "",
                        pulse: "",
                        taSysto: "",
                        taDia: "",
                        weight: "",
                        remark: "",
                        spo2:''
                    },
                },
                accessory: {
                    servicePrice: [],
                    type_consultation: [],
                    fokontany: [],
                    noPatientFound: false,
                    temp_care_line:{
                        care:{id:'',name:'',price:''},
                        qty:''
                    }
                }
            }
        },
        created() {
            this.init()
        },
        watch: {
        },
        methods: {
            async init() {
                axios.get('/api/typeConsult').then(response=>this.accessory.type_consultation=response.data)
                axios.get("/api/fokontany").then(response => response.data.forEach(fkt => this.accessory.fokontany.push(fkt.name.toLowerCase())))
            },
            async changePat() {
                await axios.get(`/api/patients/${this.formData.patient.id}/edit`)
                    .then(response => {
                        this.resetForm()
                        if (response.data.success) {
                            this.formData.patient = response.data.patient
                            this.formData.patient.last_due = (response.data.dueSum.length > 0) ? response.data.dueSum[0].amount : 0
                            let adress = this.formData.patient.adress.toLowerCase()
                            adress = adress.split(' ')
                            let check = false
                            adress.forEach(ad => {
                                if (this.accessory.fokontany.indexOf(ad) !== -1) {
                                    check = true
                                }
                            })
                            this.formData.patient.sector = check
                        } else {
                            this.accessory.noPatientFound = true
                        }
                    })

            },
            checkPriority(priority) {
                this.formData.careDetails.priority = priority
            },
            async changeConsult() {
                let servicePrice = await axios.get('/api/servicePrice', {
                    params: {
                        type_consult: this.formData.type_consult_id,
                        sector: this.formData.patient.sector
                    }
                })
                return this.accessory.servicePrice = servicePrice.data
            },
            changeItem(e, rowId) {
                //var table=document.getElementById('invoiceTable');
                let rowPrice = e.target.options[e.target.options.selectedIndex].dataset.price
                this.formData.careDetails.care_line[rowId].price = rowPrice
            },
            changeQty(index) {
                return this.formData.careDetails.care_line[index].totLine = this.formData.careDetails.care_line[index].price * this.formData.careDetails.care_line[index].quantity
            },
            addRow() {
                var count = this.formData.careDetails.care_line.length;
                count++
                this.formData.careDetails.care_line.push({id: count, quantity: "", price: "", totLine: ""})
            },
            add_care_line(){
                let line= this.accessory.temp_care_line
                line.amount= line.care.price * line.qty
                this.formData.careDetails.care_line.push(line)
                this.accessory.temp_care_line={
                    care:{id:'',name:'',price:''},
                    qty:''
                }
            },
            delete_care_line(rowId) {
                return this.formData.careDetails.care_line.splice(rowId, 1)
            },
            async submit(e) {
                e.preventDefault()
                if (this.edit === true) {
                    await axios.put(`/api/consultation/${this.formData.consult_id}`, this.formData)
                } else {
                    await this.newConsultation(this.formData)
                }
                this.resetForm()
                this.$toast.open({
                    message: "Data submited",
                    position: "top-right",
                });
                this.accessories.typeConsult_list = [...this.getTypeConsult]
            },
            resetForm() {
                this.formData = {}
                this.formData = Object.assign({}, {...this.defaultData})
            },

        },
        computed: {
            subTotal(){
                let subTot=0;
                this.formData.careDetails.care_line.forEach((line)=>subTot+=parseInt(line.amount))
                return subTot
            }
        }
    }
</script>
<style scoped>
.container{
    margin-top: 40px;
    background-color: white;
    min-height:90vh;
    padding:40px;
}
.table-title{
    background-color: #cceff0;
}
.required{
    background-color: rgba(233, 242, 238, 0.7);
}
.form-title{
    font-family: 'Enriqueta', arial, serif;
    line-height: 1.25;
    margin: 0 0 10px; font-size: 40px;
    font-weight: bold;
    color: #7c795d;
}
</style>
