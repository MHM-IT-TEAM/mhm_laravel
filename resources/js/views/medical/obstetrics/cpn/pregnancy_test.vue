<template>
<div class="container-fluid">
    <v-app>
        <v-card>
            <v-img
                class="orange--text align-end"
                height="200px"
                contain
                src="/storage/assets/media/images/system/pregTest.png"
            >
            </v-img>
            <v-divider class="mx-4"></v-divider>
            <v-card-text class="content">
                <h2>{{fullName}}</h2>
                <v-spacer></v-spacer>
                <v-chip-group
                    v-model="formData.result"
                    active-class="deep-purple accent-4 white--text"
                    column
                >
                    <v-chip

                    >Negative
                    </v-chip>
                    <v-chip
                    >
                        Positive
                    </v-chip>
                </v-chip-group>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    color="deep-purple lighten-2"
                    text
                    @click="submit"
                >
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-app>
</div>
</template>

<script>
    export default {
        name: "pregnancy_test",
        data(){
            return{
                formData:{
                    result:"",
                    patient_id:"",
                    weight:"",
                    consultation_id:""
                }
            }
        },
        methods:{
            async submit(){
                await axios.post('/api/obstetrics/pregTest',this.formData)

                if(this.formData.result===1){
                    this.$router.push({
                        name:"cpn_admission",
                        params:{
                            patient_id: this.formData.patient_id,
                            weight: this.formData.weight,
                            consultation_id:this.formData.consultation_id,
                        }
                    })
                }else{
                    this.$router.push({name:'first_cpn_list'})
                }
            },
            init(){
                this.formData.patient_id= this.$route.params.patient_id
                this.formData.consultation_id= this.$route.params.consultation_id
                this.formData.weight= this.$route.params.weight
            }
        },
        created(){
            this.init()
        },
        computed:{
            fullName(){
                return this.$route.params.fullName;
            }
        }
    }
</script>

<style scoped>
/*@media only screen and (min-width:1500px){*/

/*}*/


</style>
