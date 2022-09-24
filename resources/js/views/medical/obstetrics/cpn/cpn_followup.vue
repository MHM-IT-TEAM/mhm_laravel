<template>
    <div class="container-fluid">
        <Loading :active.sync="accessory.isLoading"></Loading>
        <v-app>
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
                    <v-btn
                        fab
                        dark
                        small
                        color="orange"
                        @click="accessory.show_internal_referral=true"
                    >
                        IR
                    </v-btn>
                    <v-btn
                        fab
                        dark
                        small
                        color="purple"
                        @click="accessory.show_additional_consult=true"
                    >
                        AC
                    </v-btn>
                </v-speed-dial>
                <div class="mt-6 p-2" v-if="patient_details">
                    <span>{{ patientFullName }}</span>
                </div>
                 <v-data-table
                :headers="headers"
                :items="cpn_data"
                sort-by="created_at"
                :sort-desc="true"
                class="elevation-1"
                :items-per-page="is_overview ? -1 : 10"
            >
                <template v-slot:top>
                    <v-toolbar
                        flat
                    >
                        <v-toolbar-title>PRENATAL CARE FOLLOWUP</v-toolbar-title>

                            <v-text-field
                                hide-details
                                placeholder="type the reference here"
                                v-model="manual_cpn_admission_id_search"
                                class="search ml-4"
                                @change="get_data(manual_cpn_admission_id_search)"
                                prepend-icon="mdi-magnify"
                                v-if="!is_overview"
                            ></v-text-field>
                            <span v-if="noDataFound" class="text-white bg-danger">no data found</span>
                        <v-btn color="primary" @click="navigateToAdmission"  v-if="!is_overview" small>View first checkup</v-btn >
                        <v-divider
                            class="mx-4"
                            inset
                            vertical
                            v-if="!is_overview"
                        ></v-divider>
