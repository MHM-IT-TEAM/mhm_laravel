<template>
<div class="container w-75">
    <v-card>
        <v-card-title>BALANCE SHEET</v-card-title>
        <v-card-text>
            <span class="text-danger">Remember:</span>Check every 2 to 4 hours for urine:if two times zero, please inform Tanja immediately<br>
            (2177)-RANDRIANASOLO Gaston
            <table class="table-sm table table-bordered">
                <tr>
                    <td>
                        Start(Date/time)
                    </td>
                    <td>
                        <input type="date"/>
                    </td>
                    <td>
                        End(Date/time)
                    </td>
                    <td>
                        <input type="date"/>
                    </td>
                    <td>
                        Number of hours
                    </td>
                    <td>
                        <input type="number"/>
                    </td>
                </tr>
            </table>
            <div class="row mt-2">
                <div class="col in_form">
                    <h2 class="text-center">IN</h2>
                    <table class="table-sm table table-bordered">
                        <tr>
                            <td>Time</td>
                            <td>What</td>
                            <td>ml</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="time" v-model="formData_in.in_time" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <select class="form-control form-control-sm" v-model="formData_in.in_what">
                                    <option v-for="opt in in_what_options">{{opt}}</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" v-model="formData_in.in_value" class="form-control form-control-sm"/>

                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-danger" @click="submit_in">Submit </button>
                            </td>
                        </tr>
                        <tr v-for="row in list.in">
                            <td>
                                <input type="time" readonly :value="row.in_time" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" :value="row.in_what" readonly/>

                            </td>
                            <td>
                                <input type="number" readonly :value="row.in_value" class="form-control form-control-sm"/>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Total</td>
                            <td></td>
                            <td class="font-weight-bold">{{total_in}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col out_form">
                    <h2 class="text-center">OUT</h2>
                    <table class="table-sm table table-bordered">
                        <tr>
                            <td>Time</td>
                            <td>What</td>
                            <td>ml</td>
                            <td>P</td>
                            <td>K</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="time" v-model="formData_out.out_time" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <select class="form-control form-control-sm" v-model="formData_out.out_what">
                                    <option v-for="opt in out_what_options">{{opt}}</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" v-model="formData_out.out_value" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="checkbox" v-model="formData_out.p" class="form-control "/>
                            </td>
                            <td>
                                <input type="checkbox" v-model="formData_out.k" class="form-control"/>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-danger" @click="submit_out">Submit </button>
                            </td>
                        </tr>
                        <tr v-for="row in list.out">
                            <td>
                                <input type="time" readonly :value="row.out_time" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" :value="row.out_what" readonly/>

                            </td>
                            <td>
                                <input type="number" disabled :value="row.out_value" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="checkbox" disabled v-model="row.p" class="form-control form-control-sm"/>
                            </td>
                            <td>
                                <input type="checkbox" disabled v-model="row.k" class="form-control form-control-sm"/>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Total</td>
                            <td></td>
                            <td class="font-weight-bold">{{total_out}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <h4 class="font-weight-bold">RESULT: &nbsp{{total_in-total_out}}</h4>
        </v-card-text>
    </v-card>
</div>
</template>

<script>
import { validationMixin } from "vuelidate";
const {
    required,
    minValue,
    minLength,
    email,
    url,
    maxLength,
    between,
    requiredIf,
} = require("vuelidate/lib/validators");
export default {
    name: "balance_sheet",
    mixins: [validationMixin],
    data:()=>({
        list:{
            in:[],
            out:[]
        },
        formData_in:{
            in_time:'',
            in_what:'',
            in_value:'',
        },
        formData_out:{
            out_time:'',
            out_what:'',
            out_value:'',
            p:false,
            k:false
        },
        in_what_options:['milk','ampicillin','glucose','cafein'],
        out_what_options:['diaper','vomit','suction']
    }),
    methods:{
        submit_in(){
            this.$v.$touch();
            if (!this.$v.$invalid){
                this.list.in.push(this.formData_in)
                this.formData_in={
                    in_time:'',
                    in_what:'',
                    in_value:'',
                }
            }
        },
        submit_out(){
            this.list.out.push(this.formData_out)
            this.formData_out={
                out_time:'',
                out_what:'',
                out_value:'',
                p:false,
                k:false
            }
        }
    },
    computed:{
        total_in(){
            return (this.list.in.length>0)?this.list.in.reduce(( sum , cur ) => sum + parseInt(cur.in_value) , 0):0
        },
        total_out(){
            return (this.list.out.length>0)?this.list.out.reduce(( sum , cur ) => sum + parseInt(cur.out_value) , 0):0
        }
    },
    validations:{
        formData_in:{
            in_time:{required},
            in_what:{required},
            in_value:{required},
        }
    }
}
</script>

<style scoped>
input[type=number]{
    max-width: 80px;
}
</style>
