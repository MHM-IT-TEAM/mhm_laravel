<template>
  <div class="container-fluid p-4">
    <Loading :active.sync="accessory.isLoading"></Loading>
    <v-app class="p-4">
      <form @submit.prevent="submit">
        <div class="d-flex flex-row justify-content-between">
          <div>
            <h1 id="title">OBSTETRICS FIRST CHECKUP</h1>
            <p>
              <i>Date: {{ today }}</i>
              <span v-if="accessory.edit">/ Updated at:{{ updated_at }}</span>
            </p>
            <div class="row">
              <div class="col-4 d-print-none" v-if="!is_overview">
                <v-switch
                  v-model="accessory.edit"
                  label="Quick Search"
                  value="true"
                  @change="reset_form"
                ></v-switch>
              </div>
              <div class="col-4 ml-4">
                <input
                  type="number"
                  class="form-control mt-4"
                  placeholder="enter the reference"
                  v-if="accessory.edit"
                  @change="fetchData"
                  v-model="accessory.reference"
                  :class="{'border border-danger':accessory.noReferenceFound}"
                />
              </div>
                <div class="col">
                    <p class="text-danger mt-6" v-if="accessory.noReferenceFound">No data found check the reference</p>
                </div>
            </div>
          </div>
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
                <td colspan="8" class="table_title">
                  Patient's Details
                  <span class="error" v-if="$v.formData.patient_id.$error"
                    >You must enter the patient Id</span
                  >
                  <span class="error" v-if="accessory.noPatientFound"
                    >No patient found</span
                  >
                  <span class="error" v-if="$v.patient_details.$error && !$v.patient_details.gender.isFemale"
                    >Patient is not female</span
                  >
                  <span class="error" v-if="!$v.formData.patient_id.$error && $v.patient_details.$error && !$v.patient_details.gender.required"
                    >Patient gender has no value</span
                  >
                </td>
              </tr>
              <tr>
                <td style="width: 5% !important">
                  <span
                    :class="{ 'text-danger': $v.formData.patient_id.$error }"
                    >Id:</span
                  >
                </td>
                <td>
                  <input
                    type="number"
                    v-model="formData.patient_id"
                    @change="change_patient"
                    :class="{
                      'border border-danger': $v.formData.patient_id.$error || accessory.noPatientFound,
                    }"
                    :disabled="accessory.edit"
                  />
                </td>
                <td>Full Name:</td>
                <td style="width: 25%">{{ fullName }}</td>
                <td style="width: 10% !important">D.O.B</td>
                <td>{{ new Date(patient_details.dob).toDateString() }}
                  <span class="error" v-if="$v.patient_details.$error && !$v.patient_details.dob.required">D.O.B has no value</span>
                </td>
                <td>
                  <span class="text-nowrap" :class="{ 'text-danger': parseInt(age) < 18 }"
                    >age: {{ age }}
                    <span v-if="$v.patient_details.$error && !$v.patient_details.dob.validateAge" class="error text-dark">Age should be between 10 and 50</span>
                  </span>
                </td>
              </tr>
              <tr>
                <td>Address:</td>
                <td colspan="">{{ patient_details.adress }}</td>
                <td>Tel:</td>
                <td>{{ patient_details.tel }}</td>
                <td>Height</td>
                <td>
                  <span
                    :class="{ 'text-danger': patient_details.height <= 150 }"
                    >{{ patient_details.height }}</span
                  >
                  <span v-if="$v.patient_details.height.$error" class="text-danger">
                      Height is required.
                  </span>
                </td>
                <td>
                  weight:
                  <span
                    :class="{
                      'text-success': bmi === 'normal',
                      'text-danger': bmi !== 'normal',
                    }"
                  >
                    <small>({{ bmi }})</small></span
                  >
                    <span v-if="$v.formData.weight.$error" class="text-danger">
                      weight is required.
                  </span>
                </td>
                <td><input type="text" v-model="formData.weight" :class="{'border border-danger':$v.formData.weight.$error}" /></td>
              </tr>
            </tbody>
          </table>

          <table class="table table-bordered" id="pregnancy_details_table">
            <tbody>
              <tr>
                <td colspan="11" class="table_title">
                  Pregnancy General Information
                  <span class="text-danger">{{ gravida_check }}</span>
                </td>
              </tr>
              <tr>
                <td><span :class="{'text-danger':$v.formData.ddr.$error|| $v.formData.unknown_lpd.$error }">LP</span> <small>(DDR)</small></td>
                <td>GA</td>
                <td colspan="">
                  <span
                    :class="{ 'text-danger': $v.formData.dpa_method.$error }"
                    >EDD<small>(DPA)</small>
                    <small
                      >[Calc/US/Corrected/<span class="text-success">Used</span
                      >]</small
                    ></span
                  >
                  <span class="error" v-if="$v.formData.dpa_method.$error"
                    >You must choose a dpa method</span
                  >
                </td>
                <td>G</td>
                <td>P</td>
                <td>A</td>
                <td>M</td>
                <td>LC<small>(EV)</small></td>
                <td>LD<small>(DDA)</small></td>
                <td>Patient at risk</td>
                <td>Precautions</td>
              </tr>
              <tr>
                <td class="border" style="width: 45px !important">
                    <div class="form-check form-check-inline mb-4">
                        <label class="form-check-label" for="unknown_ddr">unknown LPD</label> &nbsp
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="unknown_ddr"
                            v-model="formData.unknown_lpd"
                        />
                    </div>
                    <date-picker v-model="formData.ddr"
                                 @input="change_ddr"
                                 v-if="!formData.unknown_lpd"
                                 :input-debounce="500" mode="date"
                                 :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                 :max-date="new Date()">
                                 :min-date="new Date().getMonth()-8"
                        <template v-slot="{ inputValue, inputEvents }">
                            <input
                                class="bg-white border px-2 py-1 rounded"
                                :value="inputValue"
                                v-on="inputEvents"

                            />
                        </template>
                    </date-picker>
                    <span class="text-danger mt-2" v-if="$v.formData.ddr.$error">You must choose the LP</span>

                </td>
                <td>
                  <gestational-age :class="{ 'error': $v.formData.gestational_age.$error }" v-model="formData.gestational_age"></gestational-age>
                </td>
                <td colspan="" class="border" style="width: 250px !important">
                  <label>To be used</label>
                  [&nbsp
                  <select
                    v-model="formData.dpa_method"
                    :class="{
                      'border border-danger': $v.formData.dpa_method.$error,
                    }"
                  >
                    <option value="calc">calc</option>
                    <option value="echo">echo</option>
                    <option value="corrected">corrected</option>
                  </select>
                  &nbsp]

                  <div>
                    <small :class="{'text-white bg-success': formData.dpa_method === 'calc'}" class="mr-4">Calc:</small>
                      <date-picker v-model="formData.dpa_calc"
                                   :input-debounce="500" mode="date"
                                   :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                   :min-date="new Date()">
                          <template v-slot="{ inputValue, inputEvents }">
                              <input
                                  class="bg-white form-control form-control-sm px-2 py-1 rounded"
                                  :value="inputValue"
                                  v-on="inputEvents"
                                  :class="{'text-success': formData.dpa_method === 'calc'}"
                              />
                          </template>
                      </date-picker>
                  </div>

                  <div>
                    <small :class="{'text-white bg-success': formData.dpa_method === 'echo'}" class="mr-6">US: </small>
                      <date-picker v-model="formData.dpa_echo"
                                   :input-debounce="500" mode="date"
                                   :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                   :min-date="new Date()">
                          <template v-slot="{ inputValue, inputEvents }">
                              <input
                                  class="bg-white form-control form-control-sm px-2 py-1 rounded"
                                  :value="inputValue"
                                  v-on="inputEvents"
                                  :class="{'text-success': formData.dpa_method === 'echo'}"
                              />
                          </template>
                      </date-picker>
                  </div>
                  <div>
                    <small :class="{'text-white bg-success': formData.dpa_method === 'corrected'}">Corrected: </small>
                      <date-picker v-model="formData.dpa_corrected"
                                   :input-debounce="500" mode="date"
                                   :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                   :min-date="new Date()">
                          <template v-slot="{ inputValue, inputEvents }">
                              <input
                                  class="bg-white form-control form-control-sm px-2 py-1 rounded"
                                  :value="inputValue"
                                  v-on="inputEvents"
                                  :class="{'text-success': formData.dpa_method === 'corrected'}"
                              />
                          </template>
                      </date-picker>
                  </div>
                </td>
                <td class="border">
                  <input
                    type="number"
                    v-model="formData.gravida"
                    :class="{ 'text-danger': formData.gravida > 4 }"
                    class="form-control form-control-sm"
                  />
                </td>
                <td class="border">
                  <input
                    type="number"
                    v-model="formData.parity"
                    class="form-control form-control-sm"
                  />
                </td>
                <td class="border">
                  <input
                    type="number"
                    v-model="formData.abortion"
                    :class="{ 'text-danger': formData.abortion > 0 }"
                    class="form-control form-control-sm"
                  />
                </td>
                <td class="border">
                  <input
                    type="number"
                    v-model="formData.miscarriage"
                    :class="{ 'text-danger': formData.miscarriage > 0 }"
                    class="form-control form-control-sm"
                  />
                </td>
                <td class="border">
                  <input
                    type="number"
                    v-model="formData.ev"
                    class="form-control form-control-sm"
                  />
                </td>
                <td class="border">
                  <input
                    type="number"
                    class="form-control form-control-sm"
                    v-model="formData.dda"
                    :class="{ 'text-danger font-weight-bold error': $v.formData.dda.$error }"
                    min="1980"
                    :max="new Date().getFullYear()"
                    @blur="validate_dda($event.target.value)"
                  />
                </td>
                <td class="border">
                  <div class="form-check form-check-inline mb-4">
                    <label class="form-check-label" for="meal">Yes</label> &nbsp
                    <input
                      class="form-check-input"
                      type="checkbox"
                      v-model="formData.patient_at_risk"
                    />
                  </div>
                  <span v-if="$v.formData.risk_description.$error" class="error"><br />Risk description is required when patient is at risk<br /></span>
                  <textarea
                    style="width: 100%"
                    v-if="formData.patient_at_risk"
                    v-model="formData.risk_description"
                    placeholder="Write here the reason"
                    :class="{ 'text-danger font-weight-bold error mt-2': $v.formData.risk_description.$error}"
                  ></textarea>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="meal"
                      ><small>Planned C-section</small></label
                    >
                    <input
                      class="form-check-input"
                      type="checkbox"
                      v-model="formData.planned_oc"
                    />
                      <date-picker v-model="formData.planned_oc_date"
                                   v-if="formData.planned_oc"
                                   :input-debounce="500" mode="date"
                                   :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                   :min-date="new Date()">
                          <template v-slot="{ inputValue, inputEvents }">
                              <input
                                  class="bg-white form-control form-control-sm px-2 py-1 rounded"
                                  :value="inputValue"
                                  v-on="inputEvents"
                              />
                          </template>
                      </date-picker>
                  </div>
                  <div>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label" for="meal"
                        ><small>Preeclmapsia prevention Needed</small></label
                      >
                      &nbsp
                      <input
                        class="form-check-input"
                        type="checkbox"
                        v-model="formData.preeclampsia_needed"
                      />
                    </div>
                  </div>

                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="meal"
                      ><small>OGTT Needed</small></label
                    >
                    &nbsp
                    <input
                      class="form-check-input"
                      type="checkbox"
                      v-model="formData.ogtt_needed"
                    />
                  </div>
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
              <td>Michaelis rhombus</td>
              <td>Baum-HG</td>
              <td>Problem for delivery</td>
            </tr>
            <tr>
              <td class="border">
                <input type="number" v-model="formData.spin" :class="{ 'text-danger error': $v.formData.spin.$error }" />
              </td>
              <td class="border">
                <input type="number" v-model="formData.christ" :class="{ 'text-danger error': $v.formData.christ.$error }"  />
              </td>
              <td class="border">
                <input type="number" v-model="formData.troch" :class="{ 'text-danger error': $v.formData.troch.$error }"  />
              </td>
              <td class="border">
                <input type="number" v-model="formData.obst" :class="{'text-danger':formData.obst<18, 'text-danger error': $v.formData.obst.$error }" />
              </td>
              <td class="border">
                [&nbsp
                <select
                  v-model="formData.michaelis"
                  :class="{ 'text-danger': formData.michaelis !== 'Equal', 'text-danger error': $v.formData.michaelis.$error }"
                >
                  <option class="text-dark bg-light" value="Equal">Equal</option>
                  <option class="text-dark bg-light" value="Narrow">Narrow</option>
                  <option class="text-dark bg-light" value="Asymetric">Asymetric</option>
                  <option class="text-dark bg-light" value="Flat">Flat</option>
                </select>
                &nbsp]
              </td>
              <td class="border">
                [&nbsp
                <select
                  v-model="formData.baum_hg"
                  :class="{ 'text-danger': formData.baum_hg === 'Negative', 'text-danger error': $v.formData.baum_hg.$error }"
                >
                  <option class="text-dark bg-light" value="Positive">Positive</option>
                  <option class="text-dark bg-light" value="Negative">Negative</option>
                </select>
                &nbsp]
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
              <td>Blood Group/Rhesus</td>
              <td>Result of blood test <strong>[HIV]</strong></td>
              <td>Result of blood test <strong>[Syphilis]</strong></td>
              <td>Result of blood test <strong>[Others]</strong></td>
              <td>Result of blood test <strong>[HB]</strong></td>
            </tr>
            <tr>
              <td>
                [ &nbsp<select v-model="formData.blood_group">
                  <option v-for="bg in accessory.blood_group" :value="bg.name">
                    {{ bg.name }}
                  </option>
                </select>
                &nbsp] &nbsp [&nbsp
                <select v-model="formData.rhesus">
                  <option></option>
                  <option value="+">+</option>
                  <option value="-">-</option>
                </select>
                ]
              </td>

              <td>
                [ &nbsp<select v-model="formData.hiv" :class="{'text-danger':formData.hiv==='Positive'}">
                  <option value="Positive">Positive</option>
                  <option value="Negative">Negative</option>
                </select>
                &nbsp]
              </td>
              <td>
                [ &nbsp<select v-model="formData.syphilis" :class="{'text-danger':formData.syphilis==='Positive'}">
                  <option value="Positive">Positive</option>
                  <option value="Negative">Negative</option>
                </select>
                &nbsp]
              </td>
              <td>
                [ &nbsp
                <select v-model="formData.other_test">
                  <option value="+">+</option>
                  <option value="-">-</option>
                </select>
                &nbsp] &nbsp
                  <input type="text" v-model="formData.other_test_descr" />
              </td>
              <td><input type="text" v-model="formData.hb" /></td>
            </tr>
          </table>
          <table class="table table-bordered" id="preg_history">
            <tr>
              <td class="table_title" colspan="6">
                Pregnancy History

                <v-btn
                  class="mx-2 d-print-none"
                  fab
                  dark
                  color="indigo"
                  x-small
                  @click="add_row"
                  v-if="!is_overview"
                >
                  <v-icon dark> mdi-plus </v-icon>
                </v-btn>
                <span v-if="quick_birth" class="text-danger"
                  >(less than 1 year delivery frequency)</span
                >
              </td>
            </tr>
            <tr>
              <td>Year</td>
              <td>Problems in the pregnancy</td>
              <td style="text-align: center !important">
                Birth type/Place/indications/our patient?
              </td>
              <td>SA/Weight of the baby/Condition</td>
              <td>
                Newborn &nbsp
                <small>[Gender/ malformation/infection]</small>
              </td>
              <td>Problems in Pueperium</td>
            </tr>
            <tr v-for="(row, index) in formData.pregnancy_history">
              <td>
                <input type="number"
                  v-model="row.nr_year"
                  style="width: 80px"
                  class="form-control form-control-sm"
                  :class="{ 'text-danger font-weight-bold error': $v.formData.pregnancy_history.$each[index].$error }"
                  min="1980"
                  :max="new Date().getFullYear()"
                  @blur="validate_pregnancy_history_year(row, index)"
                  />
              </td>
              <td>
                <select v-model="row.pregnancy">
                    <option v-for="item of accessory.birth_problem">{{item.name}}</option>
                </select>
              </td>
              <td>
                [&nbsp
                <select
                  v-model="row.birth_type"
                  @change="birth_type_change($event, index)"
                  :data-val="row.birth_type"
                  :class="{ 'text-danger': row.birth_type === 'C-section' }"
                  style="font-size: 10px; width: 35px"
                >
                  <option value="normal">normal</option>
                  <option value="kiwi">kiwi</option>
                  <option value="forceps">forceps</option>
                  <option value="C-section">C-section</option>
                  <option value="Curretage">Curretage</option>
                  <option value="Cytotec">Cytotec</option>
                </select>
                &nbsp] /
                <input
                  type="text"
                  v-model="row.birth_place"
                  id="birth_place"
                />/
                  <input type="text" v-model="row.birth_problems" />

                  /
                <input type="checkbox" v-model="row.ourPatient" />
              </td>
              <td>
                <input
                  type="text"
                  v-model="row.sa"
                  :class="{ 'text-danger font-weight-bold': row.sa <= 37 }"
                  style="width: 25px"
                />
                /
                <input
                  type="number"
                  v-model="row.baby_weight"
                  style="width: 50px"
                />
                / [&nbsp
                <select v-model="row.baby_condition" style="font-size: 10px">
                  <option value="Alive">Alive</option>
                  <option value="premature">premature</option>
                  <option value="Died <=24 h">Died <=24 h</option>
                  <option value="Died 24h">Died 24h</option>
                  <option value="Died >24h">Died >24h</option>
                  <option value="Died 24 days">Died 28 days</option>
                  <option value="Died >28 days">Died >28 days</option>
                  <option value="malformation">malformation</option>
                  <option value="infection">infection</option>
                </select>
                &nbsp]
              </td>
              <td>
                [&nbsp
                <select v-model="row.baby_gender">
                  <option value="M">M</option>
                  <option value="F">F</option>
                </select>
                &nbsp] /
                <div class="form-check form-check-inline">
                  <label class="form-check-label" for="meal">Yes</label>
                  &nbsp
                  <input
                    class="form-check-input"
                    type="checkbox"
                    v-model="row.malformation"
                  />
                </div>
                &nbsp /
                <div class="form-check form-check-inline">
                  <label class="form-check-label" for="meal">Yes</label>
                  &nbsp
                  <input
                    class="form-check-input"
                    type="checkbox"
                    v-model="row.infection"
                  />
                </div>
              </td>
              <td><textarea v-model="row.pueperium" /></td>
            </tr>
          </table>
            <table class="table">
                <tbody>
                <tr>
                    <td colspan="3" class="table_title">
                        <strong>Pregnant woman</strong>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25% !important">
                        Any presence of disabilities
                    </td>
                    <td style="width: 60% !important">
                        <input
                            type="text"
                            style="width: 100%"
                            v-model="formData.preg_wom_disability"
                        />
                    </td>
                </tr>

                <tr>
                    <td style="width: 25% !important">
                        Chronical disease (diabetes,hypertension...)
                    </td>
                    <td style="width: 60% !important">
                        <input
                            type="text"
                            style="width: 100%"
                            v-model="formData.preg_wom_chronical_disease"
                        />
                    </td>
                </tr>
                <tr>
                    <td style="width: 25% !important">Former serious illness</td>
                    <td style="width: 60% !important">
                        <input
                            type="text"
                            style="width: 100%"
                            v-model="formData.preg_wom_former_illness"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Allergies</td>
                    <td>
                        <input
                            type="text"
                            style="width: 100%"
                            v-model="formData.preg_wom_allergie"
                        />
                    </td>
                </tr>
                <tr>
                    <td>permanent medication</td>
                    <td>
                        <input
                            type="text"
                            style="width: 100%"
                            v-model="formData.preg_wom_medication"
                        />
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="meal">Bleeding</label>
                            &nbsp
                            <input
                                class="form-check-input"
                                type="checkbox"
                                v-model="formData.preg_wom_bleeding"
                            />
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="meal">Haematoma</label>
                            &nbsp
                            <input
                                class="form-check-input"
                                type="checkbox"
                                v-model="formData.preg_wom_haematoma"
                            />
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
          <table class="table">
            <tbody>
              <!-- <tr>
                <td class="table_title" colspan="5">
                  Medical History & Anamnese
                </td>
              </tr> -->
              <tr>
                <td colspan="3" class="table_title">Close Family</td>
              </tr>
              <tr>
                <td style="width: 10% !important">Twins</td>
                <td colspan="3">
                  <input
                    type="text"
                    style="width: 100%"
                    v-model="formData.close_family_twins"
                  />
                </td>
              </tr>
              <tr>
                <td>OC</td>
                <td>
                  <input
                    type="text"
                    style="width: 100%"
                    v-model="formData.close_family_oc"
                  />
                </td>
              </tr>
              <tr>
                <td>Chronical disease (diabetes,hypertension...)</td>
                <td>
                  <input
                    type="text"
                    style="width: 100%"
                    v-model="formData.close_family_disease"
                  />
                </td>
              </tr>
              <tr>
                <td>malformation</td>
                <td>
                  <input
                    type="text"
                    style="width: 50%"
                    v-model="formData.close_family_malformation"
                  />
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="meal">Dead Baby</label>
                    &nbsp
                    <input
                      class="form-check-input"
                      type="checkbox"
                      v-model="formData.close_family_dead_baby"
                    />
                  </div>
                </td>
                  <td>
                      <div class="form-check form-check-inline">
                          <label class="form-check-label" for="meal">Miscarriage</label>
                          &nbsp
                          <input
                              class="form-check-input"
                              type="checkbox"
                              v-model="formData.close_family_miscarriage"
                          />
                      </div>
                  </td>
              </tr>
              <tr>
                <td>Problems in the pregnancy</td>
                <td>
                  <input
                    type="text"
                    style="width: 100%"
                    v-model="formData.close_family_prob_in_preg"
                  />
                </td>
              </tr>
            </tbody>
          </table>

        </div>
        <div class="row">
          <div class="col-12">
              <button
                  type="button "
                  class="btn btn-warning float-left"
                  v-if="accessory.edit"
                  @click.prevent="overView"
              >
                  Followup Data
              </button>
            <button
              type="submit"
              class="btn btn-primary float-right d-print-none"
              id="submit"
              v-if="!is_overview"
            >
              {{ submit_text }}
            </button>
          </div>
        </div>
      </form>
    </v-app>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import gestationalAge from "../../../../components/gestational_age_control";
