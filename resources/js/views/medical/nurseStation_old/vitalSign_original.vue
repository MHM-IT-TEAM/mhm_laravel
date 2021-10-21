<template>
    <div>
        <div class="form-row">
            <div class="col-sm-4 form-group">
                <label class="mb-0">Weight</label>
                <input type="text" name="weight" id="weight" class="form-control form-control-sm" v-model="vitalSign.weight" />
            </div>
            <div class="col-sm-4 form-group">
                <label class="mb-0">Temp</label>
                <input type="text" name="temp" id="temp" class="form-control form-control-sm"
                       v-model="vitalSign.temp" :class="checkTemp" />
            </div>
            <div class="col-sm-4 form-group">
                <label class="mb-0">BP-SYSTO</label>
                <input type="text" name="taSysto" id="taSysto"  class="form-control form-control-sm" v-model="vitalSign.taSysto" :class="checkBp"/>
            </div>
        </div>
        <div class="form-row mt-2">
            <div class="col-sm-4 form-group">
                <label class="mb-0">BP-DIA</label>
                <input type="text" name="taDia" id="taDia"  class="form-control form-control-sm" v-model="vitalSign.taDia" />
            </div>
            <div class="col-sm-4 form-group">
                <label class="mb-0">Pulse</label>
                <input type="text" name="pulse" id="pulse"
                       class="form-control form-control-sm" v-model="vitalSign.pulse" />
            </div>
            <div class="col-sm-4 form-group">
                <label class="mb-0">Remark</label>
                <input type="text" name="remark" id="remark" class="form-control form-control-sm" v-model="vitalSign.remark" />
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "vitalSign",
        props:['readyToSend','reset'],
        data(){
            return{
                vitalSign:{
                    weight:"",
                    temp:"",
                    taSysto:"",
                    taDia:"",
                    pulse:"",
                    remark:""
                },
                default:{
                    weight:"",
                    temp:"",
                    taSysto:"",
                    taDia:"",
                    pulse:"",
                    remark:""
                }
            }
        },
        watch:{
            readyToSend(val){
                if(val===true){
                    return this.$emit('dataSent',this.vitalSign)
                }
            },
            reset(val){
                val===true? this.resetForm():""
            },
            'vitalSign.temp':function(val){
                val>38? this.$emit('priority',"Green"):""
            },
            'vitalSign.taSysto':function(val){
                val>14? this.$emit('priority',"Green"):""
            },
        },
        methods:{
            resetForm(){
                return Object.assign(this.vitalSign,this.default)
            }
        },
        computed:{
            checkTemp(){
                return this.vitalSign.temp>37? 'text-white bg-danger':''
            },
            checkPulse(){

            },
            checkBp(){
                return this.vitalSign.taSysto>14? 'text-white bg-danger':''
            },
            sendData(){
               return this.vitalSign
            }
        }
    }
</script>

<style scoped>

</style>
