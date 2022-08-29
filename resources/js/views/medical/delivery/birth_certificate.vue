<template>
    <div class="certificate_container">
        <div class="content">
                <table class="table table-borderless table-sm header">
                    <tr>
                        <td>COMMUNE AMBOHIDRATRIMO</td>
                        <td class="text-right" style="padding-right:17px">REPOBLIKAN ' I MADAGASIKARA</td>
                    </tr>
                    <tr>
                        <td>FOKONTANY: Ambovo</td>
                        <td class="text-right">Fitiavana-Tanindrazana-Fandrosoana</td>
                    </tr>
                    <tr>
                        <td>CSB Ambovo</td>
                        <td class="text-right" style="padding-right: 140px">------0------</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="/storage/assets/media/images/system/MHMlogo_PRINT.jpg" id="logo"/>
                        </td>
                        <td class="text-right" style="padding-right: 140px">
                            <strong><input type="text" class="text-right" @change="fetchData" v-model="formData.code" placeholder="Ref" :class="{'error':$v.formData.code.$error}"/></strong>
                        </td>
                    </tr>
                </table>
                <table class="table table-borderless table-sm header">
                    <tr>
                        <td><h4 class="person">Momba ny zaza:</h4></td>
                    </tr>
                    <tr class="d-none d-print-block">
                        <td colspan="2">Anarana sy Fanampiny: {{baby_fullName}}</td>
                    </tr>
                    <tr class="d-print-none">
                        <td colspan="2">
                            Anarana sy Fanampiny: <input type="text" style="width:40%" v-model="formData.baby_firstName" placeholder="Firstname" :class="{'error':$v.formData.baby_firstName.$error}"/> &nbsp <input type="text" style="width:30%" v-model="formData.baby_lastName" placeholder="Lastname" :class="{'error':$v.formData.baby_lastName.$error}"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Daty sy ora nahaterahana: <input type="date" v-model="formData.birth_date"/> &nbsp tamin'ny (ora):<input type="time" v-model="formData.birth_time"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Lahy/vavy:
                            <select v-model="formData.baby_gender">
                                <option></option>
                                <option value="F">Zazavavy</option>
                                <option value="M">Zazalahy</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Toerana nahaterahana: CH MHM Ambovo Ambohidratrimo &nbsp &nbsp &nbsp Fokontany:Ambovo</td>
                    </tr>
                    <tr>
                        <td><h4 class="person">Momba ny Rainy:</h4></td>
                    </tr>
                    <tr>
                        <td>
                            Vita soratra ara-dalana ve? &nbsp
                            <strong><select v-model="formData.parent_married">
                                <option></option>
                                <option value=1>Eny</option>
                                <option value=0>Tsia</option>
                            </select></strong> &nbsp
                            Raha tsia, manjanaka  ny zaza ve ny rainy?
                            <strong><select v-model="formData.dad_parenting">
                                <option></option>
                                <option value=1>Eny</option>
                                <option value=0>Tsia</option>
                            </select></strong>
                        </td>
                    </tr>
                    <tr class="d-none d-print-block">
                        <td>
                            Anarana sy fanampiny: &nbsp {{dad_fullName}}
                        </td>
                    </tr>
                    <tr class="d-print-none">
                        <td>
                            Anarana sy fanampiny: &nbsp <input type="text" style="width:40%" v-model="formData.dad_firstName" placeholer="Firstname"/> &nbsp <input type="text" style="width:30%" v-model="formData.dad_lastName" placeholder="Lastname"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Daty sy toerana nahaterahana: &nbsp <input type="text" v-model="formData.dad_dob" /> &nbsp <input type="text" style="width:30%" v-model="formData.dad_pob"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Asa atao: &nbsp <input type="text" style="width:70%" v-model="formData.dad_job"/> </td>
                    </tr>
                    <tr>
                        <td>CIN: &nbsp <input type="text" v-model="formData.dad_cin_no"/> &nbsp tamin'ny <input type="date" v-model="formData.dad_cin_date"/> &nbsp  tao <input type="text" style="width:40%;" v-model="formData.dad_cin_place"/> </td>
                    </tr>
                    <tr>
                        <td>Fonenana:&nbsp <input type="text" style="width:70%" v-model="formData.dad_address"/> </td>
                    </tr>
                    <tr>
                        <td><h4 class="person">Momba ny Reniny:</h4></td>
                    </tr>
                    <tr class="d-none d-print-block">
                        <td >
                            Anarana sy fanampiny: &nbsp {{mom_fullName}}
                        </td>
                    </tr>
                    <tr  class="d-print-none">
                        <td>
                            Anarana sy fanampiny: &nbsp <input type="text" style="width:40%" v-model="formData.mom_firstName" placeholder="Firstname" :class="{'error':$v.formData.mom_firstName.$error}"/> &nbsp <input type="text" style="width:30%" v-model="formData.mom_lastName" placeholder="Lastname" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Daty sy toerana nahaterahana: &nbsp <input type="text" v-model="formData.mom_dob" /> &nbsp <input type="text" style="width:40%" v-model="formData.mom_pob"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Asa atao: &nbsp <input type="text" style="width:70%" v-model="formData.mom_job"/> </td>
                    </tr>
                    <tr>
                        <td>Fonenana:&nbsp <input type="text" style="width:70%" v-model="formData.mom_address" :class="{'error':$v.formData.mom_address.$error}"/> </td>
                    </tr>
                    <tr>
                        <td><h4 class="person">Momba ny mpanao fanambarana:</h4> </td>
                        <td> <button class="btn d-print-none" @click="make_dad_declarant">Make the dad declarant</button></td>
                    </tr>
                    <tr class="d-none d-print-block">
                        <td>
                            Anarana sy fanampiny: &nbsp {{declarant_fullName}}
                        </td>
                    </tr>
                    <tr class="d-print-none">
                        <td >
                            Anarana sy fanampiny: &nbsp <input type="text" style="width:40%" v-model="formData.declarant_firstName" :class="{'error':$v.formData.declarant_firstName.$error}"/> &nbsp <input type="text" style="width:30%" v-model="formData.declarant_lastName"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Daty sy toerana nahaterahana: &nbsp <input type="text" v-model="formData.declarant_dob" :class="{'error':$v.formData.declarant_dob.$error}" /> &nbsp <input type="text" style="width:40%" v-model="formData.declarant_pob" :class="{'error':$v.formData.declarant_pob.$error}"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Asa atao: &nbsp <input type="text" style="width:70%" v-model="formData.declarant_job"/> </td>
                    </tr>
                    <tr>
                        <td>CIN: &nbsp <input type="text" v-model="formData.declarant_cin_no" :class="{'error':$v.formData.declarant_cin_no.$error}"/> &nbsp tamin'ny <input type="date" v-model="formData.declarant_cin_date" :class="{'error':$v.formData.declarant_cin_date.$error}"/> &nbsp  tao <input type="text" style="width:40%;" v-model="formData.declarant_cin_place" :class="{'error':$v.formData.declarant_cin_place.$error}"/> </td>
                    </tr>
                    <tr>
                        <td>Fonenana:&nbsp <input type="text" style="width:70%" v-model="formData.declarant_address" :class="{'error':$v.formData.declarant_address.$error}"/> </td>
                    </tr>
                </table>
                <p class="mt-6">
                    Izaho, Mpanao fanambarana, dia manamarina fa marina avokoa ireo izay voalaza amin'ity fanambarana ity.
                </p>
                <p class="text-right">
                    Androany faha: &nbsp <input type="date" />
                </p>
                <table class="table table-sm table-borderless">
                    <tr class="person">
                        <td style="width:30%">Ny rainy</td>
                        <td style="width:30%">Ny mpanao fanambarana</td>
                        <td style="width:30%">Ny mpampivelona</td>
                    </tr>
                    <tr>
                        <td ></td>
                        <td></td>
                        <td style="width:30%; font-style: italic;font-size: 10px">
                            " Hita sy voamarina fa teraka teto amin'ny
                            TOBIM-PAHASALAMANA iadidiako marina io zaza io)"
                        </td>
                    </tr>
                </table>
