<template>
  <div class="container-fluid bg-white">
    <h3 class="text-center">PATIENT DATABASE</h3>
    <form onsubmit="return false;">
      <input
        type="text"
        name="searchBAr"
        class="form-control"
        v-model="query"
        @keyup="runSearch"
        placeholder="type your search here"
      />
    </form>
    <v-divider></v-divider>
    <patient_table :data="getPatients" :loading="loading"></patient_table>
  </div>
</template>

<script>
import patient_table from "./patient_table";
import { mapGetters, mapActions } from "vuex";
export default {
  name: "patient_crud",
  components: { patient_table },
  data() {
    return {
      query: null,
      result: null,
      timeout: null,
      loading: false,
    };
  },
  methods: {
    ...mapActions("patient", ["fetchPatients", "resetPatient"]),
    runSearch(e) {
      e.preventDefault();
      this.resetPatient();
      clearTimeout(this.timeout);
      let self = this;
      this.loading = true;
      this.timeout = setTimeout(function () {
        self.query.length > 3 ? self.fetchPatients(self.query) : "";
      }, 1000);
    },
  },
  watch: {
    get(val) {
      if (val.length > 0) this.loading = false;
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
.container-fluid {
  margin-top: 40px;
  padding-top: 40px;
  width: 75vw;
}
</style>
