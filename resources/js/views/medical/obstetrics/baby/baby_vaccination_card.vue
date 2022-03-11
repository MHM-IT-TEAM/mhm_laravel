<template>
    <div class="container">
        <form class="p-4" @submit.prevent="submit">
            <h2>INFANTILE CARD</h2>
            <br />
            <table class="myTable1" >
                <tbody>
                <tr>
                    <td style="width:2%">
                        <div class="vertical p-2">CHILD</div>
                        <input type="text"  style="width:45px; margin-bottom: 10px;border:solid black 1px" v-model="formData.patient.id" @change="changePat"/>
                    </td>
                    <td style="width:50%;">NAME:<div id="name_child"><p>{{fullName}}</p></div></td>
                    <td>BirthDate<p>{{formData.patient.birthDate}}</p></td>
                    <td>WEIGHT AT BIRTH:<div id="poids_naiss">{{formData.patient.weight_at_birth}}</div></td>
                </tr>
                <tr>
                    <td style="width:2%">
                        <div class="vertical" style="padding: 5px">MOM</div>
                        <input type="text"  style="width:45px; margin-bottom: 10px; border:solid black 1px" v-model="formData.mom.id" @change="changeMom"/>
                    </td>
                    <td>NAME:<div id="name_mother"><p>{{fullName_mom}}</p></div></td>
                    <td colspan="2">ADRESS:<div id="domicile">{{formData.mom.adress}}</div></td>
                </tr>

                </tbody>
            </table>
            <table class="myTable2">
                <tbody>
                <tr>
                    <th>VACCINS</th>
                    <th>BCG</th>
                    <th>POLIO 0</th>
                    <th>
                        DTCHelpB <br />
                        Hib1
                    </th>
                    <th>Polio1</th>
                    <th>
                        DTCHelpB <br />
                        Hib2
                    </th>
                    <th>Polio2</th>
                    <th>
                        DTCHelpB <br />
                        Hib3
                    </th>
                    <th>Polio3</th>
                    <th style="border-right: solid 1px black">VAR 1</th>
                    <th>VAR 2</th>
                </tr>
                <tr>
                    <th>
                       EXPECTED AGE FOR <br/> VACCINATION
                    </th>
                    <th colspan="2" style="text-align: center;"> 0 MONTH</th>
                    <th colspan="2" style="text-align: center;"> 6 WEEK</th>
                    <th colspan="2" style="text-align: center;"> 10 WEEK</th>
                    <th colspan="2" style="text-align: center;"> 14 WEEK</th>
                    <th style="text-align: center;">9 MONTH</th>
                    <th style="text-align: center;">Betw 15 AND 18 MONTH</th>
                </tr>
                <tr >
                    <th>
                        ACTUAL <br />
                        DATE OF VACCINATION
                    </th>
                    <td style="border-right: solid 1px black">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.bcg)==='boolean'" v-model="formData.bcg"/>
                        <input type="date" class="date"  v-if="typeof(formData.bcg)!=='boolean'" v-model="formData.bcg"/>
                    </td>
                    <td style="border-right: solid 1px black">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.polio0)==='boolean'" v-model="formData.polio0"/>
                        <input type="date" class="date"  v-if="typeof(formData.polio0)!=='boolean'" v-model="formData.polio0"/>
                    </td>
                    <td style="border-right: solid 1px black">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.dtc1)==='boolean'" v-model="formData.dtc1"/>
                        <input type="date" class="date"  v-if="typeof(formData.dtc1)!=='boolean'" v-model="formData.dtc1"/>
                    </td>
                    <td style="border-right: solid 1px black">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.polio1)==='boolean'" v-model="formData.polio1"/>
                        <input type="date" class="date"  v-if="typeof(formData.polio1)!=='boolean'" v-model="formData.polio1"/>
                    </td>
                    <td style="border-right: solid 1px black">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.dtc2)==='boolean'" v-model="formData.dtc2"/>
                        <input type="date" class="date"  v-if="typeof(formData.dtc2)!=='boolean'" v-model="formData.dtc2"/>
                    </td>
                    <td style="border-right: solid 1px black">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.polio2)==='boolean'" v-model="formData.polio2"/>
                        <input type="date" class="date"  v-if="typeof(formData.polio2)!=='boolean'" v-model="formData.polio2"/>
                    </td>
                    <td style="border-right: solid 1px black">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.dtc3)==='boolean'" v-model="formData.dtc3"/>
                        <input type="date" class="date"  v-if="typeof(formData.dtc3)!=='boolean'" v-model="formData.dtc3"/>
                    </td>
                    <td style="border-right: solid 1px black">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.polio3)==='boolean'" v-model="formData.polio3"/>
                        <input type="date" class="date"  v-if="typeof(formData.polio3)!=='boolean'" v-model="formData.polio3"/>
                    </td>

                    <td style="border-right: solid 1px black">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.var1)==='boolean'" v-model="formData.var1"/>
                        <input type="date" class="date"  v-if="typeof(formData.var1)!=='boolean'" v-model="formData.var1"/>
                    </td>
                    <td style="border-right: solid 1px black">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.var2)==='boolean'" v-model="formData.var2"/>
                        <input type="date" class="date"  v-if="typeof(formData.var2)!=='boolean'" v-model="formData.var2"/>
                    </td>
                </tr>

                <tr>
                    <th colspan="3" style="text-align: center;">VACCINS</th>
                    <th colspan="2" style="text-align: center;">PCV-10-1</th>
                    <th colspan="2" style="text-align: center;">PCV-10-2</th>
                    <th style="text-align: center;">PCV-10-3</th>
                    <th style="text-align: center;">VPI</th>
                    <th style="text-align: center;">ROTAVE 1°prise</th>
                    <th style="text-align: center;">ROTAVE 2°prise</th>
                </tr>
                <tr>
                    <th colspan="3">EXPECTED VACCINATION AGE</th>
                    <th colspan="2" style="text-align: center;"> 6 WEEK</th>
                    <th colspan="2" style="text-align: center;"> 10 WEEK</th>
                    <th colspan="2" style="text-align: center;"> 14 WEEK</th>
                    <th style="text-align: center;">6 WEEK</th>
                    <th style="text-align: center;">10 WEEK</th>
                </tr>
                <tr>
                    <th colspan="3" style="padding: 10px">
                        ACTUAL DATE OF VACCINATION
                    </th>
                    <th colspan="2" style="border-right: solid 1px black; text-align: center;">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.pcv1)==='boolean'" v-model="formData.pcv1"/>
                        <input type="date" class="date"  v-if="typeof(formData.pcv1)!=='boolean'" v-model="formData.pcv1"/>
                    </th>
                    <th colspan="2" style="border-right: solid 1px black; text-align: center;">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.pcv2)==='boolean'" v-model="formData.pcv2"/>
                        <input type="date" class="date"  v-if="typeof(formData.pcv2)!=='boolean'" v-model="formData.pcv2"/>
                    </th>
                    <th style="border-right: solid 1px black; text-align: center;">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.pcv3)==='boolean'" v-model="formData.pcv3"/>
                        <input type="date" class="date"  v-if="typeof(formData.pcv3)!=='boolean'" v-model="formData.pcv3"/>
                    </th>
                    <th style="border-right: solid 1px black; text-align: center;">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.vpi)==='boolean'" v-model="formData.vpi"/>
                        <input type="date" class="date"  v-if="typeof(formData.vpi)!=='boolean'" v-model="formData.vpi"/>
                    </th>
                    <th style="border-right: solid 1px black; text-align: center;">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.rota1)==='boolean'" v-model="formData.rota1"/>
                        <input type="date" class="date"  v-if="typeof(formData.rota1)!=='boolean'" v-model="formData.rota1"/>
                    </th>
                    <th style="border-right: solid 1px black; text-align: center;">
                        <input type="checkbox" class="ml-4"  v-if="typeof(formData.rota2)==='boolean'" v-model="formData.rota2"/>
                        <input type="date" class="date"  v-if="typeof(formData.rota2)!=='boolean'" v-model="formData.rota2"/>
                    </th>
                </tr>
                </tbody>
            </table>
            <table id="tbl1" class="myTable3" style="width: 73%; float: left">
                <tbody>
                <tr>
                    <td rowspan="2" style="width: 5%">
                        <div class="vertical" style="text-align: center">
                            ACTIVE<br />RESEARCH
                        </div>
                    </td>
                    <td style="width: 5%">
                        <div class="vertical" style="padding: 5px">DATES</div>
                    </td>
                    <td v-for="item in accessory.active_research_result">
                            <p class="p-2">{{item.research_date}}</p>
                    </td>
                    <td v-for="i in formData.active_research">
                        <span class="date_rdv vertical1"><input type="date" class='date' style="width:60px;font-size:10px;" v-model="i.research_date"/></span>
                    </td>

                </tr>
                <tr>
                    <td><div class="vertical" style="padding: 5px">CODE</div></td>
                    <td v-for="item in accessory.active_research_result">
                            <p class="ml-4 mt-4">{{item.code}}</p>
                    </td>
                    <td v-for="i in formData.active_research">
                        <span class="mt-2" ><input type="text" style="width:40px" v-model="i.code"/></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="vertical" style="padding: 5px; text-align: center">
                            DATES<br />Appointment
                        </div>
                    </td>
                    <td v-for="item in accessory.appointment_result">
                        <p class="ml-4 mt-4">{{item.date}}</p>
                    </td>
                    <td v-for="i in formData.appointment">
                        <span class="mt-2 date_rdv vertical1"><input type="date" style="width:60px;font-size:10px;" v-model=" i.date"/></span>
                    </td>

                </tr>
                </tbody>
            </table>
            <table id="tbl2" class="myTable3" style="width: auto; float: rigth;">
                <tbody>
                <tr>
                    <th colspan="2" style="font-weight: normal">
                        CODE FOR ACTIVE RESEARCH
                    </th>
                </tr>
                <tr>
                    <th>1</th>
                    <td>Rattrapage vaccinal</td>
                </tr>
                <tr>
                    <th>2</th>
                    <td>Growth surveillance</td>
                </tr>
                <tr>
                    <th>3</th>
                    <td>For curative care</td>
                </tr>
                <tr style="height: 109px">
                    <th></th>
                    <td></td>
                </tr>
                </tbody>
            </table>

                <button type="submit"  class="btn btn-primary" >Submit </button>


        </form>
    </div>