<!--                <hr>-->
            <p class="footer">
                VOARAY TETO AMIN'NY COMMUNE, Androany faha...............................................................................................
                (Sonia sy fitomboky ny tompon'andraikitra)
            </p>
            <p class="text-center d-print-none"><button class="btn btn-primary" @click="submit">Submit</button></p>


        </div>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
const {
    required,
    minLength,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "birth_certificate",
    data(){
        return{
            formData:{
                code:'',
                baby_firstName:'',
                baby_lastName:'',
                birth_date:'',
                birth_time:'',
                baby_gender:'',
                mom_id:'',
                mom_firstName:'',
                mom_lastName:'',
                mom_dob:'',
                mom_pob:'',
                mom_address:'',
                mom_job:'',
                dad_firstName:'',
                dad_lastName:'',
                dad_dob:'',
                dad_pob:'',
                dad_cin_no:'',
                dad_cin_place:'',
                dad_cin_date:'',
                dad_address:'',
                dad_job:'',
                declarant_firstName:'',
                declarant_lastName:'',
                declarant_dob:'',
                declarant_pob:'',
                declarant_cin_no:'',
                declarant_cin_date:'',
                declarant_cin_place:'',
                declarant_address:'',
                declarant_job:'',
                parent_married:'',
                dad_parenting:'',
            },

        }
    },
    validations:{
        formData:{
            code:{required},
            baby_firstName:{required},
            baby_lastName:{required},
            birth_date:{required},
            birth_time:{required},
            baby_gender:{required},
            mom_firstName:{required},
            mom_address:{required},
            declarant_firstName:{required},
            declarant_dob:{required},
            declarant_pob:{required},
            declarant_cin_no:{required},
            declarant_cin_date:{required},
            declarant_cin_place:{required},
            declarant_address:{required},

        }
    },
    created(){},
    methods:{
        async init(){
            if(this.$route.params.code !== null && this.$route.params.code !== undefined){
                await axios.get('/api/maternity/delivery_registration/'+this.$route.params.code).then(response=>{
                    console.log(response)
                })
            }
        },
        async fetchData(){
            await axios.get('/api/v1/patient_system/delivery/birth_certificate/'+this.formData.code).then(response=>{
                let src= response.data
                this.formData= Object.assign(this.formData,src.birth_admin_data[0])
                this.formData.birth_date=src.birth_date
                this.formData.birth_time=src.birth_time
                this.formData.mom_id= src.patient.id
                this.formData.mom_firstName= src.patient.firstName
                this.formData.mom_lastName= src.patient.lastName
                this.formData.mom_dob= src.patient.birthDate
                this.formData.baby_id=src.birth_medical_data_babies[0].patient_id
            })
        },
        make_dad_declarant(){
            this.formData.declarant_firstName= this.formData.dad_firstName
            this.formData.declarant_lastName= this.formData.dad_lastName
            this.formData.declarant_dob= this.formData.dad_dob
            this.formData.declarant_pob= this.formData.dad_pob
            this.formData.declarant_cin_no= this.formData.dad_cin_no
            this.formData.declarant_cin_date= this.formData.dad_cin_date
            this.formData.declarant_cin_place= this.formData.dad_cin_place
            this.formData.declarant_address= this.formData.dad_address
            this.formData.declarant_job= this.formData.dad_job
        },
        async submit(){
            this.$v.$touch()
            if (!this.$v.$invalid) {
                await axios.put('/api/v1/patient_system/delivery/birth_certificate/'+this.formData.id, this.formData)
                .then(response=>{
                    if(response.data.success){
                        this.reset_form()
                        this.$toast.open({
                            message:"data successfuly updated",
                            position:'top-right'
                        })
                        window.print()
                    }
                })
            }
        },
        reset_form(){
            for (let [key, val] of Object.entries(this.formData)) {
                this.formData[key] = "";
            }
            this.$v.$reset();
        }
    },
    computed:{
        baby_fullName(){
            return this.formData.baby_firstName  +" "+ this.formData.baby_lastName
        },
        dad_fullName(){
            return this.formData.dad_firstName +" "+ this.formData.dad_lastName
        },
        mom_fullName(){
            return this.formData.mom_firstName +" "+ this.formData.mom_lastName
        },
        declarant_fullName(){
            return this.formData.declarant_firstName +" "+ this.formData.declarant_lastName
        }
    }
}
</script>

<style scoped>
.certificate_container{
    margin:0;
    width:210mm;
    height:297mm;
    padding:5px;
}
.content{
    width:100%;
    height:100%;
    font-size: 20px;
}

#logo{
    width:300px;
    height:75px;
}
.person{
    text-decoration: underline;
    font-weight: bold;
}
.footer{
    font-style:italic;
    margin-top:50px;
    color:#006bb3;
}
@media print{
    html, body {
        width: 210mm;
        height: 297mm;
    }
    .certificate_container{
        margin: 0;
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
        page-break-after: always;
        line-height: 1.3;
    }

    /*.certificate_container{*/
    /*    margin-top: -60px;*/
    /*    height:350mm;*/
    /*    overflow: ;*/
    /*    width:280mm ;*/
    /*    margin-left: -40px;*/
    /*}*/
    /*.header td{*/
    /*    font-size: 22px;*/
    /*}*/
}
@media screen{
    .certificate_container{
        margin: 0 auto;
        width:auto;
        height:auto;
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
        transform:scale(0.8)
    }
    input,select{
        border:0.5px solid lightgray;
    }
}
</style>
