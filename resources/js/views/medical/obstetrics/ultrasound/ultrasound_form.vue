<template>
  <div class="container-fluid p-4">
    <Loading :active.sync="isLoading"></Loading>
    <v-app>
      <div>
        <div class="container border">
          <div class="table-responsive overflow-x-visible">
            <patient-information
              v-if="!is_overview"
              :key="patient_id"
              :patient_id="patient_id"
            />
            <table class="table table-sm table-borderless">
              <tr>
                <th class="table-title" colspan="13">
                  <v-icon class="text-white">mdi-stethoscope</v-icon> &nbsp; B)
                  Today's actions
                </th>
              </tr>
              <tr>
                <th colspan="2">B.3. Diagnose:</th>
              </tr>
              <tr>
                <td>
                  <div class="form-group">
                    <label>Is the patient pregnant:</label>
                    <v-radio-group
                      row
                      class="mt-0 p-0 small"
                      v-model="is_patient_pregnant"
                      :readonly="is_overview || is_updating"
                    >
                      <v-radio
                        label="Yes"
                        color="success"
                        :value="true"
                        class="radio"
                      ></v-radio>
                      <v-radio
                        label="No"
                        color="red"
                        :value="false"
                        class="radio"
                      ></v-radio>
                    </v-radio-group>
                  </div>
                </td>
              </tr>
              <tr v-if="is_patient_pregnant === false">
                <td>
                  <div class="form-group">
                    <label>Remark:</label>
                    <textarea
                      class="form-control"
                      v-model="remark_when_ultrasound_neg"
                    ></textarea>
                  </div>
                </td>
              </tr>
              <!--                                <tr>-->
              <!--                                    <td colspan="13">-->
              <!--                                        <table class="table table-borderless" style="width: 450px;">-->
              <!--                                            <tr>-->
              <!--                                                <td class="pl-4 text-decoration-underline" colspan="1">3.1. Is patient pregnant:</td>-->
              <!--                                                <td colspan="4">-->
              <!--                                                    <v-radio-group row class="mt-0 p-0 small" v-model="is_patient_pregnant" :readonly="is_overview || is_updating">-->
              <!--                                                        <v-radio label="Yes" color="success" :value="true" class="radio"></v-radio>-->
              <!--                                                        <v-radio label="No" color="red" :value="false" class="radio"></v-radio>-->
              <!--                                                    </v-radio-group>-->
              <!--                                                </td>-->
              <!--                                            </tr>-->
              <!--                                            <tr>-->
              <!--                                                <td colspan="5">-->
              <!--                                                    <textarea class="form-control"/>-->
              <!--                                                </td>-->
              <!--                                            </tr>-->
              <!--                                        </table>-->
              <!--                                    </td>-->
              <!--                                </tr>-->
              <tr v-if="is_patient_pregnant">
                <v-app class="p-2">
                  <v-card>
                    <v-dialog v-model="dialog" max-width="175px">
                      <v-card class="pt-4">
                        <v-card-text>
                          <v-select
                            :items="possible_fetus_count"
                            v-model="count_of_fetus"
                            label="Count of fetus"
                          ></v-select>
                        </v-card-text>

                        <v-card-actions>
                          <v-spacer></v-spacer>

                          <v-btn
                            text
                            color="primary"
                            x-small
                            @click="set_count_of_fetus"
                          >
                            Ok
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                    <senior-auth-dialog
                      v-on:authorized="authorized"
                      v-model="edit_dialog"
                    />
                    <v-tabs color="deep-purple accent-4" left>
                      <v-tab v-for="(tab, tabIndex) in formData" :key="tab.id"
                        >Fetus {{ tab.id + 1
                        }}<v-chip
                          x-small
                          v-if="current_screening_error(tabIndex)"
                          color="error"
                          class="ml-1"
                          >Errors</v-chip
                        ></v-tab
                      >
                      <v-btn
                        small
                        color="warning"
                        dark
                        @click="dialog = true"
                        hide-details
                        v-if="!is_overview"
                        class="ml-2 align-self-center"
                      >
                        Multiple pregnancy
                      </v-btn>

                      <v-tab-item
                        v-for="(dat, datIndex) in formData"
                        :key="dat.id"
                      >
                        <v-expansion-panels multiple>
                          <v-expansion-panel
                            v-if="dat.early_screening"
                            :class="{
                              'current-screening':
                                screening_identifier.includes('early'),
                            }"
                          >
                            <v-expansion-panel-header>
                              <div class="d-flex align-items-center">
                                <span
                                  ><small>{{
                                    date_format(dat.early_screening.created_at)
                                  }}</small>
                                  - Early screening &lt;8+0 GA</span
                                >
                                <v-chip
                                  v-if="screening_identifier.includes('early')"
                                  color="#6a6a6a"
                                  text-color="white"
                                  class="ml-1"
                                  >Current Screening</v-chip
                                >
                                <v-chip
                                  v-if="
                                    formEdit.early_screening &&
                                    $v.formData.$each[datIndex]
                                      .early_screening &&
                                    $v.formData.$each[datIndex].early_screening
                                      .$error
                                  "
                                  color="error"
                                  class="ml-1"
                                  >Errors</v-chip
                                >
                              </div>
                              <div class="float-right">
                                <v-btn
                                  right
                                  x-small
                                  class="ml-4 d-print-none float-right"
                                  color="secondary"
                                  dark
                                  @click.stop="edit('early')"
                                  v-if="
                                    can_edit_main_screenings &&
                                    !formEdit.early_screening &&
                                    !is_overview
                                  "
                                >
                                  Edit
                                </v-btn>
                              </div>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                              <table class="table main-table" id="early_table">
                                <tbody>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.1. Gestational age:
                                    </td>
                                    <td colspan="12">
                                      <div class="d-flex" style="width: 80px">
                                        <span class="text-center m-1">{{
                                          dat.early_screening.gestational_age
                                        }}</span>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.2. LP (DDR):
                                    </td>
                                    <td colspan="12" style="width: 100px">
                                      <div
                                        class="d-flex flex-column"
                                        style="width: 100px"
                                      >
                                        <div
                                          class="
                                            form-check form-check-inline
                                            mb-4
                                          "
                                        >
                                          <label
                                            class="form-check-label"
                                            for="unknown_ddr"
                                            >Unknown LP</label
                                          >&nbsp;
                                          <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="unknown_ddr"
                                            @change="
                                              calculate_ga(
                                                dat.early_screening,
                                                datIndex
                                              )
                                            "
                                            v-model="
                                              dat.early_screening.unknown_lpd
                                            "
                                            :disabled="
                                              !formEdit.early_screening ||
                                              is_overview
                                            "
                                          />
                                        </div>
                                        <date-picker
                                          v-model="dat.early_screening.ddr"
                                          @input="
                                            calculate_ga(
                                              dat.early_screening,
                                              datIndex
                                            )
                                          "
                                          v-if="
                                            !dat.early_screening.unknown_lpd
                                          "
                                          :input-debounce="500"
                                          mode="date"
                                          :popover="{
                                            visibility:
                                              !formEdit.early_screening ||
                                              is_overview
                                                ? 'hidden'
                                                : 'click',
                                          }"
                                          :model-config="accessory.dateConfig"
                                          :masks="accessory.dateConfig.masks"
                                          :max-date="new Date()"
                                          :min-date="eightMonthsAgo"
                                        >
                                          <template
                                            v-slot="{ inputValue, inputEvents }"
                                          >
                                            <input
                                              class="
                                                date-picker-narrow
                                                bg-white
                                                border
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
                                        <span
                                          class="text-danger mt-2 text-wrap"
                                          v-if="
                                            formEdit.early_screening &&
                                            $v.formData.$each[datIndex]
                                              .early_screening.ddr.$error
                                          "
                                          >You must choose the LP</span
                                        >
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.3. EDD (DPA):
                                    </td>
                                    <td colspan="12" style="width: 180px">
                                      <div style="width: 180px">
                                        <div>
                                          <date-picker
                                            :value="
                                              selected_due_date(
                                                dat.early_screening
                                              )
                                            "
                                            mode="date"
                                            :model-config="accessory.dateConfig"
                                            :masks="accessory.dateConfig.masks"
                                            :popover="{ visibility: 'hidden' }"
                                            :style="{
                                              display: selected_due_date(
                                                dat.early_screening
                                              )
                                                ? 'initial'
                                                : 'none',
                                            }"
                                          >
                                            <template
                                              v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                            >
                                              <input
                                                class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                                :value="inputValue"
                                                v-on="inputEvents"
                                                readonly
                                                disabled
                                              />
                                            </template>
                                          </date-picker>
                                        </div>
                                        <span
                                          class="text-danger text-break"
                                          style="white-space: normal !important"
                                          v-if="
                                            formEdit.early_screening &&
                                            !$v.formData.$each[datIndex]
                                              .early_screening.edd_method
                                              .selected_date_required
                                          "
                                        >
                                          The date to be used must have a
                                          value<br />
                                        </span>
                                        <span
                                          class="text-danger text-break"
                                          style="white-space: normal !important"
                                          v-if="
                                            formEdit.early_screening &&
                                            !$v.formData.$each[datIndex]
                                              .early_screening.edd_method
                                              .must_be_ultrasound_if_five_days_difference
                                          "
                                        >
                                          You must use the ultrasound date
                                          because it differs by more than 5
                                          days<br />
                                        </span>
                                        <label>To be used</label>
                                        [&nbsp;
                                        <select
                                          v-model="
                                            dat.early_screening.edd_method
                                          "
                                          @change="
                                            calculate_ga(
                                              dat.early_screening,
                                              datIndex
                                            )
                                          "
                                          :class="{
                                            'border border-danger':
                                              formEdit.early_screening &&
                                              $v.formData.$each[datIndex]
                                                .early_screening.edd_method
                                                .$error,
                                          }"
                                          :disabled="
                                            !formEdit.early_screening ||
                                            is_overview
                                          "
                                        >
                                          <option
                                            value="calc"
                                            v-if="
                                              !dat.early_screening.unknown_lpd
                                            "
                                          >
                                            calc
                                          </option>
                                          <option value="echo">echo</option>
                                          <option value="corrected">
                                            corrected
                                          </option>
                                        </select>
                                        &nbsp;]

                                        <div class="position-relative">
                                          <small
                                            :class="{
                                              'text-white bg-success':
                                                dat.early_screening
                                                  .edd_method === 'calc',
                                            }"
                                            class="mr-4"
                                            >Calc:</small
                                          >
                                          <span
                                            v-if="
                                              dat.early_screening.unknown_lpd
                                            "
                                            style="
                                              font-size: 12px;
                                              position: absolute;
                                              left: 0;
                                              top: 0;
                                            "
                                            ><br />Unknown</span
                                          >
                                          <date-picker
                                            v-model="
                                              dat.early_screening.edd_calculated
                                            "
                                            :input-debounce="500"
                                            mode="date"
                                            :model-config="accessory.dateConfig"
                                            :masks="accessory.dateConfig.masks"
                                            :min-date="new Date()"
                                            :popover="{ visibility: 'hidden' }"
                                            :style="{
                                              visibility: !dat.early_screening
                                                .unknown_lpd
                                                ? 'visible'
                                                : 'hidden',
                                            }"
                                          >
                                            <template
                                              v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                            >
                                              <input
                                                class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                                :value="inputValue"
                                                v-on="inputEvents"
                                                readonly
                                                disabled
                                                :class="{
                                                  'text-success':
                                                    dat.early_screening
                                                      .edd_method === 'calc',
                                                }"
                                              />
                                            </template>
                                          </date-picker>
                                        </div>

                                        <div>
                                          <small
                                            :class="{
                                              'text-white bg-success':
                                                dat.early_screening
                                                  .edd_method === 'echo',
                                            }"
                                            class="mr-6"
                                            >US:
                                          </small>
                                          <date-picker
                                            v-model="
                                              dat.early_screening.edd_ultrasound
                                            "
                                            :ref="`early_ultrasound${datIndex}`"
                                            @popoverWillShow="
                                              move_ultrasound_date_picker(
                                                `early_ultrasound${datIndex}`,
                                                null,
                                                dat.early_screening,
                                                datIndex
                                              )
                                            "
                                            @input="
                                              calculate_ga(
                                                dat.early_screening,
                                                datIndex
                                              )
                                            "
                                            :input-debounce="500"
                                            mode="date"
                                            :model-config="accessory.dateConfig"
                                            :masks="accessory.dateConfig.masks"
                                            :min-date="new Date()"
                                            :popover="{
                                              visibility:
                                                !formEdit.early_screening ||
                                                is_overview
                                                  ? 'hidden'
                                                  : 'click',
                                            }"
                                          >
                                            <template
                                              v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                            >
                                              <input
                                                class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                                :value="inputValue"
                                                v-on="inputEvents"
                                                readonly
                                                :class="{
                                                  'text-success':
                                                    dat.early_screening
                                                      .edd_method === 'echo',
                                                  error:
                                                    formEdit.early_screening &&
                                                    $v.formData.$each[datIndex]
                                                      .early_screening
                                                      .edd_ultrasound.$error,
                                                }"
                                              />
                                            </template>
                                          </date-picker>
                                        </div>
                                        <div>
                                          <small
                                            :class="{
                                              'text-white bg-success':
                                                dat.early_screening
                                                  .edd_method === 'corrected',
                                            }"
                                            >Corrected:
                                          </small>
                                          <date-picker
                                            v-model="
                                              dat.early_screening.edd_corrected
                                            "
                                            :ref="`early_corrected${datIndex}`"
                                            @popoverWillShow="
                                              move_ultrasound_date_picker(
                                                `early_corrected${datIndex}`,
                                                null,
                                                dat.early_screening,
                                                datIndex
                                              )
                                            "
                                            @input="calculate_ga(row, datIndex)"
                                            :input-debounce="500"
                                            mode="date"
                                            :model-config="accessory.dateConfig"
                                            :masks="accessory.dateConfig.masks"
                                            :min-date="new Date()"
                                            :popover="{
                                              visibility:
                                                !formEdit.early_screening ||
                                                is_overview
                                                  ? 'hidden'
                                                  : 'click',
                                            }"
                                          >
                                            <template
                                              v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                            >
                                              <input
                                                class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                                :value="inputValue"
                                                v-on="inputEvents"
                                                readonly
                                                :class="{
                                                  'text-success':
                                                    dat.early_screening
                                                      .edd_method ===
                                                    'corrected',
                                                }"
                                              />
                                            </template>
                                          </date-picker>
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.4. Intrauterine:
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="
                                          dat.early_screening.intrauterine
                                        "
                                        :readonly="
                                          !formEdit.early_screening ||
                                          is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.5. Embryo visible:
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="
                                          dat.early_screening.embryo_visible
                                        "
                                        :readonly="
                                          !formEdit.early_screening ||
                                          is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.6. Heartbeat:
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="dat.early_screening.heartbeat"
                                        :readonly="
                                          !formEdit.early_screening ||
                                          is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.7. Parameters:
                                    </td>
                                    <td colspan="12">
                                      <table
                                        class="table table-borderless"
                                        style="width: 400px"
                                      >
                                        <tr>
                                          <td>HC</td>
                                          <td>AC</td>
                                          <td>FL</td>
                                          <td>GS</td>
                                          <td>CRL</td>
                                          <td>BPD</td>
                                          <td>EWB</td>
                                          <td>FHR</td>
                                        </tr>
                                        <tr>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="dat.early_screening.hc"
                                              :readonly="
                                                !formEdit.early_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="dat.early_screening.ac"
                                              :readonly="
                                                !formEdit.early_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="dat.early_screening.fl"
                                              :readonly="
                                                !formEdit.early_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="dat.early_screening.gs"
                                              :readonly="
                                                !formEdit.early_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="dat.early_screening.crl"
                                              :readonly="
                                                !formEdit.early_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="dat.early_screening.bpd"
                                              :readonly="
                                                !formEdit.early_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="dat.early_screening.ewb"
                                              :readonly="
                                                !formEdit.early_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="dat.early_screening.fhr"
                                              :readonly="
                                                !formEdit.early_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.8. Other:
                                    </td>
                                    <td colspan="4">
                                      <textarea
                                        style="width: 100%"
                                        class="form-control"
                                        v-model="dat.early_screening.other"
                                        :readonly="
                                          !formEdit.early_screening ||
                                          is_overview
                                        "
                                      ></textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.9. Remark and precautions:
                                    </td>
                                    <td colspan="4">
                                      <textarea
                                        style="width: 100%"
                                        class="form-control"
                                        v-model="dat.early_screening.remark"
                                        :readonly="
                                          !formEdit.early_screening ||
                                          is_overview
                                        "
                                      ></textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="
                                        pl-4
                                        text-decoration-underline
                                        align-middle
                                      "
                                      colspan="1"
                                    >
                                      3.10. Medical Staff:
                                    </td>
                                    <td colspan="4">
                                      <v-autocomplete
                                        v-model="
                                          dat.early_screening.medical_staff
                                        "
                                        :items="medical_staff"
                                        outlined
                                        dense
                                        chips
                                        small-chips
                                        class="mt-4"
                                        :error="
                                          formEdit.early_screening &&
                                          $v.formData.$each[datIndex]
                                            .early_screening.medical_staff
                                            .$error
                                        "
                                        label="Medical Staff"
                                        multiple
                                        :disabled="
                                          !formEdit.early_screening ||
                                          is_overview
                                        "
                                      ></v-autocomplete>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </v-expansion-panel-content>
                          </v-expansion-panel>

                          <v-expansion-panel
                            v-for="(row, rowIndex) in dat.first_screening"
                            :key="'fs' + rowIndex"
                            :class="{
                              'current-screening':
                                screening_identifier.includes('1'),
                            }"
                          >
                            <v-expansion-panel-header>
                              <div class="d-flex align-items-center">
                                <span
                                  ><small>{{
                                    date_format(row.created_at)
                                  }}</small>
                                  - I. Screening 8+0 bis 11+6 GA</span
                                >
                                <v-chip
                                  v-if="screening_identifier.includes('1')"
                                  color="#6a6a6a"
                                  text-color="white"
                                  class="ml-1"
                                  >Current Screening</v-chip
                                >
                                <v-chip
                                  v-if="
                                    formEdit.first_screening &&
                                    $v.formData.$each[datIndex].first_screening
                                      .$each[rowIndex] &&
                                    $v.formData.$each[datIndex].first_screening
                                      .$each[rowIndex].$error
                                  "
                                  color="error"
                                  class="ml-1"
                                  >Errors</v-chip
                                >
                              </div>
                              <div class="float-right">
                                <v-btn
                                  right
                                  x-small
                                  class="ml-4 d-print-none float-right"
                                  color="secondary"
                                  dark
                                  @click.stop="edit(1)"
                                  v-if="
                                    rowIndex === 0 &&
                                    can_edit_main_screenings &&
                                    !formEdit.first_screening &&
                                    !is_overview
                                  "
                                >
                                  Edit
                                </v-btn>
                                <v-btn
                                  right
                                  small
                                  class="ml-4 d-print-none float-right"
                                  color="primary"
                                  v-if="
                                    rowIndex === 0 &&
                                    formEdit.first_screening &&
                                    !is_overview
                                  "
                                  @click.stop="row_push(dat.id, 1)"
                                  icon
                                >
                                  <v-icon dark>mdi-plus-circle-outline</v-icon>
                                </v-btn>
                                <v-btn
                                  right
                                  small
                                  class="ml-4 d-print-none float-right"
                                  color="red"
                                  v-if="
                                    can_delete(row) &&
                                    formEdit.first_screening &&
                                    rowIndex > 0 &&
                                    !is_overview
                                  "
                                  @click.stop="
                                    row_delete(datIndex, 1, rowIndex)
                                  "
                                  icon
                                >
                                  <v-icon dark>mdi-minus-circle-outline</v-icon>
                                </v-btn>
                              </div>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                              <table class="table main-table" id="main_table">
                                <tbody>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.1. Gestational age:
                                    </td>
                                    <td colspan="12">
                                      <div class="d-flex" style="width: 80px">
                                        <span class="text-center m-1">{{
                                          row.gestational_age
                                        }}</span>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.2. LP (DDR):
                                    </td>
                                    <td colspan="12" style="width: 100px">
                                      <div
                                        class="d-flex flex-column"
                                        style="width: 100px"
                                      >
                                        <div
                                          class="
                                            form-check form-check-inline
                                            mb-4
                                          "
                                        >
                                          <label
                                            class="form-check-label"
                                            for="unknown_ddr"
                                            >Unknown LP</label
                                          >
                                          &nbsp
                                          <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="unknown_ddr"
                                            @change="
                                              calculate_ga(row, datIndex)
                                            "
                                            v-model="row.unknown_lpd"
                                            :disabled="
                                              !formEdit.first_screening ||
                                              is_overview
                                            "
                                          />
                                        </div>
                                        <date-picker
                                          v-model="row.ddr"
                                          @input="calculate_ga(row, datIndex)"
                                          v-if="!row.unknown_lpd"
                                          :input-debounce="500"
                                          mode="date"
                                          :popover="{
                                            visibility:
                                              !formEdit.first_screening ||
                                              is_overview
                                                ? 'hidden'
                                                : 'click',
                                          }"
                                          :model-config="accessory.dateConfig"
                                          :masks="accessory.dateConfig.masks"
                                          :max-date="new Date()"
                                          :min-date="eightMonthsAgo"
                                        >
                                          <template
                                            v-slot="{ inputValue, inputEvents }"
                                          >
                                            <input
                                              class="
                                                date-picker-narrow
                                                bg-white
                                                border
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
                                        <span
                                          class="text-danger mt-2 text-wrap"
                                          v-if="
                                            formEdit.first_screening &&
                                            $v.formData.$each[datIndex]
                                              .first_screening.$each[rowIndex]
                                              .ddr.$error
                                          "
                                          >You must choose the LP</span
                                        >
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.3. EDD (DPA):
                                    </td>
                                    <td colspan="12" style="width: 180px">
                                      <div style="width: 180px">
                                        <div>
                                          <date-picker
                                            :value="selected_due_date(row)"
                                            mode="date"
                                            :model-config="accessory.dateConfig"
                                            :masks="accessory.dateConfig.masks"
                                            :popover="{ visibility: 'hidden' }"
                                            :style="{
                                              display: selected_due_date(row)
                                                ? 'initial'
                                                : 'none',
                                            }"
                                          >
                                            <template
                                              v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                            >
                                              <input
                                                class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                                :value="inputValue"
                                                v-on="inputEvents"
                                                readonly
                                                disabled
                                              />
                                            </template>
                                          </date-picker>
                                        </div>
                                        <span
                                          class="text-danger text-break"
                                          style="white-space: normal !important"
                                          v-if="
                                            formEdit.first_screening &&
                                            !$v.formData.$each[datIndex]
                                              .first_screening.$each[rowIndex]
                                              .edd_method.selected_date_required
                                          "
                                        >
                                          The date to be used must have a
                                          value<br />
                                        </span>
                                        <span
                                          class="text-danger text-break"
                                          style="white-space: normal !important"
                                          v-if="
                                            formEdit.first_screening &&
                                            !$v.formData.$each[datIndex]
                                              .first_screening.$each[rowIndex]
                                              .edd_method
                                              .must_be_ultrasound_if_five_days_difference
                                          "
                                        >
                                          You must use the ultrasound date
                                          because it differs by more than 5
                                          days<br />
                                        </span>
                                        <label>To be used</label>
                                        [&nbsp;
                                        <select
                                          v-model="row.edd_method"
                                          @change="calculate_ga(row, datIndex)"
                                          :class="{
                                            'border border-danger':
                                              formEdit.first_screening &&
                                              $v.formData.$each[datIndex]
                                                .first_screening.$each[rowIndex]
                                                .edd_method.$error,
                                          }"
                                          :disabled="
                                            !formEdit.first_screening ||
                                            is_overview
                                          "
                                        >
                                          <option
                                            value="calc"
                                            v-if="!row.unknown_lpd"
                                          >
                                            calc
                                          </option>
                                          <option value="echo">echo</option>
                                          <option value="corrected">
                                            corrected
                                          </option>
                                        </select>
                                        &nbsp;]

                                        <div class="position-relative">
                                          <small
                                            :class="{
                                              'text-white bg-success':
                                                row.edd_method === 'calc',
                                            }"
                                            class="mr-4"
                                            >Calc:</small
                                          >
                                          <span
                                            v-if="row.unknown_lpd"
                                            style="
                                              font-size: 12px;
                                              position: absolute;
                                              left: 0;
                                              top: 0;
                                            "
                                            ><br />Unknown</span
                                          >
                                          <date-picker
                                            v-model="row.edd_calculated"
                                            :input-debounce="500"
                                            mode="date"
                                            :model-config="accessory.dateConfig"
                                            :masks="accessory.dateConfig.masks"
                                            :min-date="new Date()"
                                            :popover="{ visibility: 'hidden' }"
                                            :style="{
                                              visibility: !row.unknown_lpd
                                                ? 'visible'
                                                : 'hidden',
                                            }"
                                          >
                                            <template
                                              v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                            >
                                              <input
                                                class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                                :value="inputValue"
                                                v-on="inputEvents"
                                                readonly
                                                disabled
                                                :class="{
                                                  'text-success':
                                                    row.edd_method === 'calc',
                                                }"
                                              />
                                            </template>
                                          </date-picker>
                                        </div>

                                        <div>
                                          <small
                                            :class="{
                                              'text-white bg-success':
                                                row.edd_method === 'echo',
                                            }"
                                            class="mr-6"
                                            >US:
                                          </small>
                                          <date-picker
                                            v-model="row.edd_ultrasound"
                                            :ref="`first_ultrasound${datIndex}`"
                                            @popoverWillShow="
                                              move_ultrasound_date_picker(
                                                `first_ultrasound${datIndex}`,
                                                rowIndex,
                                                row,
                                                datIndex
                                              )
                                            "
                                            @input="calculate_ga(row, datIndex)"
                                            :input-debounce="500"
                                            mode="date"
                                            :model-config="accessory.dateConfig"
                                            :masks="accessory.dateConfig.masks"
                                            :min-date="new Date()"
                                            :popover="{
                                              visibility:
                                                !formEdit.first_screening ||
                                                is_overview
                                                  ? 'hidden'
                                                  : 'click',
                                            }"
                                          >
                                            <template
                                              v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                            >
                                              <input
                                                class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                                :value="inputValue"
                                                v-on="inputEvents"
                                                readonly
                                                :class="{
                                                  'text-success':
                                                    row.edd_method === 'echo',
                                                  error:
                                                    formEdit.first_screening &&
                                                    $v.formData.$each[datIndex]
                                                      .first_screening.$each[
                                                      rowIndex
                                                    ].edd_ultrasound.$error,
                                                }"
                                              />
                                            </template>
                                          </date-picker>
                                        </div>
                                        <div>
                                          <small
                                            :class="{
                                              'text-white bg-success':
                                                row.edd_method === 'corrected',
                                            }"
                                            >Corrected:
                                          </small>
                                          <date-picker
                                            v-model="row.edd_corrected"
                                            :ref="`first_corrected${datIndex}`"
                                            @popoverWillShow="
                                              move_ultrasound_date_picker(
                                                `first_corrected${datIndex}`,
                                                rowIndex,
                                                row,
                                                datIndex
                                              )
                                            "
                                            @input="calculate_ga(row, datIndex)"
                                            :input-debounce="500"
                                            mode="date"
                                            :model-config="accessory.dateConfig"
                                            :masks="accessory.dateConfig.masks"
                                            :min-date="new Date()"
                                            :popover="{
                                              visibility:
                                                !formEdit.first_screening ||
                                                is_overview
                                                  ? 'hidden'
                                                  : 'click',
                                            }"
                                          >
                                            <template
                                              v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                            >
                                              <input
                                                class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                                :value="inputValue"
                                                v-on="inputEvents"
                                                readonly
                                                :class="{
                                                  'text-success':
                                                    row.edd_method ===
                                                    'corrected',
                                                }"
                                              />
                                            </template>
                                          </date-picker>
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.4. Intrauterine:
                                    </td>
                                    <td>
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row.intrauterine"
                                        :readonly="
                                          !formEdit.first_screening ||
                                          is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.5. Embryo visible:
                                    </td>
                                    <td>
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row.embryo_visible"
                                        :readonly="
                                          !formEdit.first_screening ||
                                          is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.6. Heartbeat:
                                    </td>
                                    <td>
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row.heartbeat"
                                        :readonly="
                                          !formEdit.first_screening ||
                                          is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.7. Parameters:
                                    </td>
                                    <td colspan="12">
                                      <table
                                        class="table table-borderless"
                                        style="width: 400px"
                                      >
                                        <tr>
                                          <td>HC</td>
                                          <td>AC</td>
                                          <td>FL</td>
                                          <td>GS</td>
                                          <td>CRL</td>
                                          <td>BPD</td>
                                          <td>EWB</td>
                                          <td>FHR</td>
                                        </tr>
                                        <tr>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.hc"
                                              :readonly="
                                                !formEdit.first_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.ac"
                                              :readonly="
                                                !formEdit.first_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.fl"
                                              :readonly="
                                                !formEdit.first_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.gs"
                                              :readonly="
                                                !formEdit.first_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.crl"
                                              :readonly="
                                                !formEdit.first_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.bpd"
                                              :readonly="
                                                !formEdit.first_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.ewb"
                                              :readonly="
                                                !formEdit.first_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.fhr"
                                              :readonly="
                                                !formEdit.first_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.8. Other:
                                    </td>
                                    <td colspan="4">
                                      <textarea
                                        style="width: 100%"
                                        class="form-control"
                                        v-model="row.other"
                                        :readonly="
                                          !formEdit.first_screening ||
                                          is_overview
                                        "
                                      ></textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.9. Remark and precautions:
                                    </td>
                                    <td colspan="4">
                                      <textarea
                                        style="width: 100%"
                                        class="form-control"
                                        v-model="row.remark"
                                        :readonly="
                                          !formEdit.first_screening ||
                                          is_overview
                                        "
                                      ></textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="
                                        pl-4
                                        text-decoration-underline
                                        align-middle
                                      "
                                      colspan="1"
                                    >
                                      3.10. Medical Staff:
                                    </td>
                                    <td colspan="4">
                                      <v-autocomplete
                                        v-model="row.medical_staff"
                                        :items="medical_staff"
                                        outlined
                                        dense
                                        chips
                                        small-chips
                                        class="mt-4"
                                        :error="
                                          formEdit.first_screening &&
                                          $v.formData.$each[datIndex]
                                            .first_screening.$each[rowIndex]
                                            .medical_staff.$error
                                        "
                                        label="Medical Staff"
                                        multiple
                                        :disabled="
                                          !formEdit.first_screening ||
                                          is_overview
                                        "
                                      ></v-autocomplete>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </v-expansion-panel-content>
                          </v-expansion-panel>

                          <v-expansion-panel
                            v-if="dat.confirmation_of_due_date_screening"
                            :class="{
                              'current-screening':
                                screening_identifier.includes('cdd'),
                            }"
                          >
                            <v-expansion-panel-header>
                              <div class="d-flex align-items-center">
                                <span
                                  ><small>{{
                                    date_format(
                                      dat.confirmation_of_due_date_screening
                                        .created_at
                                    )
                                  }}</small>
                                  - Confirmation of due date screening</span
                                >
                                <v-chip
                                  v-if="screening_identifier.includes('cdd')"
                                  color="#6a6a6a"
                                  text-color="white"
                                  class="ml-1"
                                  >Current Screening</v-chip
                                >
                                <v-chip
                                  v-if="
                                    formEdit.confirmation_of_due_date_screening &&
                                    $v.formData.$each[datIndex]
                                      .confirmation_of_due_date_screening &&
                                    $v.formData.$each[datIndex]
                                      .confirmation_of_due_date_screening.$error
                                  "
                                  color="error"
                                  class="ml-1"
                                  >Errors</v-chip
                                >
                              </div>
                              <div class="float-right">
                                <v-btn
                                  right
                                  x-small
                                  class="ml-4 d-print-none float-right"
                                  color="secondary"
                                  dark
                                  @click.stop="edit('cdd')"
                                  v-if="
                                    can_edit_main_screenings &&
                                    !formEdit.confirmation_of_due_date_screening &&
                                    !is_overview
                                  "
                                >
                                  Edit
                                </v-btn>
                              </div>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                              <table class="table main-table" id="cdd_table">
                                <tbody>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.1. Gestational age:
                                    </td>
                                    <td colspan="12">
                                      <div class="d-flex" style="width: 80px">
                                        <span class="text-center m-1">{{
                                          dat.confirmation_of_due_date_screening
                                            .gestational_age
                                        }}</span>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.2. EDD (DPA):
                                    </td>
                                    <td colspan="12" style="width: 180px">
                                      <div style="width: 180px">
                                        <div>
                                          <date-picker
                                            :value="
                                              selected_due_date(
                                                dat.confirmation_of_due_date_screening
                                              )
                                            "
                                            mode="date"
                                            :model-config="accessory.dateConfig"
                                            :masks="accessory.dateConfig.masks"
                                            :popover="{ visibility: 'hidden' }"
                                            :style="{
                                              display: selected_due_date(
                                                dat.confirmation_of_due_date_screening
                                              )
                                                ? 'initial'
                                                : 'none',
                                            }"
                                          >
                                            <template
                                              v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                            >
                                              <input
                                                class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                                :value="inputValue"
                                                v-on="inputEvents"
                                                readonly
                                                disabled
                                              />
                                            </template>
                                          </date-picker>
                                        </div>
                                        <span
                                          class="text-danger text-break"
                                          style="white-space: normal !important"
                                          v-if="
                                            formEdit.confirmation_of_due_date_screening &&
                                            !$v.formData.$each[datIndex]
                                              .confirmation_of_due_date_screening
                                              .edd_method.selected_date_required
                                          "
                                        >
                                          The date to be used must have a
                                          value<br />
                                        </span>
                                        <span
                                          class="text-danger text-break"
                                          style="white-space: normal !important"
                                          v-if="
                                            formEdit.confirmation_of_due_date_screening &&
                                            !$v.formData.$each[datIndex]
                                              .confirmation_of_due_date_screening
                                              .edd_method
                                              .must_be_ultrasound_if_five_days_difference
                                          "
                                        >
                                          You must use the ultrasound date
                                          because it differs by more than 5
                                          days<br />
                                        </span>
                                        <label>To be used</label>
                                        [&nbsp
                                        <select
                                          v-model="
                                            dat
                                              .confirmation_of_due_date_screening
                                              .edd_method
                                          "
                                          @change="
                                            calculate_ga(
                                              dat.confirmation_of_due_date_screening,
                                              datIndex
                                            )
                                          "
                                          :class="{
                                            'border border-danger':
                                              formEdit.confirmation_of_due_date_screening &&
                                              $v.formData.$each[datIndex]
                                                .confirmation_of_due_date_screening
                                                .edd_method.$error,
                                          }"
                                          :disabled="
                                            !formEdit.confirmation_of_due_date_screening ||
                                            is_overview
                                          "
                                        >
                                          <option
                                            value="calc"
                                            v-if="
                                              !dat.first_screening[0]
                                                .unknown_lpd
                                            "
                                          >
                                            calc
                                          </option>
                                          <option value="echo">echo</option>
                                          <option value="corrected">
                                            corrected
                                          </option>
                                        </select>
                                        &nbsp]

                                        <div class="position-relative">
                                          <small
                                            :class="{
                                              'text-white bg-success':
                                                dat
                                                  .confirmation_of_due_date_screening
                                                  .edd_method === 'calc',
                                            }"
                                            class="mr-4"
                                            >Calc:</small
                                          >
                                          <span
                                            v-if="
                                              dat.first_screening[0].unknown_lpd
                                            "
                                            style="
                                              font-size: 12px;
                                              position: absolute;
                                              left: 0;
                                              top: 0;
                                            "
                                            ><br />Unknown</span
                                          >
                                          <date-picker
                                            v-model="
                                              dat
                                                .confirmation_of_due_date_screening
                                                .edd_calculated
                                            "
                                            :input-debounce="500"
                                            mode="date"
                                            :model-config="accessory.dateConfig"
                                            :masks="accessory.dateConfig.masks"
                                            :min-date="new Date()"
                                            :popover="{ visibility: 'hidden' }"
                                            :style="{
                                              visibility: !dat
                                                .first_screening[0].unknown_lpd
                                                ? 'visible'
                                                : 'hidden',
                                            }"
                                          >
                                            <template
                                              v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                            >
                                              <input
                                                class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                                :value="inputValue"
                                                v-on="inputEvents"
                                                readonly
                                                disabled
                                                :class="{
                                                  'text-success':
                                                    dat
                                                      .confirmation_of_due_date_screening
                                                      .edd_method === 'calc',
                                                }"
                                              />
                                            </template>
                                          </date-picker>
                                        </div>

                                        <div>
                                          <small
                                            :class="{
                                              'text-white bg-success':
                                                dat
                                                  .confirmation_of_due_date_screening
                                                  .edd_method === 'echo',
                                            }"
                                            class="mr-6"
                                            >US:
                                          </small>
                                          <date-picker
                                            v-model="
                                              dat
                                                .confirmation_of_due_date_screening
                                                .edd_ultrasound
                                            "
                                            :ref="`cdd_ultrasound${datIndex}`"
                                            @popoverWillShow="
                                              move_ultrasound_date_picker(
                                                `cdd_ultrasound${datIndex}`,
                                                null,
                                                dat.confirmation_of_due_date_screening,
                                                datIndex
                                              )
                                            "
                                            @input="
                                              calculate_ga(
                                                dat.confirmation_of_due_date_screening,
                                                datIndex
                                              )
                                            "
                                            :input-debounce="500"
                                            mode="date"
                                            :model-config="accessory.dateConfig"
                                            :masks="accessory.dateConfig.masks"
                                            :min-date="new Date()"
                                            :popover="{
                                              visibility:
                                                !formEdit.confirmation_of_due_date_screening ||
                                                is_overview
                                                  ? 'hidden'
                                                  : 'click',
                                            }"
                                          >
                                            <template
                                              v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                            >
                                              <input
                                                class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                                :value="inputValue"
                                                v-on="inputEvents"
                                                readonly
                                                :class="{
                                                  'text-success':
                                                    dat
                                                      .confirmation_of_due_date_screening
                                                      .edd_method === 'echo',
                                                  error:
                                                    formEdit.confirmation_of_due_date_screening &&
                                                    $v.formData.$each[datIndex]
                                                      .confirmation_of_due_date_screening
                                                      .edd_ultrasound.$error,
                                                }"
                                              />
                                            </template>
                                          </date-picker>
                                        </div>
                                        <div>
                                          <small
                                            :class="{
                                              'text-white bg-success':
                                                dat
                                                  .confirmation_of_due_date_screening
                                                  .edd_method === 'corrected',
                                            }"
                                            >Corrected:
                                          </small>
                                          <date-picker
                                            v-model="
                                              dat
                                                .confirmation_of_due_date_screening
                                                .edd_corrected
                                            "
                                            :ref="`cdd_corrected${datIndex}`"
                                            @popoverWillShow="
                                              move_ultrasound_date_picker(
                                                `cdd_corrected${datIndex}`,
                                                null,
                                                dat.confirmation_of_due_date_screening,
                                                datIndex
                                              )
                                            "
                                            @input="
                                              calculate_ga(
                                                dat.confirmation_of_due_date_screening,
                                                datIndex
                                              )
                                            "
                                            :input-debounce="500"
                                            mode="date"
                                            :model-config="accessory.dateConfig"
                                            :masks="accessory.dateConfig.masks"
                                            :min-date="new Date()"
                                            :popover="{
                                              visibility:
                                                !formEdit.confirmation_of_due_date_screening ||
                                                is_overview
                                                  ? 'hidden'
                                                  : 'click',
                                            }"
                                          >
                                            <template
                                              v-slot="{
                                                inputValue,
                                                inputEvents,
                                              }"
                                            >
                                              <input
                                                class="
                                                  date-picker
                                                  bg-white
                                                  form-control form-control-sm
                                                  px-2
                                                  py-1
                                                  rounded
                                                "
                                                :value="inputValue"
                                                v-on="inputEvents"
                                                readonly
                                                :class="{
                                                  'text-success':
                                                    dat
                                                      .confirmation_of_due_date_screening
                                                      .edd_method ===
                                                    'corrected',
                                                }"
                                              />
                                            </template>
                                          </date-picker>
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.3. Parameters:
                                    </td>
                                    <td colspan="12">
                                      <table
                                        class="table table-borderless"
                                        style="width: 400px"
                                      >
                                        <tr>
                                          <td>HC</td>
                                          <td>AC</td>
                                          <td>FL</td>
                                          <td>GS</td>
                                          <td>CRL</td>
                                          <td>BPD</td>
                                          <td>EWB</td>
                                          <td>FHR</td>
                                        </tr>
                                        <tr>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="
                                                dat
                                                  .confirmation_of_due_date_screening
                                                  .hc
                                              "
                                              :readonly="
                                                !formEdit.confirmation_of_due_date_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="
                                                dat
                                                  .confirmation_of_due_date_screening
                                                  .ac
                                              "
                                              :readonly="
                                                !formEdit.confirmation_of_due_date_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="
                                                dat
                                                  .confirmation_of_due_date_screening
                                                  .fl
                                              "
                                              :readonly="
                                                !formEdit.confirmation_of_due_date_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="
                                                dat
                                                  .confirmation_of_due_date_screening
                                                  .gs
                                              "
                                              :readonly="
                                                !formEdit.confirmation_of_due_date_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="
                                                dat
                                                  .confirmation_of_due_date_screening
                                                  .crl
                                              "
                                              :readonly="
                                                !formEdit.confirmation_of_due_date_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="
                                                dat
                                                  .confirmation_of_due_date_screening
                                                  .bpd
                                              "
                                              :readonly="
                                                !formEdit.confirmation_of_due_date_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="
                                                dat
                                                  .confirmation_of_due_date_screening
                                                  .ewb
                                              "
                                              :readonly="
                                                !formEdit.confirmation_of_due_date_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="
                                                dat
                                                  .confirmation_of_due_date_screening
                                                  .fhr
                                              "
                                              :readonly="
                                                !formEdit.confirmation_of_due_date_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.4. Other:
                                    </td>
                                    <td colspan="4">
                                      <textarea
                                        style="width: 100%"
                                        class="form-control"
                                        v-model="
                                          dat.confirmation_of_due_date_screening
                                            .other
                                        "
                                        :readonly="
                                          !formEdit.confirmation_of_due_date_screening ||
                                          is_overview
                                        "
                                      ></textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.5. Remark and precautions:
                                    </td>
                                    <td colspan="4">
                                      <textarea
                                        style="width: 100%"
                                        class="form-control"
                                        v-model="
                                          dat.confirmation_of_due_date_screening
                                            .remark
                                        "
                                        :readonly="
                                          !formEdit.confirmation_of_due_date_screening ||
                                          is_overview
                                        "
                                      ></textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="
                                        pl-4
                                        text-decoration-underline
                                        align-middle
                                      "
                                      colspan="1"
                                    >
                                      3.6. Medical Staff:
                                    </td>
                                    <td colspan="4">
                                      <v-autocomplete
                                        v-model="
                                          dat.confirmation_of_due_date_screening
                                            .medical_staff
                                        "
                                        :items="medical_staff"
                                        outlined
                                        dense
                                        chips
                                        small-chips
                                        class="mt-4"
                                        :error="
                                          formEdit.confirmation_of_due_date_screening &&
                                          $v.formData.$each[datIndex]
                                            .confirmation_of_due_date_screening
                                            .medical_staff.$error
                                        "
                                        label="Medical Staff"
                                        multiple
                                        :disabled="
                                          !formEdit.confirmation_of_due_date_screening ||
                                          is_overview
                                        "
                                      ></v-autocomplete>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </v-expansion-panel-content>
                          </v-expansion-panel>

                          <div
                            class="row"
                            v-else-if="formEdit.can_add_cdd && !is_overview"
                          >
                            <div class="m-auto" style="padding: 20px 0px 40px">
                              <v-btn color="primary" @click="add_cdd">
                                Add confirmation of due date screening
                              </v-btn>
                            </div>
                          </div>

                          <v-expansion-panel
                            v-for="(row_1, rowIndex) in dat.second_screening"
                            :key="'ss' + rowIndex"
                            :class="{
                              'current-screening':
                                screening_identifier.includes('2'),
                            }"
                          >
                            <v-expansion-panel-header>
                              <div class="d-flex align-items-center">
                                <span
                                  ><small>{{
                                    date_format(row_1.created_at)
                                  }}</small>
                                  - II. Screening 18+0 bis 21+6 GA</span
                                >
                                <v-chip
                                  v-if="screening_identifier.includes('2')"
                                  color="#6a6a6a"
                                  text-color="white"
                                  class="ml-1"
                                  >Current Screening</v-chip
                                >
                                <v-chip
                                  v-if="
                                    formEdit.second_screening &&
                                    $v.formData.$each[datIndex].second_screening
                                      .$each[rowIndex] &&
                                    $v.formData.$each[datIndex].second_screening
                                      .$each[rowIndex].$error
                                  "
                                  color="error"
                                  class="ml-1"
                                  >Errors</v-chip
                                >
                              </div>
                              <div class="float-right">
                                <v-btn
                                  right
                                  x-small
                                  class="ml-4 d-print-none float-right"
                                  color="secondary"
                                  dark
                                  @click.stop="edit(2)"
                                  v-if="
                                    rowIndex === 0 &&
                                    can_edit_main_screenings &&
                                    !formEdit.second_screening &&
                                    !is_overview
                                  "
                                >
                                  Edit
                                </v-btn>
                                <v-btn
                                  right
                                  small
                                  class="ml-4 d-print-none float-right"
                                  color="primary"
                                  v-if="
                                    rowIndex === 0 &&
                                    formEdit.second_screening &&
                                    !is_overview
                                  "
                                  @click.stop="row_push(dat.id, 2)"
                                  icon
                                >
                                  <v-icon dark>mdi-plus-circle-outline</v-icon>
                                </v-btn>
                                <v-btn
                                  right
                                  small
                                  class="ml-4 d-print-none float-right"
                                  color="red"
                                  v-if="
                                    can_delete(row_1) &&
                                    formEdit.second_screening &&
                                    rowIndex > 0 &&
                                    !is_overview
                                  "
                                  @click.stop="
                                    row_delete(datIndex, 2, rowIndex)
                                  "
                                  icon
                                >
                                  <v-icon dark>mdi-minus-circle-outline</v-icon>
                                </v-btn>
                              </div>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                              <table class="table main-table">
                                <tbody>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.1. Gestational age:
                                    </td>
                                    <td colspan="12">
                                      <div class="d-flex" style="width: 80px">
                                        <span class="text-center m-1">{{
                                          row_1.gestational_age
                                        }}</span>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.2. EDD (DPA):
                                    </td>
                                    <td
                                      colspan="12"
                                      style="width: 180px !important"
                                    >
                                      <div>
                                        <small class="mr-6">US: </small>
                                        <date-picker
                                          v-model="row_1.edd_ultrasound"
                                          :ref="`second_ultrasound${datIndex}`"
                                          @popoverWillShow="
                                            move_ultrasound_date_picker(
                                              `second_ultrasound${datIndex}`,
                                              rowIndex,
                                              row_1,
                                              datIndex
                                            )
                                          "
                                          :input-debounce="500"
                                          mode="date"
                                          :model-config="accessory.dateConfig"
                                          :masks="accessory.dateConfig.masks"
                                          :min-date="new Date()"
                                          :popover="{
                                            visibility:
                                              !formEdit.second_screening ||
                                              is_overview
                                                ? 'hidden'
                                                : 'click',
                                          }"
                                        >
                                          <template
                                            v-slot="{ inputValue, inputEvents }"
                                          >
                                            <input
                                              class="
                                                date-picker
                                                bg-white
                                                form-control form-control-sm
                                                px-2
                                                py-1
                                                rounded
                                              "
                                              :value="inputValue"
                                              v-on="inputEvents"
                                              readonly
                                              :class="{
                                                error:
                                                  formEdit.second_screening &&
                                                  $v.formData.$each[datIndex]
                                                    .second_screening.$each[
                                                    rowIndex
                                                  ].edd_ultrasound.$error,
                                              }"
                                            />
                                          </template>
                                        </date-picker>
                                        <span
                                          v-if="
                                            edd_ultrasound_warning(
                                              row_1,
                                              datIndex
                                            )
                                          "
                                          class="text-wrap text-danger"
                                          >Action needed. US EDD is not close to
                                          pregnancy EDD.</span
                                        >
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.3. Proportional growth:
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row_1.normal_growth"
                                        :readonly="
                                          !formEdit.second_screening ||
                                          is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.4. Heartbeat:
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row_1.heartbeat"
                                        :readonly="
                                          !formEdit.second_screening ||
                                          is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.5. Placenta:
                                    </td>
                                    <td colspan="4">
                                      <select
                                        v-model="row_1.placenta_type"
                                        :disabled="
                                          !formEdit.second_screening ||
                                          is_overview
                                        "
                                        :class="{
                                          'border border-danger':
                                            formEdit.second_screening &&
                                            $v.formData.$each[datIndex]
                                              .second_screening.$each[rowIndex]
                                              .placenta_type.$error,
                                        }"
                                      >
                                        <option></option>
                                        <option v-for="type in placenta_type">
                                          {{ type.name }}
                                        </option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.6. Amniotic liquid:
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="ma-0 pa-0 small"
                                        v-model="row_1.normal_amniotic_fluid"
                                        :readonly="
                                          !formEdit.second_screening ||
                                          is_overview
                                        "
                                        hide-details
                                      >
                                        <v-radio
                                          label="P"
                                          color="red"
                                          value="poly"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="N"
                                          color="red"
                                          value="normal"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="O"
                                          color="red"
                                          value="olygo"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.7. Suspicion for malformation:
                                    </td>
                                    <td colspan="12">
                                      <table class="table table-borderless">
                                        <tr>
                                          <td>
                                            <v-radio-group
                                              row
                                              class="ma-0 pa-0 small"
                                              v-model="
                                                row_1.suspicion_for_malformation
                                              "
                                              :readonly="
                                                !formEdit.second_screening ||
                                                is_overview
                                              "
                                              hide-details
                                            >
                                              <v-radio
                                                label="Yes"
                                                color="success"
                                                value="yes"
                                                class="radio"
                                              ></v-radio>
                                              <v-radio
                                                label="No"
                                                color="red"
                                                value="no"
                                                class="radio"
                                              ></v-radio>
                                            </v-radio-group>
                                          </td>
                                          <td>
                                            <v-text-field
                                              label="explanation"
                                              hide-details
                                              :readonly="
                                                !formEdit.second_screening ||
                                                is_overview
                                              "
                                              :disabled="
                                                row_1.suspicion_for_malformation !==
                                                'yes'
                                              "
                                              v-model="
                                                row_1.malformation_explanation
                                              "
                                            >
                                            </v-text-field>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.8. Position:
                                    </td>
                                    <td colspan="4">
                                      <select
                                        v-model="row_1.position_of_baby"
                                        :disabled="
                                          !formEdit.second_screening ||
                                          is_overview
                                        "
                                        :class="{
                                          'border border-danger':
                                            formEdit.second_screening &&
                                            $v.formData.$each[datIndex]
                                              .second_screening.$each[rowIndex]
                                              .position_of_baby.$error,
                                        }"
                                      >
                                        <option
                                          v-for="item in position_of_baby"
                                        >
                                          {{ item.name }}
                                        </option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.9. Presentation:
                                    </td>
                                    <td colspan="4">
                                      <select
                                        v-model="row_1.presentation_of_baby"
                                        :disabled="
                                          !formEdit.second_screening ||
                                          is_overview
                                        "
                                        :class="{
                                          'border border-danger':
                                            formEdit.second_screening &&
                                            $v.formData.$each[datIndex]
                                              .second_screening.$each[rowIndex]
                                              .presentation_of_baby.$error,
                                        }"
                                      >
                                        <option
                                          v-for="item in presentation_of_baby"
                                        >
                                          {{ item.name }}
                                        </option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.10. Parameters:
                                    </td>
                                    <td colspan="12">
                                      <table
                                        class="table table-borderless"
                                        style="width: 400px"
                                      >
                                        <tr>
                                          <td>HC</td>
                                          <td>AC</td>
                                          <td>FL</td>
                                          <td>GS</td>
                                          <td>CRL</td>
                                          <td>BPD</td>
                                          <td>EWB</td>
                                          <td>FHR</td>
                                        </tr>
                                        <tr>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_1.hc"
                                              :readonly="
                                                !formEdit.second_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_1.ac"
                                              :readonly="
                                                !formEdit.second_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_1.fl"
                                              :readonly="
                                                !formEdit.second_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_1.gs"
                                              :readonly="
                                                !formEdit.second_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_1.crl"
                                              :readonly="
                                                !formEdit.second_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_1.bpd"
                                              :readonly="
                                                !formEdit.second_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_1.ewb"
                                              :readonly="
                                                !formEdit.second_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_1.fhr"
                                              :readonly="
                                                !formEdit.second_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.11. Other:
                                    </td>
                                    <td colspan="4">
                                      <textarea
                                        style="width: 100%"
                                        class="form-control"
                                        v-model="row_1.other"
                                        :readonly="
                                          !formEdit.second_screening ||
                                          is_overview
                                        "
                                      ></textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.12. Remark and precautions:
                                    </td>
                                    <td colspan="4">
                                      <textarea
                                        style="width: 100%"
                                        class="form-control"
                                        v-model="row_1.remark"
                                        :readonly="
                                          !formEdit.second_screening ||
                                          is_overview
                                        "
                                      ></textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="
                                        pl-4
                                        text-decoration-underline
                                        align-middle
                                      "
                                      colspan="1"
                                    >
                                      3.13. Medical Staff:
                                    </td>
                                    <td colspan="4">
                                      <v-autocomplete
                                        v-model="row_1.medical_staff"
                                        :items="medical_staff"
                                        outlined
                                        dense
                                        chips
                                        small-chips
                                        class="mt-4"
                                        :error="
                                          formEdit.second_screening &&
                                          $v.formData.$each[datIndex]
                                            .second_screening.$each[rowIndex]
                                            .medical_staff.$error
                                        "
                                        label="Medical Staff"
                                        multiple
                                        :disabled="
                                          !formEdit.second_screening ||
                                          is_overview
                                        "
                                      ></v-autocomplete>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </v-expansion-panel-content>
                          </v-expansion-panel>

                          <v-expansion-panel
                            v-for="(row_2, rowIndex) in dat.third_screening"
                            :key="'ts' + rowIndex"
                            :class="{
                              'current-screening':
                                screening_identifier.includes('3'),
                            }"
                          >
                            <v-expansion-panel-header>
                              <div class="d-flex align-items-center">
                                <span
                                  ><small>{{
                                    date_format(row_2.created_at)
                                  }}</small>
                                  - III. Screening 28+0 bis 31+6 GA</span
                                >
                                <v-chip
                                  v-if="screening_identifier.includes('3')"
                                  color="#6a6a6a"
                                  text-color="white"
                                  class="ml-1"
                                  >Current Screening</v-chip
                                >
                                <v-chip
                                  v-if="
                                    formEdit.third_screening &&
                                    $v.formData.$each[datIndex].third_screening
                                      .$each[rowIndex] &&
                                    $v.formData.$each[datIndex].third_screening
                                      .$each[rowIndex].$error
                                  "
                                  color="error"
                                  class="ml-1"
                                  >Errors</v-chip
                                >
                              </div>
                              <div class="float-right">
                                <v-btn
                                  right
                                  x-small
                                  class="ml-4 d-print-none float-right"
                                  v-if="
                                    rowIndex === 0 &&
                                    can_edit_main_screenings &&
                                    !formEdit.third_screening &&
                                    !is_overview
                                  "
                                  color="secondary"
                                  dark
                                  @click.stop="edit(3)"
                                >
                                  Edit
                                </v-btn>
                                <v-btn
                                  right
                                  small
                                  class="ml-4 d-print-none float-right"
                                  color="primary"
                                  v-if="
                                    rowIndex === 0 &&
                                    formEdit.third_screening &&
                                    !is_overview
                                  "
                                  @click.stop="row_push(dat.id, 3)"
                                  icon
                                >
                                  <v-icon dark>mdi-plus-circle-outline</v-icon>
                                </v-btn>
                                <v-btn
                                  right
                                  small
                                  class="ml-4 d-print-none float-right"
                                  color="red"
                                  v-if="
                                    can_delete(row_2) &&
                                    formEdit.third_screening &&
                                    rowIndex > 0 &&
                                    !is_overview
                                  "
                                  @click.stop="
                                    row_delete(datIndex, 3, rowIndex)
                                  "
                                  icon
                                >
                                  <v-icon dark>mdi-minus-circle-outline</v-icon>
                                </v-btn>
                              </div>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                              <table class="table main-table">
                                <tbody>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.1. Gestational age:
                                    </td>
                                    <td colspan="12">
                                      <div class="d-flex" style="width: 80px">
                                        <span class="text-center m-1">{{
                                          row_2.gestational_age
                                        }}</span>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.2. EDD (DPA):
                                    </td>
                                    <td
                                      colspan="12"
                                      style="width: 180px !important"
                                    >
                                      <div>
                                        <small class="mr-6">US: </small>
                                        <date-picker
                                          v-model="row_2.edd_ultrasound"
                                          :ref="`third_ultrasound${datIndex}`"
                                          @popoverWillShow="
                                            move_ultrasound_date_picker(
                                              `third_ultrasound${datIndex}`,
                                              rowIndex,
                                              row_2,
                                              datIndex
                                            )
                                          "
                                          :input-debounce="500"
                                          mode="date"
                                          :model-config="accessory.dateConfig"
                                          :masks="accessory.dateConfig.masks"
                                          :min-date="new Date()"
                                          :popover="{
                                            visibility:
                                              !formEdit.third_screening ||
                                              is_overview
                                                ? 'hidden'
                                                : 'click',
                                          }"
                                        >
                                          <template
                                            v-slot="{ inputValue, inputEvents }"
                                          >
                                            <input
                                              class="
                                                date-picker
                                                bg-white
                                                form-control form-control-sm
                                                px-2
                                                py-1
                                                rounded
                                              "
                                              :value="inputValue"
                                              v-on="inputEvents"
                                              readonly
                                              :class="{
                                                error:
                                                  formEdit.third_screening &&
                                                  $v.formData.$each[datIndex]
                                                    .third_screening.$each[
                                                    rowIndex
                                                  ].edd_ultrasound.$error,
                                              }"
                                            />
                                          </template>
                                        </date-picker>
                                        <span
                                          v-if="
                                            edd_ultrasound_warning(
                                              row_2,
                                              datIndex
                                            )
                                          "
                                          class="text-wrap text-danger"
                                          >Action needed. US EDD is not close to
                                          pregnancy EDD.</span
                                        >
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.3. Placenta:
                                    </td>
                                    <td>
                                      <select
                                        v-model="row_2.placenta_type"
                                        :disabled="
                                          !formEdit.third_screening ||
                                          is_overview
                                        "
                                        :class="{
                                          'border border-danger':
                                            formEdit.third_screening &&
                                            $v.formData.$each[datIndex]
                                              .third_screening.$each[rowIndex]
                                              .placenta_type.$error,
                                        }"
                                      >
                                        <option></option>
                                        <option v-for="type in placenta_type">
                                          {{ type.name }}
                                        </option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.4. Normal birth possible:
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row_2.normal_birth"
                                        :readonly="
                                          !formEdit.third_screening ||
                                          is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.5. Normal growth:
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row_2.normal_growth"
                                        :readonly="
                                          !formEdit.third_screening ||
                                          is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.6. Amniotic liquid (AFI):
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row_2.amniotic_liquid"
                                        :readonly="
                                          !formEdit.third_screening ||
                                          is_overview
                                        "
                                      >
                                        <v-radio
                                          label="<5"
                                          value="<5"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="5-20"
                                          value="5-20"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label=">20"
                                          value=">20"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.7. Amniotic liquid (Single pocket):
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row_2.single_pocket"
                                        :readonly="
                                          !formEdit.third_screening ||
                                          is_overview
                                        "
                                      >
                                        <v-radio
                                          label="<2"
                                          value="<2"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label=">10"
                                          value=">10"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.8. Parameters:
                                    </td>
                                    <td colspan="12">
                                      <table
                                        class="table table-borderless"
                                        style="width: 400px"
                                      >
                                        <tr>
                                          <td>HC</td>
                                          <td>AC</td>
                                          <td>FL</td>
                                          <td>GS</td>
                                          <td>CRL</td>
                                          <td>BPD</td>
                                          <td>EWB</td>
                                          <td>FHR</td>
                                        </tr>
                                        <tr>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_2.hc"
                                              :readonly="
                                                !formEdit.third_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_2.ac"
                                              :readonly="
                                                !formEdit.third_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_2.fl"
                                              :readonly="
                                                !formEdit.third_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_2.gs"
                                              :readonly="
                                                !formEdit.third_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_2.crl"
                                              :readonly="
                                                !formEdit.third_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_2.bpd"
                                              :readonly="
                                                !formEdit.third_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_2.ewb"
                                              :readonly="
                                                !formEdit.third_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row_2.fhr"
                                              :readonly="
                                                !formEdit.third_screening ||
                                                is_overview
                                              "
                                            />
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.9. Other:
                                    </td>
                                    <td colspan="4">
                                      <textarea
                                        style="width: 100%"
                                        class="form-control"
                                        v-model="row_2.other"
                                        :readonly="
                                          !formEdit.third_screening ||
                                          is_overview
                                        "
                                      ></textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.10. Remark and precautions:
                                    </td>
                                    <td colspan="4">
                                      <textarea
                                        style="width: 100%"
                                        class="form-control"
                                        v-model="row_2.remark"
                                        :readonly="
                                          !formEdit.third_screening ||
                                          is_overview
                                        "
                                      ></textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="
                                        pl-4
                                        text-decoration-underline
                                        align-middle
                                      "
                                      colspan="1"
                                    >
                                      3.11. Medical Staff:
                                    </td>
                                    <td colspan="4">
                                      <v-autocomplete
                                        v-model="row_2.medical_staff"
                                        :items="medical_staff"
                                        outlined
                                        dense
                                        chips
                                        small-chips
                                        class="mt-4"
                                        :error="
                                          formEdit.third_screening &&
                                          $v.formData.$each[datIndex]
                                            .third_screening.$each[rowIndex]
                                            .medical_staff.$error
                                        "
                                        label="Medical Staff"
                                        multiple
                                        :disabled="
                                          !formEdit.third_screening ||
                                          is_overview
                                        "
                                      ></v-autocomplete>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </v-expansion-panel-content>
                          </v-expansion-panel>

                          <v-expansion-panel
                            v-for="(row, rowIndex) in dat.additional_screening"
                            :key="'as' + rowIndex"
                            :class="{
                              'current-screening':
                                screening_identifier.includes('additional') &&
                                can_edit_additional_screening(
                                  datIndex,
                                  rowIndex
                                ),
                            }"
                          >
                            <v-expansion-panel-header>
                              <div class="d-flex align-items-center">
                                <span
                                  ><small>{{
                                    date_format(row.created_at)
                                  }}</small>
                                  - Additional screening<small>
                                    {{
                                      row.reason_id
                                        ? `(${additional_screening_reason_name(
                                            row.reason_id
                                          )})`
                                        : ""
                                    }}</small
                                  ></span
                                >
                                <v-chip
                                  v-if="
                                    screening_identifier.includes(
                                      'additional'
                                    ) &&
                                    can_edit_additional_screening(
                                      datIndex,
                                      rowIndex
                                    )
                                  "
                                  color="#6a6a6a"
                                  text-color="white"
                                  class="ml-1"
                                  >Current Screening</v-chip
                                >
                                <v-chip
                                  v-if="
                                    can_edit_additional_screening(
                                      datIndex,
                                      rowIndex
                                    ) &&
                                    $v.formData.$each[datIndex]
                                      .additional_screening.$each[rowIndex] &&
                                    $v.formData.$each[datIndex]
                                      .additional_screening.$each[rowIndex]
                                      .$error
                                  "
                                  color="error"
                                  class="ml-1"
                                  >Errors</v-chip
                                >
                              </div>
                              <div class="float-right">
                                <v-btn
                                  right
                                  x-small
                                  class="ml-4 d-print-none float-right"
                                  v-if="
                                    !can_edit_additional_screening(
                                      datIndex,
                                      rowIndex
                                    ) && !is_overview
                                  "
                                  color="secondary"
                                  dark
                                  @click.stop="
                                    edit(`additional:${datIndex},${rowIndex}`)
                                  "
                                >
                                  Edit
                                </v-btn>
                                <v-btn
                                  right
                                  small
                                  class="ml-4 d-print-none float-right"
                                  color="red"
                                  v-if="
                                    can_delete(row) &&
                                    can_edit_additional_screening(
                                      datIndex,
                                      rowIndex
                                    ) &&
                                    !is_overview
                                  "
                                  @click.stop="
                                    row_delete(datIndex, 'additional', rowIndex)
                                  "
                                  icon
                                >
                                  <v-icon dark>mdi-minus-circle-outline</v-icon>
                                </v-btn>
                              </div>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                              <table
                                class="table main-table"
                                id="additional_table"
                              >
                                <tbody>
                                  <tr>
                                    <td>
                                      <div class="d-flex flex-column">
                                        <label>Screening reason:</label>
                                        <select
                                          v-model="row.reason_id"
                                          :disabled="
                                            !can_edit_additional_screening(
                                              datIndex,
                                              rowIndex
                                            ) || is_overview
                                          "
                                          :class="{
                                            'border border-danger':
                                              can_edit_additional_screening(
                                                datIndex,
                                                rowIndex
                                              ) &&
                                              $v.formData.$each[datIndex]
                                                .additional_screening.$each[
                                                rowIndex
                                              ].reason_id.$error,
                                          }"
                                        >
                                          <option></option>
                                          <option
                                            :key="'as_reason' + type.id"
                                            v-for="type in additional_screening_reasons"
                                            :value="type.id"
                                          >
                                            {{ type.name }}
                                          </option>
                                        </select>
                                      </div>
                                      <div class="form-check form-inline">
                                        <v-text-field
                                          label="explanation"
                                          hide-details
                                          v-model="row.reason_explanation"
                                          :readonly="
                                            !can_edit_additional_screening(
                                              datIndex,
                                              rowIndex
                                            ) || is_overview
                                          "
                                          :class="{
                                            'border border-danger':
                                              can_edit_additional_screening(
                                                datIndex,
                                                rowIndex
                                              ) &&
                                              $v.formData.$each[datIndex]
                                                .additional_screening.$each[
                                                rowIndex
                                              ].reason_explanation.$error,
                                          }"
                                        >
                                        </v-text-field>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.1. Gestational age:
                                    </td>
                                    <td colspan="12">
                                      <div class="d-flex" style="width: 80px">
                                        <span class="text-center m-1">{{
                                          row.gestational_age
                                        }}</span>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.2. EDD (DPA):
                                    </td>
                                    <td
                                      colspan="12"
                                      style="width: 180px !important"
                                    >
                                      <div>
                                        <small class="mr-6">US: </small>
                                        <date-picker
                                          v-model="row.edd_ultrasound"
                                          :ref="`additional_ultrasound${datIndex}`"
                                          @popoverWillShow="
                                            move_ultrasound_date_picker(
                                              `additional_ultrasound${datIndex}`,
                                              rowIndex,
                                              row,
                                              datIndex
                                            )
                                          "
                                          :input-debounce="500"
                                          mode="date"
                                          :model-config="accessory.dateConfig"
                                          :masks="accessory.dateConfig.masks"
                                          :min-date="new Date()"
                                          :popover="{
                                            visibility:
                                              !can_edit_additional_screening(
                                                datIndex,
                                                rowIndex
                                              ) || is_overview
                                                ? 'hidden'
                                                : 'click',
                                          }"
                                        >
                                          <template
                                            v-slot="{ inputValue, inputEvents }"
                                          >
                                            <input
                                              class="
                                                date-picker
                                                bg-white
                                                form-control form-control-sm
                                                px-2
                                                py-1
                                                rounded
                                              "
                                              :value="inputValue"
                                              v-on="inputEvents"
                                              readonly
                                              :class="{
                                                error:
                                                  can_edit_additional_screening(
                                                    datIndex,
                                                    rowIndex
                                                  ) &&
                                                  $v.formData.$each[datIndex]
                                                    .additional_screening.$each[
                                                    rowIndex
                                                  ].edd_ultrasound.$error,
                                              }"
                                            />
                                          </template>
                                        </date-picker>
                                        <span
                                          v-if="
                                            edd_ultrasound_warning(
                                              row,
                                              datIndex
                                            )
                                          "
                                          class="text-wrap text-danger"
                                          >Action needed. US EDD is not close to
                                          pregnancy EDD.</span
                                        >
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.3. Proportional growth:
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row.normal_growth"
                                        :readonly="
                                          !can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) || is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.4. Heartbeat:
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row.heartbeat"
                                        :readonly="
                                          !can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) || is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.5. Placenta:
                                    </td>
                                    <td colspan="4">
                                      <select
                                        v-model="row.placenta_type"
                                        :disabled="
                                          !can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) || is_overview
                                        "
                                        :class="{
                                          'border border-danger':
                                            can_edit_additional_screening(
                                              datIndex,
                                              rowIndex
                                            ) &&
                                            $v.formData.$each[datIndex]
                                              .additional_screening.$each[
                                              rowIndex
                                            ].placenta_type.$error,
                                        }"
                                      >
                                        <option></option>
                                        <option v-for="type in placenta_type">
                                          {{ type.name }}
                                        </option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.6. Amniotic liquid:
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="ma-0 pa-0 small"
                                        v-model="row.normal_amniotic_fluid"
                                        :readonly="
                                          !can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) || is_overview
                                        "
                                        hide-details
                                      >
                                        <v-radio
                                          label="P"
                                          color="red"
                                          value="poly"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="N"
                                          color="red"
                                          value="normal"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="O"
                                          color="red"
                                          value="olygo"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.7. Suspicion for malformation:
                                    </td>
                                    <td colspan="12">
                                      <table class="table table-borderless">
                                        <tr>
                                          <td>
                                            <v-radio-group
                                              row
                                              class="ma-0 pa-0 small"
                                              v-model="
                                                row.suspicion_for_malformation
                                              "
                                              :readonly="
                                                !can_edit_additional_screening(
                                                  datIndex,
                                                  rowIndex
                                                ) || is_overview
                                              "
                                              hide-details
                                            >
                                              <v-radio
                                                label="Yes"
                                                color="success"
                                                value="yes"
                                                class="radio"
                                              ></v-radio>
                                              <v-radio
                                                label="No"
                                                color="red"
                                                value="no"
                                                class="radio"
                                              ></v-radio>
                                            </v-radio-group>
                                          </td>
                                          <td colspan="4">
                                            <v-text-field
                                              label="explanation"
                                              hide-details
                                              :readonly="
                                                !can_edit_additional_screening(
                                                  datIndex,
                                                  rowIndex
                                                ) || is_overview
                                              "
                                              :disabled="
                                                row.suspicion_for_malformation !==
                                                'yes'
                                              "
                                              v-model="
                                                row.malformation_explanation
                                              "
                                            >
                                            </v-text-field>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.8. Position:
                                    </td>
                                    <td colspan="4">
                                      <select
                                        v-model="row.position_of_baby"
                                        :disabled="
                                          !can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) || is_overview
                                        "
                                        :class="{
                                          'border border-danger':
                                            can_edit_additional_screening(
                                              datIndex,
                                              rowIndex
                                            ) &&
                                            $v.formData.$each[datIndex]
                                              .additional_screening.$each[
                                              rowIndex
                                            ].position_of_baby.$error,
                                        }"
                                      >
                                        <option
                                          v-for="item in position_of_baby"
                                        >
                                          {{ item.name }}
                                        </option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.9. Presentation:
                                    </td>
                                    <td colspan="4">
                                      <select
                                        v-model="row.presentation_of_baby"
                                        :disabled="
                                          !can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) || is_overview
                                        "
                                        :class="{
                                          'border border-danger':
                                            can_edit_additional_screening(
                                              datIndex,
                                              rowIndex
                                            ) &&
                                            $v.formData.$each[datIndex]
                                              .additional_screening.$each[
                                              rowIndex
                                            ].presentation_of_baby.$error,
                                        }"
                                      >
                                        <option
                                          v-for="item in presentation_of_baby"
                                        >
                                          {{ item.name }}
                                        </option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.10. Normal birth possible:
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row.normal_birth"
                                        :readonly="
                                          !can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) || is_overview
                                        "
                                      >
                                        <v-radio
                                          label="Yes"
                                          color="success"
                                          value="yes"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="No"
                                          color="red"
                                          value="no"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.11. Amniotic liquid (AFI):
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row.amniotic_liquid"
                                        :readonly="
                                          !can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) || is_overview
                                        "
                                      >
                                        <v-radio
                                          label="<5"
                                          value="<5"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label="5-20"
                                          value="5-20"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label=">20"
                                          value=">20"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.12. Amniotic liquid (Single pocket):
                                    </td>
                                    <td colspan="4">
                                      <v-radio-group
                                        row
                                        class="mt-0 p-0 small"
                                        v-model="row.single_pocket"
                                        :readonly="
                                          !can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) || is_overview
                                        "
                                      >
                                        <v-radio
                                          label="<2"
                                          value="<2"
                                          class="radio"
                                        ></v-radio>
                                        <v-radio
                                          label=">10"
                                          value=">10"
                                          class="radio"
                                        ></v-radio>
                                      </v-radio-group>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.13. Parameters:
                                    </td>
                                    <td colspan="12">
                                      <table
                                        class="table table-borderless"
                                        style="width: 400px"
                                      >
                                        <tr>
                                          <td>HC</td>
                                          <td>AC</td>
                                          <td>FL</td>
                                          <td>GS</td>
                                          <td>CRL</td>
                                          <td>BPD</td>
                                          <td>EWB</td>
                                          <td>FHR</td>
                                        </tr>
                                        <tr>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.hc"
                                              :readonly="
                                                !can_edit_additional_screening(
                                                  datIndex,
                                                  rowIndex
                                                ) || is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.ac"
                                              :readonly="
                                                !can_edit_additional_screening(
                                                  datIndex,
                                                  rowIndex
                                                ) || is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.fl"
                                              :readonly="
                                                !can_edit_additional_screening(
                                                  datIndex,
                                                  rowIndex
                                                ) || is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.gs"
                                              :readonly="
                                                !can_edit_additional_screening(
                                                  datIndex,
                                                  rowIndex
                                                ) || is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.crl"
                                              :readonly="
                                                !can_edit_additional_screening(
                                                  datIndex,
                                                  rowIndex
                                                ) || is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.bpd"
                                              :readonly="
                                                !can_edit_additional_screening(
                                                  datIndex,
                                                  rowIndex
                                                ) || is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.ewb"
                                              :readonly="
                                                !can_edit_additional_screening(
                                                  datIndex,
                                                  rowIndex
                                                ) || is_overview
                                              "
                                            />
                                          </td>
                                          <td>
                                            <input
                                              type="text"
                                              v-model="row.fhr"
                                              :readonly="
                                                !can_edit_additional_screening(
                                                  datIndex,
                                                  rowIndex
                                                ) || is_overview
                                              "
                                            />
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.14. Other:
                                    </td>
                                    <td colspan="4">
                                      <textarea
                                        style="width: 100%"
                                        class="form-control"
                                        v-model="row.other"
                                        :readonly="
                                          !can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) || is_overview
                                        "
                                      ></textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="pl-4 text-decoration-underline"
                                      colspan="1"
                                    >
                                      3.15. Remark and precautions:
                                    </td>
                                    <td colspan="4">
                                      <textarea
                                        style="width: 100%"
                                        class="form-control"
                                        v-model="row.remark"
                                        :readonly="
                                          !can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) || is_overview
                                        "
                                      ></textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td
                                      class="
                                        pl-4
                                        text-decoration-underline
                                        align-middle
                                      "
                                      colspan="1"
                                    >
                                      3.16. Medical Staff:
                                    </td>
                                    <td colspan="4">
                                      <v-autocomplete
                                        v-model="row.medical_staff"
                                        :items="medical_staff"
                                        outlined
                                        dense
                                        chips
                                        small-chips
                                        class="mt-4"
                                        :error="
                                          can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) &&
                                          $v.formData.$each[datIndex]
                                            .additional_screening.$each[
                                            rowIndex
                                          ].medical_staff.$error
                                        "
                                        label="Medical Staff"
                                        multiple
                                        :disabled="
                                          !can_edit_additional_screening(
                                            datIndex,
                                            rowIndex
                                          ) || is_overview
                                        "
                                      ></v-autocomplete>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </v-expansion-panel-content>
                          </v-expansion-panel>

                          <div class="row" v-if="!is_overview">
                            <div class="m-auto" style="padding: 20px 0px 40px">
                              <v-btn
                                color="primary"
                                @click="add_additional(datIndex)"
                              >
                                Add additional screening
                              </v-btn>
                            </div>
                          </div>
                        </v-expansion-panels>
                      </v-tab-item>
                    </v-tabs>
                  </v-card>
                </v-app>
              </tr>
            </table>
          </div>
          <div class="text-right mt-6" v-if="!is_overview">
            <v-btn color="info" @click.prevent="submit">Submit</v-btn>
          </div>
        </div>
      </div>
    </v-app>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
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
import patientInformation from "../../../../components/patient_information";
import gestationalAge from "../../../../components/gestational_age_control";
import letter_headVue from "../../../../components/templates/letter_head.vue";
import seniorAuthDialog from "../../../../components/senior_auth_dialog.vue";

