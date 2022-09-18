<template>
  <div class="container-fluid">
    <v-app>
      <div class="d-flex flex-row justify-content-between">
        <div>
          <h1 id="title">PRENATAL CARE FIRST CHECKUP</h1>
          <p>
            <i>Date: {{ today }}</i>
            <span v-if="accessory.edit">/ Updated at:{{ updated_at }}</span>
          </p>
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
                <span
                  class="error"
                  v-if="
                    $v.patient_details.$error &&
                    !$v.patient_details.gender.isFemale
                  "
                  >Patient is not female</span
                >
                <span
                  class="error"
                  v-if="
                    !$v.formData.patient_id.$error &&
                    $v.patient_details.$error &&
                    !$v.patient_details.gender.required
                  "
                  >Patient gender has no value</span
                >
              </td>
            </tr>
            <tr>
              <td style="width: 5% !important">
                <span :class="{ 'text-danger': $v.formData.patient_id.$error }"
                  >Id:</span
                >
              </td>
              <td>{{ formData.patient_id }}</td>
              <td>Full Name:</td>
              <td style="width: 25%">{{ fullName }}</td>
              <td style="width: 10% !important">D.O.B:</td>
              <td>
                {{
                  patient_details.birthDate
                    ? new Date(patient_details.birthDate).toDateString()
                    : ""
                }}
              </td>
              <td>
                <span
                  class="text-nowrap"
                  :class="{ 'text-danger': parseInt(age) < 18 }"
                  >Age: {{ age }}
                  <span
                    v-if="
                      $v.patient_details.$error &&
                      !$v.patient_details.birthDate.validateAge
                    "
                    class="error text-dark"
                    >Age should be between 10 and 50</span
                  >
                </span>
              </td>
            </tr>
            <tr>
              <td>Address:</td>
              <td colspan="">{{ patient_details.adress }}</td>
              <td>Tel:</td>
              <td>{{ patient_details.tel }}</td>
              <td>Height:</td>
              <td>
                <span
                  :class="{ 'text-danger': patient_details.height <= 150 }"
                  >{{ patient_details.height }}</span
                >
                <span
                  v-if="$v.patient_details.height.$error"
                  class="text-danger"
                >
                  Height is required.
                </span>
              </td>
              <td>
                Weight:
                <span
                  :class="{
                    'text-success': bmi === 'normal',
                    'text-danger': bmi !== 'normal',
                  }"
                >
                  <small v-if="bmi">({{ bmi }})</small></span
                >
                <span v-if="$v.formData.weight.$error" class="text-danger">
                  weight is required.
                </span>
              </td>
              <td>
                <input
                  type="text"
                  v-model="formData.weight"
                  :class="{ 'border border-danger': $v.formData.weight.$error }"
                  :readonly="!canEdit"
                />
              </td>
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
              <td><span>LP</span> <small>(DDR)</small></td>
              <td class="narrow">GA</td>
              <td colspan="">
                <span
                  >EDD<small>(DPA)</small>
<!--                  <date-picker-->
<!--                    :value="ultrasound_data.selected_edd"-->
<!--                    mode="date"-->
<!--                    :model-config="accessory.dateConfig"-->
<!--                    :masks="accessory.dateConfig.masks"-->
<!--                  >-->
<!--                    <template v-slot="{ inputValue, inputEvents }">-->
<!--                      <input-->
<!--                        class="bg-white border px-2 py-1 rounded"-->
<!--                        :value="inputValue"-->
<!--                        v-on="inputEvents"-->
<!--                      />-->
<!--                    </template>-->
<!--                  </date-picker>-->
                </span>
              </td>
              <td class="narrow">G</td>
              <td class="narrow">P</td>
              <td class="narrow">A</td>
              <td class="narrow">M</td>
              <td class="narrow">LC<small>(EV)</small></td>
              <td class="narrow">LD<small>(DDA)</small></td>
              <td>Patient at risk</td>
