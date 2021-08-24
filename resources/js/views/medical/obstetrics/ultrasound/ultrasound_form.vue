<template>
    <div class="container-fluid p-4">

        <v-app class="p-2">
            <v-card>
                <h2>Ultrasound Screening</h2>
                <v-toolbar
                    dense
                    floating
                    v-if="!is_overview"
                >
                    <v-text-field
                        hide-details
                        placeholder="reference"
                        v-model="reference"
                        class="search ml-4 d-print-none"
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
                        sm="2"
                        md="2"
                        lg="2"
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
                        md="6"
                    >
                        <v-text-field
                            readonly
                            label="Name"
                            readonly
                            v-model="patient.fullName"
                        >
                        </v-text-field>

                    </v-col>
                    <v-col
                    cols="12"
                    sm="4"
                    md="4"
                    >

                        <v-btn

                            x-small
                            color="secondary"
                            dark
                            @click="dialog=true"
                            hide-details
                        >
                            Twin pregnancy
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row>
                    <div class="ml-4 mb-4">
                        <div>
                          <span class="error">{{ accessory.cpn_link_error_message }}</span>
                        </div>
                        <div class="d-flex" style="max-width:600px; align-items:center;">
                          <label class="mt-auto" >Linked CPN: </label>
                          <input class="ml-1 col-3 form-control" type="number" :disabled="is_updating" v-model="cpn_admission_id" @change="linked_cpn_change" />
                          <div v-if="accessory.linked_cpn_exists">
                            <router-link target="_blank" :to="{ name: 'cpn_admission', params: { id: cpn_admission_id } }"><button class="btn btn-secondary">View CPN</button></router-link>
                          </div>
                        </div>
                    </div>
                </v-row>
                <v-dialog
                    v-model="dialog"
                    max-width="175px"
                >
                    <v-card>
                        <v-card-text>
