<template>
  <div class="container-fluid bg-light" >
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
        timeout:null
    };
  },
  methods: {
    ...mapActions("patient", ["fetchPatients","resetPatient"]),
     runSearch(e) {
        e.preventDefault()
         this.resetPatient()
         clearTimeout(this.timeout);
         let self= this
        this.timeout=setTimeout(function(){
            (self.query.length>3)?self.fetchPatients(self.query):""
        },1000)
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
.container-fluid{
    margin-top:40px;
    padding-top: 40px;
    width:75vw
}
</style>