<!--              <td>Precautions</td>-->
            </tr>
            <tr>
              <td class="border" style="width:50px !important">
                <div class="form-check">
                  <label class="form-check-label" for="unknown_ddr"
                    >unknown LP</label
                  >
                  &nbsp;
                  <input
                    class="form-check-input ml-0"
                    type="checkbox"
                    name="unknown_ddr"
                    v-model="ultrasound_data.unknown_lpd"
                  />
                </div>
                  <br>
                <date-picker
                  v-model="ultrasound_data.ddr"
                  v-if="!ultrasound_data.unknown_lpd"
                  :input-debounce="500"
                  mode="date"
                  :model-config="accessory.dateConfig"
                  :masks="accessory.dateConfig.masks"
                >
                  <template v-slot="{ inputValue, inputEvents }">
                    <input
                      class="bg-white border px-2 py-1 rounded"
                      :value="inputValue"
                      v-on="inputEvents"
                      readonly
                    />
                  </template>
                </date-picker>
              </td>
              <td>
                <span class="text-center">{{ current_gestational_age }}</span>
              </td>
              <td colspan="" class="border" style="width: 250px !important">
                <label>To be used</label>
                [&nbsp;
                <select v-model="ultrasound_data.edd_method">
                  <option value="calc">calc</option>
                  <option value="us">US</option>
                  <option value="corrected">corrected</option>
                </select>
                &nbsp;]

                <div class="position-relative">
                  <small
                    :class="{
                      'text-white bg-success':
                        ultrasound_data.edd_method === 'calc',
                    }"
                    class="mr-4"
                    >Calc:</small
                  >
                  <span
                    v-if="ultrasound_data.unknown_lpd"
                    style="font-size: 12px; position: absolute; left: 0; top: 0"
                    ><br />Unknown</span
                  >
                  <date-picker
                    v-model="ultrasound_data.edd_calc"
                    :input-debounce="500"
                    mode="date"
                    :model-config="accessory.dateConfig"
                    :masks="accessory.dateConfig.masks"
                  >
                    <template v-slot="{ inputValue, inputEvents }">
                      <input
                        class="
                          bg-white
                          form-control form-control-sm
                          px-2
                          py-1
                          rounded
                        "
                        :value="inputValue"
                        v-on="inputEvents"
                        :class="{
                          'text-success': formData.edd_method === 'calc',
                        }"
                      />
                    </template>
                  </date-picker>
                </div>

                <div>
                  <small
                    :class="{
                      'text-white bg-success':
                        ultrasound_data.edd_method === 'us',
                    }"
                    class="mr-6"
                    >US:
                  </small>
                  <date-picker
                    v-model="ultrasound_data.edd_ultrasound"
                    :input-debounce="500"
                    mode="date"
                    :model-config="accessory.dateConfig"
                    :masks="accessory.dateConfig.masks"
                  >
                    <template v-slot="{ inputValue, inputEvents }">
                      <input
                        class="
                          bg-white
                          form-control form-control-sm
                          px-2
                          py-1
                          rounded
                        "
                        :value="inputValue"
                        v-on="inputEvents"
                        :class="{
                          'text-success': ultrasound_data.edd_method === 'us',
                        }"
                      />
                    </template>
                  </date-picker>
                </div>
                <div>
                  <small
                    :class="{
                      'text-white bg-success':
                        ultrasound_data.edd_method === 'corrected',
                    }"
                    >Corrected:
                  </small>
                  <date-picker
                    v-model="ultrasound_data.edd_corrected"
                    :input-debounce="500"
                    mode="date"
                    :model-config="accessory.dateConfig"
                    :masks="accessory.dateConfig.masks"
                  >
                    <template v-slot="{ inputValue, inputEvents }">
                      <input
                        class="
                          bg-white
                          form-control form-control-sm
                          px-2
                          py-1
                          rounded
                        "
                        :value="inputValue"
                        v-on="inputEvents"
                        :class="{
                          'text-success':
                            ultrasound_data.edd_method === 'corrected',
                        }"
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
                  :readonly="!canEdit"
                  @input="gravida_input"
                  min="1"
                />
              </td>
              <td class="border">
                <input
                  type="number"
                  v-model="formData.parity"
                  class="form-control form-control-sm"
                  :readonly="!canEdit"
                  min="0"
                />
              </td>
              <td class="border">
                <input
                  type="number"
                  v-model="formData.abortion"
                  :class="{ 'text-danger': formData.abortion > 0 }"
                  class="form-control form-control-sm"
                  :readonly="!canEdit"
                  min="0"
                />
              </td>
              <td class="border">
                <input
                  type="number"
                  v-model="formData.miscarriage"
                  :class="{ 'text-danger': formData.miscarriage > 0 }"
                  class="form-control form-control-sm"
                  :readonly="!canEdit"
                  min="0"
                />
              </td>
              <td class="border">
                <input
                  type="number"
                  v-model="formData.ev"
                  class="form-control form-control-sm"
                  :readonly="!canEdit"
                />
              </td>
              <td class="border">
                <input
                  type="number"
                  class="form-control form-control-sm"
                  v-model="formData.dda"
                  :class="{
                    'text-danger font-weight-bold error':
                      $v.formData.dda.$error,
                  }"
                  :readonly="!canEdit"
                  min="1980"
                  :max="new Date().getFullYear()"
                  @blur="validate_dda($event.target.value)"
                />
              </td>
              <td class="border">
                <div class="form-check form-check-inline mb-4">
                  <yes-or-no
                    v-model="formData.patient_at_risk"
                    :disabled="!canEdit"
                    row
                  />
                </div>
                <span v-if="$v.formData.risk_description.$error" class="error"
                  ><br />Risk description is required when patient is at risk<br
                /></span>
                <textarea
                  style="width: 100%; height: 60px"
                  v-if="formData.patient_at_risk"
                  v-model="formData.risk_description"
                  placeholder="Write here the reason"
                  :class="{
                    'text-danger font-weight-bold error mt-2':
                      $v.formData.risk_description.$error,
                  }"
                  :readonly="!canEdit"
                ></textarea>
              </td>
            </tr>
          </tbody>
        </table>
          <table class="table table-sm overflow-y-hidden overflow-x-auto">
              <tr>
                <td>Preeclampsia prevention needed</td>
                <td>High frequency prenatal care</td>
                <td>OGTT needed</td>
                <td>Planned C-section</td>
                <td>Planned induction</td>
                <td>Take blood pressure medication</td>
              </tr>
              <tr>
                  <td>
                      <yes-or-no
                          row
                          v-model.number="formData.preeclampsia_needed"
                          :disabled="!canEdit"
                      />
                  </td>
                  <td>
                      <yes-or-no
                          row
                          v-model.number="formData.high_frequency_prenatal_care"
                          :disabled="!canEdit"
                      />
                  </td>
                  <td>
                      <yes-or-no
                          row
                          v-model="formData.ogtt_needed"
                          :disabled="!canEdit"
                      />
                  </td>
                  <td>
                      <yes-or-no
                          row
                          v-model="formData.planned_oc"
                          :disabled="!canEdit"
                      />
                      <date-picker
                          v-model="formData.planned_oc_date"
                          class="d-block"
                          v-if="formData.planned_oc"
                          :input-debounce="500"
                          mode="date"
                          :model-config="accessory.dateConfig"
                          :masks="accessory.dateConfig.masks"
                          :popover="{ visibility: canEdit ? 'click' : 'hidden' }"
                      >
                          <template v-slot="{ inputValue, inputEvents }">
                              <input
                                  class="
                              bg-white
                              form-control form-control-sm
                              px-2
                              py-1
                              rounded
                            "
                                  :value="inputValue"
                                  v-on="inputEvents"
                                  readonly
                              />
                          </template>
                      </date-picker>
                  </td>
                  <td>
                      <yes-or-no
                          row
                          v-model="formData.planned_induction"
                          :disabled="!canEdit"
                      />
                  </td>
                  <td>
                      <yes-or-no
                          row
                          v-model="formData.takes_blood_pressure_medication"
                          :disabled="!canEdit"
                      />
                      <div v-if="formData.takes_blood_pressure_medication">
                          <span>Start date:</span>
                          <date-picker
                              v-model="
                            formData.blood_pressure_medication_start_date
                          "
                              class="d-block"
                              :input-debounce="500"
                              mode="date"
                              :model-config="accessory.dateConfig"
                              :masks="accessory.dateConfig.masks"
                              :max-date="new Date()"
                              :popover="{
                            visibility: canEdit ? 'click' : 'hidden',
                          }"
                          >
                              <template v-slot="{ inputValue, inputEvents }">
                                  <input
                                      class="
                                bg-white
                                form-control form-control-sm
                                px-2
                                py-1
                                rounded
                              "
                                      :value="inputValue"
                                      v-on="inputEvents"
                                      readonly
                                  />
                              </template>
                          </date-picker>
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
                <td></td>
            </tr>
          <tr>
            <td>
              [ &nbsp;<select
                v-model="formData.blood_group"
                :disabled="!canEdit"
              >
                <option v-for="bg in accessory.blood_group" :value="bg.name">
                  {{ bg.name }}
                </option>
              </select>
              &nbsp;]&nbsp;[&nbsp;
              <select v-model="formData.rhesus" :disabled="!canEdit">
                <option></option>
                <option value="+">+</option>
                <option value="-">-</option>
              </select>
              ]
            </td>

            <td>
              [ &nbsp;<select
                v-model="formData.hiv"
                :class="{ 'text-danger': formData.hiv === 'Positive' }"
                :disabled="!canEdit"
              >
                <option value="Positive">Positive</option>
                <option value="Negative">Negative</option>
              </select>
              &nbsp;]
            </td>
            <td>
              [ &nbsp;<select
                v-model="formData.syphilis"
                :class="{ 'text-danger': formData.syphilis === 'Positive' }"
                :disabled="!canEdit"
              >
                <option value="Positive">Positive</option>
                <option value="Negative">Negative</option>
              </select>
              &nbsp;]
            </td>
            <td>
              [&nbsp;
              <select v-model="formData.other_test" :disabled="!canEdit">
                <option value="+">+</option>
                <option value="-">-</option>
              </select>
              &nbsp;]&nbsp;
              <input
                type="text"
                v-model="formData.other_test_descr"
                :readonly="!canEdit"
              />
            </td>
            <td>
              <input type="text" v-model="formData.hb" :readonly="!canEdit" />
            </td>
          </tr>
        </table>
        <table
          class="table table-bordered d-block overflow-y-hidden overflow-x-auto"
          id="preg_history"
        >
          <tr>
            <td class="table_title" colspan="14">
              Pregnancy History

              <v-btn
                class="mx-2 d-print-none"
                fab
                dark
                color="indigo"
                x-small
                @click="add_row"
                v-if="canEdit && !accessory.edit"
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
            <td>Birth type</td>
            <td>Indications</td>
            <td>Our patient</td>
            <td>Birth place</td>
            <td>GA</td>
            <td>Weight of the baby <small>(grams)</small></td>
            <td>Condition</td>
            <td>Newborn gender</td>
            <td>Newborn malformation</td>
            <td>Newborn infection</td>
            <td>Problems in Pueperium</td>
            <td>Actions</td>
          </tr>
          <tr v-for="(row, index) in formData.pregnancy_history">
            <td>
              <input
                type="number"
                v-model="row.nr_year"
                style="width: 60px"
                class="form-control form-control-sm"
                :class="{
                  'text-danger font-weight-bold error':
                    $v.formData.pregnancy_history.$each[index].$error,
                }"
                :readonly="!canEdit"
                min="1980"
                :max="new Date().getFullYear()"
                @blur="validate_pregnancy_history_year(row, index)"
              />
            </td>
            <td>
              <!-- <select v-model="row.pregnancy" style="font-size: 10px" :disabled="!canEdit">
                  <option v-for="item of accessory.birth_problem">{{item.name}}</option>
                </select> -->
              <input
                type="text"
                v-model="row.pregnancy"
                style="font-size: 10px"
                :disabled="!canEdit"
              />
            </td>
            <td>
              <select
                v-model="row.birth_type"
                :data-val="row.birth_type"
                :class="{ 'text-danger': row.birth_type === 'C-section' }"
                :disabled="!canEdit"
                style="font-size: 10px"
              >
                <option value="normal">normal</option>
                <option value="kiwi">kiwi</option>
                <option value="forceps">forceps</option>
                <option value="C-section">C-section</option>
                <option value="Curettage">Curettage</option>
                <option value="Cytotec">Cytotec</option>
              </select>
            </td>
            <td>
              <textarea
                v-model="row.birth_problems"
                :readonly="!canEdit"
                rows="4"
                cols="15"
              />
            </td>
            <td>
              <yes-or-no v-model="row.ourPatient" :disabled="!canEdit" />
            </td>
            <td>
              <textarea
                rows="4"
                v-model="row.birth_place"
                id="birth_place"
                cols="15"
                :readonly="!canEdit"
              />
            </td>
            <td>
              <gestational-age
                v-model="row.sa"
                :class="{ error: gestational_age_week(row.sa) <= 37 }"
                :readonly="!canEdit"
              />
            </td>
            <td>
              <input
                type="number"
                v-model="row.baby_weight"
                style="width: 50px"
                :class="{
                  'text-danger':
                    row.baby_weight &&
                    (row.baby_weight < 2000 || row.baby_weight > 3600),
                }"
                :readonly="!canEdit"
                min="0"
              />
            </td>
            <td>
              <select
                v-model="row.baby_condition"
                style="font-size: 10px"
                :disabled="!canEdit"
              >
                <option value="Alive">Alive</option>
                <option value="Died <=24h">Died ≤24h</option>
                <option value="Died >24h">Died >24h</option>
                <option value="Died <=28 days">Died ≤28 days</option>
                <option value="Died >28 days">Died >28 days</option>
              </select>
            </td>
            <td>
              <select v-model="row.baby_gender" :disabled="!canEdit">
                <option value="M">M</option>
                <option value="F">F</option>
              </select>
            </td>
            <td>
              <yes-or-no v-model="row.malformation" :disabled="!canEdit" />
            </td>
            <td>
              <yes-or-no v-model="row.infection" :disabled="!canEdit" />
            </td>
            <td>
              <textarea rows="4" v-model="row.pueperium" :readonly="!canEdit" />
            </td>
            <td>
              <v-btn
                class="mx-2 d-print-none"
                fab
                dark
                color="#870e21"
                x-small
                @click="delete_row(index)"
                v-if="canEdit && !accessory.edit"
              >
                <v-icon dark> mdi-delete </v-icon>
              </v-btn>
            </td>
          </tr>
        </table>
        <table class="table table-borderless">
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
                  :readonly="!canEdit"
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
                  :readonly="!canEdit"
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
                  :readonly="!canEdit"
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
                  :readonly="!canEdit"
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
                  :readonly="!canEdit"
                />
              </td>
            </tr>
            <tr>
              <td>Bleeding</td>
              <td>
                <yes-or-no
                  row
                  v-model="formData.preg_wom_bleeding"
                  :disabled="!canEdit"
                />
              </td>
            </tr>
            <tr>
              <td>Haematoma</td>
              <td>
                <yes-or-no
                  row
                  v-model="formData.preg_wom_haematoma"
                  :disabled="!canEdit"
                />
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-borderless">
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
                  :readonly="!canEdit"
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
                  :readonly="!canEdit"
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
                  :readonly="!canEdit"
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
                  :readonly="!canEdit"
                />
              </td>
            </tr>
            <tr>
              <td>
                <label class="form-check-label">Dead Baby</label>
              </td>
              <td>
                <yes-or-no
                  row
                  v-model="formData.close_family_dead_baby"
                  :disabled="!canEdit"
                />
              </td>
            </tr>
            <tr>
              <td>
                <label class="form-check-label">Miscarriage</label>
              </td>
              <td>
                <yes-or-no
                  row
                  v-model="formData.close_family_miscarriage"
                  :disabled="!canEdit"
                />
              </td>
            </tr>
            <tr>
              <td>Problems in the pregnancy</td>
              <td>
                <input
                  type="text"
                  style="width: 100%"
                  v-model="formData.close_family_prob_in_preg"
                  :readonly="!canEdit"
                />
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered mt-2">
          <tr>
            <td colspan="7" class="table_title">Pelvimetrie</td>
          </tr>
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
              <input
                type="number"
                v-model="formData.spin"
                :class="{ 'text-danger error': $v.formData.spin.$error }"
                :readonly="!canEdit"
              />
            </td>
            <td class="border">
              <input
                type="number"
                v-model="formData.christ"
                :class="{ 'text-danger error': $v.formData.christ.$error }"
                :readonly="!canEdit"
              />
            </td>
            <td class="border">
              <input
                type="number"
                v-model="formData.troch"
                :class="{ 'text-danger error': $v.formData.troch.$error }"
                :readonly="!canEdit"
              />
            </td>
            <td class="border">
              <input
                type="number"
                v-model="formData.obst"
                :class="{
                  'text-danger': formData.obst < 18,
                  'text-danger error': $v.formData.obst.$error,
                }"
                :readonly="!canEdit"
              />
            </td>
            <td class="border">
              [&nbsp;
              <select
                v-model="formData.michaelis"
                :disabled="!canEdit"
                :class="{
                  'text-danger': formData.michaelis !== 'Equal',
                  'text-danger error': $v.formData.michaelis.$error,
                }"
              >
                <option class="text-dark bg-light" value="Equal">Equal</option>
                <option class="text-dark bg-light" value="Narrow">
                  Narrow
                </option>
                <option class="text-dark bg-light" value="Symmetric">
                  Symmetric
                </option>
                <option class="text-dark bg-light" value="Asymmetric">
                  Asymmetric
                </option>
              </select>
              &nbsp;]
            </td>
            <td class="border">
              [&nbsp;
              <select
                :disabled="!canEdit"
                v-model="formData.baum_hg"
                :class="{
                  'text-danger': formData.baum_hg === 'Negative',
                  'text-danger error': $v.formData.baum_hg.$error,
                }"
              >
                <option class="text-dark bg-light" value="Positive">
                  Positive
                </option>
                <option class="text-dark bg-light" value="Negative">
                  Negative
                </option>
              </select>
              &nbsp;]
            </td>
            <td>
              <yes-or-no
                row
                v-model="formData.problem_for_delivery"
                :disabled="!canEdit"
              />
            </td>
          </tr>
        </table>
      </div>
      <div class="row mt-3">
        <div class="col-12">
