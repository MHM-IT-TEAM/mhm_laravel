<template>
    <div>
        <div class="form-row">
            <div class="col-sm-4 form-group">
                <label class="mb-0">Weight</label>
                <input type="text" name="weight" id="weight" class="form-control form-control-sm" v-model="formData.weight" />
            </div>
            <div class="col-sm-4 form-group">
                <label class="mb-0">Temp</label>
                <input type="text" name="temp" id="temp" class="form-control form-control-sm"
                       v-model="formData.temp" :class="checkTemp" />
            </div>
            <div class="col-sm-4 form-group">
                <label class="mb-0">BP-SYSTO</label>
                <input type="text" name="taSysto" id="taSysto"  class="form-control form-control-sm" v-model="formData.taSysto" :class="checkBp"/>
            </div>
        </div>
        <div class="form-row mt-2">
            <div class="col-sm-4 form-group">
                <label class="mb-0">BP-DIA</label>
                <input type="text" name="taDia" id="taDia"  class="form-control form-control-sm" v-model="formData.taDia" />
            </div>
            <div class="col-sm-4 form-group">
                <label class="mb-0">Pulse</label>
                <input type="text" name="pulse" id="pulse"
                       class="form-control form-control-sm" v-model="formData.pulse" />
            </div>
            <div class="col-sm-4 form-group">
                <label class="mb-0">Remark</label>
                <input type="text" name="remark" id="remark" class="form-control form-control-sm" v-model="formData.remark" />
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "vitalSign",
        props:['formData','reset'],
        computed:{
            checkTemp(){
                return this.formData.temp>37? 'text-white bg-danger':''
            },
            checkPulse(){

            },
            checkBp(){
                return this.formData.taSysto>14? 'text-white bg-danger':''
            }

        }

    }
</script>

<style scoped>

</style>
