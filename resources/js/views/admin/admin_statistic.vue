<template>
<div class="container w-75">
    <div class="table-responsive p-4 border">
        <table class="table table-sm table-bordered">
            <tr>

            </tr>
            <tr class="bg-info">
                <th>Project</th>
                <th >Service</th>
                <th>Section</th>
                <th></th>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mars</th>
                <th>Apr</th>
                <th>May</th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Aug</th>
                <th>Sep</th>
                <th>Oct</th>
                <th>Nov</th>
                <th>Dec</th>
                <th>Total</th>
            </tr>
            <tr>
                <td rowspan="5" class="font-weight-bold border" style="vertical-align: middle !important;">Mobile <br> Medical</td>
                <td>ULM</td>
                <td>ULM</td>
                <td></td>
                <td v-for="i in data.ulm">{{i}}</td>
                <td class="font-weight-bold">-</td>
            </tr>
            <tr>
                <td>MidMod</td>
                <td>MidMod</td>
                <td></td>
                <td v-for="i in data.midMob">{{i}}</td>
                <td class="font-weight-bold">-</td>
            </tr>
            <tr>
                <td>DentMod</td>
                <td>DentMod</td>
                <td></td>
                <td v-for="i in 12">-</td>
                <td class="font-weight-bold">-</td>
            </tr>
            <tr>
                <td>Ambulance car</td>
                <td>Ambulance car</td>
                <td></td>
                <td v-for="i in 12">-</td>
                <td class="font-weight-bold">-</td>
            </tr>
            <tr>
                <td>Outreaches with partner</td>
                <td>Outreaches with partner</td>
                <td></td>
                <td v-for="i in 12">-</td>
                <td class="font-weight-bold">-</td>
            </tr>
            <tr class="border bg-light">
                <th colspan="4">
                    Total mobile medical
                </th>
                <th v-for="i in 12">
                    {{data.ulm[i]+ data.midMob[i]}}
                </th>
            </tr>
            <tr>
                <td rowspan="46" class="vertical font-weight-bold">Medical</td>
                <td rowspan="26" class="vertical">Outpatients</td>
                <td rowspan="3" class="vertical">General</td>
                <td>Consultation</td>
                <td v-for="i in data.general_consultation">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.general_consultation}}</td>
            </tr>
            <tr>
                <td>Injury/Woundcare</td>
                <td v-for="i in data.general_injury">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.general_injury}}</td>

            </tr>
            <tr>
                <td>Vaccination</td>
                <td v-for="i in data.general_vaccination">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.general_vaccination}}</td>
            </tr>
            <tr class="bg-light">
              <td class="font-weight-bold">Total Outpatient-General</td>
                <td></td>
                <td  class="font-weight-bold" v-for="i in total_outpatient_general">{{symbol(i)}}</td>
                <td  class="font-weight-bold" >{{col_total_outpatient_general}}</td>
            </tr>
            <tr>
                <td rowspan="5" class="vertical">Dental</td>
                <td>Consultation</td>
                <td v-for="i in data.dental_consultation">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.dental_consultation}}</td>
            </tr>
            <tr>
                <td>Extraction</td>
                <td v-for="i in data.dental_extraction">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.dental_extraction}}</td>
            </tr>
            <tr>
                <td>Cleaning</td>
                <td v-for="i in data.dental_cleaning">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.dental_cleaning}}</td>
            </tr>
            <tr>
                <td>Care</td>
                <td v-for="i in data.dental_care">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.dental_care}}</td>
            </tr>
            <tr>
                <td>Other</td>
                <td v-for="i in 12" >-</td>
                <td class="font-weight-bold bg-light"></td>
            </tr>
            <tr class="bg-light font-weight-bold">
                <td >Total Outpatient-Dental</td>
                <td></td>
                <td v-for="i in total_dental">{{symbol(i)}}</td>
                <td>{{col_total_outpatient_dental}}</td>
            </tr>
            <tr>
                <td rowspan="6" class="vertical">Obstetrical</td>
                <td>Ultrasound</td>
                <td v-for="i in data.obstetrical_ultrasound">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.obstetrical_ultrasound}}</td>
            </tr>
            <tr>
                <td>First prenatale care</td>
                <td v-for="i in data.obstetrical_first_cpn">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.obstetrical_first_cpn}}</td>
            </tr>
            <tr>
                <td>Follow-up prenatale care</td>
                <td v-for="i in data.obstetrical_cpn_followup">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.obstetrical_cpn_followup}}</td>
            </tr>
            <tr>
                <td>Postpartum Baby</td>
                <td v-for="i in data.postpartum_baby">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.postpartum_baby}}</td>
            </tr>
            <tr>
                <td>Postpartum Mom</td>
                <td v-for="i in data.postpartum_mom">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.postpartum_mom}}</td>
            </tr>
            <tr>
                <td>Postpartum Meeting</td>
                <td v-for="i in data.postpartum_meeting">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.postpartum_meeting}}</td>
            </tr>
            <tr class="bg-light">
                <td class="font-weight-bold">Total Outpatient-Obstetrical</td>
                <td></td>
                <td class="font-weight-bold" v-for="i in total_outpatient_obstetrical">{{symbol(i)}}</td>
                <td class="font-weight-bold">
                    {{col_total_outpatient_obstetrical}}
                </td>
            </tr>
            <tr>
                <td class="vertical" rowspan="4">Pediatric</td>
                <td>Vaccination</td>
                <td v-for="i in data.pediatric_vaccination">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.pediatric_vaccination}}</td>
            </tr>
            <tr>
                <td>Routine check up</td>
                <td v-for="i in data.pediatric_checkup">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.pediatric_checkup}}</td>
            </tr>
            <tr>
                <td>Sickness</td>
                <td v-for="i in data.pediatric_sickness">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.pediatric_sickness}}</td>

            </tr>
            <tr>
                <td>Injury/Woundcare</td>
                <td v-for="i in data.pediatric_injury">{{symbol(i)}}</td>
                <td class="font-weight-bold bg-light">{{total.pediatric_injury}}</td>
            </tr>
            <tr class="bg-light">
                <td class="font-weight-bold">Total Outpatient-Pediatric</td>
                <td></td>
                <td class="font-weight-bold" v-for="i in total_outpatient_pediatric">{{symbol(i)}}</td>
                <td class="font-weight-bold">{{col_total_outpatient_pediatric}}</td>
            </tr>
            <tr>
                <td >Dermatological</td>
                <td></td>
                <td v-for="i in data.dermatological">{{symbol(i)}}</td>
                <td class="font-weight-bold">{{total.dermatological}}</td>

            </tr>
            <tr class="bg-light">
                <td class="font-weight-bold bg-light" >Total Outpatient Dermatological</td>
                <td></td>
                <td class="font-weight-bold" v-for="i in data.dermatological">{{symbol(i)}}</td>
                <td class="font-weight-bold">{{total.dermatological}}</td>
            </tr>
            <tr>
                <td >Other</td>
                <td></td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr class="bg-light">
                <td class="font-weight-bold">Total Outpatient-Other</td>
                <td></td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr class="bg-light">
                <td class="font-weight-bold">TOTAL Outpatients</td>
                <td></td>
                <td></td>
                <td v-for="i in total_outpatient" class="font-weight-bold">{{symbol(i)}}</td>
                <td class="font-weight-bold">{{col_total_outpatient}}</td>
            </tr>
            <tr>
                <td rowspan="8" class="vertical">Inpatients</td>
                <td>General</td>
                <td></td>
                <td v-for="i in data.in_patient_general">{{symbol(i)}}</td>
                <td class="font-weight-bold">{{total.in_patient_general}}</td>

            </tr>
            <tr>
                <td>Dental</td>
                <td></td>
                <td v-for="i in data.in_patient_dental">{{symbol(i)}}</td>
                <td class="font-weight-bold">{{total.in_patient_dental}}</td>
            </tr>
            <tr>
                <td rowspan="2" class="vertical">Obstetrical</td>
                <td>Nr patient</td>
                <td v-for="i in data.in_patient_obstetrical">{{symbol(i)}}</td>
                <td class="font-weight-bold">{{total.in_patient_obstetrical}}</td>
            </tr>
            <tr>
                <td>Action/treatment</td>
                <td v-for="i in data.in_patient_obstetrical_action">{{symbol(i)}}</td>
                <td class="font-weight-bold">{{total.in_patient_obstetrical_action}}</td>
            </tr>
            <tr>
                <td rowspan="2" class="vertical">Pediatric</td>
                <td>Nr patient</td>
                <td v-for="i in data.in_patient_pediatric">{{symbol(i)}}</td>
                <td class="font-weight-bold">{{total.in_patient_pediatric}}</td>
            </tr>
            <tr>
                <td>Action/treatment</td>
                <td v-for="i in data.in_patient_pediatric_action">{{symbol(i)}}</td>
                <td class="font-weight-bold">{{total.in_patient_pediatric_action}}</td>
            </tr>
            <tr>
                <td>Dermatological</td>
                <td></td>
                <td v-for="i in data.in_patient_dermatological">{{symbol(i)}}</td>
                <td class="font-weight-bold">{{total.in_patient_dermatological}}</td>

            </tr>
            <tr>
                <td>Other</td>
                <td></td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr class="bg-light">
                <td colspan="3" class="font-weight-bold">TOTAL Inpatients</td>
                <td v-for="i in 13" class="font-weight-bold">-</td>
            </tr>
            <tr>
                <td>Deliveries</td>
                <td>Obstetrical</td>
                <td></td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr class="bg-light">
                <td colspan="3" class="font-weight-bold">TOTAL Deliveries</td>
                <td v-for="i in 13" class="font-weight-bold">-</td>
            </tr>
            <tr>
                <td rowspan="7">Surgeries</td>
                <td>General</td>
                <td></td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Dental</td>
                <td></td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td rowspan="2">Obstetrical</td>
                <td>C-section</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>EUG/Other</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Pediatric</td>
                <td></td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Dermatological</td>
                <td></td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Other</td>
                <td></td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr class="bg-light">
                <td colspan="3" class="font-weight-bold">TOTAL Surgeries</td>
                <td v-for="i in 13" class="font-weight-bold">-</td>
            </tr>
            <tr class="bg-light">
                <td colspan="4" class="font-weight-bold">TOTAL Medical</td>
                <td v-for="i in 13">-</td>
            </tr>
        </table>
    </div>
