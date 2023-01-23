<template>
<div class="container-fluid w-75">
    <v-card>
        <v-card-text>
            <patient_information :patient_id="formData.patient_id"/>
        </v-card-text>
    </v-card>
        <v-card class="mt-2">
            <v-card-text>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <td>Date</td>
                            <td>Methods</td>
                            <td>Quantity</td>
                        </tr>
                        <tr>
                            <td>{{moment().format("MMM Do YY")}}</td>
                            <td>
                                <select class="form-control form-control-sm" v-model="formData.used_method">
                                    <option v-for="method in methods">{{method}}</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm" v-model="formData.qty"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <give_medicine @get_value="get_medicines" :reset="reset_medication_list"/>
                            </td>
                        </tr>
                        <tr class="table-borderless">
                            <td colspan="3">
                                <textarea class="form-control form-control-sm" placeholder="remark" v-model="formData.remark"></textarea>
                                <button class="btn btn-sm btn-primary mt-2 float-right" @click="submit">Submit</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </v-card-text>
        </v-card>
        <v-card class="mt-2">
            <v-card-text>
                <div class="table-responsive">
                    <h4 class="title">Data in the system</h4>
                    <table class="table table-sm">
                        <tr>
                            <td>Date</td>
                            <td>Methods</td>
                            <td>Quantity</td>
                            <td>Remark</td>
                        </tr>
                        <tr v-for="l in list">
                            <td>{{moment(l.created_at).format("MMM Do YY")}}</td>
                            <td>{{l.used_method}}</td>
                            <td>{{l.qty}}</td>
                            <td>{{l.remark}}</td>
                        </tr>
                    </table>
                </div>
            </v-card-text>
        </v-card>
</div>
</template>

<script>
import Patient_information from "../../../../components/patient_information";
import moment from "moment"
import Give_medicine from "../../../../components/give_medicine";
export default {
    name: "family_planning_form",
    components: {Give_medicine, Patient_information},
    data(){
        return{
            list:[],
            formData:{
                used_method:null,
                qty:'',
                patient_id:'',
                admission_id:'',
                remark:'',
                new_user:false
            },
            methods:['Microgynon','Microlut','DMPA-IM','DMPA-SC','Male condom','Female condom','Implanon NXT', 'Levoplant'],
            reset_medication_list:false,
        }
    },
    created(){
        this.init()
    },
    methods:{
        init(){
            this.formData.patient_id=this.$route.params.patient_id
            this.formData.admission_id=this.$route.params.admission_id
            this.get_data()
        },
        submit(){

                if(this.formData.methods!==null && this.formData.qty!==''){
                    axios.post('/api/v1/patient_system/out_patient/obstetrical/family_planning/main',this.formData).then(response=>{
                        if(response.data){
                            this.get_data()
                            this.formData={
                                used_method:'',
                                qty:'',
                                patient_id:'',
                                admission_id:'',
                                remark:'',
                                new_user:false
                            }
                        }
                    })

                }

        },
        get_data(){
            axios.get(`/api/v1/patient_system/out_patient/obstetrical/family_planning/main/${this.formData.patient_id}`).then(response=>{
                this.list=response.data.family_plannings
                //check whether new_user or old
                this.formData.new_user=(this.list.length>0)?0:1
            })
        },
        get_medicines(data){
            this.formData.medication=data
        },

    }
}
</script>

<style scoped>
.title{
    color:#1390C6;
    font-weight: bold;
}
</style>
