<template>
    <div class="container-fluid p-4">
        <v-app>
            <div class="mt-6 p-2" v-if="patient_details.firstName !==undefined">
                <h6>{{patient_details.firstName+" "+ patient_details.lastName }}</h6>
            </div>
            <v-data-table
                :headers="headers"
                :items="cpn_data"
                sort-by="created_at"
                class="elevation-1"
            >
                <template v-slot:top>
                    <v-toolbar
                        flat
                    >
                        <v-toolbar-title>CPN FOLLOWUP</v-toolbar-title>

                            <v-text-field
                                hide-details
                                placeholder="type the reference here"
                                v-model="reference"
                                class="search ml-4"
                                @change="search"
                                prepend-icon="mdi-magnify"
                                v-if="!is_overview"
                            ></v-text-field>
                            <span v-if="noDataFound" class="text-white bg-danger">no data found</span>

                            <v-spacer></v-spacer>
                        <v-btn color="primary" @click="redirect" v-if="!is_overview">View main page</v-btn >
                        <v-divider
                            class="mx-4"
                            inset
                            vertical
                        ></v-divider>
                        <v-spacer></v-spacer>
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
                                    v-if="!is_overview"
                                >
                                    New Data
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <span class="headline">{{ formTitle }}</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container >

                                        <v-row>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <gestational-age
                                                    v-model="editedItem.week_of_pregnancy"
                                                    label="Gestational age"
                                                    :error-messages="gestationalAgeError"
                                                ></gestational-age>
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
                                                    label="Cervix opening"
                                                    :items="cervix_opening"
                                                    item-text="name"
                                                    v-model="editedItem.cervix_opening"
                                                >

                                                </v-select>

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
                                        </v-row>
                                        <v-row>
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
<!--                                                <v-select-->
<!--                                                    :items="regular_unplanned",-->
<!--                                                    label="how?"-->
<!--                                                    v-if="editedItem.ctg_needed"-->
<!--                                                    v-model="editedItem.ctg_plan"-->
<!--                                                >-->
<!--                                                </v-select>-->
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
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                    <date-picker v-model="editedItem.appointment"
                                                        @input="menu = false"
                                                        :input-debounce="500" mode="date"
                                                        :model-config="accessory.dateConfig" :masks="accessory.dateConfig.masks"
                                                        :min-date="new Date()">
                                                            <template v-slot="{ inputValue, inputEvents }">
                                                                <input
                                                                    class="bg-white border px-2 py-1 rounded"
                                                                    :value="inputValue"
                                                                    v-on="inputEvents"

                                                                />
                                                            </template>
                                                    </date-picker>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                sm="6"
                                                md="2"
                                            >
                                                <v-select
                                                    label="Senior midwife informed"
                                                    :items="senior_midwife"
                                                    v-model="editedItem.senior_informed"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-textarea label="Remark" v-model="editedItem.remark"/>
                                            </v-col>
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
                <template v-slot:item.actions="{ item }">
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
                        color="primary"
                        @click="initialize"
                    >
                        Reset
                    </v-btn>
                </template>
            </v-data-table>
        </v-app>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import gestationalAge from "../../../../components/gestational_age_control.vue"
