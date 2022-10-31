<template>
    <div class="container-fluid p-2 border border-primary">
        <v-btn
            class="float-right"
            fab
            dark
            x-small
            color="red"
            @click="$emit('delete_row')"
        >
            <v-icon dark>
                mdi-minus
            </v-icon>
        </v-btn>
        <div class="row">
            <div class="col-2">Year</div>
           <div class="col-2">
               <input type="number" class="form-control-sm form-control"
                      v-model="formData.nr_year" :max="new Date().getFullYear()"
                      :class="{'text-danger font-weight-bold error':  formData.nr_year>new Date().getFullYear(),  }"
               />
           </div>
            <div class="col-2">Birth Place</div>
            <div class="col-3">
                <input type="text" class="form-control form-control-sm" v-model="formData.birth_place"/>
            </div>
        </div>
        <div class="row">
            <div class="col-2">Type of birth</div>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" v-model="formData.birth_type">
                    <option value="normal">normal</option>
                    <option value="kiwi">kiwi</option>
                    <option value="forceps">forceps</option>
                    <option value="C-section">C-section</option>
                    <option value="Curettage">Curettage</option>
                    <option value="Cytotec">Cytotec</option>
                </select>
            </div>
            <div class="col-2">Our patient?</div>
            <div class="col-2">
                <yes-or-no v-model.number="formData.our_patient" :value="formData.our_patient" />
            </div>
        </div>
        <div class="row">
            <div class="col-2">problem</div>
            <div class="col">
                <textarea class="form-control form-control-sm" v-model="formData.problem">
                </textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-2">GA</div>
            <div class="col-2">
                <gestational-age v-model="formData.ga"/>
            </div>
            <div class="col-1">Gender</div>
            <div class="col-1">
                <select v-model="formData.baby_gender" class="form-control form-control-sm" >
                    <option value="M">M</option>
                    <option value="F">F</option>
                </select>
            </div>
            <div class="col-2">Condition</div>
            <div class="col-2">
                <select v-model="formData.baby_condition" class="form-control form-control-sm" >
                    <option value="Alive">Alive</option>
                    <option value="Died <= 24h">Died <= 24h</option>
                    <option value="Died > 24h">Died > 24h</option>
                    <option value="Died <= 28 days">Died <= 28 days</option>
                    <option value="Died > 28 days">Died > 28 days</option>
                </select>
            </div>

        </div>
        <div class="row">
            <div class="col-2">Weight</div>
            <div class="col-2">
                <input type="number" v-model="formData.baby_weight" min="0" class="form-control form-control-sm"/>
            </div>
        </div>
        <div class="row">
            <div class="col-2">Malformation</div>
            <div class="col-4">
                <input type="text" class="form-control form-control-sm" v-model="formData.malformation"/>
            </div>
            <div class="col-2">Infection</div>
            <div class="col-4">
                <input type="text" class="form-control form-control-sm" v-model="formData.infection"/>
            </div>
        </div>
        <div class="row">
            <div class="col-2">Prob in pueperium</div>
            <div class="col">
                <textarea v-model="formData.pueperium" class="form-control form-control-sm"  />
            </div>
        </div>
    </div>
</template>

<script>
import GestationalAge from "../../../../components/gestational_age_control";
export default {
    name: "pregnancy_history_form",
    props:['value'],
    components: {GestationalAge},
    data(){
        return {
          formData:{
              nr_year:'',
              problem:'',
              birth_type:'',
              birth_place:'',
              our_patient:false,
              ga:'',
              baby_gender:'',
              baby_weight:'',
              malformation:'',
              infection:'',
              pueperium:''
          }

        }
    },
    watch:{
        formData:{
            handler:function(val){
                this.$emit('input',val)
            },
            deep:true
        },
        value:{
            handler:function(val){this.formData=val},
            immediate:true,
            deep:true
        },
        mounted(){
            this.formData=this.value
        }
    }
}
</script>

<style scoped>

</style>