const {
  required,
  minValue,
  minLength,
  email,
  url,
  maxLength,
  between,
  requiredIf
} = require("vuelidate/lib/validators");
export default {
  name: "cpn_admission",
  components: { gestationalAge },
    props:['is_overview','reference'],
  mixins: [validationMixin],
  data() {
    return {
      formData: {
        patient_id: "",
        consultation_id: "",
        weight: "",
        hydrodramnion: false,
        oligodramnion: false,
        ddr:"",
        unknown_lpd:false,
        dpa_calc: "",
        dpa_echo: "",
        dpa_corrected: "",
        dpa_method: "",
        gravida: "",
        parity: "",
        abortion: "",
        miscarriage: "",
        ev: "",
        dda: "",
        patient_at_risk: "",
        risk_description: "",
        planned_oc: false,
        planned_oc_date: "",
        preeclampsia_needed: false,
        ogtt_needed: false,
        blood_group: "",
        rhesus: "",
        hiv: "",
        syphilis: "",
        other_test: "",
          other_test_descr:"",
        hb: "",
        close_family_twins: "",
        close_family_oc: "",
        close_family_disease: "",
        close_family_malformation: "",
        close_family_dead_baby: false,
        close_family_prob_in_preg: "",
          close_family_miscarriage:"",
        preg_wom_bleeding: false,
        preg_wom_haematoma: false,
        preg_wom_medication: "",
        preg_wom_chronical_disease: "",
        preg_wom_allergie: "",
        preg_wom_former_illness: "",
        preg_wom_disability: "",
        updated_at: "",
        pregnancy_history: [
          // {
          //   nr_year: "",
          //   pregnancy: "",
          //   birth_type: "",
          //   birth_place: "",
          //   birth_problems: "",
          //   newBorn: "",
          //   pueperium: "",
          // },
        ],
        spin: "",
        christ: "",
        troch: "",
        obst: "",
        michaelis: "",
        baum_hg: "",
        problem_for_delivery: "",
        responsible:'',
        gestational_age: '1+0',
      },
      patient_details: {
        firstName: "",
        lastName: "",
        dob: "",
        adress: "",
        tel: "",
        weight: "",
        height: "",
        gender: ""
      },
      accessory: {
        dateConfig: {
              type: 'string',
              mask:'iso',
              masks: {
                  input: 'DD/MMM/YYYY',
              },
          },
        edit: false,
        reference: this.reference,
        last_id: "",
        quick_birth_output: [],
        data_populated: false,
        blood_group: "",
        isLoading: false,
        noError: true,
        birth_problem:"",
        noPatientFound: false,
        noReferenceFound:false
      },
    };
  },
  created() {
    this.init();
  },
  watch:{
      edd_check:function(val){
          if(this.gestational_age_week >=9 && this.gestational_age_week<=13){
              if(val<=5){
                  var check = confirm('the gestational age is between 9 and 13 weeks, you should choose the ultrasound for the estimated date of delivery')
                  if (check){
                      this.formData.dpa_method='echo'
                  }
              }
          }
      },
      'formData.unknown_lpd':function(val){
          if(val) this.formData.ddr=''
      }
  },
  methods: {
    async change_patient() {
      this.accessory.isLoading = true;
      let response = await axios.get(
        `/api/patients/${this.formData.patient_id}/edit`
      );

      if (response.data.patient) {
        this.$v.patient_details.$touch();
        this.accessory.noPatientFound = false;
        let lastName= response.data.patient.lastName==null?'':response.data.patient.lastName
        this.patient_details.firstName = response.data.patient.firstName.toUpperCase();
        this.patient_details.lastName = lastName;
        this.patient_details.dob = response.data.patient.birthDate;
        this.patient_details.adress = response.data.patient.adress;
        this.patient_details.height = response.data.patient.height;
        this.patient_details.gender = response.data.patient.gender;
      }
      else {
        this.accessory.noPatientFound = true;
      }
      this.accessory.isLoading = false;
    },
    add_row() {
      this.formData.pregnancy_history.push({
        nr_year: "",
        pregnancy: "",
        birth_type: "",
        birth_place: "",
        birth_problems: "",
        baby_gender: "",
        infection: "",
        malformation: "",
        baby_condition: "",
        pueperium: "",
        sa: "",
        baby_weight: "",
        ourPatient: false,
      });
    },
    async submit() {
      this.$v.$touch();

      this.formData.responsible= window.auth.user.name
      if (!this.$v.$invalid) {
        if (this.accessory.edit === false) {
          let response = await axios.post("/api/obstetrics/cpn_admission", this.formData);
          if (response.data.success === true) {
            this.reset_form();
            this.$toast.open({
              message: `Reference: ${response.data.id} `,
              position: "top-right",
              duration: 0,
            });
            this.$router.push({
                name:'cpn_followup',
                params:{
                    cpn_admission_id: response.data.id
                }
            })
          }
        } else {
          let response = await axios.put(
            `/api/obstetrics/cpn_admission/${this.accessory.reference}`,
            this.formData
          );
          if (response.data.success === true) {
            this.reset_form();
            this.$toast.open({
              message: `data successfully saved `,
              position: "top-right",
              type: "info",
            });
          }
        }
      }
    },
    reset_form() {
      this.accessory.isLoading = true;
      this.$v.$reset();
      for (let [key, val] of Object.entries(this.formData)) {
        this.formData[key] = "";
      }
      for (let [key, val] of Object.entries(this.patient_details)) {
        this.patient_details[key] = "";
      }
      this.formData.pregnancy_history = [];
      this.accessory.reference = "";
      this.accessory.data_populated = false;
      this.accessory.isLoading = false;
      this.accessory.noPatientFound=false
      this.accessory.noReferenceFound=false
    },
    birth_type_change(e, index) {
      var val = this.formData.pregnancy_history[index].birth_type;
      if (val === "C-section") {
        console.log(true);
      }
    },
    async fetchData() {
      if (this.accessory.data_populated === true) this.reset_form();
      let response = await axios.get(
        `/api/obstetrics/cpn/${this.accessory.reference}`
      );
      if(response.data.success){
          Object.assign(this.formData, response.data.admission);
          this.formData.pregnancy_history = response.data.preg_history;
          this.change_patient();
          this.accessory.data_populated = true;
          this.formData.gestational_age = response.data.admission.wop;
      }
      else this.accessory.noReferenceFound=true
    },
    async init() {
      this.accessory.isLoading = true;
      let response = await axios.get("/api/blood_group");
      let response_1 =await axios.get('/api/pregnancy_problem')

      if (this.$route.params.patient_id !== "" && this.$route.params.patient_id !== undefined) {
        this.formData.patient_id = this.$route.params.patient_id;
        this.change_patient();
      }
      this.accessory.birth_problem= response_1.data
      this.formData.weight = this.$route.params.weight;
      this.formData.consultation_id = this.$route.params.consultation_id;
      this.accessory.isLoading = false;
      if (this.$route.params.id !== undefined) {
        this.accessory.reference = this.$route.params.id;
        this.fetchData();
        this.accessory.edit=true
      }
      if(this.accessory.reference !=='' && this.accessory.reference !==undefined) this.fetchData()
      return (this.accessory.blood_group = response.data);
    },
    overView(){
        this.$router.push({
            name:'cpn_followup',
            params:{
                cpn_admission_id:this.accessory.reference,
                patient:this.patient_details
            }
        })
      },
    validate_dda() {
      if (this.formData.dda < 1980 || this.formData.dda > new Date().getFullYear())
        this.formData.dda = "";
    },
    validate_pregnancy_history_year(row, index) {
      if (row.nr_year < 1980 || row.nr_year > new Date().getFullYear())
        row.nr_year = "";
    },
      change_ddr(){
          let ddr = this.formData.ddr
          let today = new Date()
          let diff = today- new Date(ddr)
          let result=diff/(1000 * 60 * 60 * 24*7)
          let int = Math.floor(result)
          let dec= result - int
          let strDec= Math.round(dec*6)

          if(strDec>6){
              int++
              strDec=0
          }
          this.formData.gestational_age = int + '+' + strDec;
      }
  },
  computed: {
    fullName() {
      return this.patient_details.firstName + " " + this.patient_details.lastName

    },
    age() {
      return calculateAge(this.patient_details.dob);
    },
    today() {
      return new Date().toLocaleString();
    },
    updated_at() {
      if (this.formData.updated_at !== "")
        return Date(this.formData.updated_at).toLocaleString();
    },
    quick_birth() {
      let output = [];
      let diffArr = [];
      if (this.formData.pregnancy_history.length > 0) {
        for (let i = 0; i < this.formData.pregnancy_history.length; i++) {
          output.push(this.formData.pregnancy_history[i].nr_year);
        }
        output.reverse();
        for (let i = 0; i < output.length; i++) {
          diffArr.push(output[i] - output[i - 1]);
        }
        if (diffArr.indexOf(1) !== -1 || diffArr.indexOf(0) !== -1) return true;
      }
    },
    bmi() {
      let bmi =
        this.formData.weight / Math.pow(this.patient_details.height / 100, 2);
      switch (true) {
        default:
          return "";
          break;
        case bmi < 18.5:
          return "underweight";
          break;
        case bmi > 18.5 && bmi < 24.9:
          return "normal";
          break;
        case bmi > 25 && bmi < 29.9:
          return "overweight";
          break;
        case bmi > 30 && bmi < 34.9:
          return "obesity class 1";
          break;
        case bmi > 35 && bmi < 39.9:
          return "obesity class 2";
          break;
        case bmi > 40:
          return "obesity class 3";
      }
    },
    gravida_check() {
      let total =
        parseInt(toNull(this.formData.parity)) +
        parseInt(toNull(this.formData.abortion)) +
        parseInt(toNull(this.formData.miscarriage));

      if (this.formData.gravida !== "" && this.formData.gravida !== null) {
        if (total > this.formData.gravida - 1) {
          this.accessory.noError = false;
          return "(P+A+M) should not be above G";
        } else {
          this.accessory.noError = true;
        }
      }
    },
    submit_text() {
      if (this.accessory.edit === "true") {
        return "Save";
      } else {
        return "Submit";
      }
    },
    edd_check(){
        if(this.formData.dpa_calc !=='' && this.formData.dpa_echo){
            let dpa_echo= new Date(this.formData.dpa_echo)
            let dpa_calc= new Date(this.formData.dpa_calc)
            let diff_date= Math.floor((Date.UTC(dpa_echo.getFullYear(), dpa_echo.getMonth(), dpa_echo.getDate()) - Date.UTC(dpa_calc.getFullYear(), dpa_calc.getMonth(), dpa_calc.getDate()) ) /(1000 * 60 * 60 * 24))
            return Math.abs(diff_date)
        }
    },
    gestational_age_week() {
      return this.formData.gestational_age.split('+')[0];
    }

  },
  validations: {
    formData: {
      patient_id: { required },
      dpa_method: { required },
      dda: {between: between(1980, new Date().getFullYear()) },
      weight:{required},
      pregnancy_history: {
        $each: {
          nr_year: {
            required,
            between: between(1980, new Date().getFullYear())
          }
        }
      },
      ddr:{
          required:requiredIf((formData)=>{
              return !formData.unknown_lpd
          })
      },
      unknown_lpd:{
        required:requiredIf((formData)=>{
            return formData.ddr===''
        })
      },
      risk_description: { required: requiredIf((formData) => formData.patient_at_risk) },
      spin: { required },
      christ: { required },
      troch: { required },
      obst: { required },
      michaelis: { required },
      baum_hg: { required },
      gestational_age: { required }
    },
    accessory: {
      noPatientFound: { patientFound: value => value === false }
    },
    patient_details:{
        height:{required,minValue:minValue(50)},
        dob: { required, validateAge: validateAgeRange },
        gender: {required, isFemale: value => !value || value === 'F' }
    },

  },
};