<!--                            <v-text-field label="count of fetus" v-model="count_of_baby"></v-text-field>-->
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
                                <v-text-field label="password" type="password" v-model="loginForm.password" v-on:keyup.enter="login"></v-text-field>
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
                            <table class="table" id="main_table">

                                <thead class="table-active">
                                    <td>Date</td>
                                    <td>GA<small>(calculated)</small></td>
                                    <td>GA<small>(ultrasound)</small></td>
                                    <td>GA <small>(corrected)</small></td>
                                    <td colspan="3" align="center">
                                        <strong>I. Screening 8+0 bis 11+6 GA</strong>
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
                                                class="ml-4 d-print-none"
                                                color="secondary"
                                                dark
                                                @click="edit(1)"
                                                v-if="!is_overview"

                                        >
                                            Edit
                                        </v-btn>
                                        <v-btn  right
                                                small
                                                class="ml-4 d-print-none"
                                                color="primary"
                                                v-if="!is_overview"
                                                @click="row_push(dat.id,1)"
                                                icon

                                        >
                                            <v-icon  dark>mdi-plus-circle-outline</v-icon>
                                        </v-btn>
                                        <v-btn  right
                                                small
                                                class="ml-4 d-print-none"
                                                color="red"
                                                v-if="dat.first_screening.length>1 || !is_overview "
                                                @click="row_delete(dat.id,1)"

                                                icon

                                        >
                                            <v-icon  dark>mdi-minus-circle-outline</v-icon>
                                        </v-btn>
                                    </td>
                                </thead>
                                <tbody v-for="row in dat.first_screening">
                                <tr >
                                    <td>
                                        <date-picker v-model="row.created_at"
                                            v-if="!formData.unknown_lpd"
                                            :input-debounce="500" mode="date"
                                            :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                            :max-date="new Date()"
                                            :readonly=" !formEdit.first_screening">
                                            <template v-slot="{ inputValue, inputEvents }">
                                                <input
                                                    class="bg-white border px-2 py-1 rounded"
                                                    :value="inputValue"
                                                    v-on="inputEvents"

                                                />
                                            </template>
                                        </date-picker>
                                    </td>
                                    <td>
                                        <gestational-age v-model="row.wop_calculated" :readonly="!formEdit.first_screening" />
                                    </td>
                                    <td>
                                        <gestational-age v-model="row.wop_ultrasound" :readonly="!formEdit.first_screening"/>
                                    </td>
                                    <td>
                                        <gestational-age v-model="row.wop_corrected" :readonly="!formEdit.first_screening"/>
                                    </td>
                                    <td colspan="3"  class="border">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>
                                                    <label class="form-check-label">Intrauterine</label>
                                                    <v-radio-group row  class="mt-0 p-0 small" v-model="row.intrauterine" :readonly=" !formEdit.first_screening">
                                                        <v-radio label="Yes" color="success" value="yes" class="radio" ></v-radio>
                                                        <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                                    </v-radio-group>
                                                </td>
                                                <td>

                                                    <label class="form-check-label">Embryo visible</label>
                                                    <v-radio-group row  class="mt-0 p-0 small" v-model="row.embryo_visible" :readonly=" !formEdit.first_screening">
                                                        <v-radio label="Yes" color="success" value="yes" class="radio" ></v-radio>
                                                        <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                                    </v-radio-group>

                                                </td>
                                                <td>
                                                    <label class="form-check-label">Heartbeat</label>
                                                    <v-radio-group row  class="mt-0 p-0 small" v-model="row.heartbeat" :readonly=" !formEdit.first_screening">
                                                        <v-radio label="Yes" color="success" value="yes" class="radio" ></v-radio>
                                                        <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                                    </v-radio-group>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                    <td><input type="text" v-model="row.hc" :readonly=" !formEdit.first_screening" /></td>
                                    <td><input type="text" v-model="row.ac" :readonly=" !formEdit.first_screening"/></td>
                                    <td><input type="text" v-model="row.fl" :readonly=" !formEdit.first_screening"/></td>
                                    <td><input type="text" v-model="row.gs" :readonly=" !formEdit.first_screening"/></td>
                                    <td><input type="text" v-model="row.crl" :readonly=" !formEdit.first_screening"/></td>
                                    <td><input type="text" v-model="row.bpd" :readonly=" !formEdit.first_screening"/></td>
                                    <td><input type="text" v-model="row.ewb" :readonly=" !formEdit.first_screening"/></td>
                                    <td><input type="text" v-model="row.fhr" :readonly=" !formEdit.first_screening"/></td>
                                </tr>
                                <tr class="table-borderless" >
                                    <td colspan="4" >
                                        <div class="form-inline">
                                            <label>Other</label>
                                            <textarea style="width: 100%" class="form-control" v-model="row.other" :readonly=" !formEdit.first_screening"></textarea>
                                        </div>
                                    </td>
                                    <td colspan="3">
                                        <div class="form-inline">
                                            <label>Remark and precautions</label>
                                            <textarea style="width: 100%" class="form-control" v-model="row.remark" :readonly=" !formEdit.first_screening"></textarea>

                                        </div>
                                    </td>
                                    <td colspan="8">
                                        <v-autocomplete
                                            v-model="row.midwives"
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
                                </tbody>

                                <tr class="table-active">
                                    <td>Date</td>
                                    <td>GA<small>(calculated)</small></td>
                                    <td>GA<small>(ultrasound)</small></td>
                                    <td>GA <small>(corrected)</small></td>
                                    <td colspan="3" align="center">
                                        <strong>II. Screening 18+0 bis 21+6 GA</strong>
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
                                                class="ml-4 d-print-none"
                                                color="secondary"
                                                dark
                                                @click="edit(2)"
                                                v-if="!is_overview"

                                        >
                                            Edit
                                        </v-btn>
                                        <v-btn  right
                                                small
                                                class="ml-4 d-print-none"
                                                color="primary"
                                                v-if="!is_overview"
                                                @click="row_push(dat.id,2)"
                                                icon

                                        >
                                            <v-icon  dark>mdi-plus-circle-outline</v-icon>
                                        </v-btn>
                                        <v-btn  right
                                                small
                                                class="ml-4 d-print-none"
                                                color="red"
                                                v-if="dat.second_screening.length>1  "
                                                @click="row_delete(dat.id,2)"
                                                icon

                                        >
                                            <v-icon  dark>mdi-minus-circle-outline</v-icon>
                                        </v-btn>
                                    </td>
                                </tr>
                                <tbody v-for="row_1 in dat.second_screening">
                                <tr>
                                    <td>
                                        <date-picker v-model="row_1.created_at"
                                            v-if="!formData.unknown_lpd"
                                            :input-debounce="500" mode="date"
                                            :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                            :max-date="new Date()"
                                            :readonly=" !formEdit.second_screening">
                                            <template v-slot="{ inputValue, inputEvents }">
                                                <input
                                                    class="bg-white border px-2 py-1 rounded"
                                                    :value="inputValue"
                                                    v-on="inputEvents"

                                                />
                                            </template>
                                        </date-picker>
                                    </td>
                                    <td><gestational-age  v-model="row_1.wop_calculated" :readonly="!formEdit.second_screening"/></td>
                                    <td><gestational-age  v-model="row_1.wop_ultrasound" :readonly="!formEdit.second_screening"/></td>
                                    <td><gestational-age  v-model="row_1.wop_corrected" :readonly="!formEdit.second_screening"/></td>

                                    <td colspan="3" rowspan="2" class="border screening" >
                                        <table class="table">
                                            <tr class="table table-borderless ">
                                                <td>
                                                    <label class="form-check-label">proportional growth</label>
                                                    <v-radio-group row  class="mt-0 p-0 small" v-model="row_1.normal_growth" :readonly=" !formEdit.second_screening">
                                                        <v-radio label="Yes" color="success" value="yes" class="radio"></v-radio>
                                                        <v-radio label="No" color="red" value="no" class="radio"></v-radio>
                                                    </v-radio-group>
                                                </td>
                                                <td>
                                                    <label class="form-check-label">Heartbeat</label>
                                                    <v-radio-group row  class="mt-0 p-0 small" v-model="row_1.heartbeat" :readonly=" !formEdit.second_screening">
                                                        <v-radio label="Yes" color="success" value="yes" class="radio" ></v-radio>
                                                        <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                                    </v-radio-group>
                                                </td>
                                                <td>
                                                    <div class="form-check form-inline">
                                                        <label>Placenta</label> &nbsp
                                                        [ &nbsp
                                                        <select v-model="row_1.placenta_type" :readonly=" !formEdit.second_screening">
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
                                                    <v-radio-group row  class="ma-0 pa-0 small"  v-model="row_1.normal_amniotic_fluid"
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
                                                                   v-model="row_1.suspicion_for_malformation"
                                                                   :readonly=" !formEdit.second_screening" hide-details
                                                    >
                                                        <v-radio label="Yes" color="success" value="yes" class="radio"></v-radio>
                                                        <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                                    </v-radio-group>
                                                </td>
                                                <td>
                                                    <v-text-field label="explanation"
                                                                  hide-details
                                                                  :disabled="row_1.suspicion_for_malformation!=='yes'"
                                                                  v-model="row_1.malformation_explanation"
                                                    >

                                                    </v-text-field>
                                                </td>
                                            </tr>
                                            <tr class="table-borderless">
                                                <td>
                                                    <div class="form-group">
                                                        <label>Position</label>
                                                        [&nbsp
                                                        <select v-model="row_1.position_of_baby" :disabled=" !formEdit.second_screening">
                                                            <option v-for="item in position_of_baby">{{item.name}}</option>
                                                        </select>
                                                        &nbsp]
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label>Presentation</label>
                                                        [&nbsp
                                                        <select v-model="row_1.presentation_of_baby" :disabled=" !formEdit.second_screening">
                                                            <option v-for="item in presentation_of_baby">{{item.name}}</option>
                                                        </select>
                                                        &nbsp]
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>


                                    <td><input type="text" v-model="row_1.hc" :readonly=" !formEdit.second_screening" /></td>
                                    <td><input type="text"  v-model="row_1.ac" :readonly=" !formEdit.second_screening"/></td>
                                    <td><input type="text"  v-model="row_1.fl"  :readonly=" !formEdit.second_screening"/></td>
                                    <td><input type="text"  v-model="row_1.gs"  :readonly=" !formEdit.second_screening"/></td>
                                    <td><input type="text"  v-model="row_1.crl" :readonly=" !formEdit.second_screening" /></td>
                                    <td><input type="text"  v-model="row_1.bpd" :readonly=" !formEdit.second_screening" /></td>
                                    <td><input type="text"  v-model="row_1.ewb" :readonly=" !formEdit.second_screening" /></td>
                                    <td><input type="text"  v-model="row_1.fhr" :readonly=" !formEdit.second_screening" /></td>

                                <tr>
                                    <td colspan="4">
                                        <div class="form-inline">
                                            <label>Other</label>
                                            <textarea style="width: 100%; height:40px" class="form-control"  v-model="row_1.other" :readonly=" !formEdit.second_screening"></textarea>
                                        </div>
                                    </td>
                                    <td colspan="8">
                                        <div class="form-inline">
                                            <label>Remark and precautions</label>
                                            <textarea style="width: 100%; height:40px" class="form-control"  v-model="row_1.remark" :readonly=" !formEdit.second_screening"></textarea>
                                        </div>
                                        <v-autocomplete
                                            v-model="row_1.midwives"
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
                                </tbody>
                            </table>
                            <table class="table" id="second_table">
                                <tr class="table-active">
                                    <td>Date</td>
                                    <td>GA<small>(calculated)</small></td>
                                    <td>GA<small>(ultrasound)</small></td>
                                    <td>GA <small>(corrected)</small></td>
                                    <td colspan="3" align="center">
                                        <strong>III. Screening 28+0 bis 31+6 GA</strong>
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
                                                class="ml-4 d-print-none"
                                                v-if="!is_overview"
                                                color="secondary"
                                                dark
                                                @click="edit(3)"

                                        >
                                            Edit
                                        </v-btn>
                                        <v-btn  right
                                                small
                                                class="ml-4 d-print-none"
                                                color="primary"
                                                v-if="!is_overview"
                                                @click="row_push(dat.id,3)"
                                                icon

                                        >
                                            <v-icon  dark>mdi-plus-circle-outline</v-icon>
                                        </v-btn>
                                        <v-btn  right
                                                small
                                                class="ml-4 d-print-none"
                                                color="red"
                                                v-if="dat.third_screening.length>1 || !is_overview "
                                                @click="row_delete(dat.id,3)"
                                                icon

                                        >
                                            <v-icon  dark>mdi-minus-circle-outline</v-icon>
                                        </v-btn>
                                    </td>
                                </tr>
                                <tbody v-for="row_2 in dat.third_screening">
                                <tr>
                                    <td>
                                        <date-picker v-model="row_2.created_at"
                                            v-if="!formData.unknown_lpd"
                                            :input-debounce="500" mode="date"
                                            :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                            :max-date="new Date()"
                                            :readonly=" !formEdit.third_screening">
                                            <template v-slot="{ inputValue, inputEvents }">
                                                <input
                                                    class="bg-white border px-2 py-1 rounded"
                                                    :value="inputValue"
                                                    v-on="inputEvents"

                                                />
                                            </template>
                                        </date-picker>
                                    </td>
                                    <td><gestational-age v-model="row_2.wop_calculated" :readonly=" !formEdit.third_screening"/></td>
                                    <td><gestational-age v-model="row_2.wop_ultrasound" :readonly=" !formEdit.third_screening"/></td>
                                    <td><gestational-age v-model="row_2.wop_corrected" :readonly=" !formEdit.third_screening"/></td>
                                    <td colspan="3" rowspan="3" class="border">
                                        <table class="table">
                                            <tr class="table table-borderless">
                                                <td>
                                                    <div class="form-check form-inline">
                                                        <label>Placenta</label> &nbsp
                                                        [ &nbsp
                                                        <select v-model="row_2.placenta_type" :readonly=" !formEdit.third_screening">
                                                            <option></option>
                                                            <option v-for="type in placenta_type">{{type.name}}</option>
                                                        </select>
                                                        &nbsp ]
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="form-check-label">Normal birth possible</label>
                                                    <v-radio-group row  class="mt-0 p-0 small" v-model="row_2.normal_birth" :readonly=" !formEdit.third_screening">
                                                        <v-radio label="Yes" color="success" value="yes" class="radio"></v-radio>
                                                        <v-radio label="No" color="red" value="no" class="radio" ></v-radio>
                                                    </v-radio-group>
                                                </td>
                                                <td>
                                                    <label class="form-check-label">Normal growth</label>
                                                    <v-radio-group row  class="mt-0 p-0 small" v-model="row_2.normal_growth" :readonly=" !formEdit.third_screening">
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
                                                            <input type="radio" class="form-check-input" name="amnio" id="amnio_1" value="<5" v-model="row_2.amniotic_liquid"/>&nbsp&nbsp
                                                            <label><5</label>&nbsp&nbsp
                                                            <input type="radio" class="form-check-input" name="amnio" id="amnio_2" value="5-20" v-model="row_2.amniotic_liquid"/>&nbsp&nbsp
                                                            <label>5-20</label>&nbsp&nbsp
                                                            <input type="radio" class="form-check-input" name="amnio" id="amnio_3" value=">20" v-model="row_2.amniotic_liquid"/>&nbsp&nbsp
                                                            <label>>20</label>&nbsp&nbsp
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <label>Amniotic liquid (Single pocket)</label>
                                                        <div class="form-inline">
                                                            <input type="radio" class="form-check-input" name="single_pocket" id="single_pocket_1" value="<2" v-model="row_2.single_pocket"/>&nbsp&nbsp
                                                            <label><2</label>&nbsp&nbsp
                                                            <input type="radio" class="form-check-input" name="single_pocket" id="single_pocket_2" value=">10" v-model="row_2.single_pocket"/>&nbsp&nbsp
                                                            <label><10</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td><input type="text" v-model="row_2.hc"  :readonly=" !formEdit.third_screening"/></td>
                                    <td><input type="text"  v-model="row_2.ac" :readonly=" !formEdit.third_screening"/></td>
                                    <td><input type="text"  v-model="row_2.fl"  :readonly=" !formEdit.third_screening"/></td>
                                    <td><input type="text"  v-model="row_2.gs"  :readonly=" !formEdit.third_screening"/></td>
                                    <td><input type="text"  v-model="row_2.crl"  :readonly=" !formEdit.third_screening"/></td>
                                    <td><input type="text"  v-model="row_2.bpd"  :readonly=" !formEdit.third_screening"/></td>
                                    <td><input type="text"  v-model="row_2.ewb"  :readonly=" !formEdit.third_screening"/></td>
                                    <td><input type="text"  v-model="row_2.fhr"  :readonly=" !formEdit.third_screening"/></td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div class="form-inline">
                                            <label>Other</label>
                                            <textarea style="width: 100%;height:40px" class="form-control"  v-model="row_2.other" :readonly=" !formEdit.third_screening"></textarea>
                                        </div>
                                    </td>
                                    <td colspan="8">
                                        <div class="form-inline">
                                            <label>Remark and precautions</label>
                                            <textarea style="width: 100%; height:40px" class="form-control"  v-model="row_2.remark" :readonly=" !formEdit.third_screening"></textarea>
                                        </div>
                                        <v-autocomplete
                                            v-model="row_2.midwives"
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
                                </tbody>
                            </table>
                        </div>

                    </v-tab-item>
                </v-tabs>
                <v-btn class="float-right d-print-none" color="secondary" @click.prevent="submit" v-if="!is_overview">
                    Submit
                </v-btn>
            </v-card>
        </v-app>
    </div>
</template>

<script>
import gestationalAge from "../../../../components/gestational_age_control";

export default {
    name: "ultrasound_form",
    props:["is_overview","ultrasound_ref"],
    components: { gestationalAge },
    data:()=>{
        return{
            formData:[
                {
                    id:0,
                    patient_id:'',
                    first_screening:[
                        {
                            id: null,
                            created_at:'',
                            wop_calculated: null,
                            wop_corrected: null,
                            wop_ultrasound: null,
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
                            midwives:[],
                            status:'new',
                            valid:false,
                            fetus:0
                        },

                    ],
                    second_screening:[{
                        id: null,
                        created_at:'',
                        wop_calculated: null,
                        wop_corrected: null,
                        wop_ultrasound: null,
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
                        status:'new',
                        valid:false,
                        fetus:0
                    }],
                    third_screening:[{
                        id: null,
                        created_at:'',
                        wop_calculated: null,
                        wop_corrected: null,
                        wop_ultrasound: null,
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
                        status:'new',
                        remark:'',
                        valid:false,
                        fetus:0
                    }],
                },
            ],
            defaultData:[
                {
                    id:0,
                    patient_id:'',
                    first_screening:[
                        {
                            id: null,
                            created_at:'',
                            wop_calculated: null,
                            wop_corrected: null,
                            wop_ultrasound: null,
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
                            midwives:[],
                            status:'new',
                            valid:false,
                            fetus:0
                        },

                    ],
                    second_screening:[{
                        id:null,
                        created_at:'',
                        wop_calculated: null,
                        wop_corrected: null,
                        wop_ultrasound: null,
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
                        status:'new',
                        valid:false,
                        fetus:0
                    }],
                    third_screening:[{
                        id: null,
                        created_at:'',
                        wop_calculated: null,
                        wop_corrected: null,
                        wop_ultrasound: null,
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
                        status:'new',
                        remark:'',
                        valid:false,
                        fetus:0
                    }],
                },
            ],
            first_screening_data:{
                id:null,
                created_at:'',
                wop_calculated: null,
                wop_corrected: null,
                wop_ultrasound: null,
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
                midwives:[],
                status:'new',
                valid:false,
                fetus:''

            },
            second_screening_data:{
                id: null,
                created_at:'',
                wop_calculated: null,
                wop_corrected: null,
                wop_ultrasound: null,
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
                status:'new',
                valid:false,
                fetus:''
            },
            third_screening_data:{
                id: null,
                created_at:'',
                wop_calculated: null,
                wop_corrected: null,
                wop_ultrasound: null,
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
                status:'new',
                remark:'',
                valid:false,
                fetus:''
            },
            dialog:false,
            edit_dialog:false,
            count_of_fetus:1,
            placenta_type:'',
            position_of_baby:[],
            presentation_of_baby:[],
            possible_fetus_count:[1,2,3],
            reference:'',
            cpn_admission_id: null,
            is_updating:false,
            midwives:['Tanja','Tianasoa','Manitra','Finaritra'],
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
            authorized_user:false,
            edited_screening:'',
            accessory: {
                dateConfig: {
                      type: 'string',
                      mask:'iso',
                      masks: {
                          input: 'DD/MMM/YYYY',
                    },
                },
                cpn_link_error_message: null,
                linked_cpn_exists: false
            }
        }
    },
    created(){
        this.init()
    },
    watch:{
        formData:{
            handler(val){
                val.forEach(row=>{
                    row.first_screening.forEach(data=>{
                        if(data.created_at !=='' && data.wop_calculated && data.midwives.length>0) data.valid=true
                    })
                    row.second_screening.forEach(data=>{
                        if(data.created_at !=='' && data.presentation_of_baby !=='' && data.wop_calculated && data.position_of_baby !== '' && data.midwives.length>0) data.valid=true
                    })
                    row.third_screening.forEach(data=>{
                        if(data.created_at !==''  && data.wop_calculated && data.placenta_type !== '' && data.midwives.length>0) data.valid=true;

                        const calculatedDays = this.get_gestational_age_in_days(data.wop_calculated);
                        const ultrasoundDays = this.get_gestational_age_in_days(data.wop_ultrasound);

                        if (!calculatedDays || !ultrasoundDays)
                            data.wop_equality = null;
                        else
                        {
                            if (calculatedDays > ultrasoundDays)
                                data.wop_equality = 0;
                            else if (calculatedDays < ultrasoundDays)
                                data.wop_equality = 2;
                            else
                                data.wop_equality = 1;
                        }
                    })
                })
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
            await axios.get('/api/position_of_baby')
                .then(res=>this.position_of_baby=res.data)
            await axios.get('/api/presentation_of_baby')
                .then(res=>this.presentation_of_baby=res.data)
            axios.get('/api/placenta_type')
                .then(res=>this.placenta_type=res.data)
            if (this.$route.params.patient_id !== "" && this.$route.params.patient_id !== undefined) {
                this.patient.id = this.$route.params.patient_id;
                this.changePatient();
            }
            if(this.$route.params.ref !== ""){
                this.reference= this.$route.params.ref
                history.replaceState(null, null, this.$router.resolve({ name: 'ultrasound_form' }).href);

                this.search()
            }
            if(this.ultrasound_ref !==''|| this.ultrasound_ref!==undefined){
                this.reference= this.ultrasound_ref
                this.search()
            }

        },
        count_of_twin(){
            const currentCount = this.formData.length;

            if (currentCount < this.count_of_fetus) {
                for(let i=currentCount; i<this.count_of_fetus;i++){
                    this.push_form_data(i);
                }
            }
            else if (currentCount > this.count_of_fetus) {
                this.formData.splice(this.count_of_fetus);
            }

            this.dialog=false
        },
        push_form_data(i){
            this.formData.push({
                id:i,
                first_screening:[{
                    id: null,
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
                    ewb:'',
                    bpd:'',
                    intrauterine:false,
                    heartbeat:false,
                    embryo_visible:false,
                    remark:"",
                    midwives:[],
                    valid:false,
                    fetus:i+1
                }],
                second_screening:[{
                    id: null,
                    created_at:"",
                    wop_calculated: null,
                    wop_ultrasound: null,
                    wop_corrected: null,
                    hc:"",
                    ac:"",
                    fl:"",
                    gs:"",
                    crl:"",
                    fhr:"",
                    ewb:'',
                    bpd:'',
                    other:"",
                    position_of_baby:'',
                    presentation_of_baby:'',
                    heart_beat:false,
                    placenta_type:false,
                    normal_growth:false,
                    normal_amniotic_fluid:false,
                    suspicion_for_malformation:false,
                    remark:'',
                    midwives:[],
                    valid:false,
                    fetus:i+1
                }],
                third_screening:[{
                    id: null,
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
                    ewb:'',
                    bpd:'',
                    other:"",
                    normal_growth:false,
                    heart_beat:false,
                    placenta_type:'',
                    normal_birth:'',
                    amniotic_liquid:'',
                    wop_equality:'',
                    midwives:[],
                    valid:false,
                    fetus:i+1
                }]

            },)
        },
        get_gestational_age_in_days(ga) {
            if (!ga)
                return null;
            const parts = ga.split('+');
            if (parts.length !== 2)
                return null;

            return (Number(parts[0]) * 7) + Number(parts[1]);
        },
        async submit(e){
            e.preventDefault()
            await axios.post('/api/obstetrics/ultrasound',{formData:this.formData,patient_id:this.patient.id, count_of_fetus:this.count_of_fetus,ref:this.reference,cpn_admission_id:this.cpn_admission_id})
                .then(
                    resp=>{
                        this.$toast.open({
                            message: `${resp.data.msg} `,
                            position: "top-right",
                            type: "success",
                            duration: 0,
                        })
                    }
                )
                .then(
                     this.reset()
                )
        },
        async search(){
            const reference = this.reference;
            if(!reference) {
                this.reset();
                return;
            }

            //this.reset()
            this.is_updating=true
            let response= await axios.get(`/api/obstetrics/ultrasound/${reference}`)
            this.count_of_fetus=response.data.count
            
            let first_data=[]
            let second_data=[]
            let third_data=[]
            let output=[]
            for(let i=0;i<this.count_of_fetus;i++){
                if(response.data.first.length>0){
                    first_data=  response.data.first
                    this.formEdit.first_screening=false


                }else{
                    this.first_screening_data.fetus=i
                    first_data.push([Object.assign({},this.first_screening_data)])
                }
                if(response.data.second.length>0){
                    second_data=  response.data.second
                    this.formEdit.second_screening=false

                }else{
                    this.second_screening_data.fetus=i
                    second_data.push([Object.assign({},this.second_screening_data)])

                }
                if(response.data.third.length>0){
                    third_data=  response.data.third
                    this.formEdit.third_screening=false

                }else{
                    this.third_screening_data.fetus=i
                    third_data.push([Object.assign({},this.third_screening_data)])
                }

                output.push({
                    id:i,
                    first_screening:first_data[i],
                    second_screening:second_data[i],
                    third_screening:third_data[i]
                })

            }
            this.formData=[...output]
            this.formData.forEach(dat => {
                dat.first_screening.forEach(row => {
                    row.midwives = row.midwives.length>0?row.midwives.split(','):''
                    row.created_at=  row.created_at !==''?this.date_format(row.created_at):''
                    row.status='update'
                })
                dat.second_screening.forEach(row => {
                    row.midwives = row.midwives.length>0?row.midwives.split(','):''
                    row.created_at=  row.created_at !==''?this.date_format(row.created_at):''
                    if(row.placenta_type==='' && row.created_at ==='' ){
                        row.status='new'
                    }else{row.status='update'}

                })
                dat.third_screening.forEach(row => {
                    row.midwives = row.midwives.length>0?row.midwives.split(','):''
                    row.created_at=  row.created_at !==''?this.date_format(row.created_at):''
                    if(row.placenta_type==='' && row.created_at ==='' ){
                        row.status='new'
                    }else{row.status='update'}

                })
            })
            this.cpn_admission_id = response.data.cpn_admission_id;
            this.patient.id=response.data.patient_id
            this.reference = reference;
            this.changePatient()
        },
        async edit(id){
            this.edit_dialog=true
            this.edited_screening=id
        },
        async login(){
            await axios.post('/api/auth/credentials',this.loginForm)
                .then(response=>{
                    if(response.data.success===true){
                        this.authorized_user=true
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
            this.formData= Object.assign([],this.defaultData)
            this.formEdit=Object.assign({},{
                first_screening:true,
                second_screening:true,
                third_screening:true,
            })
            this.cpn_admission_id = null;
        },
        async changePatient(){
            let patData = await axios.get(
                `/api/patients/${this.patient.id}/edit`
            );
            let lastName= patData.data.patient.lastName==null?'':patData.data.patient.lastName
            this.patient.fullName = patData.data.patient.firstName.toUpperCase()+ " " + lastName;
        },
        row_push(fetus,rank){
            switch (rank){
                case 1:
                    this.formData[fetus].first_screening.push({
                        created_at:'',
                        wop_calculated: null,
                        wop_corrected: null,
                        wop_ultrasound: null,
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
                        midwives:[],
                        status:'new',
                        fetus:fetus
                    })
                    break;
                case 2:
                    this.formData[fetus].second_screening.push({
                        created_at:'',
                        wop_calculated: null,
                        wop_corrected: null,
                        wop_ultrasound: null,
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
                        valid:false,
                        fetus:fetus
                    })
                    break;
                case 3:
                this.formData[fetus].third_screening.push({
                    created_at:'',
                    wop_calculated: null,
                    wop_corrected: null,
                    wop_ultrasound: null,
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
                    valid:false,
                    fetus:fetus
                })
                    break;
            }
        },
        row_delete(fetus,rank){
            switch (rank){
                case 1:
                    this.formData[fetus].first_screening.pop()
                    break;
                case 2:
                    this.formData[fetus].second_screening.pop()
                    break;
                case 3:
                    this.formData[fetus].third_screening.pop()
                    break;

            }
        },
        date_format(date){
            let src= new Date(date)
            let year = src.getFullYear()
            let d=String(src.getDate()).padStart(2,'0')
            let month= String(src.getMonth()+1).padStart(2,'0')
            return `${year}-${month}-${d}`
        },
        linked_cpn_change(e) {
            if (!e.target.value) {
                this.accessory.linked_cpn_exists = false;
                this.accessory.cpn_link_error_message = null;
                return;
            }

          this.accessory.linked_cpn_exists = false;

          axios.get('/api/obstetrics/cpn/' + this.cpn_admission_id)
            .then(response =>
            {
                if (response.data.success) {
                    this.accessory.linked_cpn_exists = true;

                    if (response.data.admission.ultrasound_admission_id) {
                      this.accessory.cpn_link_error_message = "CPN already has a linked ultrasound";
                    }
                    else if (response.data.admission.patient_id != this.patient.id) {
                      this.accessory.cpn_link_error_message = "Patient Id does not match referenced CPN patient Id";
                    }
                    else
                      this.accessory.cpn_link_error_message = null;
                }
                else {
                    this.accessory.linked_cpn_exists = false;
                    this.accessory.cpn_link_error_message = "Could not retrieve the CPN data";
                }
            })
            .catch(error => 
            {
              this.accessory.linked_cpn_exists = false;
              this.accessory.cpn_link_error_message = "Could not retrieve the CPN data";
            });
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

@media print {
    container-fluid{size:landscape !important}
}

</style>

