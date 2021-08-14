<template>
  <div class="form-check-inline">
    <select style="width:40px" v-model="week" @change="$emit('update:week', week)" >
        <option></option>
        <option v-for="i in 40" :value="i">{{i}}</option>
    </select>
    <strong>+</strong>
    <select style="width:40px;margin-left:25px" v-model="day" @change="$emit('update:day', day)" >
        <option v-for="i in 7" :value="i-1">{{i-1}}</option>
    </select>
</div>
</template>

<script>
export default {
  name: "gestationalAge",
  computed: {
      value: () => this.week + '+' + this.day
  },
  props: {
      week: String,
      day: String
  }
};
</script>
