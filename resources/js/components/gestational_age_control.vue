<template>
  <div class="form-check-inline">
    <select v-model="gestationalAge.week" :disabled="readonly">
      <option v-if="isNull" value="" selected></option>
      <option v-for="i in 40" :value="i" :key="i">{{ i }}</option>
    </select>
    <strong class="m-auto">+</strong>
    <select v-model="gestationalAge.day" :disabled="readonly">
      <option v-if="isNull" value="" selected></option>
      <option v-for="i in 7" :value="i - 1" :key="i">{{ i - 1 }}</option>
    </select>
  </div>
</template>

<script>
export default {
  name: "gestationalAge",
  computed: {
    computedValue() {
      if (this.isNull)
        return null;

      return this.gestationalAge.week + "+" + this.gestationalAge.day;
    }
  },
  watch: {
    gestationalAge: {
      handler: function () {
        if (this.gestationalAge.week && this.gestationalAge.day)
          this.isNull = false;

        this.$emit("input", this.computedValue);
      },
      deep: true,
    },
    value() {
      if (!this.value) {
        this.isNull = true;

        this.gestationalAge.week = "";
        this.gestationalAge.day = "";
      }
      else {
        this.isNull = false;

        const parts = this.value.split('+');
        this.gestationalAge = {
          week: parts[0],
          day: parts[1]
        };
      }
    }
  },
  data: function () {
    return {
      isNull: this.value ? false : true,
      gestationalAge: {
        week: this.value ? this.value.split('+')[0] : "",
        day: this.value ? this.value.split('+')[1] : ""
      },
    };
  },
  props: {
    value: String,
    readonly: Boolean
  },
};
</script>
<style scoped>
select {
  width: 40px;
  border: 1px solid rgb(211,211,211);
  text-align-last: center;
}
</style>