<!--          <button-->
<!--            type="button "-->
<!--            class="btn btn-warning float-left"-->
<!--            v-if="ultrasound_data.created_at!==null"-->
<!--            @click.prevent="overView"-->
<!--          >-->
<!--            Followup Data-->
<!--          </button>-->
          <button
            @click="submit"
            class="btn btn-primary float-right d-print-none"
            id="submit"
            v-if="canEdit"
          >
            {{ submit_text }}
          </button>
        </div>
      </div>
      <senior-auth-dialog
        v-on:authorized="authorized"
        v-model="accessory.auth_dialog"
      />
        <v-speed-dial
            v-model="speed_dial.fab"
            :top="true"
            :right="true"
            direction="bottom"
            :open-on-hover="speed_dial.hover"
            :transition="speed_dial.transition"
        >
            <template v-slot:activator>
                <v-btn
                    v-model="speed_dial.fab"
                    color="blue darken-2"
                    dark
                    fab
                >
                    <v-icon v-if="speed_dial.fab">
                        mdi-close
                    </v-icon>
                    <v-icon v-else >
                        mdi-briefcase-check
                    </v-icon>
                </v-btn>
            </template>
            <v-btn
                fab
                dark
                small
                color="green"
                @click="accessory.show_internal_lab=true"
            >
                IL
            </v-btn>
