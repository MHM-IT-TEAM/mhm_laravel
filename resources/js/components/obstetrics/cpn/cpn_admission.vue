<template>
  <div class="container w-75 p-4 bg-light">
    <form @submit.prevent="submit">
      <div class="d-flex flex-row justify-content-between">
        <div class="p-2"><h1 id="title">OBSTETRICS OUTPATIENT N247570</h1></div>
        <div class="p-2">
          <img
            id="logo"
            src="/storage/assets/media/images/system/MHMlogo_PRINT.jpg"
            alt="MHM logo"
          />
        </div>
      </div>
      <div class="table-responsive">
        <table class="table" id="patient_details_table">
          <tbody>
            <tr>
              <td colspan="8" class="table_title">Patient's Details</td>
            </tr>
            <tr>
              <td style="width: 5% !important">
                <span :class="{ 'text-danger': $v.formData.patient_id.$error }"
                  >Id:</span
                >
              </td>
              <td>
                <input
                  type="text"
                  v-model="formData.patient_id"
                  @change="change_patient"
                  :class="{
                    'border border-danger': $v.formData.patient_id.$error,
                  }"
                />
              </td>
              <td>Full Name:</td>
              <td style="width: 25%">{{ fullName }}</td>
              <td style="width: 10% !important">D.O.B</td>
              <td>{{ patient_details.dob }}</td>
              <td>
                <span :class="{ 'text-danger': parseInt(age) < 18 }"
                  >age: {{ age }}</span
                >
              </td>
            </tr>
            <tr>
              <td>Adress:</td>
              <td colspan="">{{ patient_details.adress }}</td>
              <td>Tel:</td>
              <td>{{ patient_details.tel }}</td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered" id="pregnancy_details_table">
          <tbody>
            <tr>
              <td colspan="10" class="table_title">General Information</td>
            </tr>
            <tr>
              <td>DDR</td>
              <td colspan="2">
                <span :class="{ 'text-danger': $v.formData.dpa.$error }"
                  >DPA <small>[Echo/calc]</small></span
                >
              </td>
              <td>G</td>
              <td>P</td>
              <td>A</td>
              <td>M</td>
              <td>EV</td>
              <td>DDA</td>
              <td>Problems with last delivery</td>
            </tr>
            <tr>
              <td class="border">
                <input type="date" v-model="formData.ddr" />
              </td>
              <td colspan="2" style="width: 30%" class="border">
                <input
                  type="date"
                  v-model="formData.dpa"
                  :class="{ 'border border-danger': $v.formData.dpa.$error }"
                />
                <span>[</span
                ><select v-model="formData.dpa_method">
                  <option value="echo">Echo</option>
                  <option value="calc">Calc</option></select
                ><span>]</span>
              </td>
              <td class="border">
                <input type="text" v-model="formData.gravida" />
              </td>
              <td class="border">
                <input type="text" v-model="formData.parity" />
              </td>
              <td class="border">
                <input
                  type="text"
                  v-model="formData.abortion"
                  :class="{ 'text-danger': formData.abortion > 0 }"
                />
              </td>
              <td class="border">
                <input
                  type="text"
                  v-model="formData.miscarriage"
                  :class="{ 'text-danger': formData.miscarriage > 0 }"
                />
              </td>
              <td class="border">
                <input type="text" v-model="formData.ev" />
              </td>
              <td class="border">
                <input type="text" v-model="formData.dda" />
              </td>
              <td class="border" style="width: 30% !important">
                <textarea
                  style="width: 100%"
                  v-model="formData.problems_with_last_delivery"
                ></textarea>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered">
          <tr>
            <td>Dist.Spin[cm]</td>
            <td>Dist.Christ[cm]</td>
            <td>Dist.Troch[cm]</td>
            <td>Dist.Obst[cm]</td>
            <td>Michaelis rhombus[cm]</td>
            <td>Baum-HG[cm]</td>
            <td>Problem for delivery</td>
          </tr>
          <tr>
            <td class="border">
              <input type="text" v-model="formData.spin" />
            </td>
            <td class="border">
              <input type="text" v-model="formData.christ" />
            </td>
            <td class="border">
              <input type="text" v-model="formData.troch" />
            </td>
            <td class="border">
              <input type="text" v-model="formData.obst" />
            </td>
            <td class="border">
              <input type="text" v-model="formData.michaelis" />
            </td>
            <td class="border">
              <input type="text" v-model="formData.baum_hg" />
            </td>
            <td>
              <div class="custom-control custom-radio custom-control-inline">
                <input
                  type="radio"
                  id="prob_for_del1"
                  name="problem_for_delivery"
                  value="1"
                  v-model="formData.problem_for_delivery"
                  class="custom-control-input"
                />
                <label class="custom-control-label" for="prob_for_del1"
                  >Yes</label
                >
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input
                  type="radio"
                  id="prob_for_del2"
                  name="problem_for_delivery"
                  value="0"
                  v-model="formData.problem_for_delivery"
                  class="custom-control-input"
                />
                <label class="custom-control-label" for="prob_for_del2"
                  >No</label
                >
              </div>
            </td>
          </tr>
        </table>
        <table class="table table-bordered">
          <tr>
            <td>Blood Group</td>
            <td>Result of blood test <strong>[HIV]</strong></td>
            <td>Result of blood test <strong>[Syphilis]</strong></td>
            <td>Result of blood test <strong>[Others]</strong></td>
            <td>Result of blood test <strong>[HB]</strong></td>
          </tr>
          <tr>
            <td><input type="text" v-model="formData.blood_group" /></td>
            <td><input type="text" v-model="formData.hiv" /></td>
            <td><input type="text" v-model="formData.syphilis" /></td>
            <td><input type="text" v-model="formData.other_test" /></td>
            <td><input type="text" v-model="formData.hb_test" /></td>
          </tr>
        </table>
        <table class="table table-bordered" id="preg_history">
          <tr>
            <td class="table_title" colspan="5">
              Pregnancy History
              <v-btn
                class="mx-2"
                fab
                dark
                color="indigo"
                x-small
                @click="add_row"
              >
                <v-icon dark> mdi-plus </v-icon>
              </v-btn>
            </td>
          </tr>
          <tr>
            <td>Nr./Year</td>
            <td>Pregnancy</td>
            <td>Birth type/Place/Problems</td>
            <td>Newborn</td>
            <td>Pueperium</td>
          </tr>
          <tr v-for="row in formData.pregnancy_history">
            <td><input type="text" v-model="row.nr_year" /></td>
            <td><input type="text" v-model="row.pregnancy" /></td>
            <td>
              <input type="text" v-model="row.birth_type" />/
              <input type="text" v-model="row.birth_place" />/
              <input type="text" v-model="row.birth_problems" />
            </td>
            <td><input type="text" v-model="row.newBorn" /></td>
            <td><input type="text" v-model="row.pueperium" /></td>
          </tr>
        </table>
        <table class="table">
          <tbody>
            <tr>
              <td class="table_title" colspan="2">Medical History</td>
            </tr>
            <tr>
              <td style="width: 10% !important">Pregnant Woman</td>
              <td>
                <input
                  type="text"
                  style="width: 100%"
                  v-model="formData.pregnant_woman"
                />
              </td>
            </tr>
            <tr>
              <td style="width: 10% !important">Close Family</td>
              <td>
                <input
                  type="text"
                  style="width: 100%"
                  v-model="formData.close_family"
                />
              </td>
            </tr>
            <tr>
              <td style="width: 10% !important">Twins/OC in the family</td>
              <td>
                <input
                  type="text"
                  style="width: 40%"
                  v-model="formData.twins"
                />/
                <input type="text" style="width: 40%" v-model="formData.oc" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <button type="submit" class="btn btn-primary btn-sm">Submit</button>
    </form>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
