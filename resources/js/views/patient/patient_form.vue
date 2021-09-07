<template>
  <div class="container-fluid p-4">
      <div class="row">
          <div class="col-8">
              <form
                  id="patientForm"
                  enctype="multipart/form-data"
                  @submit.prevent="submit"
                  class="form"
                  autocomplete="off"
              >
                  <div class="patient_container p-4">
                      <h4>Personal</h4>
                      <hr />
                      <div class="row perso_detail">
                          <div class="col-sm-4">
                              <label for="firstName" class="pb-0 col-form-label">First Name</label
                              ><span class="text-danger">*</span>
                              <div class="row">
                                  <div
                                      class="col-sm-12"
                                      :class="{ 'form-group--error': $v.patient.firstName.$error }"
                                  >
                                      <input
                                          class="form-control"
                                          name="firstName"
                                          id="firstName"
                                          v-model="patient.firstName"
                                          @input="$v.patient.firstName.$touch()"
                                      />
                                      <div v-if="$v.patient.firstName.$error">
                                          <div
                                              class="error text-white alert-danger"
                                              v-if="!$v.patient.firstName.required"
                                          >
                                              First name is required
                                          </div>
                                          <div
                                              class="error text-white alert-danger"
                                              v-if="!$v.patient.firstName.minLength"
                                          >
                                              First name must have at least
                                              {{ $v.patient.firstName.$params.minLength.min }} letters.
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <label for="lastName" class="pb-0 col-form-label">Last Name</label
                              ><span class="text-danger">*</span>
                              <div class="row mb-0">
                                  <div class="col-sm-12">
                                      <input
                                          class="form-control"
                                          name="lastName"
                                          id="lastName"
                                          v-model="patient.lastName"
                                          @input="$v.patient.lastName.$touch()"
                                      />
                                      <div v-if="$v.patient.lastName.$error">
                                          <div
                                              class="error text-white alert-danger"
                                              v-if="!$v.patient.lastName.required"
                                          >
                                              Last name is required
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <label for="gender" class="pb-0 pt-0 col-form-label">Gender</label
                              ><span class="text-danger">*</span>
                              <div class="row">
                                  <div class="col-sm-12">
                                      <select
                                          class="form-control"
                                          name="gender"
                                          id="gender"
                                          v-model="patient.gender"
                                      >
                                          <option value=""></option>
                                          <option value="M">Male</option>
                                          <option value="F">Female</option>
                                      </select>
                                      <div v-if="$v.patient.gender.$error">
                                          <div
                                              class="error text-white alert-danger"
                                              v-if="!$v.patient.gender.required"
                                          >
                                              Gender is required
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="row mt-0">
                                  <div class="col-sm-6 pt-0">
                                      <label for="dob" class="pb-0 col-form-label">DOB</label
                                      ><span class="text-danger">*</span>
                                      <date-picker v-model="patient.birthDate"
                                                   name="dob"
                                                   id="dob"
                                                   :input-debounce="500" mode="date"
                                                   :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                                   :max-date="new Date()">
                                          <template v-slot="{ inputValue, inputEvents }">
                                              <input
                                                  class="bg-white form-control form-control-sm px-2 py-1 rounded"
                                                  :value="inputValue"
                                                  v-on="inputEvents"
                                              />
                                          </template>
                                      </date-picker>
                                      <div v-if="$v.patient.birthDate.$error">
                                          <div
                                              class="error text-white alert-danger"
                                              v-if="!$v.patient.birthDate.required"
                                          >
                                              Date of birth is required
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-sm-6 pt-0">
                                      <label for="dob" class="pb-0 col-form-label ">Height</label
                                      >
                                      <input
                                          type="number"
                                          class="form-control"
                                          v-model="patient.height"
                                      />

                                  </div>
                              </div>
                          </div>
                          <!--personal info-->

                          <div class="col-sm-2">
                              <label for="martialStatus" class="pb-0 col-form-label"
                              >Martial Status</label
                              >
                              <div class="row">
                                  <div class="col-sm-12">
                                      <select
                                          class="form-control"
                                          name="martialStatus"
                                          id="martialStatus"
                                          v-model="patient.martialStatus"
                                      >
                                          <option value=""></option>
                                          <option value="Single">Single</option>
                                          <option value="Couple">Couple</option>
                                      </select>
                                  </div>
                              </div>
                              <label for="bloodGroup" class="pb-0 col-form-label"
                              >Blood Group</label
                              >
                              <div class="row">
                                  <div class="col-sm-12">
                                      <input
                                          class="form-control"
                                          name="bloodGroup"
                                          id="bloodGroup"
                                          v-model="patient.bloodGroup"
                                      />
                                  </div>
                              </div>
                              <label for="occupation" class="pb-0 col-form-label"
                              >Occupation</label
                              >
                              <div class="row">
                                  <div class="col-sm-12">
                                      <input
                                          class="form-control"
                                          name="occupation"
                                          id="occupation"
                                          v-model="patient.job"
                                      />
                                  </div>
                              </div>
                              <label for="education" class="pb-0 col-form-label"
                              >Education Level</label
                              >
                              <div class="row">
                                  <div class="col-sm-12">
                                      <select
                                          class="form-control"
                                          name="education"
                                          id="education"
                                          v-model="patient.education"
                                      >
                                          <option value=""></option>
                                          <option value="illiterate">Illiterate</option>
                                          <option value="primary">Primary</option>
                                          <option value="secondary">Secondary</option>
                                          <option value="university">University</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <!-- more info-->
                          <div class="col-sm-3">
                              <div class="row">
                                  <div class="col-12">
                                      <label for="Nationality" class="pb-0 col-form-label"
                                      >Nationality</label
                                      >
                                      <div class="row">
                                          <div class="col-sm-12">
                                              <!--                                        <input class="form-control" name="nationality" id="nationality" v-model="patient.nationality"/>-->
                                              <multiselect
                                                  v-model="nationality"
                                                  label="country_name"
                                                  track-by="country_name"
                                                  placeholder="Type to search"
                                                  :options="countries"
                                                  value="countries.country_name"
                                              >
                                              </multiselect>
                                          </div>
                                      </div>
                                      <label for="idCard" class="pb-0 col-form-label">ID card</label>
                                      <div class="row">
                                          <div class="col-sm-12">
                                              <input
                                                  class="form-control"
                                                  name="idCard"
                                                  id="idCard"
                                                  v-model="patient.cin_no"
                                              />
                                              <span class="text-white bg-danger" v-if="$v.patient.cin_no.$error">ID Card required</span>
                                          </div>
                                      </div>
                                      <label for="idDate" class="pb-0 col-form-label">ID Date</label>
                                      <div class="row">
                                          <div class="col-sm-12">
                                              <date-picker v-model="patient.cin_date"
                                                           name="idDate"
                                                           id="idDate"
                                                           :input-debounce="500" mode="date"
                                                           :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                                           :max-date="new Date()">
                                                  <template v-slot="{ inputValue, inputEvents }">
                                                      <input
                                                          class="bg-white form-control form-control-sm px-2 py-1 rounded"
                                                          :value="inputValue"
                                                          v-on="inputEvents"
                                                      />
                                                  </template>
                                              </date-picker>
                                              <span class="text-white bg-danger" v-if="$v.patient.cin_date.$error">ID Card Date required</span>
                                          </div>
                                      </div>
                                      <label for="idPlace" class="pb-0 col-form-label"
                                      >ID Place</label
                                      >
                                      <div class="row">
                                          <div class="col-sm-12">
                                              <input
                                                  type="text"
                                                  class="form-control"
                                                  name="idPlace"
                                                  id="idPlace"
                                                  v-model="patient.cin_place"
                                              />
                                              <span class="text-white bg-danger" v-if="$v.patient.cin_place.$error">ID Card Place required</span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-3">
                              <div class="col-12" id="av">
                                  <input
                                      type="file"
                                      name="avatar"
                                      id="avatar"
                                      class="file"
                                      @change="avatar_change"
                                  />
                                  <div class="border" id="avatar_container"></div>
                                  <!-- <input type="file" id="avat" />	 -->
                              </div>
                              <!-- <div class="col-6 avatar">
                                              <i class="fas fa-user  w-100 h-100"></i>
                                          </div> -->
                          </div>
                          <!--Avatar and Nationality-->
                      </div>
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label>Patient category</label>
                                  <select class="form-control" v-model="patient.patient_category_id">
                                      <option v-for="item in patient_category" :value="item.id">{{item.name}}</option>
                                  </select>
                                  <span class="text-white bg-danger" v-if="$v.patient.patient_category_id.$error">You must choose a category</span>
                              </div>
                          </div>
                          <div class="col-6"  v-if="this.patient.patient_category_id===5">
                              <div class="form-group">
                                  <label>write the name of the organization</label>
                                  <select class="form-control" v-model="patient.mhm_partner_id">
                                      <option v-for="item in mhm_partner" :value="item.id">{{item.name}}</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <!--personal detail-->
                      <br />
                      <h4>Communication Details</h4>
                      <hr />
                      <div class="row">
                          <div class="col-4">
                              <div class="row">
                                  <div class="col-sm-12">
