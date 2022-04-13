<template>
    <div class="container">
        <v-card color="basil" class="form-container">
            <v-card-text>
                <table class="table table-sm">
                    <tr>
                        <td>Code: <span class="patData">{{raw_data.code}}</span></td>
                        <td>Division: <span class="patData">{{raw_data.hospital_service_division.name}}</span></td>
                        <td>Bed: <span class="patData">{{raw_data.bed.code}}</span></td>
                    </tr>
                    <tr>
                        <td>Date In: <span class="patData">{{raw_data.date}}</span></td>
                        <td colspan="2">Diagnostic: <span class="patData">{{raw_data.provisional_diagnosis}}</span> </td>
                    </tr>
                    <tr>
                        <td>Id: <span class="patData">{{raw_data.patient_id}}</span></td>
                        <td colspan="2"><span class="patData">{{raw_data.patient.firstName}} &nbsp {{raw_data.patient.lastName}}</span> </td>
                    </tr>
                </table>
            </v-card-text>

            <v-tabs
                v-model="tab"
                background-color="transparent"
                color="basil"
                grow
            >
                <v-tab
                >
                   Actions
                </v-tab>
                <v-tab
                >
                    Medicines
                </v-tab>
                <v-tab
                >
                    Medical Appreciation
                </v-tab>
            </v-tabs>

            <v-tabs-items v-model="tab">
                <v-tab-item
                >
                    <v-card
                        color="basil"
                        flat
                    >
                        <v-card-text> <In_actions :maternity_admission_id="$route.params.id"/></v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item
                >
                    <v-card
                        color="lime lighten-4"
                        flat
                    >
                        <v-card-text><In_medicines/></v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item
                >
                    <v-card
                        color="lime lighten-5"
                        flat
                    >
                        <v-card-text><medical_appreciation :maternity_admission_id="$route.params.id"/></v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs-items>
        </v-card>
    </div>
</template>

<script>
import In_actions from "./in_actions";
import In_medicines from "./in_medicines";
import Medical_appreciation from "./medical_appreciation";

export default {
    name: "in_patient_data_entry",
    components: {Medical_appreciation, In_medicines, In_actions},
    data () {
        return {
            tab: null,
            raw_data:{
                code:'',
                date:'',
                hospital_service_division:{name:''},
                bed:{code:''},
                provisional_diagnosis:'',
                patient_id:'',
                patient:{firstName:'', lastName:''}

            }
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            await axios.get(`/api/maternity/maternity_admission/${this.$route.params.id}`).then(response=>{
                this.raw_data= response.data
            })
        }
    }
}
</script>

<style scoped>
    .container{
        background: #fff;
        border-radius: 2px;
        min-height: 100vh;
        margin: 5rem;
        width: 90vw;
    }
    .basil {
        background-color: #FFFBE6 !important;
    }
    .basil--text {
        color: #356859 !important;
    }
    .form-container{
        min-height:90vh;
    }
    .patData{
        color:#8D608C;
    }
</style>