</template>

<script>
export default {
    name: "infantile_card",
    data(){
        return{
            formData:{
                patient:{
                    id:'',
                    birthDate:'',
                    firstName:'',
                    lastName:'',
                    weight_at_birth:'',
                },
                mom:{
                    id:'',
                    firstName:'',
                    lastName:'',
                    Adress:''
                },
                bcg:false,
                polio0:false,
                dtc1:false,
                polio1:false,
                dtc2:false,
                polio2:false,
                dtc3:false,
                polio3:false,
                var1:false,
                var2:false,
                pcv1:false,
                pcv2:false,
                pcv3:false,
                vpi:false,
                rota1:false,
                rota2:false,
                active_research:[],
                appointment:[],
                consultation_id:''

            },
            defaultData:{
                patient:{
                    id:'',
                    birthDate:'',
                    firstName:'',
                    lastName:'',
                    weight_at_birth:'',
                },
                mom:{
                    id:'',
                    firstName:'',
                    lastName:'',
                    Adress:''
                },
                bcg:false,
                polio0:false,
                dtc1:false,
                polio1:false,
                dtc2:false,
                polio2:false,
                dtc3:false,
                polio3:false,
                var1:false,
                var2:false,
                pcv1:false,
                pcv2:false,
                pcv3:false,
                vpi:false,
                rota1:false,
                rota2:false,
                active_research:[],
                appointment:[],

            },
            accessory:{
                max_td_length:16,
                active_research_result:[],
                appointment_result:[]
            }
        }
    },
    computed:{
        td_avalaible(){
            return this.accessory.max_td_length-this.accessory.active_research_result.length
        },
        appointment_avalaible(){

            return this.accessory.max_td_length-this.accessory.appointment_result.length
        },
        fullName() {
            return this.formData.patient.firstName + " " + this.formData.patient.lastName

        },
        fullName_mom() {
            return this.formData.mom.firstName + " " + this.formData.mom.lastName

        },
    },
    created(){
        this.init()
    },
    methods:{
        async changePat(){
            let patData = await axios.get(`/api/v1/patient_system/patient/patient/${this.formData.patient.id}/edit`);
            this.formData.patient.firstName=patData.data.patient.firstName !==null?patData.data.patient.firstName:''
            this.formData.patient.lastName=patData.data.patient.lastName!==null?patData.data.patient.lastName:''
            this.formData.patient.birthDate=patData.data.patient.birthDate
            axios.get(`/api/v1/patient_system/out_patient/obstetrical/baby_checkup/${this.formData.patient.id}`)
            .then(response=>this.formData.patient.weight_at_birth=response.data.birth_medical_data[0].birth_weight)
            axios.get(`/api/v1/patient_system/out_patient/obstetrical/baby_vaccination/${this.formData.patient.id}`)
            .then(response=>{
                if(response.data.vaccinRecord.length>0){
                    this.check(response.data.vaccinRecord)
                }
                this.fill_research_data(response.data.active_research,response.data.appointment)
            })
        },
        async changeMom(){
            let patData = await axios.get(`/api/v1/patient_system/patient/patient/${this.formData.mom.id}/edit`);
            this.formData.mom.firstName=patData.data.patient.firstName !==null?patData.data.patient.firstName:''
            this.formData.mom.lastName=patData.data.patient.lastName!==null?patData.data.patient.lastName:''
            this.formData.mom.adress=patData.data.patient.adress
        },
        async submit(){
            await axios.post('/api/v1/patient_system/out_patient/obstetrical/baby_vaccination',this.formData)
            .then(response=>{
                if(response.data.success===true){
                    this.$toast.open({
                        message: 'Data submitted',
                        position: "top-right",
                    });
                    this.formData=Object.assign({},this.defaultData)
                    this.accessory.active_research_result=[]
                    this.accessory.appointment_result=[]
                }
            })
        },
        check(data){
            let fdKey=Object.keys(this.formData)
            let updateField=['bcg','polio0','dtc1','polio1','polio2','dtc2','dtc3','polio3','var1','var2','pcv1','pcv2','pcv3','vpi','rota1','rota2']
            data.forEach(row=>{
                let resKey= Object.keys(row)
                fdKey.forEach(key=>{
                    if(resKey.indexOf(key)!==-1 && updateField.indexOf(key)!==-1){
                        if(row[key]===1){
                            this.formData[key]=row.created_at
                        }
                    }
                })
            })
        },
        fill_research_data(data,appointment){
            if(data.length>0){
                data.forEach(item=>{
                    this.accessory.active_research_result.push(item)
                })
            }
            if(appointment.length>0){
                appointment.forEach(item=>{
                    this.accessory.appointment_result.push({date:item.date})
                })
            }
            for (let i=0; i<this.td_avalaible; i++){
                this.formData.active_research.push({research_date:'',code:''})
            }
            for(let i=0;i<this.appointment_avalaible;i++){
                this.formData.appointment.push({date:''})
            }
        },
        init(){
            this.formData.patient.id= this.$route.params.patient_id
            this.formData.consultation_id=this.$route.params.consultation_id
            this.changePat()
        }

    },

}
</script>

