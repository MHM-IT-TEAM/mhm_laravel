<template>
  <div class="container-fluid mt-4">
    <form>
      <input
        type="text"
        name="searchBAr"
        class="form-control"
        v-model="query"
        @change="runSearch"
        placeholder="type your search here"
      />
    </form>
    <v-divider></v-divider>
    <patient-data :data="getPatients"></patient-data>
  </div>
</template>

<script>
import patientData from "./patientData";
import { mapGetters, mapActions } from "vuex";
export default {
  name: "patientSearch",
  components: { patientData },
  data() {
    return {
      query: null,
      result: null,
    };
  },
  methods: {
    ...mapActions("patient", ["fetchPatients"]),
    async runSearch() {
      let response = await this.fetchPatients(this.query);
    },
  },
  computed: {
    ...mapGetters("patient", ["getPatients"]),
    get: function () {
      return this.getPatients;
    },
  },
};
</script>

<style scoped>
</style>
