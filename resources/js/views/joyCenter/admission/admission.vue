<template>
  <div class="container">
    <v-app>
      <h1 class="text-center form-title">PATIENT ADMISSION</h1>
      <div class="inline mb-4">
        Quick search
        <input
          type="number"
          class="required"
          style="width: 80px"
          @change="quickSearch"
          v-model="formData.id"
        />
      </div>
      <div class="table-responsive">
        <table class="table table-sm">
          <tr>
            <th class="table-title" colspan="3">
              <v-icon>mdi-account-circle</v-icon> A) Personal information
              <span
                :class="{
                  'text-primary': formData.consultation_priority_id === 'BLUE',
                }"
                v-if="formData.consultation_priority_id === 'BLUE'"
                >Blue consultation_priority_id</span
              >
            </th>
          </tr>
          <tr>
            <td style="width: 20%"><span class="text-danger">*</span>Id</td>
            <td style="width: 40%">First name</td>
            <td style="width: 40%">Last name</td>
          </tr>
          <tr>
            <td>
              <input
                type="number"
                class="border required"
                v-model="formData.patient.id"
                @change="changePat"
                :class="{
                  'border border-danger': $v.formData.patient.id.$error,
                }"
              />
              <p
                class="text-white bg-danger"
                v-if="$v.formData.patient.id.$error"
              >
                The patient id is required
              </p>
            </td>
            <td class="required">
              {{ formData.patient.firstName }}
            </td>
            <td class="required">
              {{ formData.patient.lastName }}
            </td>
          </tr>
          <tr>
            <td>Date of birth (age)</td>
            <td>Address</td>
            <td>Tel</td>
          </tr>
          <tr>
            <td class="required">
              {{
                moment(formData.patient.birthDate).format("DD-MMM-YYYY")
              }}
              &nbsp ({{ check_age }})
            </td>
            <td
              class="required"
              :class="{
                'text-white bg-success': formData.patient.sector === true,
              }"
            >
              {{ formData.patient.adress }}
            </td>
            <td class="required">{{ formData.patient.tel }}</td>
          </tr>
        </table>
        <table class="table table-sm">
          <tr>
            <th class="table-title" colspan="6">
              <v-icon>mdi-stethoscope</v-icon>B) Today's consultation
            </th>
          </tr>
          <tr>
            <td>
              <select
                class="required"
                v-model="formData.category_id"
                @change="changeCategory"
                :disabled="formData.patient.id === ''"
              >
                <option value="">
                  <span class="text-danger">*</span>Category
                </option>
                <option v-for="item in accessory.categories" :value="item.id">
                  {{ item.name }}
                </option>
              </select>
            </td>
            <td>
              <select
                class="required"
                v-model="formData.service_id"
                @change="changeService"
                :disabled="formData.category_id === ''"
              >
                <option value="">Service</option>
                <option v-for="item in accessory.services" :value="item.id">
                  {{ item.name }}
                </option>
              </select>
            </td>
            <td>
              <select
                class="required"
                v-model="formData.service_activity_id"
                @change="changeActivity"
                :disabled="formData.service_id === ''"
              >
                <option value="">Activity</option>
                <option
                  v-for="item in accessory.service_activities"
                  :value="item.id"
                >
                  {{ item.name }}
                </option>
              </select>
              <span
                v-if="$v.formData.service_activity_id.$error"
                class="text-white bg-danger"
                >you have to choose here</span
              >
            </td>
            <td>
              <select
                class="form-control form-control-sm required"
                v-model="formData.admission_priority_id"
                :class="priority_color"
              >
                <option value="">Priority</option>
                <option v-for="item in accessory.priorities" :value="item.id">
                  {{ item.code + "=> " + item.description }}
                </option>
              </select>
            </td>
            <td>
              <select
                class="form-control form-control-sm required"
                v-model="formData.mhm_partner_id"
              >
                <option value="">Choose if MHM's partner</option>
                <option
                  v-for="partner in accessory.mhm_partners"
                  :value="partner.id"
                >
                  {{ partner.name }}
                </option>
              </select>
            </td>
          </tr>
          <tr v-if="formData.admission_priority_id === 3">
            <td colspan="3">
              Provisional Diagnosis<span class="text-danger">*</span>
            </td>
          </tr>
          <tr v-if="formData.admission_priority_id === 3">
            <td colspan="5">
              <textarea
                class="form-control form-control-sm required"
                v-model="formData.provisional_diagnosis"
              ></textarea>
              <span
                v-if="$v.formData.provisional_diagnosis.$error"
                class="text-white bg-danger"
                >Please provide a provisional diagnosis</span
              >
            </td>
          </tr>
          <tr>
            <td>Temp</td>
            <td>Weight</td>
            <td>Height</td>
            <td>Blood Pressure</td>
            <td>Pulse</td>
            <td>SpO<small>2</small></td>
          </tr>
          <tr>
            <td>
              <input
                type="number"
                class="required"
                v-model="formData.temp"
                :class="{ 'text-danger': formData.temp >= 38 }"
                :disabled="formData.patient.id === ''"
              />
            </td>
            <td>
              <input
                type="number"
                class="required"
                v-model="formData.weight"
                :disabled="formData.patient.id === ''"
              />
            </td>
            <td>
              <input
                type="number"
                class="required"
                v-model="formData.patient.height"
                :disabled="formData.patient.id === ''"
              />
            </td>
            <td>
              <input
                type="number"
                class="required"
                style="width: 40px"
                v-model="formData.taSysto"
                :class="{ 'text-danger': formData.taSysto >= 14 }"
                :disabled="formData.patient.id === ''"
              />
              /
              <input
                type="number"
                class="required"
                style="width: 40px"
                v-model="formData.taDia"
                :disabled="formData.patient.id === ''"
              />
            </td>
            <td>
              <input
                type="number"
                class="required"
                v-model="formData.pulse"
                :disabled="formData.patient.id === ''"
              />
            </td>
            <td>
              <input
                type="number"
                class="required"
                v-model="formData.spo2"
                :class="{ 'text-danger': formData.taSysto >= 75 }"
                :disabled="formData.patient.id === ''"
              />
            </td>
          </tr>
        </table>
        <table class="table table-sm">
          <tr>
            <th class="table-title pl-4">
              <v-icon>mdi-calendar-check</v-icon>
              Remarks:
            </th>
          </tr>
          <tr>
            <td>
              <textarea
                class="form-control form-control-sm"
                v-model="formData.remark"
                :disabled="formData.patient.id === ''"
              ></textarea>
            </td>
          </tr>
        </table>
        <table class="table table-sm">
          <tr>
            <th class="table-title pl-4">
              <v-icon>mdi-cash</v-icon>
              Pricing
            </th>
          </tr>
        </table>
        <p v-if="formData.patient.patient_category_id === 3" class="bg-info">
          The patient is registered as Mhm's employee
        </p>
        <p v-if="formData.patient.patient_category_id === 4" class="bg-info">
          The patient is registered as a staff family of Mhm's employee
        </p>
        <p v-if="formData.patient.patient_category_id === 5" class="bg-info">
          The patient is registered as member of Mhm's partnership
        </p>
      </div>
      <div class="row">
        <div class="col-6">
          <table class="table table-sm">
            <tr>
              <td>Name</td>
              <td>Price</td>
            </tr>
            <tr>
              <td>{{ formData.admission_care_details.name }}</td>
              <td>
                <span v-if="!accessory.price_manual_entry">{{
                  formData.admission_care_details.price
                }}</span>
                <input
                  type="number"
                  v-if="accessory.price_manual_entry"
                  v-model="formData.admission_care_details.price"
                  class="required"
                />
              </td>
            </tr>
          </table>
        </div>
        <div class="col-6">
          <table class="table table-sm">
            <tr>
              <td>Previous unpaid amount</td>
              <td :class="{ 'text-danger': formData.patient.last_due > 0 }">
                {{ formData.patient.last_due }}
              </td>
              <td></td>
            </tr>
            <tr>
              <td>Total</td>
              <td class="font-weight-bold text-decoration-underline">
                {{
                  parseInt(formData.admission_care_details.price) +
                  formData.patient.last_due
                }}
              </td>
            </tr>
          </table>
          <div class="text-right mt-6">
            <v-btn
              color="info"
              :loading="accessory.form_is_submitting"
              @click="submit"
              v-if="!accessory.quick_search"
              >submit</v-btn
            >
          </div>
        </div>
        <!--patient height dialog modal -->
        <v-dialog v-model="accessory.height_modal" max-width="290">
          <v-card>
            <v-card-title class="text-h5">
              Enter the height of the patient
            </v-card-title>

            <v-card-text>
              <input
                type="number"
                class="form-control form-control-sm"
                @keydown.enter.prevent="update_patient_height"
                v-model="formData.patient.height"
              />
            </v-card-text>
          </v-card>
        </v-dialog>
      </div>
    </v-app>
  </div>
