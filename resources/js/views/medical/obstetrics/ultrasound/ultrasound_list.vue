<template>
    <div class="container">
        <v-app>
            <h3 class="p-2 text-center">Ultrasound</h3>
            <Loading :active.sync="isLoading"></Loading>
            <patient-list :headers="headers" :service_id="8" :service_activity_id="11" @edit="editUltrasound" />

            <v-dialog
                content-class="h-100"
                v-model="is_existing_ultrasound_dialog_open"
            >
                <v-app class="h-100">
                    <v-card class="p-4 h-auto">
                        <v-card-title>
                        <span>
                            <h3 class="mb-0">Ultrasound Admissions <small class="extra-small"> in the last year</small></h3>
                            <h5><br/>{{ existing_ultrasound_patient ? `${existing_ultrasound_patient.firstName} ${existing_ultrasound_patient.lastName}` : '' }}</h5>
                        </span>
                            <v-spacer></v-spacer>
                            <v-text-field
                                v-model="existing_ultrasound_search"
                                append-icon="mdi-magnify"
                                label="Search"
                                single-line
                                hide-details
                            ></v-text-field>
                        </v-card-title>
                        <v-btn
                            color="primary"
                            class="m-auto d-block"
                            @click="addUltrasoundAdmission"
                        >
                            <v-icon class="mr-2">mdi-plus-circle-outline</v-icon>
                            Add new ultrasound admission
                        </v-btn>
                        <v-data-table
                            sort-by="updated_at"
                            sort-desc
                            :search="existing_ultrasound_search"
                            :headers="existing_ultrasound_headers" :items="existing_ultrasound_admissions"
                        >
                            <template v-slot:item.created_at="{ item }">
                                <span class="text-nowrap">{{ new Date(item.created_at).toLocaleDateString() }}</span>
                            </template>
                            <template v-slot:item.updated_at="{ item }">
                                <span class="text-nowrap">{{ new Date(item.updated_at).toLocaleDateString() }}</span>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <div>
                                    <v-icon small class="mr-2"
                                            @click="existingUltrasoundSelected(item)">
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
import patientList from "../../../../components/patient_list.vue";

export default {
    name: "ultrasound_list",
    components: { patientList },
    data() {
        return {
            isLoading: false,
            search: "",
            headers: [
                { text: "Id", value: "patient_id" },
                { text: "First Name", value: "patient.firstName" },
                { text: "Last Name", value: "patient.lastName" },
                { text: "Status", value: "status" },
                { text: 'Ref',value:"ultra_sound_admission.id"},
                { text: "Actions", value: "actions", sortable: false },
            ],
            is_existing_ultrasound_dialog_open: false,
            admission_for_existing_ultrasound: null,
            existing_ultrasound_search: '',
            existing_ultrasound_headers: [
                { text: "Id", value: "id" },
                { text: "Created Date", value: "created_at" },
                { text: "Modified Date", value: "updated_at" },
                { text: "Status", value: "screening_status" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            existing_ultrasound_admissions: [],
            existing_ultrasound_patient: null
        };
    },
    methods: {
        editUltrasound(item) {
            this.existing_ultrasound_patient = null;
            this.existing_ultrasound_admissions = [];
            this.admission_for_existing_ultrasound = item;

            this.isLoading = true;
            axios.get(`/api/v1/patient_system/out_patient/obstetrical/ultrasound/get_recent_ultrasound_admissions_for_patient/${item.patient.id}`)
                .then(response =>
                {
                    this.existing_ultrasound_patient = response.data.patient;
                    this.existing_ultrasound_admissions = response.data.ultrasound_admissions;

                    if (this.existing_ultrasound_admissions.length === 0) {
                        this.addUltrasoundAdmission();
                    } else {
                        if (this.existing_ultrasound_admissions.length === 1
                            && (new Date() - new Date(this.existing_ultrasound_admissions[0].updated_at)) < 120 * 24 * 60 * 60 * 1000) {
                            this.existingUltrasoundSelected(this.existing_ultrasound_admissions[0]);
                        }
                        else {
                            this.is_existing_ultrasound_dialog_open = true;
                        }
                    }
                })
                .finally(() => this.isLoading = false)
        },
        existingUltrasoundSelected(ultrasound_admission) {
            this.$router.push({
                name: "ultrasound_form_base",
                params: {
                    patient_id: this.existing_ultrasound_patient.id,
                    consultation_id: this.admission_for_existing_ultrasound.id,
                    ref: ultrasound_admission.id
                },
            });
        },
        addUltrasoundAdmission() {
            this.$router.push({
                name: "ultrasound_form_base",
                    params: {
                        patient_id: this.existing_ultrasound_patient.id,
                        consultation_id: this.admission_for_existing_ultrasound.id
                    }
            });
        },
        getColor(status) {
            if (status === "RUNNING") return "blue";
            else if (status === "DONE") return "green";
            else return "green";
        }
    },
};
</script>
<style scoped>
small.extra-small {
    font-size: 60%;
}
</style>