const validationFunctions = {
  selected_date_required: function (val, vm) {
    if (!val) return true;

    const selected_date = this.selected_due_date(vm);

    if (selected_date) return true;
    else return false;
  },

  must_be_ultrasound_if_five_days_difference: function (val, vm) {
    if (vm && vm.edd_ultrasound && val && val != "echo") {
      const selected_date = this.selected_due_date(vm);
      if (selected_date) {
        const ultrasound_date = new Date(vm.edd_ultrasound);

        const diff = Math.abs(selected_date - ultrasound_date);

        const diff_in_days = Math.round(diff / (1000 * 60 * 60 * 24));
        if (diff_in_days > 5) {
          return false;
        }
      }
    }
    return true;
  },
};

const responsible = window.auth.user.name;

export default {
  name: "ultrasound_form",
  props: ["is_overview", "ultrasound_ref"],
  components: { patientInformation, gestationalAge, seniorAuthDialog },
  mixins: [validationMixin],
  data: () => {
    return {
      formData: [
        {
          id: 0,
          patient_id: "",
          early_screening: null,
          remark_when_ultrasound_neg: "",
          first_screening: [
            {
              id: null,
              created_at: new Date(),
              edd_calculated: null,
              edd_corrected: null,
              edd_ultrasound: null,
              edd_method: null,
              ddr: null,
              unknown_lpd: false,
              gestational_age: null,
              hc: "",
              ac: "",
              fl: "",
              gs: "",
              crl: "",
              fhr: "",
              other: "",
              bpd: "",
              ewb: "",
              intrauterine: null,
              heartbeat: null,
              embryo_visible: null,
              remark: "",
              medical_staff: [],
              status: "new",
              responsible: responsible,
              fetus: 0,
              accessory: {
                previous_ddr: null,
              },
            },
          ],
          confirmation_of_due_date_screening: null,
          second_screening: [],
          third_screening: [],
          additional_screening: [],
        },
      ],
      defaultData: [
        {
          id: 0,
          patient_id: "",
          remark_when_ultrasound_neg: "",
          early_screening: null,
          first_screening: [
            {
              id: null,
              created_at: new Date(),
              edd_calculated: null,
              edd_corrected: null,
              edd_ultrasound: null,
              edd_method: null,
              ddr: null,
              unknown_lpd: false,
              gestational_age: null,
              hc: "",
              ac: "",
              fl: "",
              gs: "",
              crl: "",
              fhr: "",
              other: "",
              bpd: "",
              ewb: "",
              intrauterine: null,
              heartbeat: null,
              embryo_visible: null,
              remark: "",
              medical_staff: [],
              responsible: responsible,
              status: "new",
              fetus: 0,
              accessory: {
                previous_ddr: null,
              },
            },
          ],
          confirmation_of_due_date_screening: null,
          second_screening: [],
          third_screening: [],
          additional_screening: [],
        },
      ],
      first_screening_data: {
        id: null,
        created_at: new Date(),
        edd_calculated: null,
        edd_corrected: null,
        edd_ultrasound: null,
        edd_method: null,
        ddr: null,
        unknown_lpd: false,
        gestational_age: null,
        hc: "",
        ac: "",
        fl: "",
        gs: "",
        crl: "",
        fhr: "",
        other: "",
        bpd: "",
        ewb: "",
        intrauterine: null,
        heartbeat: null,
        embryo_visible: null,
        remark: "",
        medical_staff: [],
        responsible: responsible,
        status: "new",
        fetus: "",
        accessory: {
          previous_ddr: null,
        },
      },
      confirmation_of_due_date_screening_data: {
        id: null,
        created_at: new Date(),
        edd_calculated: null,
        edd_corrected: null,
        edd_ultrasound: null,
        edd_method: null,
        gestational_age: null,
        hc: "",
        ac: "",
        fl: "",
        gs: "",
        crl: "",
        fhr: "",
        bpd: "",
        ewb: "",
        remark: null,
        other: null,
        medical_staff: [],
        responsible: responsible,
        status: "new",
        fetus: "",
      },
      second_screening_data: {
        id: null,
        created_at: new Date(),
        edd_ultrasound: null,
        gestational_age: null,
        hc: "",
        ac: "",
        fl: "",
        gs: "",
        crl: "",
        fhr: "",
        bpd: "",
        other: "",
        ewb: "",
        position_of_baby: "",
        presentation_of_baby: "",
        heartbeat: null,
        placenta_type: "",
        normal_growth: null,
        normal_amniotic_fluid: null,
        suspicion_for_malformation: null,
        malformation_explanation: "",
        remark: "",
        medical_staff: [],
        responsible: responsible,
        status: "new",
        fetus: "",
      },
      third_screening_data: {
        id: null,
        created_at: new Date(),
        edd_ultrasound: null,
        gestational_age: null,
        hc: "",
        ac: "",
        fl: "",
        gs: "",
        crl: "",
        fhr: "",
        other: "",
        bpd: "",
        ewb: "",
        normal_growth: null,
        placenta_type: "",
        normal_birth: "",
        amniotic_liquid: "",
        single_pocket: "",
        wop_equality: "",
        medical_staff: [],
        responsible: responsible,
        status: "new",
        remark: "",
        fetus: "",
      },
      additional_screening_data: {
        id: null,
        created_at: new Date(),
        reason_id: null,
        reason_explanation: null,
        edd_ultrasound: null,
        gestational_age: null,
        hc: "",
        ac: "",
        fl: "",
        gs: "",
        crl: "",
        fhr: "",
        ewb: "",
        bpd: "",
        position_of_baby: "",
        presentation_of_baby: "",
        heartbeat: null,
        normal_growth: null,
        placenta_type: "",
        normal_amniotic_fluid: null,
        suspicion_for_malformation: null,
        malformation_explanation: "",
        normal_birth: "",
        amniotic_liquid: "",
        single_pocket: "",
        wop_equality: "",
        medical_staff: [],
        responsible: responsible,
        status: "new",
        other: "",
        remark: "",
        fetus: "",
      },
      is_patient_pregnant: null,
      isLoading: false,
      dialog: false,
      edit_dialog: false,
      count_of_fetus: 1,
      placenta_type: "",
      position_of_baby: [],
      presentation_of_baby: [],
      additional_screening_reasons: [],
      possible_fetus_count: [1, 2, 3],
      reference: "",
      screening_identifier: "1",
      admission_id: null,
      is_updating: false,
      medical_staff: [
        "Tanja",
        "Tianasoa",
        "Manitra",
        "Finaritra",
        "Dr Martin",
        "Dr Petra",
        "Hobilalaina",
        "Ando",
      ],
      formEdit: {
        first_screening: true,
        early_screening: false,
        confirmation_of_due_date_screening: false,
        can_add_cdd: false,
        second_screening: false,
        third_screening: false,
        additional_screening: [],
      },
      loginForm: {
        id: "",
        password: "",
      },
      patient_id: "",
      remark_when_ultrasound_neg: "",
      authorized_user: false,
      edited_screening: "",
      accessory: {
        dateConfig: {
          type: "string",
          mask: "iso",
          masks: {
            input: "DD/MMM/YYYY",
          },
        },
      },
    };
  },
  created() {
    this.init();
  },
  methods: {
    async init() {
      this.isLoading = true;
      await Promise.allSettled([
        axios
          .get("/api/v1/extra/position_of_baby")
          .then((res) => (this.position_of_baby = res.data)),
        axios
          .get("/api/v1/extra/presentation_of_baby")
          .then((res) => (this.presentation_of_baby = res.data)),
      ]);
      await Promise.allSettled([
        axios
          .get("/api/v1/extra/placenta_type")
          .then((res) => (this.placenta_type = res.data)),
        axios
          .get("/api/v1/extra/ultrasound_additional_screening_reasons")
          .then((res) => (this.additional_screening_reasons = res.data)),
      ]);

      if (
        this.$route.params.patient_id !== "" &&
        this.$route.params.patient_id !== undefined
      ) {
        this.patient_id = this.$route.params.patient_id;
      }
      if (this.$route.params.consultation_id) {
        this.admission_id = this.$route.params.consultation_id;
      }
      if (this.$route.params.ref && this.$route.params.ref !== "") {
        this.reference = this.$route.params.ref;

        await this.search(true);
      } else if (this.ultrasound_ref) {
        this.reference = this.ultrasound_ref;

        await this.search();
      }

      this.isLoading = false;
    },
    set_count_of_fetus() {
      const currentCount = this.formData.length;

      if (currentCount < this.count_of_fetus) {
        for (let i = currentCount; i < this.count_of_fetus; i++) {
          this.push_form_data(i);
        }
      } else if (currentCount > this.count_of_fetus) {
        this.formData.splice(this.count_of_fetus);
      }

      this.dialog = false;
    },
    push_form_data(i) {
      this.formData.push({
        id: i,
        early_screening: null,
        first_screening: [
          {
            id: null,
            created_at: this.formData[0].first_screening[0].created_at,
            edd_calculated:
              this.formData[0].first_screening[0].edd_calculated || null,
            edd_ultrasound: null,
            edd_corrected: null,
            ddr: this.formData[0].first_screening[0].ddr,
            unknown_lpd:
              this.formData[0].first_screening[0].unknown_lpd || false,
            hc: "",
            ac: "",
            fl: "",
            gs: "",
            crl: "",
            fhr: "",
            other: "",
            ewb: "",
            bpd: "",
            intrauterine: null,
            heartbeat: null,
            embryo_visible: null,
            remark: "",
            status: "new",
            medical_staff: [],
            responsible: responsible,
            fetus: i,
          },
        ],
        confirmation_of_due_date_screening: null,
        second_screening: [],
        third_screening: [],
        additional_screening: [],
      });
    },
    get_gestational_age_in_days(ga) {
      if (!ga) return null;
      const parts = ga.split("+");
      if (parts.length !== 2) return null;

      return Number(parts[0]) * 7 + Number(parts[1]);
    },
    calculate_ga(row, datIndex) {
      if (!row.unknown_lpd) {
        if (!row.ddr && row.accessory && row.accessory.previous_ddr) {
          row.ddr = row.accessory.previous_ddr;
        }

        if (row.ddr) {
          let date = new Date(row.ddr);
          date.setDate(date.getDate() + 7);
          date.setMonth(date.getMonth() - 3);
          date.setFullYear(date.getFullYear() + 1);

          row.edd_calculated = new Date(date);

          if (!row.edd_method) row.edd_method = "calc";
        }
      } else {
        if (!row.accessory) row.accessory = {};
        if (row.ddr) row.accessory.previous_ddr = row.ddr;

        row.ddr = null;
        row.edd_calculated = null;

        if (row.edd_method === "calc") {
          if (row.edd_ultrasound) row.edd_method = "echo";
          else if (row.edd_corrected) row.edd_method = "corrected";
          else row.edd_method = null;
        }
      }

      let selectedDate;
      if ("edd_method" in row) {
        selectedDate = this.selected_due_date(row);
      } else {
        selectedDate = this.selected_due_date_for_pregnancy(
          this.formData[datIndex]
        );
      }

      if (selectedDate) {
        const diff = selectedDate - new Date(row.created_at);
        const diff_in_days = Math.round(diff / 1000 / 60 / 60 / 24);

        const ga_in_days = 40 * 7 - diff_in_days;

        const ga_weeks = Math.floor(ga_in_days / 7);
        const ga_days = ga_in_days % 7;

        row.gestational_age = ga_weeks + "+" + ga_days;
      } else {
        row.gestational_age = null;
      }
    },
    move_ultrasound_date_picker(ref, rowIndex, row, datIndex) {
      let date_picker = this.$refs[ref];

      if (date_picker instanceof Array && date_picker.length == 1)
        date_picker = date_picker[0];
      else if (rowIndex != null) date_picker = date_picker[rowIndex];

      const date =
        row.edd_corrected ||
        row.edd_ultrasound ||
        row.edd_calculated ||
        this.selected_due_date_for_pregnancy(this.formData[datIndex]);

      if (date) date_picker.move(date);
    },
    selected_due_date_for_pregnancy(dat) {
      if (dat.confirmation_of_due_date_screening) {
        const cdd_date = this.selected_due_date(
          dat.confirmation_of_due_date_screening
        );
        if (cdd_date) return cdd_date;
      }

      if (dat.first_screening && dat.first_screening.length > 0) {
        const first_due_date = this.selected_due_date(
          dat.first_screening[dat.first_screening.length - 1]
        );
        if (first_due_date) return first_due_date;
      }

      if (dat.early_screening) {
        return this.selected_due_date(dat.early_screening);
      }

      return null;
    },
    selected_due_date(row) {
      if (row && row.edd_method) {
        let selectedDate;
        switch (row.edd_method) {
          case "calc":
            selectedDate = row.edd_calculated;
            break;
          case "echo":
            selectedDate = row.edd_ultrasound;
            break;
          case "corrected":
            selectedDate = row.edd_corrected;
            break;
        }

        if (selectedDate) return new Date(selectedDate);
      }
      return null;
    },
    add_early_screening_if_necessary() {
      if (!this.formEdit.first_screening) return;

      for (let i = 0; i < this.formData.length; i++) {
        if (this.formData[i].early_screening) continue;

        if (this.formData[i].first_screening.length === 1) {
          if (
            this.get_gestational_age_in_days(
              this.formData[i].first_screening[0].gestational_age
            ) < this.get_gestational_age_in_days("8+0")
          ) {
            this.formData[i].early_screening = Object.assign(
              {},
              this.formData[i].first_screening[0]
            );
            this.formData[i].first_screening[0] = Object.assign(
              {},
              this.first_screening_data
            );
            this.screening_identifier = "early";
          }
        }
      }
    },
    async submit(e) {
      e.preventDefault();

      if (this.is_patient_pregnant) {
        this.$v.$touch();

        if (this.formEdit.additional_screening.length > 0) {
          if (
            !this.formData
              .map((_, i) => {
                if (i in this.formEdit.additional_screening) {
                  return this.formData[i].additional_screening
                    .map((_, j) => {
                      if (this.formEdit.additional_screening[i].includes(j))
                        return this.$v.formData.$each[i].additional_screening
                          .$each[j].$invalid;
                      return false;
                    })
                    .every((x) => x == false);
                }

                return true;
              })
              .every((x) => x === true)
          ) {
            return;
          }
        } else {
          if (
            !this.formData
              .map((_, i) => {
                if (this.formEdit.early_screening) {
                  return (
                    this.$v.formData.$each[i].early_screening.$invalid == false
                  );
                } else if (this.formEdit.first_screening) {
                  return this.formData[i].first_screening
                    .map(
                      (_, j) =>
                        this.$v.formData.$each[i].first_screening.$each[j]
                          .$invalid
                    )
                    .every((x) => x == false);
                } else if (this.formEdit.confirmation_of_due_date_screening) {
                  return (
                    this.$v.formData.$each[i].confirmation_of_due_date_screening
                      .$invalid == false
                  );
                } else if (this.formEdit.second_screening) {
                  return this.formData[i].second_screening
                    .map(
                      (_, j) =>
                        this.$v.formData.$each[i].second_screening.$each[j]
                          .$invalid
                    )
                    .every((x) => x == false);
                } else if (this.formEdit.third_screening) {
                  return this.formData[i].third_screening
                    .map(
                      (_, j) =>
                        this.$v.formData.$each[i].third_screening.$each[j]
                          .$invalid
                    )
                    .every((x) => x == false);
                } else {
                  console.log(
                    "No screening selected for edit. Not submitting."
                  );
                  return false;
                }
              })
              .every((x) => x === true)
          ) {
            return;
          }
        }

        this.add_early_screening_if_necessary();

        if (this.screening_identifier.includes("additional"))
          this.screening_identifier = "additional";
      }

      await axios
        .post("/api/v1/patient_system/out_patient/obstetrical/ultrasound", {
          formData: this.formData,
          screening: this.screening_identifier,
          patient_id: this.patient_id,
          admission_id: this.admission_id,
          is_patient_pregnant: this.is_patient_pregnant,
          remark_when_ultrasound_neg: this.remark_when_ultrasound_neg,
          count_of_fetus: this.count_of_fetus,
          ref: this.reference,
        })
        .then((resp) => {
          this.$toast.open({
            message: `${resp.data.msg}`,
            position: "top-right",
            type: "success",
            duration: 0,
          });
        })
        .then((x) => {
          this.$router.push({ name: "ultrasound_list" });
        })
        .catch((e) => {
          console.log(e);
          this.$toast.open({
            message: `${e} `,
            position: "top-right",
            type: "error",
            duration: 0,
          });
        });
    },
    async search(preserve_admission_id) {
      const reference = this.reference;
      if (!reference) {
        this.reset();
        return;
      }

      this.is_updating = true;
      let response = await axios.get(
        `/api/v1/patient_system/out_patient/obstetrical/ultrasound/${reference}`
      );
      this.count_of_fetus = response.data.count;
      this.is_patient_pregnant =
        response.data.is_patient_pregnant == 1 ? true : false;

      let early_data = [];
      let first_data = [];
      let cdd_data = [];
      let second_data = [];
      let third_data = [];
      let additional_data = [];
      let output = [];
      for (let i = 0; i < this.count_of_fetus; i++) {
        if (response.data.early.length > 0) {
          early_data = response.data.early;
        }

        if (response.data.first.length > 0) {
          first_data = response.data.first;

          this.formEdit.first_screening = false;
          this.formEdit.third_screening = false;
          if (response.data.confirmation_of_due_date.length == 0) {
            // When first screening is too late, a confirmation of due date screening should happen
            if (
              this.get_gestational_age_in_days(
                first_data[i][0].gestational_age
              ) > this.get_gestational_age_in_days("11+6")
            ) {
              this.formEdit.can_add_cdd = true;
            }
            this.screening_identifier = "2";
            this.formEdit.first_screening = false;
            this.formEdit.confirmation_of_due_date_screening = false;
            this.formEdit.second_screening = true;
            this.formEdit.third_screening = false;
          } else {
            cdd_data = response.data.confirmation_of_due_date;

            this.screening_identifier = "2";
            this.formEdit.first_screening = false;
            this.formEdit.confirmation_of_due_date_screening = false;
            this.formEdit.second_screening = true;
            this.formEdit.third_screening = false;
          }
        } else {
          this.first_screening_data.fetus = i;

          if (early_data && early_data.length > i) {
            this.first_screening_data.ddr = early_data[i].ddr;
            this.first_screening_data.unknown_lpd = early_data[i].unknown_lpd;
            this.first_screening_data.edd_calculated =
              early_data[i].edd_calculated;
          }

          first_data.push([Object.assign({}, this.first_screening_data)]);
        }
        if (response.data.second.length > 0) {
          second_data = response.data.second;

          this.screening_identifier = "3";
          this.formEdit.first_screening = false;
          this.formEdit.confirmation_of_due_date_screening = false;
          this.formEdit.can_add_cdd = false;
          this.formEdit.second_screening = false;
          this.formEdit.third_screening = true;
        } else {
          if (this.formEdit.second_screening) {
            this.second_screening_data.fetus = i;
            second_data.push([Object.assign({}, this.second_screening_data)]);
          } else {
            second_data.push([]);
          }
        }
        if (response.data.third.length > 0) {
          third_data = response.data.third;
          this.screening_identifier = "";
          this.formEdit.third_screening = false;
        } else {
          if (this.formEdit.third_screening) {
            this.third_screening_data.fetus = i;
            third_data.push([Object.assign({}, this.third_screening_data)]);
          } else {
            third_data.push([]);
          }
        }
        if (response.data.additional.length > 0) {
          additional_data = response.data.additional;
        }

        if (this.formEdit.early_screening) {
          early_data[i].created_at = new Date();
        }
        if (this.formEdit.first_screening) {
          first_data[i].created_at = new Date();
        }
        if (this.formEdit.confirmation_of_due_date_screening) {
          cdd_data[i].created_at = new Date();
        }
        if (this.formEdit.second_screening) {
          second_data[i].created_at = new Date();
        }
        if (this.formEdit.third_screening) {
          third_data[i].created_at = new Date();
        }

        output.push({
          id: i,
          early_screening: early_data[i],
          first_screening: first_data[i],
          confirmation_of_due_date_screening: cdd_data[i],
          second_screening: second_data[i],
          third_screening: third_data[i],
          additional_screening: additional_data[i],
        });
      }

      this.formData = [...output];
      this.formData.forEach((dat, datIndex) => {
        if (dat.early_screening) {
          dat.early_screening.medical_staff =
            dat.early_screening.medical_staff.length > 0
              ? dat.early_screening.medical_staff.split(",")
              : "";
          if (this.formEdit.early_screening) {
            dat.early_screening.status = "new";
          } else {
            dat.early_screening.status = "update";
          }
          dat.early_screening.created_at = dat.early_screening.created_at
            ? this.date_format(dat.early_screening.created_at)
            : "";
          this.calculate_ga(dat.early_screening, datIndex);
        }

        dat.first_screening.forEach((row) => {
          row.medical_staff =
            row.medical_staff.length > 0 ? row.medical_staff.split(",") : "";
          if (this.formEdit.first_screening) {
            row.edd_calculated = dat.first_screening[0].edd_calculated;

            row.status = "new";
          } else {
            row.status = "update";
          }

          row.created_at = row.created_at
            ? this.date_format(row.created_at)
            : "";
          this.calculate_ga(row, datIndex);
        });

        if (dat.confirmation_of_due_date_screening) {
          dat.confirmation_of_due_date_screening.medical_staff =
            dat.confirmation_of_due_date_screening.medical_staff.length > 0
              ? dat.confirmation_of_due_date_screening.medical_staff.split(",")
              : "";
          if (this.formEdit.confirmation_of_due_date_screening) {
            dat.confirmation_of_due_date_screening.edd_calculated =
              dat.first_screening[0].edd_calculated;
            dat.confirmation_of_due_date_screening.status = "new";
          } else {
            dat.confirmation_of_due_date_screening.status = "update";
          }
          dat.confirmation_of_due_date_screening.created_at = dat
            .confirmation_of_due_date_screening.created_at
            ? this.date_format(
                dat.confirmation_of_due_date_screening.created_at
              )
            : "";
          this.calculate_ga(dat.confirmation_of_due_date_screening, datIndex);
        }

        dat.second_screening.forEach((row) => {
          row.medical_staff =
            row.medical_staff.length > 0 ? row.medical_staff.split(",") : "";

          if (this.formEdit.second_screening) {
            row.edd_calculated = dat.first_screening[0].edd_calculated;

            row.status = "new";
          } else {
            row.status = "update";
          }

          row.created_at = row.created_at
            ? this.date_format(row.created_at)
            : "";
          this.calculate_ga(row, datIndex);
        });
        dat.third_screening.forEach((row) => {
          row.medical_staff =
            row.medical_staff.length > 0 ? row.medical_staff.split(",") : "";

          if (this.formEdit.third_screening) {
            row.edd_calculated = dat.first_screening[0].edd_calculated;

            row.status = "new";
          } else {
            row.status = "update";
          }

          row.created_at = row.created_at
            ? this.date_format(row.created_at)
            : "";
          this.calculate_ga(row, datIndex);
        });
        if (dat.additional_screening) {
          dat.additional_screening.forEach((row) => {
            row.medical_staff =
              row.medical_staff.length > 0 ? row.medical_staff.split(",") : "";

            if (!row.created_at) {
              row.edd_calculated = dat.first_screening[0].edd_calculated;

              row.status = "new";
            } else {
              row.status = "update";
            }

            row.created_at = row.created_at
              ? this.date_format(row.created_at)
              : "";
            this.calculate_ga(row, datIndex);
          });
        }
      });

      if (!preserve_admission_id)
        this.admission_id = response.data.admission_id;
      this.patient_id = response.data.patient_id;

      this.reference = reference;
    },
    async edit(id) {
      this.edit_dialog = true;
      this.edited_screening = id;
    },
    authorized() {
      this.authorized_user = true;
      switch (this.edited_screening) {
        case "early":
          this.formEdit.early_screening = true;
          this.screening_identifier += ",early";
          break;
        case 1:
          this.formEdit.first_screening = true;
          this.screening_identifier += ",1";
          break;
        case "cdd":
          this.formEdit.confirmation_of_due_date_screening = true;
          this.screening_identifier += ",cdd";
          break;
        case 2:
          this.formEdit.second_screening = true;
          this.screening_identifier += ",2";
          break;
        case 3:
          (this.formEdit.third_screening = true),
            (this.screening_identifier += ",3");
          break;
        default:
          if (this.edited_screening.startsWith("additional:")) {
            const parts = this.edited_screening
              .substring("additional:".length)
              .split(",");
            const datIndex = Number(parts[0]);
            const rowIndex = Number(parts[1]);

            if (!(datIndex in this.formEdit.additional_screening))
              this.formEdit.additional_screening[datIndex] = [];
            this.formEdit.additional_screening[datIndex].push(rowIndex);

            this.screening_identifier += ",additional";
          }
          break;
      }

      this.edit_dialog = false;
    },
    reset() {
      this.$v.$reset();
      this.formData = Object.assign([], this.defaultData);
      this.screening_identifier = "1";
      this.is_patient_pregnant = true;
      this.formEdit = Object.assign(
        {},
        {
          early_screening: false,
          first_screening: true,
          confirmation_of_due_date_screening: false,
          can_add_cdd: false,
          second_screening: false,
          third_screening: false,
          additional_screening: [],
        }
      );
    },
    row_push(fetus, rank) {
      let data;
      switch (rank) {
        case 1:
          data = {
            created_at: new Date(),
            edd_calculated: null,
            edd_corrected: null,
            edd_ultrasound: null,
            hc: "",
            ac: "",
            fl: "",
            gs: "",
            crl: "",
            fhr: "",
            other: "",
            bpd: "",
            ewb: "",
            intrauterine: null,
            heartbeat: null,
            embryo_visible: null,
            remark: "",
            medical_staff: [],
            status: "new",
            fetus: fetus,
          };
          this.calculate_ga(data, fetus);

          this.formData[fetus].first_screening.push(data);
          break;
        case 2:
          data = {
            created_at: new Date(),
            edd_calculated: null,
            edd_corrected: null,
            edd_ultrasound: null,
            hc: "",
            ac: "",
            fl: "",
            gs: "",
            crl: "",
            fhr: "",
            bpd: "",
            other: "",
            ewb: "",
            position_of_baby: "",
            presentation_of_baby: "",
            heartbeat: null,
            placenta_type: "",
            normal_growth: null,
            normal_amniotic_fluid: null,
            suspicion_for_malformation: null,
            malformation_explanation: "",
            remark: "",
            medical_staff: [],
            status: "new",
            fetus: fetus,
          };
          this.calculate_ga(data, fetus);

          this.formData[fetus].second_screening.push(data);
          break;
        case 3:
          data = {
            created_at: new Date(),
            edd_calculated: null,
            edd_corrected: null,
            edd_ultrasound: null,
            hc: "",
            ac: "",
            fl: "",
            gs: "",
            crl: "",
            fhr: "",
            other: "",
            bpd: "",
            ewb: "",
            normal_growth: null,
            placenta_type: "",
            normal_birth: "",
            amniotic_liquid: "",
            single_pocket: "",
            wop_equality: "",
            medical_staff: [],
            status: "new",
            remark: "",
            fetus: fetus,
          };
          this.calculate_ga(data, fetus);

          this.formData[fetus].third_screening.push(data);
          break;
        case "additional":
          data = Object.assign({}, this.additional_screening_data);
          data.created_at = new Date();
          data.status = "new";
          data.fetus = fetus;
          this.calculate_ga(data, fetus);

          this.formData[fetus].additional_screening.push(data);

          if (!(fetus in this.formEdit.additional_screening))
            this.formEdit.additional_screening[fetus] = [];
          this.formEdit.additional_screening[fetus].push(
            this.formData[fetus].additional_screening.length - 1
          );

          this.screening_identifier += ",additional";
          break;
      }
    },
    row_delete(datIndex, rank, rowIndex) {
      switch (rank) {
        case 1:
          this.formData[datIndex].first_screening.splice(rowIndex, 1);
          break;
        case 2:
          this.formData[datIndex].second_screening.splice(rowIndex, 1);
          break;
        case 3:
          this.formData[datIndex].third_screening.splice(rowIndex, 1);
          break;
        case "additional":
          this.formData[datIndex].additional_screening.splice(rowIndex, 1);
          this.formEdit.additional_screening[datIndex] =
            this.formEdit.additional_screening[datIndex].filter(
              (x) => x !== rowIndex
            );
          this.formEdit.additional_screening[datIndex] =
            this.formEdit.additional_screening[datIndex].map((x) =>
              x > rowIndex ? x - 1 : x
            );

          if (
            this.formData
              .map((x) => x.additional_screening.length)
              .every((x) => x === 0)
          ) {
            function removeAll(str, find) {
              while (str.includes(find)) str = str.replace(find, "");
              return str;
            }

            this.screening_identifier = removeAll(
              this.screening_identifier,
              ",additional"
            );
            this.screening_identifier = removeAll(
              this.screening_identifier,
              "additional,"
            );
            this.screening_identifier = removeAll(
              this.screening_identifier,
              "additional"
            );
          }
          break;
      }
    },
    date_format(date) {
      if (!date) return "";

      let src = new Date(date);
      let year = src.getFullYear();
      let d = String(src.getDate()).padStart(2, "0");
      let month = String(src.getMonth() + 1).padStart(2, "0");
      return `${year}-${month}-${d}`;
    },
    add_cdd() {
      this.formData.forEach((dat, datIndex) => {
        dat.confirmation_of_due_date_screening = Object.assign(
          {},
          this.confirmation_of_due_date_screening_data
        );
        dat.confirmation_of_due_date_screening.fetus = datIndex;
      });

      this.formEdit.second_screening = false;
      this.formEdit.confirmation_of_due_date_screening = true;
      this.screening_identifier = "cdd";
    },
    add_additional(i) {
      if (
        this.formData[i].additional_screening &&
        this.formData[i].additional_screening.length > 0
      ) {
        this.row_push(i, "additional");
      } else {
        let data = Object.assign({}, this.additional_screening_data);
        data.created_at = new Date();
        data.fetus = i;
        this.calculate_ga(data, i);

        this.formData[i].additional_screening = [data];

        this.formEdit.additional_screening[i] = [0];
      }
      this.screening_identifier = "additional";
      this.formEdit.early_screening =
        this.formEdit.first_screening =
        this.formEdit.confirmation_of_due_date_screening =
        this.formEdit.second_screening =
        this.formEdit.third_screening =
          false;
    },
    edd_ultrasound_warning(row, datIndex) {
      const selected_edd_for_pregnancy = this.selected_due_date_for_pregnancy(
        this.formData[datIndex]
      );

      if (!selected_edd_for_pregnancy || !row.edd_ultrasound) return;

      const abs_diff = Math.abs(
        selected_edd_for_pregnancy - new Date(row.edd_ultrasound)
      );
      const diff_in_days = abs_diff / (1000 * 60 * 60 * 24);

      if (diff_in_days > 4) {
        return true;
      } else {
        return false;
      }
    },
    additional_screening_reason_name(reason_id) {
      if (reason_id == null) return "";

      const reason = this.additional_screening_reasons.filter(
        (x) => x.id == reason_id
      )[0];
      if (reason) return reason.name;

      return "";
    },
    can_edit_additional_screening(fetus, screening_index) {
      return (
        fetus in this.formEdit.additional_screening &&
        this.formEdit.additional_screening[fetus].includes(screening_index)
      );
    },
    can_delete(row) {
      return row.status === "new";
    },
    current_screening_error(datIndex) {
      return (
        (this.formEdit.early_screening &&
          this.$v.formData.$each[datIndex]?.early_screening.$error) ||
        (this.formEdit.first_screening &&
          this.$v.formData.$each[datIndex]?.first_screening.$error) ||
        (this.formEdit.confirmation_of_due_date_screening &&
          this.$v.formData.$each[datIndex]?.confirmation_of_due_date_screening
            .$error) ||
        (this.formEdit.second_screening &&
          this.$v.formData.$each[datIndex]?.second_screening.$error) ||
        (this.formEdit.third_screening &&
          this.$v.formData.$each[datIndex]?.third_screening.$error) ||
        (this.formEdit.additional_screening.length > 0 &&
          this.$v.formData.$each[datIndex]?.additional_screening.$error)
      );
    },
  },
  computed: {
    eightMonthsAgo() {
      let date = new Date();
      date.setMonth(date.getMonth() - 8);
    },
    can_edit_main_screenings() {
      return this.formData.every(
        (dat) =>
          !dat.additional_screening ||
          dat.additional_screening.every((x) => x.status != "new")
      );
    },
  },
  validations: {
    formData: {
      $each: {
        early_screening: {
          ddr: {
            required: requiredIf((x) => {
              return !x || !x.unknown_lpd;
            }),
          },
          edd_method: {
            required,
            selected_date_required: validationFunctions.selected_date_required,
            must_be_ultrasound_if_five_days_difference:
              validationFunctions.must_be_ultrasound_if_five_days_difference,
          },
          edd_ultrasound: {
            required,
          },
          medical_staff: {
            required,
            minLength: minLength(1),
          },
        },
        first_screening: {
          $each: {
            ddr: {
              required: requiredIf((x) => {
                return !x || !x.unknown_lpd;
              }),
            },
            edd_method: {
              required,
              selected_date_required:
                validationFunctions.selected_date_required,
              must_be_ultrasound_if_five_days_difference:
                validationFunctions.must_be_ultrasound_if_five_days_difference,
            },
            edd_ultrasound: {
              required,
            },
            medical_staff: {
              required,
              minLength: minLength(1),
            },
          },
        },
        confirmation_of_due_date_screening: {
          edd_method: {
            required,
            selected_date_required: validationFunctions.selected_date_required,
            must_be_ultrasound_if_five_days_difference:
              validationFunctions.must_be_ultrasound_if_five_days_difference,
          },
          edd_ultrasound: {
            required,
          },
          medical_staff: {
            required,
            minLength: minLength(1),
          },
        },
        second_screening: {
          $each: {
            presentation_of_baby: {
              required,
            },
            position_of_baby: {
              required,
            },
            edd_ultrasound: {
              required,
            },
            placenta_type: {
              required,
            },
            medical_staff: {
              required,
              minLength: minLength(1),
            },
          },
        },
        third_screening: {
          $each: {
            edd_ultrasound: {
              required,
            },
            placenta_type: {
              required,
            },
            medical_staff: {
              required,
              minLength: minLength(1),
            },
          },
        },
        additional_screening: {
          $each: {
            reason_id: { required },
            reason_explanation: {
              requiredIfReasonIsOther: requiredIf((x) => x.reason_id == 7),
            },
            edd_ultrasound: {
              required,
            },
            presentation_of_baby: required,
            position_of_baby: required,
            placenta_type: {
              required,
            },
            medical_staff: {
              required,
              minLength: minLength(1),
            },
          },
        },
      },
    },
  },
};
</script>