<!--                                      <input-->
<!--                                          type="text"-->
<!--                                          class="form-control"-->
<!--                                          name="adress"-->
<!--                                          id="adress"-->
<!--                                          v-model="patient.adress"-->
<!--                                      />-->
                                      <v-combobox
                                          v-model="patient.adress"
                                          :items="fokontany"
                                          label="Address"
                                      ></v-combobox>
                                      <div v-if="$v.patient.adress.$error">
                                          <div
                                              class="error text-white alert-danger"
                                              v-if="!$v.patient.adress.required"
                                          >
                                              Address is required
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-4">
                              <label for="tel" class="pb-0 col-form-label">Mobile No</label>
                              <div class="row">
                                  <div class="col-sm-12">
                                      <input
                                          type="text"
                                          class="form-control"
                                          name="tel"
                                          id="tel"
                                          v-model="patient.tel"
                                      />
                                  </div>
                              </div>
                          </div>

                          <div class="col-4">
                              <label for="tel" class="pb-0 col-form-label">Email</label>
                              <div class="row">
                                  <div class="col-sm-12">
                                      <input
                                          type="email"
                                          class="form-control"
                                          name="email"
                                          id="email"
                                          v-model="patient.email"
                                      />
                                  </div>
                              </div>
                          </div>
                      </div>
                      <br />
                      <h4>Relatives Contact</h4>
                      <hr />
                      <div class="row">
                          <table class="table w-100 table-borderless">
                              <thead>
                              <tr>
                                  <th>Mom</th>
                                  <th>Dad</th>
                              </tr>
                              </thead>
                              <tbody>
                              <tr>
                                  <td>
                                      <input
                                          type="text"
                                          class="form-control"
                                          name="mom_name"
                                          id="mom_name"
                                          v-model="patient.mom_name"
                                      />
                                  </td>
                                  <td>
                                      <input
                                          type="text"
                                          class="form-control"
                                          name="dad_name"
                                          id="dad_name"
                                          v-model="patient.dad_name"
                                      />
                                  </td>
                              </tr>
                              </tbody>
                          </table>
                      </div>
                      <div class="">
                          <div class="row">
                              <div class="col-10">
                                  <h4 class="text-danger">Emergency Contact</h4>
                              </div>
                              <div class="col-2">
                                  <!--                            <button class="btn btn-sm btn-primary float-right" @click="add_row()" type="button"><i class="fa fa-plus"></i></button>-->
                                  <v-btn
                                      class="mx-2 float-right"
                                      fab
                                      dark
                                      small
                                      color="indigo"
                                      @click="add_row"
                                  >
                                      <v-icon dark> mdi-plus </v-icon>
                                  </v-btn>
                              </div>
                          </div>
                          <table id="emergency_table" class="table w-100 table-borderless">
                              <thead>
                              <th>Name</th>
                              <th>Tel</th>
                              </thead>
                              <tbody>
                              <tr v-for="row in em_rows" :key="row.id">
                                  <td>
                                      <input
                                          type="text"
                                          class="form-control"
                                          name="emContact_name[]"
                                          v-model="row.name"
                                      />
                                  </td>
                                  <td>
                                      <input
                                          type="text"
                                          class="form-control"
                                          name="emContact_tel[]"
                                          v-model="row.tel"
                                      />
                                  </td>
                              </tr>
                              </tbody>
                          </table>
                      </div>

                      <div id="test">
                          <!--                    <button type="submit" id="submit" name="submit" class="btn btn-sm btn-primary">Submit</button>-->
                          <v-btn color="primary" type="submit"> Submit </v-btn>
                      </div>
                  </div>
              </form>
          </div>
          <div class="col-4">
              <v-simple-table>
                  <template v-slot:default>
                      <thead>
                      <tr>
                          <th class="text-left">
                              ID
                          </th>
                          <th class="text-left">
                              First name
                          </th>
                          <th class="text-left">
                              Last name
                          </th>
                          <th class="text-left">
                              Date of birth
                          </th>
                          <th class="text-left">
                              Address
                          </th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr
                          v-for="item in suggestions"
                          :key="item.id"
                      >
                          <td>{{item.id}}</td>
                          <td>{{ item.firstName }}</td>
                          <td>{{ item.lastName }}</td>
                          <td>{{ item.birthDate }}</td>
                          <td>{{ item.adress }}</td>
                      </tr>
                      </tbody>
                  </template>
              </v-simple-table>
          </div>
      </div>

  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import moment from "moment"
