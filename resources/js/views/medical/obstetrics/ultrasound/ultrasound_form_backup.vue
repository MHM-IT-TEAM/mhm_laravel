<template>
  <div class="container-fluid p-4">
    <v-app class="p-2">
      <v-card>
          <v-toolbar
              dense
              floating
          >
              <v-text-field
                  hide-details
                  placeholder="Quick search"
                  v-model="reference"
                  class="search ml-4"
                  @change="search"
                  prepend-icon="mdi-magnify"
                  clearable

              ></v-text-field>
          </v-toolbar>

           <v-row>
              </v-row>
              <v-row>
                <v-col
                    cols="12"
                    sm="6"
                    md="2"
                >
                    <v-text-field
                        clearable
                        hide-details
                        v-model="patient.id"
                        label="Patient Id"
                        @change="changePatient"
                    >
                    </v-text-field>
                </v-col>
                  <v-col
                      cols="12"
                      sm="6"
                      md="4"
                  >
                      <v-text-field
                          readonly
                          label="Name"
                          readonly
                          v-model="patient.fullName"
                      >
                      </v-text-field>

                  </v-col>
                  <v-col>

                      <v-btn
                          right
                          x-small
                          color="secondary"
                          dark
                          @click="dialog=true"
                          :disabled="is_updating"
                      >
                          Twin pregnancy
                      </v-btn>
                  </v-col>
              </v-row>
          <v-dialog
              v-model="dialog"
              max-width="175px"
          >
              <v-card>
                  <v-card-text>
