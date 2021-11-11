<template>
    <div class="container-fluid">
        <h6 class="text-center mt-2 form-title" v-if="accessory.form_type==='result'">Internal lab-work</h6>
        <h6 class="text-center mt-2 title" v-if="accessory.form_type !=='result'">C.1 Internal lab-work</h6>
        <patient_information :patient_id="accessory.admission.patient_id" v-if="accessory.form_type==='result'"></patient_information>
        <hr>
        <p class="title pl-2" v-if="accessory.form_type==='result'"> <v-icon class="text-white" >mdi-stethoscope</v-icon> &nbsp B) Today's actions</p>
        <div class="form-group row">
           <div class="col-2">
               <label>Date</label>
               <date-picker v-model="formData.date"
                            name="idDate"
                            id="idDate"
                            :input-debounce="500" mode="date"
                            :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
               >
                   <template v-slot="{ inputValue, inputEvents }">
                       <input
                           class="bg-white form-control form-control-sm px-2 py-1 rounded"
                           :value="inputValue"
                           v-on="inputEvents"
                           :disabled="accessory.form_read_only"
                       />
                   </template>
               </date-picker>
           </div>
        </div>
        <div class="row">
            <div class="col-6 border">
                <h6 class="text-center subtitle">BLOOD</h6>
                <div class="row">
                    <div class="col-6">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th colspan="2">Test</th>
                                    <th v-if="accessory.form_type==='result'">Result</th>
                                </tr>
                            </thead>
                            <tr v-for="test in formData.blood_test.pos_neg">
                                <td>
                                    {{test.label}}
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input" v-model="test.checked" :disabled="accessory.form_submitted || accessory.form_type==='result'"/>

                                </td>
                                <td v-if="test.checked && accessory.form_type==='result'">
                                    <select class="form-control form-control-sm" v-model="test.result" :disabled="!test.checked || accessory.form_read_only">
                                        <option value=""></option>
                                        <option v-for="item in formData.pos_neg">{{item}}</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-6">
                       <div class="table-responsive">
                           <table class="table table-sm">
                               <thead>
                               <tr>
                                   <th colspan="2">Test</th>
                                   <th v-if="accessory.form_type==='result'">Result</th>
                               </tr>
                               </thead>
                               <tr v-for="test in formData.blood_test.result">
                                   <td>
                                       {{test.label}}
                                   </td>
                                   <td>
                                       <input type="checkbox" class="form-check-input" v-model="test.checked" :disabled="accessory.form_submitted || accessory.form_type==='result'"/>

                                   </td>
                                   <td v-if="test.checked && accessory.form_type==='result'">
                                       <select class="form-control form-control-sm result" v-model="test.result" v-if="test.items!==null" :disabled="!test.checked || accessory.form_read_only">
                                           <option value=""></option>
                                           <option v-for="i in test.items">{{i}}</option>
                                       </select>
                                       <input class="form-control form-control-sm result" type="text" v-model="test.result" v-if="test.items===null" :disabled="!test.checked || accessory.form_read_only"/>
                                   </td>
                               </tr>
                           </table>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-6 border">
                <h6 class="text-center subtitle">URINE</h6>
                <div class="row">
                    <div class="col-4" v-for="test in formData.urine_test">
                        <div class="text-center font-weight-bold">
                            {{test.category}} &nbsp
                            <input type="checkbox" v-model="test.checked" @click="check_all(test)"/>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tr>
                                    <th colspan="2">Test</th>
                                    <th v-if="accessory.form_type==='result'">Result</th>
                                </tr>
                                <tr v-for="child in test.children">
                                    <td>
                                        {{child.label}}
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-check-input" v-model="child.checked" :disabled="accessory.form_submitted || accessory.form_type==='result'"/>
                                    </td>
                                    <td v-if="child.checked && accessory.form_type==='result'">
                                        <select class="form-control form-control-sm result" v-model="child.result" :disabled="!child.checked || accessory.form_read_only" v-if="child.items!==null">
                                            <option value=""></option>
                                            <option v-for="i in child.items">{{i}}</option>
                                        </select>
                                        <input class="form-control form-control-sm result" type="text" v-model="child.result" v-if="child.items===null" :disabled="!child.checked || accessory.form_read_only"/>

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label>Remark</label>
                <textarea class="form-control form-control-sm" v-model="formData.remark" :disabled="accessory.form_submitted || accessory.form_read_only"></textarea>
            </div>
        </div>
        <div class="text-right">
            <v-btn
                @click="submit"
                color="warning"
                x-small
                :disabled="accessory.form_submitted || accessory.form_read_only"
            >
                <span v-if="!accessory.form_submitted">Submit</span>
                <span v-if="accessory.form_submitted">Submitted</span>
            </v-btn>
        </div>

    </div>
</template>