import { mapActions, mapGetters } from "vuex";
import _ from 'lodash';
const {
  required,
  requiredIf,
  minLength,
  email,
  url,
  maxLength,
} = require("vuelidate/lib/validators");
export default {
  name: "patient_form",
  mixins: [validationMixin],
  props: ["isEdit"],
  data() {
    return {
      patient: {
        patId: "",
        firstName: "",
        lastName: "",
        gender: "",
          height:"",
        birthDate: "",
        martialStatus: "",
        bloodGroup: "",
        education: "",
        job: "",
        cin_no: "",
        cin_date: "",
        cin_place: "",
        adress: "",
        tel: "",
        email: "",
        mom_name: "",
        dad_name: "",
        avatar: null,
        patient_category_id:'',
        mhm_partner_id:'',

      },
      countries: [],
      fokontany:[],
      patient_category:[],
      mhm_partner:[],
      nationality: "",
      em_rows: [{ name: "", tel: "" }],
      default_em_rows: [{ name: "", tel: "" }],
      accessory: {
        dateConfig: {
          type: 'string',
          mask:'iso',
          masks: {
              input: 'DD/MMM/YYYY',
          },
        },
      },
      suggestions:[]
    };
  },
  validations: {
    patient: {
      firstName: {
        required,
        minLength: minLength(4),
      },
      lastName: {
        required,
      },
      gender: {
        required,
      },
      birthDate: {
        required,
      },
      adress: {
        required,
      },
      patient_category_id: {
          required
      },
      cin_no:{
          required:requiredIf(patient=>{
             return moment().diff(moment(patient.birthDate,"YYYY-MM-DD-"), 'years')>=18
          })
      },
      cin_date: {
          required:requiredIf(patient=>patient.cin_no!=="")
      },
        cin_place: {
            required:requiredIf(patient=>patient.cin_no!=="")
        }
    },
  },
  computed: {
    ...mapGetters("patient", ["selectedPatient"]),
      check_age(){
          return moment().diff(moment(this.patient.birthDate,"YYYY-MM-DD-"), 'years')
      },
  },
  created() {
    this.getCountries();
    this.getFokontany()
    this.getPatientCategory()
    this.getPartner()
  },

  mounted() {
    if (this.isEdit == true) {
      this.edit();
    }
  },
  watch: {
    isEdit: function (val) {
      if (val === false) {
        this.resetForm();
      } else {
        this.edit();
      }
    },
    patient:{
       async handler(val){
           this.check_data(val)
        },
        deep:true
    }
  },
  methods: {
    ...mapActions("patient", ["addPatient", "updatePatient"]),
    getCountries() {
      axios.get("/api/v1/extra/countries").then((response) => {
        this.countries = response.data;
      });
    },
    getFokontany(){
        this.fokontany=[]
        axios.get("/api/v1/extra/fokontany").then(response=> response.data.forEach(fkt=>this.fokontany.push(fkt.name)))
    },
    getPatientCategory(){
        this.patientCategory=[]
        axios.get("/api/v1/patient_system/patient/category").then(response=>this.patient_category=response.data)
    },
    getPartner(){
      this.mhm_partner=[]
      axios.get("/api/v1/extra/mhm_partner").then(response=>this.mhm_partner=response.data)
    },
    avatar_change(e) {
      let files = document.getElementById("avatar");
      let avatar_container = document.getElementById("avatar_container");
      let file = files.files[0];
      this.patient.avatar = e.target.files[0];
      let img = document.createElement("img");
      if (file) {
        avatar_container.innerHTML = "";
        const reader = new FileReader();
        reader.addEventListener("load", function () {
          img.setAttribute("src", this.result);
          img.setAttribute("id", "preview");
          img.style.maxHeight = "250px";
          img.style.maxWidth = "250px";
        });
        avatar_container.append(img);
        reader.readAsDataURL(file);
      } else {
        avatar_container.innerHTML = "";
      }
    },
    add_row() {
      this.em_rows.push({});
    },
    async edit() {
      await Object.assign(this.patient, this.selectedPatient);
      this.em_rows = this.patient.em_contacts;
    },
    async submit(e) {
      this.$v.patient.$touch();
      if (this.$v.$invalid) {
        return true;
      }
      let formData = new FormData();
      Object.entries(this.patient).forEach(([key, value]) =>{
              if(value!==null){
                  formData.append(key, value)
              }
          }
      );
      formData.append("em_rows", JSON.stringify(this.em_rows));
      formData.append("nationality", this.nationality.country_name);
      if (this.isEdit === true) {
        formData.append("_method", "PUT");
        await this.updatePatient(formData);
        this.$toast.open({
          message: "Patient updated",
          position: "top-right",
        });
      } else {
        await this.addPatient(formData);
        // e.target.reset();
        this.$toast.open({
          message: "Patient created",
          position: "top-right",
        });
      }
      this.resetForm();
    },
    check_data:_.debounce(async function(val){
        let text= val.firstName +' '+ val.lastName
        if(text.length>4){
            let response= await axios.get('/api/v1/patient_system/patient/search/',{params:{query:text}})
            this.suggestions=response.data
        }
    },1000),
    resetForm() {
      for (let [key, value] of Object.entries(this.patient)) {
        this.patient[key] = "";
      }
      this.em_rows = [...this.default_em_rows];
      this.$v.$reset();
      this.$emit("close");
    },
  },
};
</script>
<style src="../../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
#avatar_container {
  max-height: 250px;
  height: 250px;
}
#preview {
  max-height: 250px;
  max-width: 200px;
}
</style>