<!--                      <v-text-field label="count of fetus" v-model="count_of_baby"></v-text-field>-->
                      <v-select
                          :items="possible_fetus_count"
                          v-model="count_of_fetus"
                          label="count of fetus"
                      ></v-select>
                  </v-card-text>

                  <v-card-actions>
                      <v-spacer></v-spacer>

                      <v-btn
                          text
                          color="primary"
                          x-small
                          @click="count_of_twin"
                      >
                          Ok
                      </v-btn>
                  </v-card-actions>
              </v-card>
          </v-dialog>
          <v-dialog
              v-model="edit_dialog"
              max-width="175px"
          >
              <v-card>
                  <v-card-text>
                      <!--                      <v-text-field label="count of fetus" v-model="count_of_baby"></v-text-field>-->
                    <v-card-title>Login</v-card-title>
                      <v-text-field
                          label="id"
                          v-model="loginForm.id"
                      ></v-text-field>
                      <v-text-field label="password" type="password" v-model="loginForm.password"></v-text-field>
                  </v-card-text>

                  <v-card-actions>
                      <v-spacer></v-spacer>

                      <v-btn
                          text
                          color="primary"
                          x-small
                          @click="login"
                      >
                          Ok
                      </v-btn>
                  </v-card-actions>
              </v-card>
          </v-dialog>
          <v-tabs
              color="deep-purple accent-4"
              left
          >
            <v-tab v-for="tab in formData" :key="tab.id">Fetus {{tab.id+1}}</v-tab>

              <v-tab-item
                  v-for="dat in formData"
                  :key="dat.id"
              >

                  <div class="table-responsive">
                      <table class="table">
                          <tr class="table-active">
                              <td>Date</td>
                              <td>WOP<small>(calculated)</small></td>
                              <td>WOP<small>(ultrasound)</small></td>
                              <td>WOP <small>(corrected)</small></td>
                              <td colspan="3" align="center">
                                  <strong>First Screening 8+0 bis 11+6 WOP</strong>
                              </td>
                              <td>HC</td>
                              <td>AC</td>
                              <td>FL</td>
                              <td>GS</td>
                              <td>CRL</td>
                              <td>BPD</td>
                              <td>EWB</td>
                              <td>
                                  FHR
                                  <v-btn  right
                                          x-small
                                          class="ml-4"
                                          color="secondary"
                                          dark
                                          @click="edit(1)"

                                  >
                                      Edit
                                  </v-btn>
                              </td>
                          </tr>

                              <tr>
                                  <td>
                                      <input type="date" v-model="dat.first_screening.created_at" :readonly=" !formEdit.first_screening"/>
                                  </td>
                                  <td>
                                      <input type="text" v-model="dat.first_screening.wop_calculated" :readonly=" !formEdit.first_screening" />
                                  </td>
                                  <td>
                                      <input type="text" v-model="dat.first_screening.wop_ultrasound" :readonly=" !formEdit.first_screening"/>
                                  </td>
                                  <td>
                                      <input type="text" v-model="dat.first_screening.wop_corrected" :readonly=" !formEdit.first_screening"/>
                                  </td>
                                  <td colspan="3"  class="border">
                                      <table class="table table-borderless">
                                          <tr>
                                              <td>
                                                  <label class="form-check-label">Intrauterine</label>
                                                  <v-radio-group row  class="mt-0 p-0 small" v-model="dat.first_screening.intrauterine" :readonly=" !formEdit.first_screening">
                                                      <v-radio label="Yes" color="success" value="yes" class="radio" ></v-radio>
                                                      <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                                  </v-radio-group>
                                              </td>
                                              <td>

                                                  <label class="form-check-label">Embryo visible</label>
                                                  <v-radio-group row  class="mt-0 p-0 small" v-model="dat.first_screening.embryo_visible" :readonly=" !formEdit.first_screening">
                                                      <v-radio label="Yes" color="success" value="yes" class="radio" ></v-radio>
                                                      <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                                  </v-radio-group>

                                              </td>
                                              <td>
                                                  <label class="form-check-label">Heartbeat</label>
                                                  <v-radio-group row  class="mt-0 p-0 small" v-model="dat.first_screening.heartbeat" :readonly=" !formEdit.first_screening">
                                                      <v-radio label="Yes" color="success" value="yes" class="radio" ></v-radio>
                                                      <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                                  </v-radio-group>
                                              </td>
                                          </tr>

                                      </table>
                                  </td>
                                  <td><input type="text" v-model="dat.first_screening.hc" :readonly=" !formEdit.first_screening" /></td>
                                  <td><input type="text" v-model="dat.first_screening.ac" :readonly=" !formEdit.first_screening"/></td>
                                  <td><input type="text" v-model="dat.first_screening.fl" :readonly=" !formEdit.first_screening"/></td>
                                  <td><input type="text" v-model="dat.first_screening.gs" :readonly=" !formEdit.first_screening"/></td>
                                  <td><input type="text" v-model="dat.first_screening.crl" :readonly=" !formEdit.first_screening"/></td>
                                  <td><input type="text" v-model="dat.first_screening.bpd" :readonly=" !formEdit.first_screening"/></td>
                                  <td><input type="text" v-model="dat.first_screening.ewb" :readonly=" !formEdit.first_screening"/></td>
                                  <td><input type="text" v-model="dat.first_screening.fhr" :readonly=" !formEdit.first_screening"/></td>
                              </tr>
                              <tr class="table-borderless">
                                  <td colspan="4" >
                                      <div class="form-inline">
                                          <label>Other</label>
                                          <textarea style="width: 100%" class="form-control" v-model="dat.first_screening.other" :readonly=" !formEdit.first_screening"></textarea>
                                      </div>
                                  </td>
                                  <td colspan="3">
                                      <div class="form-inline">
                                          <label>Remark and precautions</label>
                                          <textarea style="width: 100%" class="form-control" v-model="dat.first_screening.remark" :readonly=" !formEdit.first_screening"></textarea>

                                      </div>
                                  </td>
                                  <td colspan="8">
                                      <v-autocomplete
                                          v-model="dat.first_screening.midwives"
                                          :items="midwives"
                                          outlined
                                          dense
                                          chips
                                          small-chips
                                          class="mt-4"
                                          label="Midwives"
                                          multiple
                                          :readonly=" !formEdit.first_screening"
                                      ></v-autocomplete>
                                  </td>
                              </tr>

                          <tr class="table-active">
                              <td>Date</td>
                              <td>WOP<small>(calculated)</small></td>
                              <td>WOP<small>(ultrasound)</small></td>
                              <td>WOP <small>(corrected)</small></td>
                              <td colspan="3" align="center">
                                  <strong>Second Screening 18+0 bis 21+6 WOP</strong>
                              </td>
                              <td>HC</td>
                              <td>AC</td>
                              <td>FL</td>
                              <td>GS</td>
                              <td>CRL</td>
                              <td>BPD</td>
                              <td>EWB</td>
                              <td>
                                  FHR
                                  <v-btn  right
                                          x-small
                                          class="ml-4"
                                          color="secondary"
                                          dark
                                          @click="edit(2)"

                                  >
                                      Edit
                                  </v-btn>
                              </td>
                          </tr>
                          <tr>
                              <td><input type="date" v-model="dat.second_screening.created_at" :readonly=" !formEdit.second_screening"/></td>
                              <td><input type="text"  v-model="dat.second_screening.wop_calculated" :readonly=" !formEdit.second_screening"/></td>
                              <td><input type="text"  v-model="dat.second_screening.wop_ultrasound" :readonly=" !formEdit.second_screening"/></td>
                              <td><input type="text"  v-model="dat.second_screening.wop_corrected" :readonly=" !formEdit.second_screening"/></td>

                              <td colspan="3" rowspan="2" class="border screening" >
                                  <table class="table">
                                      <tr class="table table-borderless ">
                                          <td>
                                              <label class="form-check-label">proportional growth</label>
                                              <v-radio-group row  class="mt-0 p-0 small" v-model="dat.second_screening.normal_growth" :readonly=" !formEdit.second_screening">
                                                  <v-radio label="Yes" color="success" value="yes" class="radio"></v-radio>
                                                  <v-radio label="No" color="red" value="no" class="radio"></v-radio>
                                              </v-radio-group>
                                          </td>
                                          <td>
                                              <label class="form-check-label">Heartbeat</label>
                                              <v-radio-group row  class="mt-0 p-0 small" v-model="dat.second_screening.heartbeat" :readonly=" !formEdit.second_screening">
                                                  <v-radio label="Yes" color="success" value="yes" class="radio" ></v-radio>
                                                  <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                              </v-radio-group>
                                          </td>
                                          <td>
                                              <div class="form-check form-inline">
                                                  <label>Placenta</label> &nbsp
                                                  [ &nbsp
                                                  <select v-model="dat.second_screening.placenta_type" :readonly=" !formEdit.second_screening">
                                                      <option></option>
                                                      <option v-for="type in placenta_type">{{type.name}}</option>
                                                  </select>
                                                  &nbsp ]
                                              </div>
                                          </td>
                                      </tr>
                                      <tr class="table-borderless mt-4">
                                          <td >

                                              <label class="form-check-label mt-2 ">Amniotic liquid</label>
                                              <v-radio-group row  class="ma-0 pa-0 small"  v-model="dat.second_screening.normal_amniotic_fluid"
                                                             :readonly=" !formEdit.second_screening"
                                                             hide-details
                                              >
                                                  <v-radio label="P" color="red" value="poly" class="radio" ></v-radio>
                                                  <v-radio label="N" color="red" value="normal" class="radio" ></v-radio>
                                                  <v-radio label="O" color="red" value="olygo" class="radio" ></v-radio>
                                              </v-radio-group>
                                          </td>
                                          <td>
                                              <label class="form-check-label mt-2">Supicion for Malformation</label>
                                              <v-radio-group row  class="ma-0 pa-0 small"
                                                             v-model="dat.second_screening.suspicion_for_malformation"
                                                             :readonly=" !formEdit.second_screening" hide-details
                                              >
                                                  <v-radio label="Yes" color="success" value="yes" class="radio"></v-radio>
                                                  <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                              </v-radio-group>
                                          </td>
                                          <td>
                                              <v-text-field label="explanation"
                                                hide-details
                                                :disabled="dat.second_screening.suspicion_for_malformation!=='yes'"
                                                            v-model="dat.second_screening.malformation_explanation"
                                              >

                                              </v-text-field>
                                          </td>
                                      </tr>
                                      <tr class="table-borderless">
                                          <td>
                                              <div class="form-group">
                                                  <label>Position</label>
                                                  [&nbsp
                                                  <select v-model="dat.second_screening.position_of_baby" :disabled=" !formEdit.second_screening">
                                                      <option v-for="item in position_of_baby">{{item.name}}</option>
                                                  </select>
                                                  &nbsp]
                                              </div>
                                          </td>
                                          <td>
                                              <div class="form-group">
                                                  <label>Presentation</label>
                                                  [&nbsp
                                                  <select v-model="dat.second_screening.presentation_of_baby" :disabled=" !formEdit.second_screening">
                                                      <option v-for="item in presentation_of_baby">{{item.name}}</option>
                                                  </select>
                                                  &nbsp]
                                              </div>
                                          </td>
                                      </tr>
                                  </table>
                              </td>


                          <td><input type="text" v-model="dat.second_screening.hc" :readonly=" !formEdit.second_screening" /></td>
                          <td><input type="text"  v-model="dat.second_screening.ac" :readonly=" !formEdit.second_screening"/></td>
                          <td><input type="text"  v-model="dat.second_screening.fl"  :readonly=" !formEdit.second_screening"/></td>
                          <td><input type="text"  v-model="dat.second_screening.gs"  :readonly=" !formEdit.second_screening"/></td>
                          <td><input type="text"  v-model="dat.second_screening.crl" :readonly=" !formEdit.second_screening" /></td>
                          <td><input type="text"  v-model="dat.second_screening.bpd" :readonly=" !formEdit.second_screening" /></td>
                          <td><input type="text"  v-model="dat.second_screening.ewb" :readonly=" !formEdit.second_screening" /></td>
                          <td><input type="text"  v-model="dat.second_screening.fhr" :readonly=" !formEdit.second_screening" /></td>

                          <tr>
                              <td colspan="4">
                                  <div class="form-inline">
                                      <label>Other</label>
                                      <textarea style="width: 100%; height:40px" class="form-control"  v-model="dat.second_screening.other" :readonly=" !formEdit.second_screening"></textarea>
                                  </div>
                              </td>
                              <td colspan="8">
                                  <div class="form-inline">
                                      <label>Remark and precautions</label>
                                      <textarea style="width: 100%; height:40px" class="form-control"  v-model="dat.second_screening.remark" :readonly=" !formEdit.second_screening"></textarea>
                                  </div>
                                  <v-autocomplete
                                      v-model="dat.second_screening.midwives"
                                      :items="midwives"
                                      outlined
                                      dense
                                      chips
                                      small-chips
                                      class="mt-2"
                                      label="Midwives"
                                      multiple
                                      :readonly=" !formEdit.second_screening"
                                  ></v-autocomplete>
                              </td>
                          </tr>
                      </table>
                      <table class="table">
                          <tr class="table-active">
                              <td>Date</td>
                              <td>WOP<small>(calculated)</small></td>
                              <td>WOP<small>(ultrasound)</small></td>
                              <td>WOP <small>(corrected)</small></td>
                              <td colspan="3" align="center">
                                  <strong>Third Screening 28+0 bis 31+6 WOP</strong>
                              </td>
                              <td>HC</td>
                              <td>AC</td>
                              <td>FL</td>
                              <td>GS</td>
                              <td>CRL</td>
                              <td>BPD</td>
                              <td>EWB</td>
                              <td>
                                  FHR
                                  <v-btn  right
                                          x-small
                                          class="ml-4"
                                          color="secondary"
                                          dark
                                          @click="edit(3)"

                                  >
                                      Edit
                                  </v-btn>
                              </td>
                          </tr>
                          <tr>
                              <td><input type="date" v-model="dat.third_screening.created_at"  :readonly=" !formEdit.third_screening"/></td>
                              <td><input type="text" v-model="dat.third_screening.wop_calculated" :readonly=" !formEdit.third_screening"/></td>
                              <td><input type="text" v-model="dat.third_screening.wop_ultrasound" :readonly=" !formEdit.third_screening"/></td>
                              <td><input type="text" v-model="dat.third_screening.wop_corrected" :readonly=" !formEdit.third_screening"/></td>
                              <td colspan="3" rowspan="3" class="border">
                                    <table class="table">
                                        <tr class="table table-borderless">
                                            <td>
                                                <div class="form-check form-inline">
                                                    <label>Placenta</label> &nbsp
                                                    [ &nbsp
                                                    <select v-model="dat.third_screening.placenta_type" :readonly=" !formEdit.third_screening">
                                                        <option></option>
                                                        <option v-for="type in placenta_type">{{type.name}}</option>
                                                    </select>
                                                    &nbsp ]
                                                </div>
                                            </td>
                                            <td>
                                                <label class="form-check-label">Normal birth possible</label>
                                                <v-radio-group row  class="mt-0 p-0 small" v-model="dat.third_screening.normal_birth" :readonly=" !formEdit.third_screening">
                                                    <v-radio label="Yes" color="success" value="yes" class="radio"></v-radio>
                                                    <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                                </v-radio-group>
                                            </td>
                                            <td>
                                                <label class="form-check-label">Normal growth</label>
                                                <v-radio-group row  class="mt-0 p-0 small" v-model="dat.third_screening.normal_growth" :readonly=" !formEdit.third_screening">
                                                    <v-radio label="Yes" color="success" value="yes" class="radio"></v-radio>
                                                    <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                                </v-radio-group>
                                            </td>
                                        </tr>
                                        <tr class="table-borderless">
                                            <td >
                                                <div class="form-check ">
                                                    <label>Amniotic liquid (AFI)</label>
                                                    <div class="form-inline">
                                                        <input type="radio" class="form-check-input" name="amnio" id="amnio_1" value="<5" v-model="dat.third_screening.amniotic_liquid"/>&nbsp&nbsp
                                                        <label><5</label>&nbsp&nbsp
                                                        <input type="radio" class="form-check-input" name="amnio" id="amnio_2" value="5-20" v-model="dat.third_screening.amniotic_liquid"/>&nbsp&nbsp
                                                        <label>5-20</label>&nbsp&nbsp
                                                        <input type="radio" class="form-check-input" name="amnio" id="amnio_3" value=">20" v-model="dat.third_screening.amniotic_liquid"/>&nbsp&nbsp
                                                        <label>>20</label>&nbsp&nbsp
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <label>Amniotic liquid (Single pocket)</label>
                                                    <div class="form-inline">
                                                        <input type="radio" class="form-check-input" name="single_pocket" id="single_pocket_1" value="<2" v-model="dat.third_screening.single_pocket"/>&nbsp&nbsp
                                                        <label><2</label>&nbsp&nbsp
                                                        <input type="radio" class="form-check-input" name="single_pocket" id="single_pocket_2" value=">10" v-model="dat.third_screening.single_pocket"/>&nbsp&nbsp
                                                        <label><10</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="table-borderless">
                                            <td colspan="2">
                                                <div class="form-check form-inline">
                                                    <label>Caculated WOP</label>
                                                    <v-chip-group
                                                        class="ml-4"
                                                        active-class="deep-purple accent-4 white--text"
                                                        column
                                                        v-model="dat.third_screening.wop_equality"
                                                        :readonly=" !formEdit.third_screening"
                                                    >
                                                        <v-chip
                                                            x-small
                                                        >>
                                                        </v-chip>
                                                        <v-chip
                                                            x-small
                                                        >
                                                            =
                                                        </v-chip>
                                                        <v-chip
                                                            x-small
                                                        >
                                                            <
                                                        </v-chip>
                                                    </v-chip-group>
                                                    <label>US result</label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                              </td>
                              <td><input type="text" v-model="dat.third_screening.hc"  :readonly=" !formEdit.third_screening"/></td>
                              <td><input type="text"  v-model="dat.third_screening.ac" :readonly=" !formEdit.third_screening"/></td>
                              <td><input type="text"  v-model="dat.third_screening.fl"  :readonly=" !formEdit.third_screening"/></td>
                              <td><input type="text"  v-model="dat.third_screening.gs"  :readonly=" !formEdit.third_screening"/></td>
                              <td><input type="text"  v-model="dat.third_screening.crl"  :readonly=" !formEdit.third_screening"/></td>
                              <td><input type="text"  v-model="dat.third_screening.bpd"  :readonly=" !formEdit.third_screening"/></td>
                              <td><input type="text"  v-model="dat.third_screening.ewb"  :readonly=" !formEdit.third_screening"/></td>
                              <td><input type="text"  v-model="dat.third_screening.fhr"  :readonly=" !formEdit.third_screening"/></td>
                          </tr>
                          <tr>
                              <td colspan="4">
                                  <div class="form-inline">
                                      <label>Other</label>
                                      <textarea style="width: 100%;height:40px" class="form-control"  v-model="dat.third_screening.other" :readonly=" !formEdit.third_screening"></textarea>
                                  </div>
                              </td>
                              <td colspan="8">
                                  <div class="form-inline">
                                      <label>Remark and precautions</label>
                                      <textarea style="width: 100%; height:40px" class="form-control"  v-model="dat.third_screening.remark" :readonly=" !formEdit.third_screening"></textarea>
                                  </div>
                                  <v-autocomplete
                                      v-model="dat.third_screening.midwives"
                                      :items="midwives"
                                      outlined
                                      dense
                                      chips
                                      small-chips
                                      class="mt-2"
                                      label="Midwives"
                                      multiple
                                      :readonly=" !formEdit.third_screening"
                                  ></v-autocomplete>
                              </td>
                          </tr>
                      </table>