const {
    required,
    minLength,
    email,
    url,
    maxLength,
} = require("vuelidate/lib/validators");
    export default {
        name: "cpn_followup",
        mixins: [validationMixin],
        components: { gestationalAge },
        props:['is_overview','cpn_ref'],
        data: () => ({
            dialog: false,
            dialogDelete: false,
            headers: [
                { text: 'Date', value: 'created_at' },
                { text: 'GA', value: 'week_of_pregnancy' },
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
                {text:'Cervix opening',value:'cervix_opening'},
                {text:'Liquids',value:'liquids'},
                {text:'Oedema',value:'oedema'},
                {text:'Varicosis',value:'varicosis'},
                {text:'Protein_test',value:'protein_test'},
                {text:'Sugar_test',value:'sugar_test'},
                {text:'Blood_test',value:'blood_test'},
                {text:'Leucocyte_test',value:'leucocyte_test'},
                {text:'OGTT',value:'ogtt'},
                {text:'CTG needed',value:'ctg_needed'},
                {text:'US needed',value:'us_needed'},
                {text:'Senior midwife informed',value:'senior_informed'},
                {text:'Appointment',value:'appointment'},
                {text:'Actions',value:'actions',sortable:false},
                {text:'Remark',value:'remark',sortable:false},
                {text:'Responsible',value:'responsible'}

            ],
            cpn_data: [],
            editedIndex: -1,
            editedItem: {
                cpn_admission_id:'',
                date:"",
                week_of_pregnancy:'',
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
                cervix_opening:'',
                cervix_position:'',
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
                us_needed:false,
                us_plan:"",
                ctg_needed:false,
                ctg_plan:"",
                appointment:'',
                responsible:'',
                senior_informed:'',
                remark:''
            },
            defaultItem: {
                cpn_admission_id:'',
                date:"",
                week_of_pregnancy:'',
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
                cervix_opening:'',
                cervix_position:'',
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
                us_needed:false,
                us_plan:"",
                ctg_needed:false,
                ctg_plan:"",
                appointment:'',
                responsible:'',
                senior_informed:'',
                remark:''
            },
            eyes:['white','medium','red'],
            ok:['ok','not ok'],
            lp1:[],
            lp2:[],
            lp3:[],
            pos_baby:[],
            posNeg:["positive","negative"],
            cervix_length:[],
            cervix_opening:[],
            cervix_position:[],
            membranes:["intact","bulging","ruptured","not to be determined"],
            liquids:["blood","infection","amniotic clear","amniotic meconial"],
            leading_part:["fixed","engaged","mobile"],
            leading_part_attitude:["transversal","oblic","longitudinal","abnormal"],
            oedema:[],
            urine_test:["Negative","trace","+","++","+++","invalid"],
            varicosis:["Negative","left leg","right leg","vulva"],
            regular_unplanned:["regular","unplanned"],
            senior_midwife:["Tanja","Tianasoa"],
            is_new_form:true,
            menu:false,
            reference:'',
            patient_details:{},
            noDataFound:false,
            accessory: {
                dateConfig: {
                    type: 'string',
                    mask:'iso',
                    masks: {
                        input: 'DD/MMM/YYYY',
                    },
                }
            }

        }),

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Data' : 'Edit Data'
            },
            gestationalAgeError(){
                const errors = []
                if (!this.$v.editedItem.week_of_pregnancy.$dirty) return errors
                !this.$v.editedItem.week_of_pregnancy.required && errors.push('The gestational age is required!')
                return errors
            },
            today(){
                return new Date().toLocaleString();
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
                if(this.cpn_ref!=='' && this.cpn_ref!==undefined){
                    this.reference= this.cpn_ref
                    this.search()
                }
                if(Object.keys(this.$route.params).length>0){
                    let table_data= await axios.get(`/api/obstetrics/cpn_followup/${this.$route.params.cpn_admission_id}`)
                    this.cpn_data= table_data.data
                    this.reference= this.editedItem.cpn_admission_id= this.$route.params.cpn_admission_id
                    this.patient_details= this.$route.params.patient
                }
                // if(this.reference !=='' || this.reference !==undefined) this.search()
                let lp1 = await axios.get('/api/lp1')
                let lp2 = await axios.get('/api/lp2')
                let lp3 = await axios.get('/api/lp3')
                let cervix_length=  await axios.get('/api/cervix_length')
                let cervix_opening=  await axios.get('/api/cervix_opening')
                let cervix_position=  await axios.get('/api/cervix_position')
                this.lp1=lp1.data
                this.lp2= lp2.data
                this.lp3=lp3.data
                this.cervix_length= cervix_length.data
                this.cervix_opening= cervix_opening.data
                this.cervix_position= cervix_position.data

            },

            editItem (item) {
                this.editedIndex = this.cpn_data.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem (item) {
                this.editedIndex = this.cpn_data.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialogDelete = true
            },

            async deleteItemConfirm () {
                await axios.delete(`/api/obstetrics/cpn_followup/${this.cpn_data[this.editedIndex].id}`)
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
                        this.cpn_data[this.editedIndex].responsible=window.auth.user.name
                        let update= await axios.put(`/api/obstetrics/cpn_followup/${this.cpn_data[this.editedIndex].id}`,this.editedItem)
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
                        this.editedItem.cpn_admission_id=this.reference
                        this.editedItem.responsible=window.auth.user.name
                        if (!this.$v.$invalid) {
                            this.cpn_data.push(this.editedItem)
                            let post= await axios.post('/api/obstetrics/cpn_followup',this.editedItem)
                            if(post.data.success===true){
                                this.$toast.open({
                                    message: 'Data submitted',
                                    position: "top-right",
                                });
                                this.close()
                            }
                        }
                    }


            },
            async search(){
                this.reset()
                let fetch= await axios.get(`/api/obstetrics/cpn_followup/${this.reference}`)
                if(fetch.data.length>0){
                    this.cpn_data= fetch.data
                }
                else this.noDataFound=true
            },
            redirect(){
                this.$router.push({
                    name:"cpn_admission",
                    params:{
                        id: this.reference,

                    }
                })
            },
            reset(){
                this.editedItem= {...this.defaultItem}
                this.cpn_data=[]
                this.noDataFound=false
            }

        },
        validations:{
            editedItem:{
                week_of_pregnancy:{
                    required
                }
            }
        }


    }
</script>

<style scoped>
.search{
    max-width:250px;
}
</style>
