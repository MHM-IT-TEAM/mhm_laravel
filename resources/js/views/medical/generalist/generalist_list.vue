<template>
  <div class="container w-75">
    <patient-list :headers="headers" :service_id="6" @edit="process_consultation" title="General doctor" />
  </div>
</template>

<script>
import PatientList from "../../../components/patient_list";
export default {
  name: "generalist_list",
  components: { PatientList },
  data() {
    return {
      headers: [
        {text:'Time',value:'time'},
        { text: "Id", value: "patient_id" },
        { text: "First Name", value: "patient.firstName" },
        { text: "Last Name", value: "patient.lastName" },
        { text: "Type", value: "admission_type.code" },
        { text: "Status", value: "status" },
        { text: "Actions", value: "actions", sortable: false },
      ],
    };
  },
  methods: {
    process_consultation(consultation) {
      this.$router.push({
        name: "generalist_consultation",
        params: { admission: consultation },
      });
    },
  },
};
</script>

<style scoped>
</style>