</template>
<script>
import { validationMixin } from "vuelidate";
const {
  required,
  requiredIf,
  minLength,
  email,
  url,
  maxLength,
} = require("vuelidate/lib/validators");
export default {
  name: "admission",
  mixins: [validationMixin],
  props: ["edit", "reference"],
  data() {
    return {
      formData: {
        id: "",
        category_id: "",
        service_id: "",
        service_activity_id: "",
        admission_priority_id: "",
        mhm_partner_id: "",
        status: "RUNNING",
        temp: "",
        pulse: "",
        taSysto: "",
        taDia: "",
        weight: "",
        spo2: "",
        provisional_diagnosis: "",
        patient: {
          id: "",
          firstName: "",
          lastName: "",
          birthDate: "",
          adress: "",
          tel: "",
          sector: false,
          last_due: 0,
          patient_category_id: "",
          mhm_partner_id: "",
        },
        remark: "",
        admission_care_details: {
          id: "",
          name: "",
          price: null,
        },
      },
      accessory: {
        categories: [],
        services: [],
        service_activities: [],
        divisions: [],
        priorities: [],
        mhm_partners: [],
        price_manual_entry: false,
        fokontany: [],
        noPatientFound: false,
        form_is_submitting: false,
        form_update: false,
        height_modal: false,
        quick_search: false,
      },
    };
  },
  watch: {
    reference(val) {
      this.resetForm();
      this.formData.id = val;
      this.fetch_reference();
    },
    // accessory:{
    //     handler(val){
    //         if(val.services.length===1){
    //             this.formData.service_id= val.services[0].id
    //         }
    //     },
    //     deep:true
    // }
  },
  mounted() {
    this.init();
  },
  validations: {
    formData: {
      service_activity_id: { required },
      admission_priority_id: { required },
      patient: {
        id: { required },
      },
      provisional_diagnosis: {
        required: requiredIf(
          (formData) => formData.admission_priority_id === 3
        ),
      },
    },
  },
  methods: {
    async init() {
      axios
        .get("/api/v1/patient_system/system/category")
        .then((response) => (this.accessory.categories = response.data));
      axios
        .get("/api/v1/patient_system/admission/priority")
        .then((response) => (this.accessory.priorities = response.data));
      axios
        .get("/api/v1/extra/fokontany")
        .then((response) =>
          response.data.forEach((fkt) =>
            this.accessory.fokontany.push(fkt.name.toLowerCase())
          )
        );
      axios
        .get("/api/v1/extra/mhm_partner")
        .then((response) => (this.accessory.mhm_partners = response.data));
      if (this.reference !== "" && this.reference !== undefined) {
        this.formData.id = this.reference;
        this.fetch_reference();
      }
    },
    async changePat() {
      await axios
        .get(
          `/api/v1/patient_system/patient/with_due_sum/${this.formData.patient.id}`
        )
        .then((response) => {
          this.resetForm();
          if (response.data) {
            this.formData.patient = response.data;
            // this.formData.patient.last_due =response.data.patient_due!==null?parseInt(response.data.patient_due.amount):0
            let adress = this.formData.patient.adress.toLowerCase().split(" ");
            let check = false;
            adress.forEach((ad) => {
              if (this.accessory.fokontany.indexOf(ad) !== -1) {
                check = true;
              }
            });
            this.formData.patient.sector = check;
          } else {
            this.accessory.noPatientFound = true;
          }
          if ([3, 4, 5, 6].includes(this.formData.patient.patient_category_id))
            this.formData.admission_priority_id = 1;
          else this.formData.admission_priority_id = 5;
        });
      await axios
        .get(
          `/api/v1/patient_system/cashier/patient_due/${this.formData.patient.id}`
        )
        .then((response) => {
          this.formData.patient.last_due = response.data;
        });
    },
    async changeCategory() {
      this.accessory.service_activities = [];
      this.accessory.services = [];
      this.formData.admission_care_details = { id: "", name: "", price: null };
      await this.validate_category();
      if (this.formData.category_id !== "") {
        await axios
          .get(
            `/api/v1/patient_system/system/service/category/${this.formData.category_id}`
          )
          .then((response) => (this.accessory.services = response.data));
        if (this.accessory.services.length === 1) {
          this.formData.service_id = this.accessory.services[0].id;
          this.changeService();
        }
      }
    },
    async changeService() {
      this.formData.admission_care_details = { id: "", name: "", price: null };
      this.accessory.service_activities = [];
      await this.validate_service();
      if (this.formData.service_id !== "") {
        axios
          .get(
            `/api/v1/patient_system/system/serviceActivity/service/${this.formData.service_id}`
          )
          .then((response) => {
            this.accessory.service_activities = response.data;
            if (this.accessory.service_activities.length === 1) {
              this.formData.service_activity_id =
                this.accessory.service_activities[0].id;
              this.changeActivity();
            }
          });
      }
    },
    async changeActivity() {
      this.formData.admission_care_details = { id: "", name: "", price: null };
      let patient_category;
      if (this.formData.patient.patient_category_id === null) {
        patient_category = this.formData.patient.sector === false ? 0 : 1;
      } else patient_category = this.formData.patient.patient_category_id;
      console.log(patient_category);
      await axios
        .get(
          `/api/v1/patient_system/admission/activity_price/${this.formData.service_activity_id}/${patient_category}`
        )
        .then((response) => {
          if (response.data.length > 0) {
            this.formData.admission_care_details = response.data[0];
          }
        });
    },
    add_care_line() {
      let line = this.accessory.temp_care_line;
      line.amount = line.price * line.qty;
      this.formData.admission_care_details.push(line);
      this.accessory.temp_care_line = { id: "", name: "", price: "", qty: "" };
    },
    delete_care_line(rowId) {
      return this.formData.admission_care_details.splice(rowId, 1);
    },
    async validate_service() {
      if (
        this.formData.patient.gender === "M" &&
        this.formData.service_id === 8 &&
        this.formData.category_id === 6
      ) {
        this.$toast.open({
          message: "the patient is not female",
          position: "top-right",
          type: "error",
        });
        this.formData.service_id = "";
      }
      if (
        this.check_age < 2 &&
        this.formData.service_id !== 9 &&
        this.formData.category_id === 6
      ) {
        this.$toast.open({
          message: "the patient should go to the pediatric service",
          position: "top-right",
          type: "error",
        });
        this.formData.service_id = "";
      }
      if (
        this.check_age > 18 &&
        this.formData.service_id === 9 &&
        this.formData.category_id === 6
      ) {
        this.$toast.open({
          message: "the patient is too old for pediatric service",
          position: "top-right",
          type: "error",
        });
        this.formData.service_id = "";
      }
      if (
        this.formData.patient.gender === "M" &&
        this.formData.service_id === 14 &&
        this.formData.category_id === 7
      ) {
        this.$toast.open({
          message: "the patient is not female",
          position: "top-right",
          type: "error",
        });
        this.formData.service_id = "";
      }
      if (
        this.check_age < 2 &&
        this.formData.service_id !== 15 &&
        this.formData.category_id === 7
      ) {
        this.$toast.open({
          message: "the patient should go to the pediatric service",
          position: "top-right",
          type: "error",
        });
        this.formData.service_id = "";
      }
      if (
        this.formData.service_id === 8 &&
        this.formData.patient.height !== null
      ) {
        this.accessory.height_modal = true;
      }
    },
    async validate_category() {
      if (
        this.formData.patient.gender === "M" &&
        this.formData.category_id === 8
      ) {
        this.$toast.open({
          message: "the patient is not female",
          position: "top-right",
          type: "error",
        });
        this.formData.category_id = "";
      }
    },
    async update_patient_height() {
      await axios
        .put(
          `/api/v1/patient_system/patient/patient/${this.formData.patient.id}`,
          this.formData.patient
        )
        .then((response) => {
          if (response.data.success) {
            this.accessory.height_modal = false;
            this.$toast.open({
              message: "the height of the patient is updated",
              position: "top-right",
              type: "success",
            });
          }
        });
    },
    resetForm() {
      this.formData = {
        id: "",
        category_id: "",
        service_id: "",
        service_activity_id: "",
        admission_priority_id: "",
        mhm_partner_id: "",
        status: "RUNNING",
        temp: "",
        pulse: "",
        taSysto: "",
        taDia: "",
        weight: "",
        spo2: "",
        provisional_diagnosis: "",
        patient: {
          id: "",
          firstName: "",
          lastName: "",
          birthDate: "",
          adress: "",
          tel: "",
          sector: false,
          last_due: 0,
          patient_category_id: "",
          mhm_partner_id: "",
        },
        remark: "",
        admission_care_details: {
          id: "",
          name: "",
          price: null,
        },
      };
    },
    async submit() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        return true;
      }
      this.accessory.form_is_submitting = true;
      this.formData.user_id = window.auth.user.id;
      this.formData.patient_id = this.formData.patient.id;
      if (!this.accessory.form_update) {
        await axios
          .post("/api/v1/patient_system/admission/admission", this.formData)
          .then((response) => {
            if (response.data.success) {
              this.accessory.form_is_submitting = false;
              this.$toast.open({
                message: response.data.msg,
                position: "top-right",
                type: "success",
              });
              this.resetForm();
              this.$v.$reset();
            }
          });
      } else {
        await axios
          .put(
            `/api/v1/patient_system/admission/admission/${this.formData.id}`,
            this.formData
          )
          .then((response) => {
            if (response.data.success) {
              this.$v.$reset();
              this.accessory.form_is_submitting = false;
              this.$emit("updated");
            }
          });
      }
    },
    async fetch_reference() {
      await axios
        .get(`/api/v1/patient_system/admission/admission/${this.formData.id}`)
        .then((response) => {
          this.accessory.form_update = true;
          let care_details = [];
          this.formData = response.data;
          this.formData.patient.last_due =
            response.data.patient.patient_due !== null
              ? parseInt(response.data.patient.patient_due.amount)
              : 0;
          this.changeCategory();
          this.changeService();
        });
      this.changeActivity();
    },
    quickSearch() {
      this.accessory.quick_search = true;
      this.fetch_reference();
    },
  },
  computed: {
    check_age() {
      let now = new Date().getFullYear();
      let birthDate = new Date(this.formData.patient.birthDate);
      return now - birthDate.getFullYear();
    },
    priority_color() {
      switch (this.formData.admission_priority_id) {
        case 3:
          return "text-white bg-danger";
          break;
        case 4:
          return "tex-white bg-warning";
          break;
        default:
          return "";
      }
    },
  },
};
</script>
<style scoped>
.container {
  margin-top: 40px;
  background-color: white;
  min-height: 90vh;
  padding: 40px;
}
.table-title {
  background-color: #1390c6;
  color: white;
}
.required {
  background-color: rgba(233, 242, 238, 0.7);
}
.form-title {
  font-family: "Enriqueta", arial, serif;
  margin: 0 0 10px;
  font-size: 40px;
  font-weight: bold;
  color: #7c795d;
}
</style>
