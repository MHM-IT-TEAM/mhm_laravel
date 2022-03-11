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
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Vaccination</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr class="bg-light">
              <td class="font-weight-bold">Total Outpatient-General</td>
                <td></td>
                <td v-for="i in 13">-</td>
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
                <td>{{total.dental_extraction+ total.dental_care+total.dental_cleaning+total.dental_consultation}}</td>
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
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Postpartum Baby</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Postpartum Mom</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Postpartum Meeting</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr class="bg-light">
                <td class="font-weight-bold">Total Outpatient-Obstetrical</td>
                <td></td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td class="vertical" rowspan="4">Pediatric</td>
                <td>Vaccination</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Routine check up</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Sickness</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Injury/Woundcare</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr class="bg-light">
                <td class="font-weight-bold">Total Outpatient-Pediatric</td>
                <td></td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td >Dermatological</td>
                <td></td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr class="bg-light">
                <td class="font-weight-bold bg-light" >Total Outpatient Dermatological</td>
                <td></td>
                <td v-for="i in 13">-</td>
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
                <td>Other
                <td v-for="i in 13" class="font-weight-bold">-</td>
            </tr>
            <tr>
                <td rowspan="8" class="vertical">Inpatients</td>
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
                <td rowspan="2" class="vertical">Obstetrical</td>
                <td>Nr patient</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Action/treatment</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td rowspan="2" class="vertical">Pediatric</td>
                <td>Nr patient</td>
                <td v-for="i in 13">-</td>
            </tr>
            <tr>
                <td>Action/treatment</td>
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
                dental_consultation:[],
                dental_extraction:[],
                dental_care:[],
                dental_cleaning:[],
                obstetrical_ultrasound:[],
                obstetrical_first_cpn:[],
                obstetrical_cpn_followup:[]
            }
        }
    },
    created(){
        this.init()
    },
    methods:{
        init(){
            axios.get("/api/v1/admin/statistics_overview").then(
                response=>{
                    this.data=response.data
                }
            )

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
        total(){
            return{
                general_consultation:this.data.general_consultation.reduce((a,b)=>a+b,0),
                dental_consultation:this.data.dental_consultation.reduce((a,b)=>a+b,0),
                dental_extraction: this.data.dental_extraction.reduce((a,b)=>a+b,0),
                dental_care: this.data.dental_care.reduce((a,b)=>a+b,0),
                dental_cleaning: this.data.dental_cleaning.reduce((a,b)=>a+b,0),
                obstetrical_ultrasound: this.data.obstetrical_ultrasound.reduce((a,b)=>a+b,0),
                obstetrical_first_cpn: this.data.obstetrical_first_cpn.reduce((a,b)=>a+b,0),
            }
        }
    }

}
</script>

<style scoped>
.vertical{
    vertical-align: middle;
}
</style>
