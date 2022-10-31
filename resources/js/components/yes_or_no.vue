<template>
<!--    <v-radio-group row class="mt-0 p-0 small" :value="value" @change="$emit('input', $event)">-->
<!--        <v-radio class="radio" label="Yes" :value="1"></v-radio>-->
<!--        <v-radio class="radio" label="No" :value="0"></v-radio>-->
<!--    </v-radio-group>-->

 <div class="">
     <label class="radio-inline">
         <input type="radio"  v-model.number="val" value="1"  @change="$emit('input', val)"> Yes
     </label>
     <label class="radio-inline">
         <input type="radio"  v-model.number="val" value="0"  @change="$emit('input', val)"> No
     </label>
 </div>
<!--  <div>-->
<!--      <select class="form-control form-control-sm" v-model.number="val" >-->
<!--          <option value="1">Yes</option>-->
<!--          <option value="0">No</option>-->
<!--      </select>-->
<!--  </div>-->
</template>

<script>
export default {
  name: "yesOrNo",
  data: function () {
    return {
        val:'',
        updated_val:''
    }
  },
  props:['value','row'],
    watch:{
      value(data){
        if(data !=='') this.val=data
      }
    },
    mounted(){
      this.val=this.value
    }
};
</script>
<style>
  .v-input--selection-controls__ripple {
    transform: scale(0.65);
  }
  .v-input--radio-group .v-input__control .v-messages {
    display: none;
  }
</style>
<style scoped>
.group-container {
    display: inline-block;
}
.small{
    max-height: 10px;
}
.small >>> i{
    font-size: 12px;

}
.radio{
    font-size:11px !important;
}
.radio >>>label{
    font-size:12px !important;
}
</style>
