<template>
    <div class="container-fluid vh-100">
        <div class="d-inline mb-2" v-if="!is_overview">
            <span class="font-weight-bold"  > ({{patient.id}})-{{patient.firstName}} {{patient.lastName}}</span>
            <v-btn class="float-right" x-small dark color="purple" @click="dialog=true" v-if="editable">New Data</v-btn>
        </div>
        <v-tabs
            v-model="tab"
            background-color="primary"
            dark
            height="25"
        >
            <v-tab
                v-for="item in ultrasound_exam_list"
                :key="item.fetus_id"
            >
                F--{{ item.fetus_id }}
            </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
            <v-tab-item
                v-for="item in ultrasound_exam_list"
                :key="item.fetus_id"
            >
                <v-card flat>
                    <v-card-text>
                      <div class="table-responsive">
                          <table class="table table-sm table-striped">
                              <thead>
                              <th>Date</th>
                              <th>Calc GA</th>
                              <th>US GA</th>
                              <th>Corrected GA</th>
                              <th>Intra Ut</th>
                              <th>Embryo visible</th>
                              <th>BPD</th>
                              <th>HC</th>
                              <th>AC</th>
                              <th>FL</th>
                              <th>GS</th>
                              <th>CRL</th>
                              <th>FHR</th>
                              <th>EWB</th>
                              <th>Norm growth</th>
                              <th>Heartbeat</th>
                              <th>Placenta type</th>
                              <th>Pos of baby</th>
                              <th>Pres of baby</th>
                              <th>Amnio liquid</th>
                              <th>Remark</th>
                              <th>Medical staff</th>
                              </thead>
                              <tbody>
                              <tr v-for="row in item.exams">
                                  <td>{{moment(row.created_at).format("DD/MMM/YYYY")}}</td>
                                  <td>{{row.calculated_ga}}</td>
                                  <td>{{row.ultrasound_ga}}</td>
                                  <td>{{row.corrected_ga}}</td>
                                  <td>{{row.intra_uterine}}</td>
                                  <td>{{row.embryo_visible}}</td>
                                  <td>{{row.bpd}}</td>
                                  <td>{{row.hc}}</td>
                                  <td>{{row.ac}}</td>
                                  <td>{{row.fl}}</td>
                                  <td>{{row.gs}}</td>
                                  <td>{{row.crl}}</td>
                                  <td>{{row.fhr}}</td>
                                  <td>{{row.ewb}}</td>
                                  <td>{{row.proportional_growth}}</td>
                                  <td>{{row.heart_beat}}</td>
                                  <td>{{row.placenta_type}}</td>
                                  <td>{{row.position_of_baby}}</td>
                                  <td>{{row.presentation_of_baby}}</td>
                                  <td>{{row.amniotic_liquid}}</td>
                                  <td>{{row.remark}}</td>
                                  <td>{{row.medical_staff}}</td>
                              </tr>
                              </tbody>
                          </table>
                      </div>
                    </v-card-text>
                </v-card>
            </v-tab-item>
        </v-tabs-items>
        <v-row
            align="start"
            justify="space-around"
            class="mt-4"
        >
            <v-btn
                tile
                color="purple"
                dark
                small
                @click="go_back"
                v-if="!is_overview"
            >
                <v-icon left>
                    mdi-arrow-left-bold
                </v-icon>
                Go back
            </v-btn>
        </v-row>
        <v-dialog
            v-model="dialog"
        >
            <v-card>
                <v-card-title class="text-h5">
                    ({{patient.id}})-{{patient.firstName}} {{patient.lastName}}
                </v-card-title>

                <v-card-text>
                   <ultrasound_form_new :admission="$route.params.ultrasound_admission" :admission_id="admission_id" @success="form_submitted"/>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import Ultrasound_form_new from "./ultrasound_form_new";
import moment from 'moment'
export default {
    name: "ultrasound_exam_crud",
    props:['is_overview','ultrasound_admission_id'],
    components: {Ultrasound_form_new},
    data(){
        return{
            tab:null,
            editable:false,
            patient:{},
            admission:null,
            admission_id:'',
            ultrasound_exam_list:[
                  {
                      fetus_id:'',
                      exams:[]
                  }
            ],
          dialog:false
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            if(this.$route.params.patient!==undefined){
                this.patient=this.$route.params.patient
                this.populate_exam_list(this.$route.params.ultrasound_admission.ultrasound_details)
            }
            if(this.$route.params.ultrasound_admission!==undefined){
                if(this.$route.params.ultrasound_admission.status==='open'){
                    this.editable=true
                }
            }
            this.admission_id= this.$route.params.admission_id ?? ''
            if(this.is_overview){
                axios.get(`/api/v1/patient_system/out_patient/obstetrical/ultrasound/details/${this.ultrasound_admission_id}`).then(response=>{
                    this.populate_exam_list(response.data.ultrasound_details)
                })
            }
        },
        populate_exam_list(src){
            let list_of_fetus_id=[]
            src.forEach(exam=>{
                list_of_fetus_id.push(exam.fetus_id)
            })
            let filtered_fetuses=[... new Set(list_of_fetus_id)]
            let output=[]
            filtered_fetuses.forEach(fetus=>{
                output.push(
                    {
                        fetus_id:fetus,
                        exams:src.filter(exam=>exam.fetus_id===fetus)
                    }
                )
            })
            this.ultrasound_exam_list=output
        },
        form_submitted(){
            this.dialog=false
            axios.get(`/api/v1/patient_system/out_patient/obstetrical/ultrasound/admission_list/${this.patient.id}`).then(response=>{
                this.populate_exam_list(response.data[0].ultrasound_details)
            })
        },
        go_back(){
            this.$router.push({
                name: "patient_ultrasound_admission_list",
                params: { admission:{
                        patient:this.patient
                    }
                }
            })
        }

    },
}
</script>

<style scoped>
.title{
    color: #1390C6;
}
</style>
