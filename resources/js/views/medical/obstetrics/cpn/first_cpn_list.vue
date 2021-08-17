<template>
  <div class="container">
      <patient-list :headers="headers" @edit="editItem" :type_consult="4"></patient-list>
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
    getFullName(firstName, lastName) {
      let name;
      if (firstName) 
        name = firstName;
      if (lastName)
        name += " " + lastName;

      if (!name)
        name = "<Missing name>"

      return name;
    },
    editItem(item) {
      console.log(item.patient_id);
      this.$router.push({
        name: "pregnancy_test",
        params: {
          patient_id: item.patient_id, 
          fullName: this.getFullName(item.patient.firstName, item.patient.lastName),
          weight: item.vital_signs.weight,
          consultation_id: item.id,
        },
      });
    }
  },
};
</script>
<style scoped>
</style>