<!--                        <v-btn color="primary" @click="navigateToOverview"  v-if="!is_overview" small>View overview</v-btn>-->


                        <v-dialog
                            v-model="dialog"
                            max-width="100vw"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    color="primary"
                                    dark
                                    class="mb-2"
                                    v-bind="attrs"
                                    v-on="on"
                                    small
                                    v-if="!is_overview"
                                >
                                    New Data
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title class="align-items-baseline">
                                    <span class="headline">{{ formTitle }}</span>
                                    <span class="pl-2" v-if="patientFullName">- {{ patientFullName }}</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container >

                                        <v-row>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                            <v-text-field
                                                :value="editedItem.gestational_age"
                                                label="Gestational age"
                                                readonly
                                                disabled
                                            ></v-text-field>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-text-field
                                                    v-model="editedItem.weight"
                                                    label="weight(kg)"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-text-field
                                                    v-model="editedItem.bp_left"
                                                    label="Blood pressure (left)"
                                                ></v-text-field>

                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-text-field
                                                    v-model="editedItem.bp_right"
                                                    label="Blood pressure (right)"
                                                ></v-text-field>

                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    :items="eyes"
                                                    label="Eyes"
                                                    v-model="editedItem.eyes"
                                                ></v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    :items="ok"
                                                    label="Breast checkup"
                                                    v-model="editedItem.breast"
                                                ></v-select>
                                            </v-col>

                                        </v-row>
                                        <v-row>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-text-field
                                                    v-model="editedItem.belly_size"
                                                    label="Belly size(cm)"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-text-field
                                                    v-model="editedItem.uterus_size"
                                                    label="Uterus size(cm)"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    :items="lp1"
                                                    item-text="name"
                                                    item-value="value"
                                                    label="LP I"
                                                    v-model="editedItem.lp1"
                                                ></v-select>

                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    :items="lp2"
                                                    item-text="name"
                                                    label="LP II"
                                                    v-model="editedItem.lp2"

                                                ></v-select>

                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    :items="lp3"
                                                    label="LP III"
                                                    item-text="name"
                                                    v-model="editedItem.lp3"

                                                ></v-select>

                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    :items="posNeg"
                                                    v-model="editedItem.mov_baby"
                                                    label="Movement of the baby"
                                                ></v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-text-field
                                                    v-model="editedItem.heartbeat_baby"
                                                    label="Heartbeat of the baby"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                             <v-select
                                                 :items="cervix_length"
                                                 item-text="name"
                                                 v-model="editedItem.cervix_length"
                                                 label="Cervix length"
                                             ></v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Cervix position"
                                                    :items="cervix_position"
                                                    item-text="name"
                                                    v-model="editedItem.cervix_position"
                                                >

                                                </v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2">
                                                <v-select
                                                    label="Cervix consistency"
                                                    :items="cervix_consistency"
                                                    item-text="name"
                                                    v-model="editedItem.cervix_consistency"
                                                >

                                                </v-select>

                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2">
                                                <v-select
                                                    label="Cervix opening"
                                                    :items="cervix_opening"
                                                    item-text="name"
                                                    v-model="editedItem.cervix_opening"
                                                >

                                                </v-select>

                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Discharge"
                                                    :items="discharge"
                                                    v-model="editedItem.discharge"
                                                ></v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Liquids"
                                                    :items="liquids"
                                                    v-model="editedItem.liquids"
                                                ></v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Membranes"
                                                    :items="membranes"
                                                    v-model="editedItem.membranes"
                                                >

                                                </v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Leading parts"
                                                    :items="leading_part"
                                                    v-model="editedItem.leading_part"
                                                >
                                                </v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Leading part attitude"
                                                    :items="leading_part_attitude"
                                                    v-model="editedItem.leading_part_attitude"
                                                >
                                                </v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Oedema"
                                                    :items="posNeg"
                                                    v-model="editedItem.oedema"
                                                ></v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Varicosis"
                                                    :items="varicosis"
                                                    v-model="editedItem.varicosis"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Protein test"
                                                    :items="urine_test"
                                                    v-model="editedItem.protein_test"
                                                ></v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Sugar test"
                                                    :items="urine_test"
                                                    v-model="editedItem.sugar_test"
                                                ></v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Blood test"
                                                    :items="urine_test"
                                                    v-model="editedItem.blood_test"
                                                ></v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Leucocyte test"
                                                    :items="urine_test"
                                                    v-model="editedItem.leucocyte_test"
                                                ></v-select>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-text-field
                                                    label="OGTT"
                                                    v-model="editedItem.ogtt"
                                                ></v-text-field>
                                            </v-col>

                                        </v-row>
                                        <v-row>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-checkbox
                                                    v-model="editedItem.ctg_needed"
                                                    label="CTG needed"
                                                    value=1
                                                ></v-checkbox>
                                               <v-select
                                                    :items="ctg_us_reasons"
                                                    label="Reason"
                                                    v-if="editedItem.ctg_needed"
                                                    v-model="editedItem.ctg_reason"
                                                    :class="{'error': $v.editedItem.ctg_reason.$error }">
                                               </v-select>
                                               <v-textarea
                                                    v-if="editedItem.ctg_needed"
                                                    v-model="editedItem.ctg_explanation"
                                                    label="Explanation"
                                                    rows="3"
                                                    dense
                                                >
                                                </v-textarea>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-checkbox
                                                    v-model="editedItem.us_needed"
                                                    label="US needed"
                                                    value=1
                                                ></v-checkbox>
                                                <v-select
                                                    :items="ctg_us_reasons"
                                                    label="Reason"
                                                    v-if="editedItem.us_needed"
                                                    v-model="editedItem.us_reason"
                                                    :class="{'error': $v.editedItem.ctg_reason.$error }">
                                                </v-select>
                                                <v-textarea
                                                    v-if="editedItem.us_needed"
                                                    v-model="editedItem.us_explanation"
                                                    label="Explanation"
                                                    rows="3"
                                                    dense
                                                >
                                                </v-textarea>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <div>
                                                    <label for="appointment">Appointment date</label>
                                                    <date-picker v-model="editedItem.appointment"
                                                        id="appointment"
                                                        @input="menu = false"
                                                        :input-debounce="500" mode="date"
                                                        :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                                        :min-date="new Date()"
                                                        :popover="{ visibility: is_overview ? 'hidden' : 'click' }">
                                                            <template v-slot="{ inputValue, inputEvents }">
                                                                <input
                                                                    class="bg-white border px-2 py-1 rounded"
                                                                    :value="inputValue"
                                                                    v-on="inputEvents"
                                                                    readonly
                                                                />
                                                            </template>
                                                    </date-picker>
                                                </div>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Senior midwife informed"
                                                    class="ml-2"
                                                    :items="senior_midwife"
                                                    multiple
                                                    v-model="editedItem.senior_informed"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-textarea label="Remark" v-model="editedItem.remark" rows="3"/>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <give_medicine @get_value="get_medicines" :reset="reset_medication_list"/>
                                        </v-row>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="close"
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="save"
                                    >
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="dialogDelete" max-width="500px">
                            <v-card>
                                <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                    <v-spacer></v-spacer>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                </template>
                <template v-slot:item.actions="{ item }" v-if="!is_overview">
                    <v-icon
                        small
                        class="mr-2"
                        @click="editItem(item)"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        small
                        @click="deleteItem(item)"
                    >
                        mdi-delete
                    </v-icon>
                </template>
                <template v-slot:no-data v-if="!is_overview">
                    <v-btn
                        class="float-left"
                        color="primary"
                        @click="initialize"
                        small
                    >
                        Reset
                    </v-btn>
                </template>
                <template v-slot:item.created_at="{ item }">
                    <span class="text-nowrap">{{ item.created_at }}</span>
                </template>
                <template v-slot:item.ctg_needed="{ item }">
                    <span>{{ yesNoString(item.ctg_needed) }}</span>
                </template>
                <template v-slot:item.us_needed="{ item }">
                    <span>{{ yesNoString(item.us_needed) }}</span>
                </template>
                <template v-slot:item.appointment="{ item }">
                    <span>{{ item.appointment ? new Date(item.appointment).toLocaleDateString() : '' }}</span>
                </template>
            </v-data-table>

                <senior-auth-dialog
                    v-on:authorized="authorized"
                    v-model="auth_dialog"
                />
                <v-dialog
                    v-model="accessory.show_internal_lab"
                >
                    <v-card>

                        <v-card-text class="p-2">
                            <internal_lab :form_type="'request'" :admission="$route.params.admission"/>
                        </v-card-text>
                    </v-card>
                </v-dialog>
            <v-dialog
                v-model="accessory.show_additional_consult"
            >
                <v-card>

                    <v-card-text class="p-2">
                        <additional_consultation :admission="$route.params.admission"/>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <v-dialog
                v-model="accessory.show_internal_referral"
            >
                <v-card>

                    <v-card-text class="p-2">
                        <internal_referral :admission="$route.params.admission" @form_submitted="accessory.show_internal_referral=false"/>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-app>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import gestationalAge from "../../../../components/gestational_age_control.vue"