</div>
</template>

<script>
export default {
    name: "admin_statistic",
    data(){
        return{
            data:{
                ulm:[],
                midMob:[],
                general_consultation:[],
                general_vaccination:[],
                general_injury:[],
                dental_consultation:[],
                dental_extraction:[],
                dental_care:[],
                dental_cleaning:[],
                obstetrical_ultrasound:[],
                obstetrical_first_cpn:[],
                obstetrical_cpn_followup:[],
                pediatric_checkup:[],
                pediatric_vaccination:[],
                pediatric_sickness:[],
                pediatric_injury:[],
                postpartum_baby:[],
                postpartum_mom:[],
                postpartum_meeting:[],
                dermatological:[],
                in_patient_general:[],
                in_patient_dental:[],
                in_patient_obstetrical:[],
                in_patient_obstetrical_action:[],
                in_patient_pediatric:[],
                in_patient_pediatric_action:[],
                in_patient_dermatological:[],
                data_loaded:false
            }
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get("/api/v1/admin/statistics_overview").then(
                response=>{
                    this.data=response.data
                }
            )
            this.data_loaded=true

        },
        symbol(val){
            return val===0?"-":val
        },

    },
    computed:{
        total_dental(){
            let output=[]
            for(let i=0; i<12;i++){
                output.push(this.data.dental_consultation[i]+this.data.dental_extraction[i]+this.data.dental_care[i]+this.data.dental_cleaning[i])
            }
            return output
        },
        total_outpatient_general(){
            let output=[]
            for(let i=0; i<12;i++){
                output.push(this.data.general_consultation[i]+this.data.general_injury[i]+this.data.general_vaccination[i])
            }
            return output
        },
        total_outpatient_obstetrical(){
            let output=[]
            for(let i=0; i<12;i++){
                output.push(
                    this.data.obstetrical_ultrasound[i]+
                    this.data.obstetrical_first_cpn[i]+this.data.obstetrical_cpn_followup[i] +
                    this.data.postpartum_baby[i]+
                    this.data.postpartum_mom[i]+ this.data.postpartum_meeting[i]
                )
            }
            return output
        },
        total_outpatient_pediatric(){
            let output=[]
            for(let i=0; i<12;i++){
                output.push(
                    this.data.pediatric_injury[i]+ this.data.pediatric_sickness[i]+ this.data.pediatric_vaccination[i]+
                    this.data.pediatric_checkup[i]

                )
            }
            return output
        },
        total(){
            return{
                general_consultation:this.data.general_consultation.reduce((a,b)=>a+b,0),
                general_vaccination:this.data.general_vaccination.reduce((a,b)=>a+b,0),
                general_injury:this.data.general_injury.reduce((a,b)=>a+b,0),
                dental_consultation:this.data.dental_consultation.reduce((a,b)=>a+b,0),
                dental_extraction: this.data.dental_extraction.reduce((a,b)=>a+b,0),
                dental_care: this.data.dental_care.reduce((a,b)=>a+b,0),
                dental_cleaning: this.data.dental_cleaning.reduce((a,b)=>a+b,0),
                obstetrical_ultrasound: this.data.obstetrical_ultrasound.reduce((a,b)=>a+b,0),
                obstetrical_first_cpn: this.data.obstetrical_first_cpn.reduce((a,b)=>a+b,0),
                obstetrical_cpn_followup: this.data.obstetrical_cpn_followup.reduce((a,b)=>a+b,0),
                pediatric_checkup: this.data.pediatric_checkup.reduce((a,b)=>a+b,0),
                pediatric_vaccination: this.data.pediatric_vaccination.reduce((a,b)=>a+b,0),
                pediatric_sickness: this.data.pediatric_sickness.reduce((a,b)=>a+b,0),
                pediatric_injury: this.data.pediatric_injury.reduce((a,b)=>a+b,0),
                postpartum_baby: this.data.postpartum_baby.reduce((a,b)=>a+b,0),
                postpartum_mom: this.data.postpartum_mom.reduce((a,b)=>a+b,0),
                postpartum_meeting: this.data.postpartum_meeting.reduce((a,b)=>a+b,0),
                dermatological: this.data.dermatological.reduce((a,b)=>a+b,0),
                in_patient_general: this.data.in_patient_general.reduce((a,b)=>a+b,0),
                in_patient_dental: this.data.in_patient_dental.reduce((a,b)=>a+b,0),
                in_patient_obstetrical: this.data.in_patient_obstetrical.reduce((a,b)=>a+b,0),
                in_patient_obstetrical_action: this.data.in_patient_obstetrical_action.reduce((a,b)=>a+b,0),
                in_patient_pediatric: this.data.in_patient_pediatric.reduce((a,b)=>a+b,0),
                in_patient_pediatric_action: this.data.in_patient_pediatric_action.reduce((a,b)=>a+b,0),
                in_patient_dermatological: this.data. in_patient_dermatological.reduce((a,b)=>a+b,0),
            }
        },
        col_total_outpatient_general(){
            return this.total.general_injury+this.total.general_vaccination+this.total.general_consultation
        },
        col_total_outpatient_dental(){
          return this.total.dental_extraction+this.total.dental_care+this.total.dental_cleaning+this.total.dental_consultation
        },
        col_total_outpatient_obstetrical(){
            return this.total.obstetrical_ultrasound+ this.total.obstetrical_first_cpn+ this.total.obstetrical_cpn_followup+this.total.postpartum_baby+this.total.postpartum_mom+this.total.postpartum_meeting
        },
        col_total_outpatient_pediatric(){
            return this.total.pediatric_injury+ this.total.pediatric_sickness+this.total.pediatric_checkup+ this.total.pediatric_vaccination
        },
        total_outpatient(){
           return this.total_dental.map((a,i)=>{
               return a+ this.total_outpatient_general[i]+  this.total_outpatient_obstetrical[i]+
                   this.total_outpatient_pediatric[i]
           })
        },
        total_in_patient(){
            if(this.data_loaded){
                return this.in_patient_obstetrical.map((a,i)=>{
                    return a+2
                })
            }
        },
        col_total_outpatient(){
            return this.total_outpatient.reduce((a,b)=>a+b,0)
        }
    },

}
</script>

<style scoped>
.vertical{
    vertical-align: middle;
}
</style>
