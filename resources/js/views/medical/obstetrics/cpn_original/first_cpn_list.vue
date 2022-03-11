<template>
  <div class="container">
      <v-app>
          <h3 class="p-2 text-center">Prenatal checkup </h3>
          <patient-list :headers="headers" @edit="editItem" :type_consult="12"></patient-list>
      </v-app>
  </div>
</template>

<script>
import PatientList from "../../../../components/patient_list";
export default {
  name: "first_cpn_list",
    components: {PatientList},
    data() {
    return {
      headers: [
        { text: "Id", value: "patient_id" },
        { text: "First Name", value: "patient.firstName" },
        { text: "Last Name", value: "patient.lastName" },
        { text: "Status", value: "status" },
        { text: "Actions", value: "actions", sortable: false },
      ]
    };
  },
  methods: {
    editItem(item) {
       this.$router.push({
        name:"cpn_admission",
        params:{
          patient_id: item.patient_id,
          weight: item.weight,
          consultation_id:item.id,
        }
      });
    }
  },
};
</script>
<style scoped>
</style>
