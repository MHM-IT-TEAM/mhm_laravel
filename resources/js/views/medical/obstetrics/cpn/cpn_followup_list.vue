<template>
  <div class="container-fluid vh-100">
      <v-app>
          <Loading :active.sync="isLoading"></Loading>
          <patient-list :headers="headers" @edit="editItem"  :service_activity_id="service_activities" title="cpn followup"></patient-list>
          <v-dialog
              content-class="h-100"
              v-model="is_existing_cpn_admission_dialog_open"
          >
              <v-app class="h-100">
                  <v-card class="p-4 h-auto">
                      <v-card-title>
                          <v-text-field
                              v-model="existing_cpn_admission_search"
                              append-icon="mdi-magnify"
                              label="Search"
                              single-line
                              hide-details
                          ></v-text-field>
                      </v-card-title>
                      <v-data-table
                          sort-by="sort_date"
                          sort-desc
                          :search="existing_cpn_admission_search"
                          :headers="existing_cpn_admission_headers" :items="existing_cpn_admissions"
                      >
<!--                          <template v-slot:item.created_at="{ item }">-->
<!--                              <span class="text-nowrap">{{ new Date(item.created_at).toLocaleDateString() }}</span>-->
<!--                          </template>-->
<!--                          <template v-slot:item.last_followup_date="{ item }">-->
<!--                              <span class="text-nowrap">{{ item.last_followup_date ? new Date(item.last_followup_date).toLocaleDateString() : 'No followups' }}</span>-->
<!--                          </template>-->
<!--                          <template v-slot:item.actions="{ item }">-->
<!--                              <div>-->
<!--                                  <v-icon small class="mr-2"-->
<!--                                          @click="existingCpnAdmissionSelected(item)">-->
<!--                                      mdi-pencil-->
<!--                                  </v-icon>-->
<!--                              </div>-->
<!--                          </template>-->
                      </v-data-table>
                  </v-card>
              </v-app>
          </v-dialog>
      </v-app>
  </div>
</template>

<script>
import PatientList from "../../../../components/patient_list";
export default {
  name: "cpn_followup_list",
  components: {PatientList},
  data() {
    return {
      isLoading: false,
      headers: [
        {text:'Time',value:'time'},
        { text: "Id", value: "patient_id" },
        { text: "First Name", value: "patient.firstName" },
        { text: "Last Name", value: "patient.lastName" },
        { text: "Status", value: "status" },
        { text: "Actions", value: "actions", sortable: false },
      ],
      is_existing_cpn_admission_dialog_open: false,
      admission_for_existing_cpn_admission: null,
      existing_cpn_admission_search: '',
      existing_cpn_admission_headers: [
          { text: "Id", value: "id" },
          { text: "Created Date", value: "created_at" },
          { text: "Last Followup Date", value: "last_followup_date" },
          { text: "Last Followup Gestational Age", value: "last_followup_gestational_age" },
          { text: "Number of followups", value: "number_of_followups" },
          { text: "Actions", value: "actions", sortable: false },
      ],
      existing_cpn_admissions: [],
      existing_cpn_admission_patient: null,
        service_activities:[13]
    };
  },
  methods: {
    editItem(item) {
        axios.get(`/api/v1/patient_system/out_patient/obstetrical/cpn/get_recent_cpn_admissions_for_patient/${item.patient_id}`).then(response=>{
            this.$router.push({
                name:"cpn_followup",
                params:{
                    cpn_admission: response.data,
                    admission_id:item.id,
                    admission:item
                }
            });
        })
    },
    addCpnFollowup(cpn_admission_id, admission_id) {
      // this.$router.push({
      //   name:"cpn_followup",
      //   params:{
      //     cpn_ref: cpn_admission_id,
      //     admission_id: admission_id
      //   }
      // });
    },
    existingCpnAdmissionSelected(cpn_admission) {
      this.addCpnFollowup(cpn_admission.id, this.admission_for_existing_cpn_admission.id);
    }
  },
};
</script>
<style scoped>
small.extra-small {
    font-size: 60%;
}
</style>