import seniorAuthDialog from "../../../../components/senior_auth_dialog.vue"
import Give_medicine from "../../../../components/give_medicine";
import Internal_lab from "../../labwork/internal/internal_lab";
import Additional_consultation from "../../../../components/additional_consultation";
import Internal_referral from "../../../../components/internal_referral";
const {
    required,
    requiredIf,
    minLength,
    email,
    url,
    maxLength,
} = require("vuelidate/lib/validators");
    export default {
        name: "cpn_followup",
        mixins: [validationMixin],
        components: {
            Internal_referral,
            Additional_consultation, Internal_lab, Give_medicine, gestationalAge, seniorAuthDialog },
        props:['is_overview','cpn_admission_id'],
        data: () => ({
            dialog: false,
            dialogDelete: false,
            headers: [
                { text: 'Date', value: 'created_at' },
                { text: 'GA', value: 'gestational_age' },
                { text: 'Weight (kg)', value: 'weight' },
                { text: 'BP (left)', value: 'bp_left' },
                { text: 'BP (right)', value: 'bp_right' },
                { text: 'Eyes', value: 'eyes' },
                {text:'Breast',value:'breast'},
                {text:'Belly size (cm)',value:'belly_size'},
                {text:'Uterus size (cm)',value:'uterus_size'},
                {text:'LP I Uterus size (cm)',value:'lp1'},
                {text:'LPII',value:'lp2'},
                {text:'LPIII',value:'lp3'},
                {text:'Mov of the baby',value:'mov_baby'},
                {text:'Heartbeat of the baby', value:'heartbeat_baby'},
                {text:'Cervix length',value:'cervix_length'},
                {text:'Cervix posistion',value:'cervix_position'},
                {text:'Cervix Consistency',value:'cervix_consistency'},
                {text:'Cervix Opening',value:'cervix_opening', width: '150px'},
                {text:'Discharge',value:'discharge'},
                {text:'Liquids',value:'liquids'},
                {text:'Oedema',value:'oedema'},
                {text:'Varicosis',value:'varicosis'},
                {text:'Protein test',value:'protein_test'},
                {text:'Sugar test',value:'sugar_test'},
                {text:'Blood test',value:'blood_test'},
                {text:'Leucocyte test',value:'leucocyte_test'},
                {text:'OGTT',value:'ogtt'},
                {text:'CTG needed',value:'ctg_needed'},
                {text:'CTG reason',value:'ctg_reason'},
                {text:'CTG explanation',value:'ctg_explanation', width: '200px'},
                {text:'US needed',value:'us_needed'},
                {text:'US reason',value:'us_reason'},
                {text:'US explanation',value:'us_explanation', width: '200px'},
                {text:'Appointment',value:'appointment'},
                {text:'Remark',value:'remark',sortable:false, width: '300px'},
                {text:'Senior midwife informed',value:'senior_informed'},
                {text:'Responsible',value:'responsible'},
                {text:'Actions',value:'actions',sortable:false}
            ],
            cpn_data: [],
            editedIndex: -1,
            editedItem: {
                cpn_admission_id:'',
                date:"",
                gestational_age:null,
                weight:'',
                bp_left:'',
                bp_right:'',
                eyes:'',
                breast:'',
                belly_size:'',
                uterus_size:'',
                lp1:'',
                lp2:'',
                lp3:'',
                mov_baby:'',
                heartbeat_baby:'',
                cervix_length:'',
                cervix_consistency:'',
                cervix_opening:'',
                cervix_position:'',
                discharge:'',
                liquids:'',
                oedema:'',
                varicosis:'',
                protein_test:'',
                sugar_test:'',
                blood_test:'',
                leucocyte_test:'',
                ogtt:'',
                membranes:"",
                leading_part:"",
                leading_part_attitude: "",
                us_needed:null,
                us_reason:"",
                us_explanation:null,
                ctg_needed:null,
                ctg_reason:"",
                ctg_explanation:null,
                appointment:'',
                responsible:'',
                senior_informed:[],
                remark:''
            },
            defaultItem: {
                cpn_admission_id:'',
                date:"",
                gestational_age: null,
                weight:'',
                bp_left:'',
                bp_right:'',
                eyes:'',
                breast:'',
                belly_size:'',
                uterus_size:'',
                lp1:'',
                lp2:'',
                lp3:'',
                mov_baby:'',
                heartbeat_baby:'',
                cervix_length:'',
                cervix_consistency:'',
                cervix_opening:'',
                cervix_position:'',
                discharge:'',
                liquids:'',
                oedema:'',
                varicosis:'',
                protein_test:'',
                sugar_test:'',
                blood_test:'',
                leucocyte_test:'',
                ogtt:'',
                membranes:"",
                leading_part:"",
                leading_part_attitude: "",
                us_needed:null,
                us_reason:"",
                us_explanation:null,
                ctg_needed:null,
                ctg_reason:"",
                ctg_explanation:null,
                appointment:'',
                responsible:'',
                senior_informed:[],
                remark:''
            },
            auth_dialog: false,
            eyes:['white','medium','red'],
            ok:['ok','not ok'],
            lp1:[],
            lp2:[],
            lp3:[],
            pos_baby:[],
            posNeg:["positive","negative"],
            cervix_length:[],
            cervix_consistency:[],
            cervix_opening:[],
            cervix_position:[],
            membranes:["intact","bulging","ruptured","not to be determined"],
            discharge:["Candida", "Gardnerella", "Bleeding fresh", "Bleeding old", "Other"],
            liquids:["Clear", "Bloody", "Yellow", "Green", "Meconial", "Thick", "Infecteuse"],
            leading_part:["fixed","engaged","mobile","not reachable"],
            leading_part_attitude:["transversal","oblic","longitudinal","abnormal"],
            oedema:[],
            urine_test:["Negative","trace","+","++","+++","invalid"],
            varicosis:["Negative","Left leg","Right leg","Both legs", "Vulva"],
            ctg_us_reasons:["QM","Additional"],
            senior_midwife:["Tanja","Tianasoa", "Marlies"],
            is_new_form:true,
            menu:false,
            patient_details:{},
            noDataFound:false,
            manual_cpn_admission_id_search:'',
            accessory: {
                dateConfig: {
                    type: 'string',
                    mask:'iso',
                    masks: {
                        input: 'DD/MMM/YYYY',
                    },
                },
                isLoading: false,
                show_internal_lab:false,
                show_additional_consult:false,
                show_internal_referral:false
            },
            reset_medication_list:false,
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

        }),

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Data' : 'Edit Data'
            },
            today(){
                return new Date().toLocaleString();
            },
            patientFullName() {
                if (!this.patient_details)
                    return "";

                const firstName = this.patient_details.firstName ?? "";
                const lastName = this.patient_details.lastName ?? "";

                return `${firstName} ${lastName}`;
            }
        },

        watch: {
            dialog (val) {
                val || this.close()
            },
            dialogDelete (val) {
                val || this.closeDelete()
            },
        },

        created () {
            this.initialize()
        },

        methods: {
            async initialize () {
                //check whether getting data from cpn admission or from props
                var id = this.manual_cpn_admission_id_search =  this.cpn_admission_id ?? this.$route.params?.cpn_admission?.id
                if(id) await this.get_data(id)
                await Promise.allSettled(
                    [  axios.get('/api/v1/extra/lp1')
                            .then(response => this.lp1 = response.data),
                        axios.get('/api/v1/extra/lp2')
                            .then(response => this.lp2 = response.data),
                        axios.get('/api/v1/extra/lp3')
                            .then(response => this.lp3 = response.data),
                        axios.get('/api/v1/extra/cervix_length')
                            .then(response => this.cervix_length = response.data),
                        axios.get('/api/v1/extra/cervix_consistency')
                            .then(response => this.cervix_consistency = response.data),
                        axios.get('/api/v1/extra/cervix_opening')
                            .then(response => this.cervix_opening = response.data),
                        axios.get('/api/v1/extra/cervix_position')
                            .then(response => this.cervix_position = response.data)
                    ]
                );
            },
            get_medicines(data){
                this.editedItem.medication=data
            },

            requireAuthorization(action) {
                this.auth_dialog = true;
                this.auth_action = action;
            },

            authorized() {
                this.authorized_user = true;
                this.auth_dialog = false;
                this.auth_action();
                this.auth_action = null;
            },

            editItem (item) {
                // if a day has passed since creation, require senior auth
                if (!this.authorized_user &&
                    (new Date().getDate() !== new Date(item.created_at).getDate() ||
                    (new Date() - new Date(item.created_at) > (1000 * 60 * 60 * 24)))) {
                    this.requireAuthorization(() => this.editItem(item));
                }
                else {
                    this.editedIndex = this.cpn_data.indexOf(item)
                    this.editedItem = Object.assign({}, item)
                    this.dialog = true
                }
            },

            deleteItem (item) {
                // if a day has passed since creation, require senior auth
                if (!this.authorized_user &&
                    (new Date().getDate() !== new Date(item.created_at).getDate() ||
                    (new Date() - new Date(item.created_at) > (1000 * 60 * 60 * 24)))) {
                    this.requireAuthorization(() => this.deleteItem(item));
                }
                else {
                    this.editedIndex = this.cpn_data.indexOf(item)
                    this.editedItem = Object.assign({}, item)
                    this.dialogDelete = true
                }
            },

            async deleteItemConfirm () {
                await axios.delete(`/api/v1/patient_system/out_patient/obstetrical/cpn/followup/${this.cpn_data[this.editedIndex].id}`)
                this.cpn_data.splice(this.editedIndex, 1)
                this.closeDelete()

            },

            close () {
                this.dialog = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },

            closeDelete () {
                this.dialogDelete = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },

            async save () {
                    if (this.editedIndex > -1) {
                        Object.assign(this.cpn_data[this.editedIndex], this.editedItem)
                        this.cpn_data[this.editedIndex].responsible=window.auth.user.name;
                        let update = await axios.put(`/api/v1/patient_system/out_patient/obstetrical/cpn/followup/${this.cpn_data[this.editedIndex].id}`,this.editedItem)
                        if(update.data.success===true){
                            this.$toast.open({
                                message: 'Data updated',
                                position: "top-right",
                            });
                            this.close()
                        }
                    } else {
                        //new data
                        this.$v.editedItem.$touch();
                        this.editedItem.cpn_admission_id=this.manual_cpn_admission_id_search;
                        this.editedItem.admission_id= this.$route.params.admission_id
                        this.editedItem.responsible=window.auth.user.name;
                        if (!this.$v.$invalid) {

                            let post= await axios.post('/api/v1/patient_system/out_patient/obstetrical/cpn/followup',this.editedItem)
                            if(post.data.success===true){
                                this.$toast.open({
                                    message: 'Data submitted',
                                    position: "top-right"
                                });
                                this.close()
                            }
                            this.get_data(this.manual_cpn_admission_id_search)
                        }
                    }
            },
            async get_data(cpn_admission_id){
                this.reset()
                this.accessory.isLoading = true;
                if(!cpn_admission_id) return
                let fetch = await axios.get(`/api/v1/patient_system/out_patient/obstetrical/cpn/followup/${cpn_admission_id}`)
                if(fetch.data){
                    const cpn_data = fetch.data.followups;
                    cpn_data.forEach(data =>
                    {
                        data.senior_informed =
                            (data.senior_informed && data.senior_informed.length > 0)
                            ? data.senior_informed.split(',')
                            : [];
                    });
                    this.cpn_data= cpn_data;
                    this.patient_details = fetch.data.patient;
                    //gestational age
                    let [src_date,src_ga]= [fetch.data.created_at,fetch.data.gestational_age]
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
                    this.editedItem.gestational_age= ga_in_week + "+"+ ga_in_days
                }
                else {
                    this.noDataFound=true;
                }
                this.accessory.isLoading = false;
            },
            async navigateToAdmission(){
                this.$router.push({
                    name:"cpn_admission",
                    params:{
                        patient:this.$route.params.admission.patient,
                        weight:this.$route.params.admission.weight,
                        admission:this.$route.params.admission,
                        admission_id:this.$route.params.admission.id,
                    }
                })
            },
            reset(){
                this.editedItem= {...this.defaultItem}
                this.cpn_data=[]
                this.noDataFound=false
                this.accessory.data_fetched = false;
            },
            yesNoString(x) {
                if (x == null)
                    return null;

                return x ? 'Yes' : 'No'
            },
            formatDate(date) {
                if (!date)
                    return '';

                return `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
            }
        },
        validations:{
            editedItem: {
                us_reason: {
                    required: requiredIf(x => x.us_needed)
                },
                ctg_reason: {
                    required: requiredIf(x => x.ctg_needed)
                }
            }
        }
    }
</script>

<style scoped>
.search{
    max-width:250px;
}
.v-speed-dial {
    position: absolute;
}

.v-btn--floating {
    position: relative;
}
</style>