<!--                      <table class="table">-->
<!--                          <tr class="table-active">-->
<!--                              <td>Date</td>-->
<!--                              <td>WOP<small>(calculated)</small></td>-->
<!--                              <td>WOP<small>(ultrasound)</small></td>-->
<!--                              <td>WOP <small>(corrected)</small></td>-->
<!--                              <td colspan="3" align="center">-->
<!--                                  <strong>Extra screening</strong>-->
<!--                              </td>-->
<!--                              <td>HC</td>-->
<!--                              <td>AC</td>-->
<!--                              <td>FL</td>-->
<!--                              <td>GS</td>-->
<!--                              <td>CRL</td>-->
<!--                              <td>BPD</td>-->
<!--                              <td>-->
<!--                                  FHR-->
<!--                                  <v-btn  right-->
<!--                                          x-small-->
<!--                                          class="ml-4"-->
<!--                                          color="secondary"-->
<!--                                          dark-->
<!--                                          @click="edit(3)"-->

<!--                                  >-->
<!--                                      Edit-->
<!--                                  </v-btn>-->
<!--                              </td>-->
<!--                          </tr>-->
<!--                          <tr v-for="extra in dat.extra_screening">-->
<!--                              <td><input type="date" v-model="extra.created_at"  :readonly=" !formEdit.third_screening"/></td>-->
<!--                              <td><input type="text" v-model="extra.wop_calculated" :readonly=" !formEdit.third_screening"/></td>-->
<!--                              <td><input type="text" v-model="extra.wop_ultrasound" :readonly=" !formEdit.third_screening"/></td>-->
<!--                              <td><input type="text" v-model="extra.wop_corrected" :readonly=" !formEdit.third_screening"/></td>-->
<!--                              <td colspan="3">-->
<!--                                  <table class="table">-->