const {
  required,
  minLength,
  email,
  url,
  maxLength,
} = require("vuelidate/lib/validators");
export default {
  name: "cpn_admission",
  mixins: [validationMixin],
  data() {
    return {
      formData: {
        patient_id: "",
        ddr: "",
        dpa: "",
        dpa_calc: false,
        dpa_echo: false,
        dpa_method: "method",
        gravida: "",
        parity: "",
        abortion: "",
        miscarriage: "",
        ev: "",
        dda: "",
        problems_with_last_delivery: "",
        blood_group: "",
        hiv: "",
        syphilis: "",
        other_test: "",
        hb_test: "",
        pregnant_woman: "",
        close_family: "",
        twins: "",
        oc: "",
        pregnancy_history: [
          {
            nr_year: "",
            pregnancy: "",
            birth_type: "",
            birth_place: "",
            birth_problems: "",
            newBorn: "",
            pueperium: "",
          },
        ],
        spin: "",
        christ: "",
        troch: "",
        obst: "",
        michaelis: "",
        baum_hg: "",
        problem_for_delivery: "",
      },
      patient_details: {
        firstName: "",
        lastName: "",
        dob: "",
        adress: "",
        tel: "",
      },
    };
  },
  methods: {
    async change_patient() {
      let patData = await axios.get(
        `/api/patients/${this.formData.patient_id}/edit`
      );
      this.patient_details.firstName = patData.data.patient.firstName.toUpperCase();
      this.patient_details.lastName = patData.data.patient.lastName;
      this.patient_details.dob = patData.data.patient.birthDate;
      this.patient_details.adress = patData.data.patient.adress;
    },
    add_row() {
      this.formData.pregnancy_history.push({});
    },
    submit() {
      this.$v.formData.$touch();
      if (!this.$v.$invalid) this.reset_form();
      //axios.post("/api/obstetrics/cpn/admission", this.formData);
      this.$toast.open({
        message: "data submited",
        position: "top-right",
      });
    },
    reset_form() {
      this.$v.$reset();
      for (let [key, val] of Object.entries(this.formData)) {
        this.formData[key] = "";
      }
      for (let [key, val] of Object.entries(this.patient_details)) {
        this.patient_details[key] = "";
      }
    },
  },
  computed: {
    fullName() {
      return (
        this.patient_details.firstName + " " + this.patient_details.lastName
      );
    },
    age() {
      if (this.patient_details.dob !== "") {
        var difference =
          Date.now() - new Date(this.patient_details.dob).getTime();
        var age = new Date(difference);
        return Math.abs(age.getUTCFullYear() - 1970);
      } else {
        return "";
      }
    },
  },
  validations: {
    formData: {
      patient_id: { required },
      dpa: { required },
    },
  },
};
</script>

<style scoped>
.container {
  box-shadow: 0px 0px 0.5cm rgba(0, 0, 0, 0.8);
  margin-top: 0.6%;
  background-color: white !important;
  font-family: calibri;
}
input {
  font-size: 11px;
}
input[type="date"]::-webkit-calendar-picker-indicator {
  display: none;
  -webkit-appearance: none;
  max-width: 65px;
}
input:hover {
  border-bottom: 2px solid rgb(194, 194, 194);
  border-radius: 0;
}
td {
  line-height: 10px;
}
#logo {
  max-width: 250px;
  max-height: 100px;
}
#title {
  margin-top: 10px;
  font-weight: bold;
}
.table_title {
  background-color: rgb(195, 195, 195) !important;
  font-weight: bold;
  /*-webkit-print-color-adjust: exact;*/
}
</style>