function calculateAge(dob) {
  if (dob !== "") {
    var difference =
      Date.now() - new Date(dob).getTime();
    var age = new Date(difference);
    return Math.abs(age.getUTCFullYear() - 1970);
  } else {
    return "";
  }
};
function validateAgeRange(dob) {
  if (!dob)
    return true;

  const age = calculateAge(dob);
  if (age >= 10 && age <= 50) {
    return true;
  }

  return false;
};
function toNull(val) {
  let response;
  val === "" ? (response = 0) : (response = val);
  return response;
}
</script>

<style scoped>
.container {
  box-shadow: 0px 0px 0.5cm rgba(0, 0, 0, 0.8);
  margin-top: 0.6%;
  background-color: white !important;
  font-family: calibri;
  z-index: 500;
}
input {
  font-size: 11px;
   border: lightgrey solid 0.5px;
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
select {
  line-height: 110%;
  border: 1px solid rgb(211,211,211);
}
select:hover {
  cursor: pointer;
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
#submit {
  color: white !important;
  background: rgb(117, 2, 45) !important;
  border: none !important;
  background-color: linear-gradient(
    90deg,
    rgba(117, 2, 45, 1) 0%,
    rgba(67, 9, 121, 0.989233193277311) 50%,
    rgba(255, 0, 129, 1) 100%
  ) !important;
}
span.error {
  line-height: initial;
}
@media screen and (max-width: 1500px) {
  #birth_place {
    width: 50px;
  }
}
</style>
