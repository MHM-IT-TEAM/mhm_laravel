<template>
<div class="container w-75">
    <h3 class="mb-4">Pregnancy Checkup Form</h3>
    ({{$route.params.stork_admission.patient.id}})-{{nullToStr($route.params.stork_admission.patient.firstName) +" "+ nullToStr($route.params.stork_admission.patient.lastName)  }}
    <section id="form" class="mb-4 border shadow p-2" >
        <div class="row">
            <div class="col-2">
                BDCF:
            </div>
            <div class="col-4">
                <input type="text" class="form-control form-control-sm" v-model="formData.bdcf"/>
            </div>
            <div class="col-2">
                CTG:
            </div>
            <div class="col-4">
<!--                <input type="text" class="form-control form-control-sm" v-model="formData.ctg"/>-->
                <select class="form-control form-control-sm " v-model="formData.ctg">
                    <option v-for="ct in ctg">{{ct}}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                Belly size <small>(cm)</small>:
            </div>
            <div class="col">
                <input type="number" class="form-control form-control-sm" v-model="formData.belly_size"/>
            </div>
            <div class="col-2">
                HU <small>(cm)</small>:
            </div>
            <div class="col">
                <input type="number" class="form-control form-control-sm" v-model="formData.hu"/>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                Weight:
            </div>
            <div class="col">
                <input type="number" class="form-control form-control-sm" v-model="formData.weight"/>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                Remark
            </div>
            <div class="col">
                <textarea class="form-control form-control-sm"  v-model="formData.remark"/>
            </div>
        </div>
        <button class="btn btn-sm btn-primary mt-2" @click="submit">Submit</button>
    </section>
    <hr>
    <h4>Data in the system</h4>
    <div class="table-responsive">
        <table class="table table-sm">
            <tr>
                <td>Date</td>
                <td>BDCF</td>
                <td>CTG</td>
                <td>Belly size</td>
                <td>HU</td>
                <td>Weight</td>
                <td>Remark</td>
                <td>User</td>
            </tr>
            <tr v-for="row in list">
                <td>{{row.created_at}}</td>
                <td>{{row.bdcf}}</td>
                <td>{{row.ctg}}</td>
                <td>{{row.belly_size}}</td>
                <td>{{row.hu}}</td>
                <td>{{row.weight}}</td>
                <td>{{row.remark}}</td>
                <td>{{row.user}}</td>
            </tr>
        </table>
    </div>
</div>
</template>

<script>
export default {
    name: "pregnancy_checkup_form",
    data(){
        return{
            formData:{
                stork_admission_id:'',
                belly_size:'',
                ctg:'',
                hu:'',
                weight:'',
                remark:''
            },
            list:[],
            ctg:["good","suspicious","patological"]
        }
    },
    created(){
        this.init()
    },
    methods:{
        init(){
            axios.get(`/api/v1/patient_system/in_patient/stork/pregnancy_checkup/stork_admission_id/${this.$route.params.stork_admission.id}`).then(response=>this.list=response.data)
        },
        submit(){
            this.formData.stork_admission_id = this.$route.params.stork_admission.id
            this.formData.user = window.auth.user.name
            axios.post("/api/v1/patient_system/in_patient/stork/pregnancy_checkup",this.formData).then(
                response=>{
                    this.list=response.data
                    this.formData= {
                        stork_admission_id:'',
                        belly_size:'',
                        ctg:'',
                        hu:'',
                        weight:'',
                        remark:''
                    }
                }
            )
        },
        nullToStr(text){
            return text===null?'':text
        },
    }
}
</script>

<style scoped>

</style>
