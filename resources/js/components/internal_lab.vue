<template>
    <div>
        <h4 class="text-center form-title" v-if="form_type==='result'">LAB-WORK</h4>
        <patient_information :patient_id="admission.patient_id" v-if="form_type==='result'"></patient_information>
        <hr>
        <p class="title pl-2" v-if="form_type==='result'"> <v-icon class="text-white" >mdi-stethoscope</v-icon> &nbsp B) Today's actions</p>
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
                                    <th v-if="form_type==='result'">Result</th>
                                </tr>
                            </thead>
                            <tr v-for="test in formData.blood_test.pos_neg">
                                <td>
                                    {{test.title}}
                                </td>
                                <td>
                                    <input type="checkbox" class="form-check-input" v-model="test.checked"/>

                                </td>
                                <td v-if="form_type==='result'">
                                    <select class="form-control form-control-sm" v-model="test.result" :disabled="!test.checked">
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
                                   <th v-if="form_type==='result'">Result</th>
                               </tr>
                               </thead>
                               <tr v-for="test in formData.blood_test.result">
                                   <td>
                                       {{test.title}}
                                   </td>
                                   <td>
                                       <input type="checkbox" class="form-check-input" v-model="test.checked"/>

                                   </td>
                                   <td v-if="form_type==='result'">
                                       <select class="form-control form-control-sm result" v-model="test.result" v-if="test.items!==null" :disabled="!test.checked">
                                           <option value=""></option>
                                           <option v-for="i in test.items">{{i}}</option>
                                       </select>
                                       <input class="form-control form-control-sm result" type="text" v-model="test.result" v-if="test.items===null" :disabled="!test.checked"/>
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
                        <p class="text-center font-weight-bold">{{test.category}}</p>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tr>
                                    <th colspan="2">Test</th>
                                    <th v-if="form_type==='result'">Result</th>
                                </tr>
                                <tr v-for="child in test.children">
                                    <td>
                                        {{child.title}}
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-check-input" v-model="child.checked"/>
                                    </td>
                                    <td v-if="form_type==='result'">
                                        <select class="form-control form-control-sm result" v-model="child.result" :disabled="!child.checked" v-if="child.items!==null">
                                            <option value=""></option>
                                            <option v-for="i in child.items">{{i}}</option>
                                        </select>
                                        <input class="form-control form-control-sm result" type="text" v-model="child.result" v-if="child.items===null" :disabled="!child.checked"/>

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
                <textarea class="form-control form-control-sm"></textarea>
            </div>
        </div>
        <div class="text-right" v-if="form_type==='result'">
            <v-btn
                text
                @click="submit"
                class="btn"
            >
                Submit
            </v-btn>
        </div>

    </div>
</template>

<script>
import Patient_information from "./patient_information";
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
                        {title:'COVID',checked:false,result:''},
                        {title:'HIV',checked:false,result:''},
                        {title:'Malaria',checked:false,result:''},
                        {title:'Syphilis',checked:false,result:''},
                    ],
                    result:[
                        {title:'BG',checked:false,result:'',items:['A','B','O','AB','pos','neg']},
                        {title:'Bilirubin',checked:false,result:'',items:null},
                        {title:'CRP',checked:false,result:'',items:['neg','[10-40]','[40-80]','>80']},
                        {title:'Glycemia',checked:false,result:'',items:null},
                        {title:'HB',checked:false,result:'',items:null},
                        {title:'PTT',checked:false,result:'',items:null},
                    ]
                },
                urine_test:[
                    {
                        category:'Pregnancy',
                        children:[{title:'Pregnancy_test', checked:false,result:'',items:['pos','neg']}]
                    },
                    {
                        category:'Small',
                        children:[
                            {title:'PH',checked:false,result:'',items:null},
                            {title:'Glucose',checked:false,result:'',items:null},
                            {title:'Protein',checked:false,result:'',items:null},
                        ]
                    },
                    {
                        category:'big',
                        children:[
                            {title:'Leucocyte',checked:false,result:'',items:null},
                            {title:'Nitrite',checked:false,result:'',items:null},
                            {title:'Protein',checked:false,result:'',items:null},
                            {title:'PH',checked:false,result:'',items:null},
                            {title:'blood',checked:false,result:'',items:['A','B','O','AB','pos','neg']},
                            {title:'SP gravity',checked:false,result:'',items:null},
                            {title:'Ketane',checked:false,result:'',items:null},
                            {title:'Bilirubin',checked:false,result:'',items:null},
                            {title:'Glucose',checked:false,result:'',items:null},
                        ]
                    }

                ]
            },
            accessory:{
                dateConfig: {
                    type: 'string',
                    mask:'iso',
                    masks: {
                        input: 'DD/MMM/YYYY',
                    },
                },
            },
        }
    },
    methods:{
        async submit(){

        }
    }
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