<!--            <v-btn-->
<!--                fab-->
<!--                dark-->
<!--                small-->
<!--                color="indigo"-->
<!--            >-->
<!--                <v-icon>mdi-plus</v-icon>-->
<!--            </v-btn>-->
<!--            <v-btn-->
<!--                fab-->
<!--                dark-->
<!--                small-->
<!--                color="red"-->
<!--            >-->
<!--                <v-icon>mdi-delete</v-icon>-->
<!--            </v-btn>-->
        </v-speed-dial>
        <v-dialog
            v-model="accessory.show_internal_lab"
        >
            <v-card>

                <v-card-text class="p-2">
                    <internal_lab :form_type="'request'" :admission="$route.params.admission"/>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-app>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import moment from "moment"
import gestationalAge from "../../../../components/gestational_age_control";
import seniorAuthDialog from "../../../../components/senior_auth_dialog";
import Internal_lab from "../../labwork/internal/internal_lab";
const {
  required,
  minValue,
  minLength,
  email,
  url,
  maxLength,
  between,
  requiredIf,
} = require("vuelidate/lib/validators");
export default {
  name: "cpn_admission",
  components: {Internal_lab, gestationalAge, seniorAuthDialog },
  props: ["is_overview", "reference"],
  mixins: [validationMixin],
  data() {
    return {
      formData: {
        created_at: new Date(),
        patient_id: "",
        consultation_id: "",
        ultrasound_admission_id: null,
        weight: "",
        hydrodramnion: false,
        oligodramnion: false,
        ddr: "",
        unknown_lpd: false,
        edd_calc: "",
        edd_ultrasound: "",
        edd_corrected: "",
        edd_method: "",
        gestational_age: null,
        gravida: "",
        parity: "",
        abortion: "",
        miscarriage: "",
        ev: "",
        dda: "",
        patient_at_risk: null,
        risk_description: "",
        preeclampsia_needed: null,
        high_frequency_prenatal_care: null,
        ogtt_needed: null,
        planned_oc: null,
        planned_oc_date: "",
        planned_induction: null,
        takes_blood_pressure_medication: null,
        blood_pressure_medication_start_date: null,
        blood_group: "",
        rhesus: "",
        hiv: "",
        syphilis: "",
        other_test: "",
        other_test_descr: "",
        hb: "",
        close_family_twins: "",
        close_family_oc: "",
        close_family_disease: "",
        close_family_malformation: null,
        close_family_dead_baby: null,
        close_family_prob_in_preg: "",
        close_family_miscarriage: null,
        preg_wom_bleeding: null,
        preg_wom_haematoma: null,
        preg_wom_medication: "",
        preg_wom_chronical_disease: "",
        preg_wom_allergie: "",
        preg_wom_former_illness: "",
        preg_wom_disability: "",
        updated_at: "",
        pregnancy_history: [],
        spin: "",
        christ: "",
        troch: "",
        obst: "",
        michaelis: "",
        baum_hg: "",
        problem_for_delivery: null,
        responsible: "",
      },
      patient_details: {
        id:"",
        firstName: "",
        lastName: "",
        birthDate: "",
        adress: "",
        tel: "",
        weight: "",
        height: "",
        gender: "",
      },
      ultrasound_data: {
        id:null,
        created_at: null,
        unknown_lpd: false,
        ddr: null,
        gestational_age: null,
        edd_method: null,
        edd_calc: null,
        edd_ultrasound: null,
        edd_corrected: null,
        selected_edd: null,
      },
      accessory: {
        dateConfig: {
          type: "string",
          mask: "iso",
          masks: {
            input: "DD/MMM/YYYY",
          },
        },
        edit: false,
        reference: this.reference,
        last_id: "",
        quick_birth_output: [],
        data_populated: false,
        blood_group: "",
        loading: {
          data: false,
          patient: false,
          ultrasound: false,
        },
        noError: true,
        birth_problem: "",
        noPatientFound: false,
        ultrasound_link_error_message: "",
        auth_dialog: false,
        authorized_user: false,
          show_internal_lab:false
      },
        speed_dial:{
            direction: 'top',
            fab: false,
            fling: false,
            hover: false,
            tabs: null,
            top: false,
            right: true,
            bottom: true,
            left: false,
            transition: 'slide-y-reverse-transition',
        },
    };
  },
  created() {
    this.init();
  },
  methods: {
    add_row() {
      this.formData.pregnancy_history.push({
        nr_year: "",
        pregnancy: "",
        birth_type: "",
        birth_place: "",
        birth_problems: "",
        baby_gender: "",
        infection: null,
        malformation: null,
        baby_condition: "",
        pueperium: "",
        sa: null,
        baby_weight: "",
        ourPatient: null,
      });
    },
    delete_row(index) {
      this.formData.pregnancy_history.splice(index, 1);
    },
    async submit() {
      this.$v.$touch();
      this.formData.responsible = window.auth.user.name;
      if (!this.$v.$invalid) {
        if (this.accessory.edit === false) {
            this.formData.ultrasound_data=this.ultrasound_data
            this.formData.ultrasound_data.gestational_age=this.current_gestational_age
            this.formData.ultrasound_admission_id=this.ultrasound_data.id
          let response = await axios.post(
            "/api/v1/patient_system/out_patient/obstetrical/cpn/admission",
            this.formData
          );
          if (response.data.success === true) {
            this.reset_form();
            this.$toast.open({
              message: `Reference: ${response.data.cpn_admission.id} `,
              position: "top-right",
              duration: 0,
            });
            this.$router.push({
              name: "cpn_followup",
              params: {
                cpn_admission: response.data.cpn_admission,
                  admission_id:this.$route.params.admission_id
              },
            });
          }
        } else {
          let response = await axios.put(
            `/api/v1/patient_system/out_patient/obstetrical/cpn_admission/${this.accessory.reference}`,
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
      this.accessory.loading.data = true;
      this.$v.$reset();
      for (let [key, val] of Object.entries(this.formData)) {
        this.formData[key] = "";
      }
      for (let [key, val] of Object.entries(this.patient_details)) {
        this.patient_details[key] = "";
      }
      this.formData.pregnancy_history = [];
      this.formData.created_at = new Date();
      this.accessory.reference = "";
      this.accessory.data_populated = false;
      this.accessory.loading.data = false;
      this.accessory.noPatientFound = false;

    },
    async fetchData() {
      // copy the reference because it is reset by reset_form
      const reference = this.accessory.reference;

      if (!reference) return;

      if (this.accessory.data_populated === true) this.reset_form();
      let response = await axios.get(
        `/api/v1/patient_system/out_patient/obstetrical/cpn/admission/${reference}`
      );

      this.accessory.reference = reference;

      if (response.data.success) {
        Object.assign(this.formData, response.data.admission);
        this.formData.pregnancy_history = response.data.preg_history;
        this.formData.gestational_age = response.data.admission.wop;
        this.accessory.data_populated = true;
        this.patient_details=response.data.patient
        if (response.data.ultrasound) {
          this.set_ultrasound_data(response.data.ultrasound);
        } else {
          // this.set_legacy_edd_data(response.data.legacy_edd);
            this.set_legacy_edd_data(response.data);

        }
      }
    },
    async init() {
      // this.accessory.loading.data = true;
        axios.get("/api/v1/extra/blood_group").then((response) => (this.accessory.blood_group = response.data)),
        axios.get("/api/v1/extra/pregnancy_problem").then((response) => (this.accessory.birth_problems = response.data))
      if (this.$route.params.patient){
        [this.patient_details,this.formData.patient_id,this.formData.weight,this.formData.consultation_id]=[this.$route.params.patient,this.$route.params.patient.id,this.$route.params.weight,this.$route.params.admission_id]
      }
      if(this.reference) this.accessory.reference=this.reference
      if (this.accessory.reference !== "" && this.accessory.reference) {
        this.accessory.edit = true;
        await this.fetchData();
      }

      if (
        this.formData.consultation_id &&
        !this.ultrasound_data.created_at &&
        !this.accessory.edit
      ) {
          axios
              .get(
                  "/api/v1/patient_system/out_patient/obstetrical/cpn/get_ultrasound_admission_data/" +
                  this.formData.patient_id
              )
              .then((response) => {
                  if (response.data) {
                      this.set_ultrasound_data(response.data)
                      // this.ultrasound_data={
                      //     created_at:response.data.created_at,
                      //     ddr:response.data.last_period_date,
                      //     edd_calc:response.data.edd_calculated,
                      //     edd_corrected:response.data.edd_corrected,
                      //     edd_ultrasound:response.data.edd_ultrasound,
                      //     gestational_age:'',
                      //     edd_method:response.data.edd_method,
                      //     selected_edd:'',
                      //     unknown_lpd:response.data.unknown_lpd,
                      //     calculated_ga:response.data.calculated_ga,
                      //     ultrasound_ga:response.data.ultrasound_ga,
                      //     corrected_ga:response.data.corrected_ga,
                      // }
                  }
              })
      }

      this.accessory.loading.data = false;
    },
    authorized() {
      this.accessory.authorized_user = true;
      this.accessory.auth_dialog = false;
    },
    overView() {
      this.$router.push({
        name: "cpn_followup",
        params: {
          cpn_ref: this.accessory.reference,
        },
      });
    },
    validate_dda() {
      if (
        this.formData.dda < 1980 ||
        this.formData.dda > new Date().getFullYear()
      )
        this.formData.dda = "";
    },
    validate_pregnancy_history_year(row, index) {
      if (row.nr_year < 1980 || row.nr_year > new Date().getFullYear())
        row.nr_year = "";
    },
    gestational_age_week(gestational_age) {
      if (!gestational_age || !gestational_age.includes("+")) return undefined;

      return gestational_age.split("+")[0];
    },
    set_legacy_edd_data(data) {
      function get_edd_from_dpa_ga(dpa_ga, created_date) {
        const parts = dpa_ga.split("+");
        const ga_in_days = Number(parts[0]) * 7 + Number(parts[1]);

        const on_date = new Date(created_date);

        return new Date(
          on_date.setDate(on_date.getDate() + (40 * 7 - ga_in_days))
        );
      }

      this.ultrasound_data.unknown_lpd = data.unknown_lpd || false;
      this.ultrasound_data.ddr = data.ddr;
      this.ultrasound_data.edd_calc = get_edd_from_dpa_ga(
        data.dpa_calc,
        data.created_at
      );

      this.ultrasound_data.created_at = data.created_at;
      this.ultrasound_data.edd_method = data.dpa_method;
      this.ultrasound_data.edd_ultrasound = get_edd_from_dpa_ga(
        data.dpa_echo,
        data.created_at
      );
      this.ultrasound_data.edd_corrected = get_edd_from_dpa_ga(
        data.dpa_corrected,
        data.created_at
      );

      switch (this.ultrasound_data.edd_method) {
        case "calc":
          this.ultrasound_data.selected_edd = this.ultrasound_data.edd_calc;
          break;
        case "us":
          this.ultrasound_data.selected_edd =
            this.ultrasound_data.edd_ultrasound;
          break;
        case "corrected":
          this.ultrasound_data.selected_edd =
            this.ultrasound_data.edd_corrected;
          break;
      }

      this.ultrasound_data.gestational_age = this.ultrasound_ga;
      if (!this.formData.gestational_age)
        this.formData.gestational_age = this.ultrasound_data.gestational_age;
    },
    gravida_input() {
      if (this.formData.gravida == 1) {
        this.formData.parity =
          this.formData.miscarriage =
          this.formData.abortion =
          this.formData.ev =
            0;
      }
    },
    set_ultrasound_data(data){
        this.ultrasound_data={
            id:data.id,
            created_at:data.created_at,
            ddr:moment(data.last_period_date,"YYYY-MM-DD HH:mm").toISOString(),
            edd_calc:moment(data.edd_calculated,"YYYY-MM-DD HH:mm").toISOString(),
            edd_corrected:moment(data.edd_corrected,"YYYY-MM-DD HH:mm").toISOString(),
            edd_ultrasound:moment(data.edd_ultrasound,"YYYY-MM-DD HH:mm").toISOString(),
            gestational_age:'',
            edd_method:data.edd_method,
            selected_edd:'',
            unknown_lpd:data.unknown_lpd,
            calculated_ga:data.calculated_ga,
            ultrasound_ga:data.ultrasound_ga,
            corrected_ga:data.corrected_ga,
        }
    },
    nullToString(txt){
        return txt===null ? '' : txt
    }
  },
  computed: {
    canEdit() {
      return !this.is_overview && !this.senior_auth_required;
    },
    senior_auth_required() {
      // if more than a day has passed, require senior authorization
      if (
        !this.accessory.authorized_user &&
        (new Date().getDate() !==
          new Date(this.formData.created_at).getDate() ||
          new Date() - new Date(this.formData.created_at) > 1000 * 60 * 60 * 24)
      ) {
        return true;
      }
      return false;
    },
    fullName() {
      return (
        this.nullToString(this.patient_details.firstName) + " " + this.nullToString(this.patient_details.lastName)
      );
    },
    age() {
      return calculateAge(this.patient_details.birthDate);
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
      if (!this.formData.weight || !this.patient_details.height) return null;

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
          return "(P+A+M) should be less than G";
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
    ultrasound_ga() {
      if (!this.ultrasound_data || !this.ultrasound_data.selected_edd)
        return null;

      const selectedDate = this.ultrasound_data.selected_edd;

      const diff = new Date(selectedDate) - new Date(this.formData.created_at);
      const diff_in_days = Math.round(diff / 1000 / 60 / 60 / 24);

      const ga_in_days = 40 * 7 - diff_in_days;

      const ga_weeks = Math.floor(ga_in_days / 7);
      const ga_days = ga_in_days % 7;

      return ga_weeks + "+" + ga_days;
    },
    // planned_oc_min_date() {
    //   const edd = new Date(this.ultrasound_data.edd_method);
    //   return new Date(edd.setDate(edd.getDate() - 4 * 7));
    // },
    // planned_oc_default_date() {
    //   const edd = new Date(this.ultrasound_data.edd_method);
    //   return new Date(edd.setDate(edd.getDate() - 2 * 7));
    // },
    current_gestational_age(){
        let src_ga, src_date
        switch (this.ultrasound_data.edd_method){
            case 'us':
                src_ga=this.ultrasound_data.ultrasound_ga
                break;
            case 'calc':
                src_ga=this.ultrasound_data.calculated_ga
                break;
            case 'corrected':
                src_ga=this.ultrasound_data.corrected_ga
                break;
            default:
                return "0+0"
        }
        if (src_ga===null) return "0+0"
        src_date= this.ultrasound_data.created_at
        const diff = new Date()- new Date(src_date);
        const diff_in_days = Math.round(diff / 1000 / 60 / 60 / 24);
        const ga_weeks = Math.floor(diff_in_days / 7);
        const ga_days = diff_in_days % 7;
        // splitting src date
        let [left_ga,right_ga]= [parseInt(src_ga.split('+')[0]),parseInt(src_ga.split('+')[1])]
       // summing the right part
        let ga_in_days= ga_days+ right_ga
        let ga_in_week= ga_weeks+ left_ga
        if (ga_in_days>6) ga_in_week++
        return ga_in_week + "+"+ ga_in_days
    }
  },
  validations: {
    formData: {
      patient_id: { required },
      dda: { between: between(1980, new Date().getFullYear()) },
      weight: { required },
      pregnancy_history: {
        $each: {
          nr_year: {
            required,
            between: between(1980, new Date().getFullYear()),
          },
        },
      },
      risk_description: {
        required: requiredIf((formData) => formData.patient_at_risk),
      },
      spin: { required },
      christ: { required },
      troch: { required },
      obst: { required },
      michaelis: { required },
      baum_hg: { required },
    },
    accessory: {
      noPatientFound: { patientFound: (value) => value === false },
      ultrasound_link_error_message: { should_not_have_value: maxLength(0) },
    },
    patient_details: {
      height: { required, minValue: minValue(50) },
      birthDate: { required, validateAge: validateAgeRange },
      gender: { required, isFemale: (value) => !value || value === "F" },
    },
  },
};

function calculateAge(birthDate) {
  if (birthDate !== "") {
    var difference = Date.now() - new Date(birthDate).getTime();
    var age = new Date(difference);
    return Math.abs(age.getUTCFullYear() - 1970);
  } else {
    return "";
  }
}
function validateAgeRange(birthDate) {
  if (!birthDate) return true;

  const age = calculateAge(birthDate);
  if (age >= 10 && age <= 50) {
    return true;
  }

  return false;
}
function toNull(val) {
  let response;
  val === "" ? (response = 0) : (response = val);
  return response;
}
</script>

<style scoped>
/*.container {*/
/*  box-shadow: 0px 0px 0.5cm rgba(0, 0, 0, 0.8);*/
/*  margin-top: 0.6%;*/
/*  background-color: white !important;*/
/*  font-family: calibri;*/
/*  z-index: 500;*/
/*}*/
input {
  font-size: 11px;
  border: lightgrey solid 0.5px;
  min-width: 45px;
}
textarea {
  font-size: 11px;
  border: lightgrey solid 0.5px;
  resize: both;
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
  border: 1px solid rgb(211, 211, 211);
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
    color:#FF80AB;
}
.table_title {
  background-color: #1390c6 !important;
  color: white;
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
.table td {
  padding: 0.5rem !important;
}
.table.precautions-table td {
  padding: 0rem !important;
}
.table.precautions-table td label {
  vertical-align: sub;
}
.table.precautions-table {
  margin-bottom: 0px;
}
td {
  line-height: normal;
}
.narrow {
  width: 85px;
}
.v-speed-dial {
    position: absolute;
}

.v-btn--floating {
    position: relative;
}
</style>
