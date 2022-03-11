<template>
  <div class="container">
      <v-app>
          <Loading :active.sync="isLoading"></Loading>
          <h3 class="p-2 text-center">Prenatal checkup followup</h3>
          <patient-list :headers="headers" @edit="editItem" :type_consult="8"></patient-list>
          <v-dialog
              content-class="h-100"
              v-model="is_existing_cpn_admission_dialog_open"
          >
              <v-app class="h-100">
                  <v-card class="p-4 h-auto">
                      <v-card-title>
                        <span>
                            <h3 class="mb-0">Prenatal first checkups <small class="extra-small"> in the last year</small></h3>
                            <h5><br/>{{ existing_cpn_admission_patient ? `${existing_cpn_admission_patient.firstName} ${existing_cpn_admission_patient.lastName}` : '' }}</h5>
                        </span>
                          <v-spacer></v-spacer>
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
                          <template v-slot:item.created_at="{ item }">
                              <span class="text-nowrap">{{ new Date(item.created_at).toLocaleDateString() }}</span>
                          </template>
                          <template v-slot:item.last_followup_date="{ item }">
                              <span class="text-nowrap">{{ item.last_followup_date ? new Date(item.last_followup_date).toLocaleDateString() : 'No followups' }}</span>
                          </template>
                          <template v-slot:item.actions="{ item }">
                              <div>
                                  <v-icon small class="mr-2"
                                          @click="existingCpnAdmissionSelected(item)">
                                      mdi-pencil
                                  </v-icon>
                              </div>
                          </template>
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
      existing_cpn_admission_patient: null
    };
  },
  methods: {
    editItem(item) {
      this.existing_cpn_admission_patient = null;
      this.existing_cpn_admissions = [];
      this.admission_for_existing_cpn_admission = item;

      this.isLoading = true;
      axios.get(`/api/v1/patient_system/out_patient/obstetrical/cpn_followup/get_recent_cpn_admissions_for_patient/${item.patient.id}`)
          .then(response =>
          {
              this.existing_cpn_admission_patient = response.data.patient;
              this.existing_cpn_admissions = response.data.cpn_admissions;
              if (this.existing_cpn_admissions.length === 0) {
                this.$toast.open({
                  message: 'No first checkup found for patient',
                  type: 'error',
                  position: 'top-right',
                  duration: 0
                });
              }
              else if (this.existing_cpn_admissions.length === 1) {
                this.addCpnFollowup(this.existing_cpn_admissions[0].id, this.admission_for_existing_cpn_admission.id);
              }
              else {
                this.existing_cpn_admissions.forEach(x => {
                  x.sort_date = x.last_followup_date ?? x.created_at;
                });

                this.is_existing_cpn_admission_dialog_open = true;
              }
          })
          .finally(() => this.isLoading = false);
    },
    addCpnFollowup(cpn_admission_id, admission_id) {
      this.$router.push({
        name:"cpn_followup",
        params:{
          cpn_ref: cpn_admission_id,
          admission_id: admission_id
        }
      });
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