<style scoped>
input {
  font-size: 11px;
  outline: none;
  border-bottom: 1px solid #c8c8c8;
}
input[type="text"] {
  max-width: 40px;
}
td,
th {
  white-space: nowrap !important;
}
.small {
  max-height: 10px;
}
.small >>> i {
  font-size: 17px;
}
.radio {
  font-size: 11px !important;
}
.radio >>> label {
  font-size: 12px !important;
}
.table th,
.table td {
  padding: 0.35rem !important;
}
.screening {
  border-collapse: collapse !important;
}
select {
  border: 1px solid rgb(211, 211, 211);
}
@media print {
  container-fluid {
    size: landscape !important;
  }
}
input.date-picker {
  width: 180px;
}
input.date-picker-narrow {
  width: 100px;
}

.form-title {
  font-size: 3rem;
  letter-spacing: 5px;
}
.table-title {
  background-color: #1390c6;
  color: white;
}
input.medium {
  width: 55px;
}
.select-medium {
  width: 200px;
}
.input-medium {
  width: 200px;
}
.v-expansion-panel-header {
  border: solid #1390c6;
  border-width: 0.5px 1px;
}
.current-screening .v-expansion-panel-header {
  background-color: #e2e2e2;
  border: solid #0e739c;
  border-width: 0.8px 1.4px;
}
.current-screening .v-expansion-panel-content {
  border: solid #0e739c;
}
.v-expansion-panel-header--active {
  background-color: #c8c8c8;
}
.v-expansion-panel-content {
  border: solid #1390c6;
}
table.main-table table {
  margin-left: -0.3rem;
}
.overflow-x-visible {
  overflow-x: visible !important;
}
</style>