<script>
import Patient_information from "../../../../components/patient_information";
export default {
    name: "internal_lab",
    props:['admission','form_type'],
    components: {Patient_information},
    data(){
        return{
            formData:{
                date:new Date(),
                pos_neg:['pos','neg'],
                blood_test:{
                    pos_neg:[
                        {db_name:'blood_covid',label:'COVID',checked:false,result:''},
                        {db_name:'blood_hiv',label:'HIV',checked:false,result:''},
                        {db_name:'blood_malaria',label:'Malaria',checked:false,result:''},
                        {db_name:'blood_syphilis',label:'Syphilis',checked:false,result:''},
                    ],
                    result:[
                        {db_name:'blood_bg',label:'BG',checked:false,result:'',items:['A','B','O','AB','pos','neg']},
                        {db_name:'blood_bilirubin',label:'Bilirubin',checked:false,result:'',items:null},
                        {db_name:'blood_crp',label:'CRP',checked:false,result:'',items:['neg','[10-40]','[40-80]','>80']},
                        {db_name:'blood_glycemia',label:'Glycemia',checked:false,result:'',items:null},
                        {db_name:'blood_hb',label:'HB',checked:false,result:'',items:null},
                        {db_name:'blood_ogtt',label:'OGTT',checked:false,result:'',items:['neg','suspicious','pos']},
                    ]
                },
                urine_test:[
                    {
                        category:'Pregnancy',
                        checked:false,
                        children:[{db_name:'urine_pregnancy_test',label:'Pregnancy_test', checked:false,result:'',items:['pos','neg']}]
                    },
                    {
                        category:'Small',
                        checked:false,
                        children:[
                            {db_name:'urine_small_ph',label:'PH',checked:false,result:'',items:['5.0','6.0','6.5','7.0','7.5','8.0','8+5']},
                            {db_name:'urine_small_glucose',label:'Glucose',checked:false,result:'',items:['neg','trace','+','++','+++','++++']},
                            {db_name:'urine_small_protein',label:'Protein',checked:false,result:'',items:['neg','trace','+','++','+++','++++']},
                        ]
                    },
                    {
                        category:'big',
                        checked:false,
                        children:[
                            {db_name:'urine_big_leucocyte',label:'Leucocyte',checked:false,result:'',items:['neg','pos','trace','small','moderate','large']},
                            {db_name:'urine_big_nitrite',label:'Nitrite',checked:false,result:'',items:['neg','pos']},
                            {db_name:'urine_big_protein',label:'Protein',checked:false,result:'',items:['neg','trace','+','++','+++','++++']},
                            {db_name:'urine_big_ph',label:'PH',checked:false,result:'',items:['5.0','6.0','6.5','7.0','7.5','8.0','8+5']},
                            {db_name:'urine_big_blood',label:'Blood',checked:false,result:'',items:['neg','trace','small','moderate','large']},
                            {db_name:'urine_big_sp_gravity',label:'SP gravity',checked:false,result:'',items:['1.000','1.005','1.010','1.015','1.020','1.025','1.030']},
                            {db_name:'urine_big_ketane',label:'Ketane',checked:false,result:'',items:['neg','pos','trace','small','moderate','large']},
                            {db_name:'urine_big_bilirubin',label:'Bilirubin',checked:false,result:'',items:['neg','pos','trace','small','moderate','large']},
                            {db_name:'urine_big_glucose',label:'Glucose',checked:false,result:'',items:['neg','trace','+','++','+++','++++']},
                        ]
                    }

                ],
                remark:''
            },
            accessory:{
                dateConfig: {
                    type: 'string',
                    mask:'iso',
                    masks: {
                        input: 'DD/MMM/YYYY',
                    },
                },
                form_submitted:false,
                form_type:'',
                admission:'',
                results:[],
                form_read_only:false
            },
        }
    },

    created(){
        if(this.$route.params.request){

            console.log(this.$route.params.request)
            this.accessory.admission=this.$route.params.request.admission
            this.accessory.results= this.$route.params.request.internal_lab_results
            this.accessory.form_type='result'
            let data=this.$route.params.request
            this.formData.blood_test.pos_neg.forEach(bt=>{
                bt.checked= data[bt.db_name]
                // bt.result=this.accessory.results[0][bt.db_name]
            })
            this.formData.blood_test.result.forEach(bt=>{
                bt.checked= data[bt.db_name]
                // bt.result=this.accessory.results[0][bt.db_name]
            })
            this.formData.urine_test.forEach(ut=>{
                ut.children.forEach(test=>{
                    test.checked=data[test.db_name]
                    // test.result=this.accessory.results[0][test.db_name]
                })
            })
            if(this.accessory.results.length>0){
                this.accessory.form_read_only=true
                this.formData.blood_test.pos_neg.forEach(bt=>{
                    bt.result=this.accessory.results[0][bt.db_name]
                    console.log(this.accessory.results[0][bt.db_name])
                })
                this.formData.blood_test.result.forEach(bt=>{
                    bt.result=this.accessory.results[0][bt.db_name]
                })
                this.formData.urine_test.forEach(ut=>{
                    ut.children.forEach(test=>{
                        test.result=this.accessory.results[0][test.db_name]
                    })
                })
            }
        }
    },
    methods:{
        async submit(){
            if(this.accessory.form_type!=='result'){
                this.formData.admission_id= this.admission.id
                axios.post("/api/v1/patient_system/internal_lab/resource",this.formData).then(response=>{
                    this.accessory.form_submitted=true
                })
            }else{
                this.formData.internal_lab_request_id=this.$route.params.request.id
                this.formData.user_id= window.auth.user.id
                axios.post("/api/v1/patient_system/internal_lab/save_result",this.formData).then(response=>{
                    if(response.data.success)  this.accessory.form_submitted=true
                })
            }
        },
        check_all(row){
            if(row.checked) row.children.forEach(child=>child.checked=false)
            else row.children.forEach(child=>child.checked=true)
        }
    },

}
</script>

<style scoped>
.title{
    color:white;
    background-color: #1390C6;
    font-size: 13px !important;
    font-weight:bold;
}
.subtitle{
    color:#1390C6;
    font-weight: bold;
}
.btn{
    color:white;
    background-color: #1390C6;
}
.result{
    width:50px;
}
.form-title{
    font-family: 'Enriqueta', arial, serif;
    line-height: 1.25;
    margin: 0 0 10px; font-size: 40px;
    font-weight: bold;
    color: #7c795d;
}
</style>