<!--                                  </table>-->
<!--                              </td>-->
<!--                          </tr>-->
<!--                      </table>-->
                  </div>

              </v-tab-item>
          </v-tabs>
          <v-btn class="float-right" color="secondary" @click.prevent="submit">
              Submit
          </v-btn>
      </v-card>
    </v-app>
  </div>
</template>

<script>
export default {
  name: "ultrasound_form",
    props:["is_overView"],
    data:()=>{
      return{
          formData:[
              {
                  id:0,
                  patient_id:'',
                  first_screening:{
                      created_at:'',
                      wop_calculated:'',
                      wop_corrected:'',
                      wop_ultrasound:'',
                      hc:"",
                      ac:"",
                      fl:"",
                      gs:"",
                      crl:"",
                      fhr:"",
                      other:"",
                      bpd:'',
                      ewb:'',
                      intrauterine:false,
                      heartbeat:false,
                      embryo_visible:false,
                      remark:"",
                      midwives:[]
                  },
                  second_screening:{
                      created_at:'',
                      wop_calculated:'',
                      wop_corrected:'',
                      wop_ultrasound:'',
                      hc:"",
                      ac:"",
                      fl:"",
                      gs:"",
                      crl:"",
                      fhr:"",
                      other:"",
                      bpd:'',
                      ewb:'',
                      position_of_baby:'',
                      presentation_of_baby:'',
                      heartbeat:false,
                      placenta_type:'',
                      normal_growth:false,
                      normal_amniotic_fluid:false,
                      suspicion_for_malformation:false,
                      malformation_explanation:'',
                      remark:'',
                      midwives:[],
                      status:'',
                      valid:false
                  },
                  third_screening:{
                      created_at:'',
                      wop_calculated:'',
                      wop_corrected:'',
                      wop_ultrasound:'',
                      hc:"",
                      ac:"",
                      fl:"",
                      gs:"",
                      crl:"",
                      fhr:"",
                      other:"",
                      bpd:'',
                      ewb:'',
                      normal_growth:false,
                      placenta_type:'',
                      normal_birth:'',
                      amniotic_liquid:'',
                      single_pocket:'',
                      wop_equality:'',
                      midwives:[],
                      status:'',
                      remark:'',
                      valid:false
                  },
                  // extra_screening:[
                  //     {
                  //         created_at:'',
                  //         wop_calculated:'',
                  //         wop_corrected:'',
                  //         wop_ultrasound:'',
                  //         hc:"",
                  //         ac:"",
                  //         fl:"",
                  //         gs:"",
                  //         crl:"",
                  //         fhr:"",
                  //         other:"",
                  //         bpd:'',
                  //     }
                  // ]

              },
          ],
          defaultData:[
              {
                  id:0,
                  patient_id:'',
                  first_screening:{
                      created_at:'',
                      wop_calculated:'',
                      wop_corrected:'',
                      wop_ultrasound:'',
                      hc:"",
                      ac:"",
                      fl:"",
                      gs:"",
                      crl:"",
                      fhr:"",
                      other:"",
                      ewb:'',
                      bpd:'',
                      intrauterine:false,
                      heartbeat:false,
                      embryo_visible:false,
                      remark:"",
                      midwives:[]
                  },
                  second_screening:{
                      created_at:'',
                      wop_calculated:'',
                      wop_corrected:'',
                      wop_ultrasound:'',
                      hc:"",
                      ac:"",
                      fl:"",
                      gs:"",
                      crl:"",
                      fhr:"",
                      bpd:'',
                      other:"",
                      ewb:'',
                      position_of_baby:'',
                      presentation_of_baby:'',
                      heartbeat:false,
                      placenta_type:'',
                      normal_growth:false,
                      normal_amniotic_fluid:false,
                      suspicion_for_malformation:false,
                      malformation_explanation:'',
                      remark:'',
                      midwives:[],
                      status:'',
                      valid:false
                  },
                  third_screening:{
                      created_at:'',
                      wop_calculated:'',
                      wop_corrected:'',
                      wop_ultrasound:'',
                      hc:"",
                      ac:"",
                      fl:"",
                      gs:"",
                      crl:"",
                      fhr:"",
                      bpd:'',
                      other:"",
                      ewb:'',
                      normal_growth:false,
                      placenta_type:'',
                      normal_birth:'',
                      amniotic_liquid:'',
                      single_pocket:'',
                      wop_equality:'',
                      midwives:[],
                      status:'',
                      remark:'',
                      valid:false
                  }

              },
          ],
          dialog:false,
          edit_dialog:false,
          count_of_fetus:1,
          placenta_type:'',
          position_of_baby:[],
          presentation_of_baby:[],
          possible_fetus_count:[2,3],
          reference:'',
          is_updating:false,
          midwives:['Tanja','Tianasoa','Manitra','Finaritra'],
          formStatus:{
              first_screening:'',
              second_screening:'',
              third_screening:'',
          },
          formEdit:{
              first_screening:true,
              second_screening:true,
              third_screening:true,
          },
          loginForm:{
              id:'',
              password:''
          },
          patient:{
              id:'',
              fullName:''
          },

          edited_screening:''
      }
    },
    created(){
        this.init()
    },
    watch:{
      formData:{
          handler(val){
              if(val[0].third_screening.placenta_type !=='' && val[0].third_screening.midwives.length>0)this.formData[0].third_screening.valid=true
              if(val[0].second_screening.position_of_baby !=='' && val[0].second_screening.presentation_of_baby !=='' && val[0].second_screening.midwives.length>0)this.formData[0].second_screening.valid=true
          },
          deep:true
      },
        patient:{
          handler(val){
              val.id===null?this.patient.fullName='':''
          },
            deep:true
        }
    },
    methods:{
      async init(){
          await axios.get('/api/v1/extra/position_of_baby')
          .then(res=>this.position_of_baby=res.data)
          await axios.get('/api/v1/extra/presentation_of_baby')
          .then(res=>this.presentation_of_baby=res.data)
          axios.get('/api/v1/extra/placenta_type')
          .then(res=>this.placenta_type=res.data)
          if (this.$route.params.patient_id !== "" && this.$route.params.patient_id !== undefined) {
              this.patient.id = this.$route.params.patient_id;
              this.changePatient();
          }
      },
      count_of_twin(){
          for(let i=0; i<this.count_of_fetus-1;i++){
            this.push_form_data(i);
          }
          this.dialog=false
      },
        push_form_data(i){
          this.formData.push({
              id:i+1,
              first_screening:{
                  created_at:this.formData[0].first_screening.created_at,
                  wop_calculated:this.formData[0].first_screening.wop_calculated,
                  wop_ultrasound:this.formData[0].first_screening.wop_ultrasound,
                  wop_corrected:this.formData[0].first_screening.wop_corrected,
                  hc:"",
                  ac:"",
                  fl:"",
                  gs:"",
                  crl:"",
                  fhr:"",
                  other:"",
                  intrauterine:false,
                  heartbeat:false,
                  embryo_visible:false,
                  remark:"",
                  midwives:[]
              },
              second_screening:{
                  created_at:"",
                  wop_calculated:"",
                  wop_ultrasound:"",
                  wop_corrected:"",
                  hc:"",
                  ac:"",
                  fl:"",
                  gs:"",
                  crl:"",
                  fhr:"",
                  other:"",
                  position_of_baby:'',
                  presentation_of_baby:'',
                  heart_beat:false,
                  placenta_type:false,
                  normal_growth:false,
                  normal_amniotic_fluid:false,
                  suspicion_for_malformation:false,
                  remark:'',
                  midwives:[]
              },
              third_screening:{
                  created_at:"",
                  wop_calculated:"",
                  wop_ultrasound: "",
                  wop_corrected:"",
                  hc:"",
                  ac:"",
                  fl:"",
                  gs:"",
                  crl:"",
                  fhr:"",
                  other:"",
                  normal_growth:false,
                  heart_beat:false,
                  placenta_type:'',
                  normal_birth:'',
                  amniotic_liquid:'',
                  wop_equality:'',
                  midwives:[]
              }

          },)
        },
        async submit(e){
          e.preventDefault()
            await axios.post('/api/v1/patient_system/out_patient/obstetrical/ultrasound',{formData:this.formData,patient_id:this.patient.id, count_of_fetus:this.count_of_fetus,ref:this.reference,formStatus:this.formStatus})
            .then(
                this.$toast.open({
                    message: `data successfully submitted `,
                    position: "top-right",
                    type: "success",
                })
            )
            .then(
               // this.reset()
            )

        },
        async search(){
            this.reset()
            this.formEdit.second_screening=true
            this.is_updating=true
            let response= await axios.get(`/api/v1/patient_system/out_patient/obstetrical/ultrasound/${this.reference}`)
            this.formData=response.data;
            this.formEdit.first_screening=false
            if(this.formData[0].second_screening.position_of_baby !==''  && this.formData[0].second_screening.presentation_of_baby !==''  ){
                this.formEdit.second_screening=false
                this.formStatus.second_screening='update'
            }else{
                this.formStatus.second_screening='new'
            }
            if(this.formData[0].third_screening.placenta_type !==null && this.formData[0].third_screening.midwives.length>0 ){
                this.formEdit.third_screening=false
                this.formStatus.third_screening='update'
            }else{
                this.formStatus.third_screening='new'
            }
            this.patient.id=response.data[0].patient_id
            this.changePatient()

        },
        async edit(id){
          this.edit_dialog=true
            this.edited_screening=id
        },
        async login(){
            await axios.post('/api/v1/auth/credentials',this.loginForm)
            .then(response=>{
                if(response.data.success===true){
                    switch(this.edited_screening){
                        case 1: this.formEdit.first_screening=true
                            break;
                        case 2: this.formEdit.second_screening=true
                            break;
                        case 3:this.formEdit.third_screening=true
                    }
                }
                this.edit_dialog=false
                this.loginForm={
                    id:"",
                    password:""
                }
            })
        },
        reset(){
          this.formData= Object.assign({},this.defaultData)
            this.formEdit=Object.assign({},{
                first_screening:true,
                second_screening:true,
                third_screening:true,
            })
        },
        async changePatient(){
            let patData = await axios.get(
                `/api/v1/patient_system/patient/patient/${this.patient.id}/edit`
            );
            let lastName= patData.data.patient.lastName==null?'':patData.data.patient.lastName
            this.patient.fullName = patData.data.patient.firstName.toUpperCase()+ " " + lastName;
        }
    },



};
</script>

<style scoped>
input {
  font-size: 11px;
  outline: none;
  border-bottom: 1px solid #c8c8c8;

}
input[type=text]{
    max-width: 40px;
}
td {
  white-space: nowrap !important;
}
.small{
  max-height: 10px;
}
.small >>> i{
    font-size:17px;

}
.radio{
    font-size:11px !important;
}
.radio >>>label{
    font-size:12px !important;
}
.table th, .table td {
    padding:0.35rem !important;
}
.screening{
    border-collapse: collapse !important;
}

</style>

