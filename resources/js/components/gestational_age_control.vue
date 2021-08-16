<template>
  <div class="form-check-inline">
    <select style="width: 40px" v-model="gestationalAge.week" :disabled="readonly">
      <option v-for="i in 40" :value="i">{{ i }}</option>
    </select>
    <strong>+</strong>
    <select style="width: 40px; margin-left: 25px" v-model="gestationalAge.day" :disabled="readonly">
      <option v-for="i in 7" :value="i - 1">{{ i - 1 }}</option>
    </select>
  </div>
</template>

<script>
export default {
  name: "gestationalAge",
  computed: {
    computedValue() {
      return this.gestationalAge.week + "+" + this.gestationalAge.day;
    }
  },
  watch: {
    gestationalAge: {
      handler: function () {
        this.$emit("input", this.computedValue);
      },
      deep: true,
    },
    value() {
        const parts = this.value.split('+');
        this.gestationalAge.week = parts[0];
        this.gestationalAge.day = parts[1];
    }
  },
  data: function () {
    return {
      gestationalAge: {
        week: this.value ? this.value.split('+')[0] : 1,
        day: this.value ? this.value.split('+')[1] : 0
      },
    };
  },
  props: {
    value: String,
    readonly: Boolean
  },
};
</script>
