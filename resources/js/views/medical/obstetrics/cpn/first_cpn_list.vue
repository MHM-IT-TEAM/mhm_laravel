<template>
  <div class="container-fluid vh-100">
      <v-app>
          <patient-list :headers="headers" @edit="editItem" :service_activity_id="service_activities"  title="First CPN Checkup"></patient-list>
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
        {text:'Time',value:'time'},
        { text: "Id", value: "patient_id" },
        { text: "First Name", value: "patient.firstName" },
        { text: "Last Name", value: "patient.lastName" },
          { text: "Type of admission", value:"admission_type.code", sortable: false },
          { text: "From", value:"from_admission" },
        { text: "Status", value: "status" },
        { text: "Actions", value: "actions", sortable: false },
      ],
        service_activities:[12]
    };
  },
  methods: {
    editItem(item) {
       this.$router.push({
        name:"new_cpn_admission",//new_cpn_admission
        params:{
          admission:item
        }
      });
    }
  },
};
</script>
<style scoped>
</style>
