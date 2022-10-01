<template>
<div class="container-fluid w-75">
   <patient_information :patient_id="$route.params.patient_id" v-if="$route.params.patient_id !==''"/>
    <div class="form-group">
        <label class="label" >Mom Id</label>
        <input type="number" readonly class="form-control form-control-sm w-25" v-model="accessory.milk_pro_admission_data.mom_id">
    </div>
    <div class="form-group">
        <label class="label" >Story</label>
        <textarea class="form-control form-control-sm" readonly v-model="accessory.milk_pro_admission_data.story"/>
    </div>
    <h3 class="title">Data in the system</h3>
    <div class="table-responsive">
        <table class="table table-sm">
            <tr>
                <td>Date</td>
                <td>Weight</td>
                <td>Milk Given</td>
                <td>Remark</td>
            </tr>
            <tr v-for="row in accessory.milk_pro_admission_data.milkprogram_followups">
                <td>{{row.created_at}}}</td>
                <td>{{row.weight}}</td>
                <td>
                    <table class="table table-sm">
                        <tr>
                            <th>Name</th>
                            <th>QTY</th>
                        </tr>
                        <tr v-for="r in row.milk_program_followup_details">
                            <td>{{ r.item.description }}</td>
                            <td>{{ r.qty }}</td>
                        </tr>
                    </table>
                </td>
                <td>{{row.remark}}</td>
            </tr>
        </table>
    </div>
    <button class="btn btn-primary "  @click.stop="dialog = true">Add data</button>
    <v-dialog
        v-model="dialog"
        max-width="900"
    >
        <v-card>
            <v-card-title class="text-h5">
                Add Data
            </v-card-title>

            <v-card-text>
               <div class="form-group">
                   <label>Weight</label>
                   <input type="number" class="form-control form-control-sm w-25" v-model="formData.weight">
               </div>
                <div class="form-group">
                    <label>Remark</label>
                    <textarea class="form-control form-control-sm" v-model="formData.remark"/>
                </div>
<!--                <div class="table-responsive">-->
<!--                    <table class="table table-sm">-->
<!--                        <tr>-->
<!--                            <th>Milk/Food</th>-->
<!--                            <th>Qty</th>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>-->
<!--                                <select class="form-control form-control-sm" v-model="accessory.temporary_milk_data.milk">-->
<!--                                    <option v-for="m in milk" :value="m">{{m.name}}</option>-->
<!--                                </select>-->
<!--                            </td>-->
<!--                            <td>-->
<!--                                <input type="number" class="form-control form-control-sm" @keydown.enter="add_milk_row" v-model="accessory.temporary_milk_data.qty"/>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        <tr v-for="row in formData.milk_given">-->
<!--                            <td>{{row.milk.name}}</td>-->
<!--                            <td>{{row.qty}}</td>-->
<!--                        </tr>-->
<!--                    </table>-->
<!--                </div>-->
                <give_medicine @get_value="get_medicines" :reset="reset_medication_list"/>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn
                    color="green darken-1"
                    text
                    @click="dialog = false"
                >
                    Cancel
                </v-btn>

                <v-btn
                    color="green darken-1"
                    text
                    @click="submit"
                >
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</div>
</template>

<script>
import Baby_milk_pro_admission from "./baby_milk_pro_admission";
import Patient_information from "../../../../components/patient_information";
import Give_medicine from "../../../../components/give_medicine";
export default {
    name: "baby_milk_pro_followup",
    components: {Give_medicine, Patient_information, Baby_milk_pro_admission},
    data(){
        return{
            dialog:false,
            milk:[
                {id:1,name:'PRE-NURSIE'},
                {id:2,name:'NURSIE-2'},
            ],
            formData:{
                patient_id:'',
                milkprogram_admission_id:'',
                admission_id:'',
                weight:null,
                remark:'',
                medication:[]
            },
            accessory:{
                temporary_milk_data:{
                    milk:null,
                    qty:''
                },
                milk_pro_admission_data:{
                    mom_id:'',
                    story:'',
                    milkprogram_followups:[]
                }
            },
            reset_medication_list:false
        }
    },
    created(){
        this.init()
    },
    methods:{
        init(){
            //need to check if coming from list or admission
            if(this.$route.params.patient_id){
                this.formData.patient_id=this.$route.params.patient_id
                this.formData.milkprogram_admission_id=this.$route.params.milk_pro_admission.id
                this.accessory.milk_pro_admission_data=this.$route.params.milk_pro_admission
                this.formData.admission_id= this.$route.params.admission_id
            }
            if(this.$route.params.followup_data){
                this.accessory.milk_pro_admission_data=this.$route.params.followup_data
            }

        },
        add_milk_row(){
            this.formData.milk_given.push(this.accessory.temporary_milk_data)
            this.accessory.temporary_milk_data={milk:null, qty:''}
        },
        get_medicines(data){
            this.formData.medication=data
        },
        async submit(){
            await axios.post("/api/v1/patient_system/out_patient/obstetrical/milkPro/store_followup",this.formData).then(response=>{
                if(response.data.success){
                    this.accessory.milk_pro_admission_data={milkprogram_followups:[]}
                    this.$toast.open({
                        message: `Data submitted`,
                        position: "top-right",
                    });
                    this.dialog=false
                }
            })
            await axios.get(`/api/v1/patient_system/out_patient/obstetrical/milkPro/patient/${this.formData.patient_id}`).then(response=>{
                this.accessory.milk_pro_admission_data=response.data.milk_program_admission
            })
        }
    }
}
</script>

<style scoped>
.title{
    color:#1390C6;
    font-weight: bold;
}
</style>