<style scoped>
form{
    background:khaki;
    padding-bottom:50px;
}
table.myTable {
    width: 50%;
    margin-right: 100px;
}
table.myTable1 {
    width: 100%;
    margin-right: 5px;
    margin-bottom: 0px;
}
.myTable1 tr td {
    border: 1px solid black;
}
input[type="date"]::-webkit-calendar-picker-indicator {
    display: none;
    -webkit-appearance: none;
    max-width: 65px;
}

h2 {
    margin: 0 auto;
    text-align: center;
}
.vertical {
    writing-mode: vertical-rl;
    transform: rotate(180deg);
}
.vertical1 {
    width: 50px;
    writing-mode: vertical-rl;
    transform: rotate(-90deg);
}

table.myTable2 {
    width: 100%;
    margin-right: 5px;
    margin-top: 0px;
}
.myTable2 th {
    font-weight: normal;
    border: 1px solid rgb(0, 0, 0);
}
.myTable3 {
    width: 100%;
}

table.myTable3 td {
    border: 1px solid rgb(0, 0, 0);
}

.myTable3 th {
    border: 1px solid rgb(0, 0, 0);
}

.myTable3 td {
    width: 50px;
}
table#tbl1.myTable3 {
    border-color: red;
}
td.vertical1 input.rdv {
    width: 60px;
    padding: 2px;
    font-size: 12px;
    border: none;
}
td.vertical1 {
    padding: 0px;

}

#tbl2 th {
    width: 5%;
}

#tbl2 td {
    text-align: center;
}

table {
    border-collapse: collapse;
    /* margin: 5px; */
    margin-left: auto;
}
.container {
    margin: 20px 25px 10px 25px;
}
input {
    background: khaki;
}
input.code {
    width: 20px;
    border: none;
    /* height: 66px; */
}

input.date {
    width: 95px;
    font-size: 9px;
}
/*.date_rdv {
  padding: -5px;
  margin: -5px;
}*/

@media print {
    body {
        background: none;
    }
    input {
        background: none;
    }
    #go {
        display: none;
    }
}
</style>
