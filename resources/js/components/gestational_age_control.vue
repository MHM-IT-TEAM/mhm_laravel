<template>
  <div class="form-check-inline">
    <select v-model="gestationalAge.week" :disabled="readonly">
      <option v-if="isNull" value="" selected></option>
      <option v-for="i in 40" :value="i" :key="i">{{ i }}</option>
    </select>
    <strong class="m-auto">+</strong>
    <select v-model="gestationalAge.day" :disabled="readonly">
      <option v-if="isNull" value="" selected></option>
      <option v-for="i in 7" :value="i - 1" :key="i-1">{{ i - 1 }}</option>
    </select>
  </div>
</template>

<script>
export default {
  name: "gestationalAge",
  computed: {
    computedValue() {
      // if (this.isNull)
      //   return null;
      return this.gestationalAge.week + "+" + this.gestationalAge.day;
    }
  },
  watch: {
    gestationalAge: {
      handler: function () {
        if (this.gestationalAge.week !== "" && this.gestationalAge.day !== "")
          this.isNull = false;

        this.$emit("input", this.computedValue);
      },
      deep: true,
    },
    value() {
      this.onValueChanged();
    }
  },
  data: function () {
    return {
      isNull: true,
      gestationalAge: {
        week: "",
        day: ""
      },
    };
  },
  props: {
    value: String,
    readonly: Boolean
  },
  methods: {
    onValueChanged() {
      if (!this.value || !this.value.includes('+')) {
        this.isNull = true;

        this.gestationalAge.week = "";
        this.gestationalAge.day = "";
      }
      else {
        const parts = this.value.split('+');
        if (parts.length <= 1) {
          this.isNull = true;
          return;
        }

        this.isNull = false;

        this.gestationalAge = {
          week: parts[0],
          day: parts[1]
        };
      }
    }
  },
  created() {
    this.onValueChanged();
  }
};
</script>
<style scoped>
select {
  width: 40px;
  border: 1px solid rgb(211,211,211);
  text-align-last: center;
}
</style>
