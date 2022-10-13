<template>
    <v-app>
        <div class="container">
            <div class="p-2 title">
                <h2 style="display: inline-block">Birth registration</h2>
                <v-btn class="float-right d-print-none"><v-icon>mdi-printer</v-icon></v-btn>
            </div>
            <v-row class="mt-2">
                <v-col>
                    <v-card>
                        <v-card-title>General info</v-card-title>
                        <v-card-text>
                            <div class="form-inline">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input v-model="formData.birth_date" type="date" :class="{'error':$v.formData.birth_date.$error}"/>
                                </div>
                                <div class="form-group">
                                    <label>Time:</label>
                                    <input v-model="formData.birth_time" type="time" :class="{'error':$v.formData.birth_time.$error}"/>
                                </div>
                                <div class="form-group">
                                    <label>External Delivery:</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input v-model="formData.external_delivery"  type="radio" id="external_delivery_1" name="external_delivery" value="yes" class="custom-control-input v-model=">
                                        <label class="custom-control-label" for="external_delivery_1">yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input v-model="formData.external_delivery" type="radio" id="external_delivery_2" name="external_delivery" value="no" class="custom-control-input v-model=">
                                        <label class="custom-control-label" for="external_delivery_2">no</label>
                                    </div>
                                </div>
                                <div class="form-group" v-if="formData.external_delivery==='yes'">
                                    <label>Where</label>
                                    <select class="form-control-sm form-control" v-model="formData.external_delivery_place">
                                        <option v-for="opt in delivery_place">{{opt}}</option>
                                    </select>
                                </div>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-card>
                        <v-card-title class="purple darken-1 white--text">Mom</v-card-title>
                        <v-card-text>
                            <h5 class="subtitle mt-2">Personal Info</h5>
                            <div class="row">
                                <div class="col-sm-2 col-md-2" >
                                    Patient Nr: &nbsp <input type="number" v-model="formData.patient_id" @change="changePat" :class="{'error':$v.formData.patient_id.$error}" id="patNum"/>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    Fullname: &nbsp {{patient_fullname}}
                                </div>
                                <div  class="col-sm-4 col-md-2">
                                    Birthdate: &nbsp {{patient_birthDate}}
                                </div>
                                <div class="col-sm-4 col-md-3">
                                    Address: {{patient_adress}}
                                </div>

                            </div>
                            <h5 class="subtitle mt-2">Medical data</h5>
                            <div class="row">
                                <div class="col-sm-6 col-md-2">
                                    cpn ref: &nbsp <v-btn text dark color="blue" @click="view_pregnancy_card">{{formData.cpn_admission_id}}</v-btn>
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    GA: &nbsp <input v-model="formData.GA" type="text" style="max-width: 50px;" :class="{'error':$v.formData.GA.$error}"/>
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <div class="row ">
                                        <div class="form-group col-3"  >
                                            <label class="form-check-label">twin?</label> &nbsp
                                            <input type="checkbox" class="form-check-input" style="min-width: 50px" v-model="twin"/>
                                        </div>
                                        <div class="form-group col form-inline">
                                            <label v-if="twin">count of babies </label>
                                            <input type="number" max="3" class="form-control form-control-sm ml-2" style="max-width: 50px" v-model="count_twin" @change="insert_twin" v-if="twin"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label>Induction?</label> &nbsp
                                            <select v-model.number="formData.induction" :class="{'error':$v.formData.induction.$error}" >
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group ml-2" v-if="formData.induction===1">
                                            <v-select
                                                v-model="formData.induction_method"
                                                :items="induction_method"
                                                :menu-props="{ maxHeight: '400' }"
                                                label="Induction method"
                                                multiple
                                                dense
                                            ></v-select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-6" v-if="formData.induction===1">
                                    <v-select
                                        v-model="formData.induction_reason"
                                        :items="induction_reason"
                                        :menu-props="{ maxHeight: '400' }"
                                        label="Induction reason"
                                        multiple
                                        dense
                                    ></v-select>
                                </div>
                                <div>

                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div  class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label>Position Mom</label>
                                        <select v-model="formData.position" :class="{'error':$v.formData.position.$error}">
                                            <option v-for="position in position_mom">{{position}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div  class="col-sm-6">
                                    <div class="form-group">
                                        <label>CTG</label>
                                        <select v-model="formData.ctg">
                                            <option v-for="i in ctg">{{i}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div  class="col-sm-6">
                                    <div class="form-group p-2">
<!--                                        <label>Complication Before birth</label>-->
<!--                                        <textarea class="form-control form-control-sm" v-model="formData.complication_mom_before_birth" style="min-width: 100px"/>-->
                                        <v-select v-model="formData.complication_mom_before_birth" multiple label="Complication Before birth" :items="complication_mom_before_birth"/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group p-2">
<!--                                        <label>Complication After birth</label>-->
<!--                                        <textarea class="form-control form-control-sm" v-model="formData.complication_mom_after_birth"/>-->
                                        <v-select v-model="formData.complication_mom_after_birth" multiple label="Complication After birth" :items="complication_mom_after_birth"/>

                                    </div>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-sm-6 col-md-2">
                                    <div class="form-group">
                                        <label>Placenta Time</label>
                                        <input type="time" v-model="formData.placenta_time" :class="{'error':$v.formData.placenta_time.$error}" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <div class="form-group">
                                        <label :class="{'error':$v.formData.placenta_spontaneous.$error}">Placenta Spontaneous</label> &nbsp
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" id="placenta_spontaneous_1" name="placenta_spontaneous" value="yes" class="custom-control-input" v-model="formData.placenta_spontaneous">
                                            <label class="custom-control-label" for="placenta_spontaneous_1">yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" id="placenta_spontaneous_2" name="placenta_spontaneous" value="no" class="custom-control-input" v-model="formData.placenta_spontaneous">
                                            <label class="custom-control-label" for="placenta_spontaneous_2">no</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <div class="form-group">
                                        <label><span :class="{'error':$v.formData.placenta_complete.$error}">Pla.Complete</span></label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" id="placenta_complete_1" name="placenta_complete" value="yes" class="custom-control-input" v-model="formData.placenta_complete">
                                            <label class="custom-control-label" for="placenta_complete_1">yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" id="placenta_complete_2" name="placenta_complete" value="no" class="custom-control-input" v-model="formData.placenta_complete">
                                            <label class="custom-control-label" for="placenta_complete_2">no</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <div class="form-group">
                                        <span :class="{'error':$v.formData.placenta_manual_delivery.$error}">Pla. Manual Revision</span>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" id="placenta_manual_del_1" name="placenta_manual_del" value="yes" class="custom-control-input" v-model="formData.placenta_manual_delivery">
                                            <label class="custom-control-label" for="placenta_manual_del_1">yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" id="placenta_manual_del_2" name="placenta_manual_del" value="no" class="custom-control-input" v-model="formData.placenta_manual_delivery">
                                            <label class="custom-control-label" for="placenta_manual_del_2">no</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <div class="form-group">
                                        <span :class="{'error':$v.formData.placenta_curetage.$error}">Curetage</span>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" id="placenta_curetage_1" name="placenta_curetage" value="yes" class="custom-control-input" v-model="formData.placenta_curetage">
                                            <label class="custom-control-label" for="placenta_curetage_1">yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" id="placenta_curetage_2" name="placenta_curetage" value="no" class="custom-control-input" v-model="formData.placenta_curetage">
                                            <label class="custom-control-label" for="placenta_curetage_2">no</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                Injuries  &nbsp
                                <v-btn
                                    x-small
                                    color="primary"
                                    fab
                                    @click="formData.birth_injury = ! formData.birth_injury"
                                >
                                    <v-icon dark v-if="!formData.birth_injury">mdi-plus</v-icon>
                                    <v-icon dark v-if="formData.birth_injury">mdi-minus</v-icon>
                                </v-btn>
                            </div>
                            <div class="row" v-if="formData.birth_injury">
                                <div class="col">
                                    <select class="form-control form-control-sm" v-model="temp_injury.where">
                                        <option value="">Where</option>
                                        <option v-for="where in injury_where">{{where}}</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control form-control-sm"  v-model="temp_injury.position">
                                        <option value="">Position</option>
                                        <option v-for="position in injury_position">{{position}}</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control form-control-sm"  v-model="temp_injury.degree">
                                        <option value="">Degree</option>
                                        <option v-for="degree in injury_degree">{{degree}}</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <v-btn
                                        x-small
                                        color="success"
                                        icon
                                        @click="push_injury"
                                    >
                                        <v-icon>mdi-check</v-icon>
                                    </v-btn>
                                </div>
                            </div>
                            <div class="row" v-for="(row,i) in formData.injuries" >
                                <div class="col">
                                    {{row.where}}
                                </div>
                                <div class="col">
                                    {{row.position}}
                                </div>
                                <div class="col">
                                    {{row.degree}}
                                </div>
                                <div class="col">
                                    <v-btn
                                        x-small
                                        color="red"
                                        icon
                                        @click="delete_injury(i)"
                                    >
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Blood Loss</label>
                                        <select v-model="formData.blood_loss" class="form-control form-control-sm">
                                            <option v-for="b in blood_loss">{{b}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Stitches</label>
                                        <input type="text" class="form-control form-control-sm text-danger" v-model="formData.stiches"/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Anesthesia</label>
                                        <select v-model="formData.anesthesia"  :class="{'border-danger':$v.formData.anesthesia.$error}" class="form-control form-control-sm" >
                                            <option v-for="type in anesthesia">{{type}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Sterlisation package</label>
                                        <input type="text" v-model="formData.sterilisation_package" class="form-control form-control-sm"/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Stitches package</label>
                                        <input type="text" v-model="formData.stitches_package" class="form-control form-control-sm"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        Medicines used During delivery&nbsp
                                        <v-btn
                                            class="mx-2"
                                            fab
                                            dark
                                            color="indigo"
                                            x-small
                                            @click="accessory.add_med_during= !accessory.add_med_during"
                                        >
                                            <v-icon dark v-if="!accessory.add_med_during">
                                                mdi-plus
                                            </v-icon>
                                            <v-icon dark v-if="accessory.add_med_during">
                                                mdi-minus
                                            </v-icon>
                                        </v-btn>
                                    </div>
                                    <div class="row border mb-2 border-info" v-if="accessory.add_med_during">
                                        <div class="col-md-2 col-sm-6">
                                            <input type="time" class="form-control mt-2" v-model="accessory.search.time"/>
                                        </div>
                                        <div class="col-sm-6">

                                            <v-select
                                                :items="medicines_used_during"
                                                label="Medicines"
                                                v-model="accessory.search.item"
                                                dense
                                            ></v-select>
                                        </div>
                                        <div class="col-md-2 col-sm-6">
                                            <input type="number" class="form-control  mt-2" placeholder=" quantity" @keydown.enter.prevent="add_medicine('medicines_used_during')" v-model="accessory.search.quantity" />
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <v-btn color="purple" x-small @click="add_medicine('medicines_used_during')" class="mt-4" dark>Add</v-btn>
                                        </div>
                                    </div>
                                    <div class="row bg-secondary text-white" v-for="row in formData.medicines_used_during">
                                        <div class="col-md-3 col-sm-6">{{row.time}}</div>
                                        <div class="col-sm-6">{{row.item}}</div>
                                        <div class="col-md-3 col-sm-6">{{row.quantity}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        Medicines used after delivery&nbsp
                                        <v-btn
                                            class="mx-2"
                                            fab
                                            dark
                                            color="indigo"
                                            x-small
                                            @click="accessory.add_med_after= !accessory.add_med_after"
                                        >
                                            <v-icon dark v-if="!accessory.add_med_after">
                                                mdi-plus
                                            </v-icon>
                                            <v-icon dark v-if="accessory.add_med_after">
                                                mdi-minus
                                            </v-icon>
                                        </v-btn>
                                    </div>
                                    <div class="row border border-info mb-2" v-if="accessory.add_med_after">
                                        <div class="col-md-2 col-sm-6">
                                            <input type="time" class="form-control mt-2" v-model="accessory.search.time"/>
                                        </div>
                                        <div class="col-sm-6">
                                            <v-select
                                                :items="medicines_used_after"
                                                label="Medicines"
                                                v-model="accessory.search.item"
                                                dense
                                            ></v-select>
                                        </div>
                                        <div class="col-md-2 col-sm-6">
                                            <input type="number" class="form-control  mt-2" placeholder=" quantity" @keydown.enter.prevent="add_medicine('medicines_used_after')" v-model="accessory.search.quantity" />
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <v-btn color="purple" class="mt-4" x-small @click="add_medicine('medicines_used_after')" dark>Add</v-btn>
                                        </div>
                                    </div>
                                    <div class="row bg-secondary text-white" v-for="row in formData.medicines_used_after">
                                        <div class="col-md-3 col-sm-6">{{row.time}}</div>
                                        <div class="col-sm-6">{{row.item}}</div>
                                        <div class="col-md-3 col-sm-6">{{row.quantity}}</div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col">
                                    Remark:
                                    <textarea class="form-control"  v-model="formData.remarks"/>
                                </div>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col v-for="(baby,index) in formData.babies" :key="index" :set="v = $v.formData.babies.$each[index]">
                    <v-card min-width="400px">
                        <v-card-title class="purple accent-2 white--text">Baby-{{index+1}}</v-card-title>
                        <v-card-subtitle class="mt-2">
                            <div class="row" >
                                <div class="col-sm-6">
                                    Firstname
                                    <input type="text" v-model="baby.firstName" class="form-control form-control-sm" :class="{ 'error': v.firstName.$error }"/>
                                </div>
                                <div class="col-sm-6">
                                    Lastname
                                    <input type="text" v-model="baby.lastName" class="form-control form-control-sm" :class="{ 'error': v.lastName.$error }"/>
                                </div>
                            </div>
                        </v-card-subtitle>
                        <v-card-text>
                            <div class="row">
                                <div class="col-sm-3 col-md-2" >
                                    <div class="form-group">
                                        <label>Alive?</label><br>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'alive_1_'+index" name="alive" value="yes" class="custom-control-input" v-model="baby.alive">
                                            <label class="custom-control-label" :for="'alive_1_'+index">yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'alive_2_'+index" name="alive" value="no" class="custom-control-input" v-model="baby.alive">
                                            <label class="custom-control-label" :for="'alive_2_'+index">no</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6 col-md-4" v-if="baby.alive==='no'">
                                    <div class="form-group">
                                        <label>Death explanation</label>
                                        <input type="text" class="form-control form-control-sm" v-model="baby.death_explanation"/>
                                    </div>
                                </div>
                                <div class="col-sm-6  col-md-2">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select v-model="baby.gender" :class="{ 'error': v.gender.$error }" class="form-control form-control-sm">
                                            <option v-for="g in gender">{{g}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-2">
                                    <div class="form-group">
                                        <label>Modus</label>
                                        <select  v-model="baby.modus" :class="{ 'error': v.modus.$error }" class="form-control form-control-sm">
                                            <option v-for="type in modus">{{type.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <div class="form-group">
                                        <label>Position</label>
                                        <select v-model="baby.position" :class="{ 'error': v.position.$error }" class="form-control form-control-sm">
                                            <option v-for="pb in position_baby">{{pb}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <div class="form-group">
                                        <label>Presentation </label>
                                        <select v-model="baby.presentation"  class="form-control form-control-sm">
                                            <option v-for="pb in presentation_baby">{{pb}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-2">
                                    <div class="form-group">
                                        <label>Maturity</label>
                                        <select v-model="baby.maturity" :class="{ 'error': v.maturity.$error }" class="form-control form-control-sm">
                                            <option v-for="m in maturity">{{m}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-2">
                                    <div class="form-group">
                                        <label>Correlation</label>
                                        <select v-model="baby.correlation" :class="{ 'error': v.correlation.$error }" class="form-control form-control-sm">
                                            <option v-for="c in correlation">{{c}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-2">
                                    <div class="form-group">
                                        <label>Vit K</label>
                                        <select v-model="baby.vit_k" :class="{ 'error': v.vit_k.$error }" class="form-control form-control-sm">
                                            <option v-for="opt in vit_k">{{opt}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col padding-0">
                                    <div class="form-group">
                                        <label>Weight</label>
                                        <input type="number" v-model="baby.weight" :class="{ 'error': v.weight.$error }" class="form-control form-control-sm"/>
                                    </div>
                                </div>
                                <div class="col padding-0 ">
                                    <div class="form-group">
                                        <label>Length</label>
                                        <input type="number" v-model="baby.length" :class="{ 'error': v.length.$error }" class="form-control form-control-sm"/>
                                    </div>
                                </div>
                                <div class="col padding-0">
                                    <div class="form-group">
                                        <label>Head</label>
                                        <input type="number" v-model="baby.head" :class="{ 'error': v.head.$error }" class="form-control form-control-sm"/>

                                    </div>
                                </div>
                                <div class="col padding-0">
                                    <div class="form-group">
                                        <label>Arm</label>
                                        <input type="number" v-model="baby.arm" :class="{ 'error': v.arm.$error }" class="form-control form-control-sm"/>
                                    </div>
                                </div>
                                <div class="col padding-0">
                                    <div class="form-group">
                                        <label>Chest</label>
                                        <input type="number" v-model="baby.chest" :class="{ 'error': v.chest.$error }" class="form-control form-control-sm"/>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <label>APGAR</label>
                                </div>
                                <div class="col-2">
                                    <input type="number" class="form-control form-control-sm" v-model="baby.apgar_1" :class="{ 'error': v.apgar_1.$error }"/>
                                </div>
                                <div class="col-2">
                                    <input type="number" class="form-control form-control-sm" v-model="baby.apgar_2" :class="{ 'error': v.apgar_2.$error }"/>
                                </div>
                                <div class="col-2">
                                    <input type="number" class="form-control form-control-sm" v-model="baby.apgar_3" :class="{ 'error': v.apgar_3.$error }"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Malformation?</label><br>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'malformation_1_'+index" name="malformation" value="yes" class="custom-control-input" v-model="baby.malformation">
                                            <label class="custom-control-label" :for="'malformation_1_'+index">yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input  type="radio" :id="'malformation_2_'+index" name="malformation" value="no" class="custom-control-input" v-model="baby.malformation">
                                            <label class="custom-control-label" :for="'malformation_2_'+index">no</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group " v-if="baby.malformation==='yes'">
                                        <label>Explanation</label>
                                        <input type="text"   v-model="baby.malformation_explanation" class="form-control text-danger"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span :class="{ 'error': v.risk_of_cerebral_palsy.$error }">Risk of cerebral palsy and/or jaundice?</span>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" :id="'new_bron_risk_1'+index" :name="'new_bron_risk'+index" value="yes" class="custom-control-input" v-model="baby.risk_of_cerebral_palsy">
                                        <label class="custom-control-label" :for="'new_bron_risk_1'+index">yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" :id="'new_bron_risk_2'+index" :name="'new_bron_risk'+index" value="no" class="custom-control-input" v-model="baby.risk_of_cerebral_palsy">
                                        <label class="custom-control-label" :for="'new_bron_risk_2'+index">no</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>infection:</label>
                                        <input type="text" v-model="baby.infection" class="text-danger form-control"/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Pelvimetry</label>
                                        <select v-model="baby.pelvimetry" :class="{ 'error': v.pelvimetry.$error }">
                                            <option value="normal">Normal</option>
                                            <option value="pathological">Pathological</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span :class="{ 'error': v.cpa_needed.$error }">CPA needed?</span>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" :id="'cpa_needed_1'+index" :name="'cpa_needed'+index" value="yes" class="custom-control-input" v-model="baby.cpa_needed">
                                        <label class="custom-control-label" :for="'cpa_needed_1'+index">yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" :id="'cpa_needed_2'+index" :name="'cpa_needed'+index" value="no" class="custom-control-input" v-model="baby.cpa_needed">
                                        <label class="custom-control-label" :for="'cpa_needed_2'+index">no</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <span :class="{ 'error': v.extra_supervision_needed.$error }">Extra supervision needed?</span>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" :id="'extra_supervision_1'+index" :name="'extra_supervision'+index" value="yes" class="custom-control-input" v-model="baby.extra_supervision_needed">
                                        <label class="custom-control-label" :for="'extra_supervision_1'+index">yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" :id="'extra_supervision_2'+index" :name="'extra_supervision'+index" value="no" class="custom-control-input" v-model="baby.extra_supervision_needed">
                                        <label class="custom-control-label" :for="'extra_supervision_2'+index">no</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <span :class="{ 'error': v.swobs_taken.$error }">Swobs taken?</span>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" :id="'swobs_taken_1'+index" :name="'swobs_taken'+index" value="yes" class="custom-control-input" v-model="baby.swobs_taken">
                                        <label class="custom-control-label" :for="'swobs_taken_1'+index">yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input  type="radio" :id="'swobs_taken_2'+index" :name="'swobs_taken'+index" value="no" class="custom-control-input" v-model="baby.swobs_taken">
                                        <label class="custom-control-label" :for="'swobs_taken_2'+index">no</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                  <div class="form-group p-2">
<!--                                      <label>Complication Before birth</label>-->
<!--                                      <textarea class="form-control form-control-sm" v-model="baby.complication_before_birth"/>-->
                                      <v-select v-model="baby.complication_before_birth" multiple label="Complication before birth" :items="complication_baby_before_birth"/>


                                  </div>
                              </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
<!--                                        <label>Complication After birth</label>-->
<!--                                        <textarea class="form-control form-control-sm" v-model="baby.complication_after_birth"/>-->
                                        <v-select v-model="baby.complication_after_birth" multiple label="Complication after birth" :items="complication_baby_after_birth"/>

                                    </div>
                                </div>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-card  class="pa-2">
                        <v-card-title>Medical Team</v-card-title>
                        <table class="table medical-team">
                            <tr>
                                <td>Responsible Midwives</td>
                                <td colspan="5">
                                    <input type="text" v-model="formData.responsible_midwives" />
                                </td>
                            </tr>
                            <tr>
                                <td>Trainee</td>
                                <td colspan="5">
                                    <input type="text" v-model="formData.trainee"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Senior if present</td>
                                <td colspan="5">
                                    <input type="text" v-model="formData.senior_midwives"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Midwife assistant</td>
                                <td colspan="5">
                                    <input type="text" v-model="formData.assistant_midwives"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Anesthetist</td>
                                <td colspan="5">
                                    <input type="text" v-model="formData.anesthetists"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Doctor</td>
                                <td colspan="5">
                                    <input type="text" v-model="formData.doctors"/>
                                </td>
                            </tr>
                        </table>
                    </v-card>
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="2">
                    <v-btn  class="btn" id="submit" @click="submit" :loading="form_is_submitting" color="primary">Submit</v-btn>
                </v-col>
            </v-row>
        </div>
    </v-app>
</template>

<script>
import { validationMixin } from "vuelidate";
const {
    required,
    minLength,
    maxLength,
} = require("vuelidate/lib/validators");
export default {
    name: "delivery_registration",
    data(){
        return{
            formData:{
                code:'',
                patient_id:'',
                cpn_admission_id:'',
                birth_date:'',
                birth_time:'',
                GA:'',
                external_delivery:'',
                external_delivery_place:'',
                babies:[
                    {   id:'',
                        firstName:'',
                        lastName:'',
                        alive:'',
                        gender:'',
                        death_explanation:'',
                        death_type:'',
                        modus:'',
                        position:'',
                        presentation:'',
                        correlation:'',
                        maturity:'',
                        vit_k:'',
                        E1:'Done',
                        weight:'',
                        length:'',
                        head:'',
                        arm:'',
                        chest:'',
                        apgar:'',
                        apgar_1:'',
                        apgar_2:'',
                        apgar_3:'',
                        malformation:'',
                        malformation_explanation:'',
                        infection:'',
                        baby_not_crying:'',
                        risk_of_cerebral_palsy:'',
                        cpa_needed:'',
                        extra_supervision_needed:'',
                        swobs_taken:'',
                        pelvimetry:'',
                        complication_before_birth:[],
                        complication_after_birth:[],
                    }
                ],
                position:'',
                induction:'',
                induction_method:[],
                induction_reason:[],
                ctg:'',
                complication_mom_before_birth:[],
                complication_mom_after_birth:[],
                placenta_time:'',
                placenta_complete:'',
                placenta_spontaneous:'',
                placenta_manual_delivery:'',
                placenta_curetage:'',
                birth_injury:false,
                injuries:[],
                injury_where:'',
                injury_position:'',
                injury_degree:'',
                injuries_description:'',
                blood_loss:'',
                stiches:'',
                anesthesia:'',
                sterilisation_package:'',
                stitches_package:'',
                medicines_used_during:[],
                medicines_used_after:[],
                remarks:'',
                trainee:'',
                responsible_midwives:'',
                senior_midwives:'',
                assistant_midwives:'',
                doctors:'',
                anesthetists:'',

            },
            delivery_place:["at home","On the road","In the ambulance"],
            birth_complications:[
                'Long labour',
                'eclampsia',
                'Bad CTG',
                'High Blood pressure',
                'Long Pushing'
            ],
            position_mom:['laying on her back','laying on her side','sitting','standing','all fours','kneeing'],
            position_baby:['occiput anterior left','occiput anterior right','occiput posterior left','occiput posterior right','occiput sacre','cheen anterior','full knee','one foot','full feet','Oblic'],
            presentation_baby:['Cephalic','Breech','face','transversal'],
            ctg:['normal','pathological','suspicious'],
            blood_loss:['<250','250-500','500-750','750-1000','1000-1500','1500-2000','2000-2500','>2500'],
            correlation:['<','=','>'],
            maturity:['immature','premature','mature','post EDD'],
            gender:['M','F'],
            modus:[],
            patient_fullname:'',patient_adress:'',patient_birthDate:'',
            twin:false,count_twin:1,
            induction_method:["Ballon","Cytotec","Oxytocin","Opening of membranes"],
            induction_reason:["Gestational diabetes","High blood pressure","Short lady","MFIU","Pre eclampsia","suspicious CTG","To avoid C-section","IUGR","sign of infection","broken membranes >= 12h",'to avoid re c-section','big EFW comparing to the body of the mom'],
            injury_where:['Perineum','Vagina','Labia','Clitoris','Anus','Cervix'],
            complication_mom_before_birth: ['Gestational diabetes','Prolaps of the umbilical cord','polyhydramnion','Olygohydramnion',
                'suspicion of COVID','Stagnation of Dilatation','long labor','long pushing',
                'DFP','pre-eclampsia','infection signs','AIS','Placenta praevia total',
                'placenta praevia marginalis','early detachement of placenta',
                'suspicious pelvic','high blood pressure','epilepsia','sign of pre rupture of the uterus'],
            complication_mom_after_birth: ['Bleeding','Major tears','placenta Accreta','Hemorrhage','Curetage','Hysterectomie','Infection','atonie uterine','rupture uterine','T cut section'],
            complication_baby_before_birth:['bad CTG','Prolaps of the ubmilical cord','prolaps of the hand','head wrong position','IUGR','SGA','Abnormal presentation','macrosomia'],
            complication_baby_after_birth:['Umbilical cord wrap','Shoulder dystocia','bad baby','infection signs'],
            injury_position:["Left","right"],
            injury_degree:["I","II","III","IV"],
            anesthesia:["no","Local","General","Spinal"],
            medicines_used_during: ["Buscopan","SSI","SGI","RL","Ampicilline","Loxen","Cytotec","Partusisten","Oxyto","Meptid"],
            medicines_used_after: ["Oxyto","Cytotec IR","Exacyl","Ampicilline","Ibuprofene","Paracetamol","SSI","Cell gauz","SGI","RL"],
            baby_element:{
                id:'',
                firstName:'',
                lastName:'',
                alive:'',
                gender:'',
                death_explanation:'',
                death_type:'',
                modus:'',
                position:'',
                presentation:'',
                correlation:'',
                maturity:'',
                vit_k:'',
                E1:'Done',
                weight:'',
                length:'',
                head:'',
                arm:'',
                chest:'',
                apgar:'',
                apgar_1:'',
                apgar_2:'',
                apgar_3:'',
                malformation:'',
                malformation_explanation:'',
                infection:'',
                baby_not_crying:'',
                risk_of_cerebral_palsy:'',
                cpa_needed:'',
                extra_supervision:'',
                swobs_taken:''
            },
            accessory:{
                search:{
                    item:'',
                    quantity:'',
                    time:''
                },
                temp_list:[],
                add_med_during:false,
                add_med_after:false,
                cpn_admission:null
            },
            vit_k:["no","orally","IV"],
            temp_injury:{
                where:'',
                position:'',
                degree:''
            },
            form_is_submitting:false

        }
    },
    validations:{
        formData:{
            patient_id:{required},
            GA:{required},
            induction:{required},
            birth_date:{required},
            birth_time:{required},
            position:{required},
            external_delivery:{required},
            placenta_time:{required},
            placenta_complete:{required},
            placenta_spontaneous:{required},
            placenta_manual_delivery:{required},
            placenta_curetage:{required},
            anesthesia:{required},
            babies:{
                $each:{
                    firstName:{required},
                    lastName:{required},
                    alive:{required},
                    gender:{required},
                    modus:{required},
                    position:{required},
                    correlation:{required},
                    maturity:{required},
                    vit_k:{required},
                    weight:{required},
                    length:{required},
                    head:{required},
                    arm:{required},
                    chest:{required},
                    apgar_1:{required},
                    apgar_2:{required},
                    apgar_3:{required},
                    risk_of_cerebral_palsy:{required},
                    cpa_needed:{required},
                    extra_supervision_needed:{required},
                    swobs_taken:{required},
                    pelvimetry:{required}

                }
            },
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){


            await axios.get('/api/v1/extra/birth_type').then(response=>this.modus=response.data)
            this.fetch_last_code()
        },
        async fetch_last_code(){
            await axios.get('/api/v1/patient_system/delivery/last_code').then(response=>this.formData.code=response.data)
        },
        async changePat(){
            await axios.get(`/api/v1/patient_system/delivery/patient_data/${this.formData.patient_id}`).then(response=>{
                this.patient_fullname= this.nullToStr(response.data.patient_data.firstName) + ' '+ this.nullToStr(response.data.patient_data.lastName)
                this.patient_adress=response.data.patient_data.adress
                this.patient_birthDate=response.data.patient_data.birthDate
                this.formData.cpn_admission_id= response.data.patient_data.cpn_admissions[0]?.id
                this.formData.GA=response.data.ga
                this.accessory.cpn_admission=response.data.patient_data.cpn_admissions[0]

            })
        },
        insert_twin(){
            this.formData.babies=[]
            for(let i=1;i<=this.count_twin;i++){
                this.formData.babies.push({...this.baby_element})
            }
        },
        async submit(){
            this.$v.$touch()
            if(!this.$v.$invalid){
                this.form_is_submitting=true
                this.formData.code= this.new_code
                this.formData.user_id = window.auth.user.id
                this.formData.induction_method= this.formData.induction_method.constructor===Array?  this.formData.induction_method.join():this.formData.induction_method
                this.formData.induction_reason= this.formData.induction_reason.constructor===Array? this.formData.induction_reason.join():this.formData.induction_reason
                this.formData.complication_mom_before_birth= this.formData.complication_mom_before_birth.constructor===Array? this.formData.complication_mom_before_birth.join():this.formData.complication_mom_before_birth
                this.formData.complication_mom_after_birth= this.formData.complication_mom_after_birth.constructor===Array? this.formData.complication_mom_after_birth.join():this.formData.complication_mom_after_birth
                this.formData.babies.forEach(baby=>{
                    baby.complication_before_birth= baby.complication_before_birth.constructor===Array? baby.complication_before_birth.join(): baby.complication_before_birth
                    baby.complication_after_birth= baby.complication_after_birth.constructor===Array ? baby.complication_after_birth.join() :baby.complication_after_birth
                })
                await axios.post('/api/v1/patient_system/delivery/register_birth',this.formData).then(response=>{
                    if(response.data.success){
                        this.form_is_submitting=false
                        this.$toast.open({
                            message:JSON.stringify(response.data.patients),
                            duration:0,
                            position:'top'
                        })
                        this.$router.push({name:'birth_certificate',code:response.data.id})

                    }
                })
            }

        },
        // async fetchItem(code){
        //     this.accessory.search.temp_list = [];
        //     await axios({
        //         method:'GET',
        //         url:'http://127.0.0.1:8000/api/item',
        //         params:{ search_text: code },
        //     }).then((response) => {
        //             let data = response.data.data;
        //             this.accessory.temp_list=data
        //         });
        // },
        add_medicine(type){
            if (
                this.accessory.search.item !== "" &&
                this.accessory.search.quantity !== ""
            ) {
                this.formData[type].push({
                    item: this.accessory.search.item,
                    time:this.accessory.search.time,
                    quantity: this.accessory.search.quantity,
                });
                this.accessory.search.item = "";
                this.accessory.search.time = "";
                this.accessory.search.quantity = "";
                this.accessory.edit = true;
            }
        },
        nullToStr(text){
            return text===null?'':text
        },
        view_pregnancy_card(){
            this.$router.push({name:'delivery_pregnancy_card',params:{data:this.accessory.cpn_admission}})
            // let routeData = this.$router.resolve({name: 'routeName', query: {data: "someData"}});
            // window.open(routeData.href, '_blank');
        },
        push_injury(){
            console.log("here")
            if(this.temp_injury.where!==''){
                this.formData.injuries.push(this.temp_injury)
                this.temp_injury={
                    where:'',
                    position:'',
                    degree:''
                }
            }
        },
        delete_injury(i){
            this.formData.injuries.splice(i,1)
        }
    },
    computed:{
        new_code(){
            let date =new Date()
            let intPart= parseInt(this.formData.code.split('-')[1])
            intPart++
            let zero=''
            let intPart_length= intPart.toString().length
            for(let i=0;i<3-intPart_length;i++){
                zero+='0'
            }
            return date.getFullYear()+'-'+zero+intPart
        },
        apgar(){
            let result=[]
            this.formData.babies.forEach(baby=>{
                result.push(baby.apgar_1+"/"+baby.apgar_2+"/"+baby.apgar_3)
            })
            return result
        }
    }
}
</script>

<style scoped>
.title{
    background-color: #1A417E;
    color:whitesmoke;
}
input, select{
    border:0.5px  solid lightgrey;
}
/*input[type=number]{*/
/*    width:50px;*/
/*}*/
#patNum{
    max-width: 60px;
}
.medical-team input{
    width:100%;
}
#submit{
    background-color:#bc51cf;
    color:white;
}
.subtitle{
    color:#1A417E;
}
.input-table{
    padding:0px 10px 0px !important;
    height:2px;
}
.input-table>td{
    padding:0px 10px 0px !important;
    margin:0px 10px 0px;
}
.padding-0{
    padding-right:0;
    padding-left:0;
}
/*@media print{*/
/*    .registration-container{*/
/*        margin-left: -250px !important;*/
/*        !*width: 210mm;*!*/
/*        !*height: 297mm;*!*/
/*        size:A4;*/
/*        padding: 50px;*/
/*    }*/
/*}*/
/*@media screen and (max-width: 1480px){*/
/*    .registration-container{*/
/*        transform: scale(0.9);*/
/*    }*/
/*}*/
</style>
