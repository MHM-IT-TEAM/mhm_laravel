<template>
    <div class="container w-75">
         <v-app>
             <table class="table table-stripped table-sm">
                 <tr>
                     <td v-for="tooth in first_row" >{{tooth.id}}</td>
                 </tr>
                 <tr>
                     <td  v-for="(tooth,i) in first_row">
                         <v-btn x-small :disabled="tooth.blank" @click="process(tooth,i,1)" :class="{'text-danger':tooth.extraction,'text-success':tooth.cleaning,'text-info':tooth.care}">
                             <v-icon>
                                 mdi-tooth
                             </v-icon>
                         </v-btn>
                     </td>
                 </tr>
                 <tr>
                     <td v-for="tooth in second_row" >{{tooth.id}}</td>
                 </tr>
                 <tr>
                     <td  v-for="(tooth,i) in second_row">
                         <v-btn x-small :disabled="tooth.blank" @click="process(tooth,i,2)" :class="{'text-danger':tooth.extraction}">
                             <v-icon>
                                 mdi-tooth
                             </v-icon>
                         </v-btn>
                     </td>
                 </tr>
                 <tr>
                     <td>&nbsp</td>
                 </tr>
             </table>
             <h6>Quick overview</h6>
             <table class="table-sm table">
                 <tr>
                     <td style="width:20%; color:red">Extraction</td>
                     <td style="width:80%">
                        <span v-for="i in diagnostic.extraction">{{i}} - </span>
                     </td>
                 </tr>
                 <tr>
                     <td style="width:20%; color:green">Cleaning</td>
                     <td style="width:80%">
                         <span v-for="i in diagnostic.cleaning">{{i}} - </span>
                     </td>
                 </tr>
                 <tr>
                     <td style="width:20%; color:blue">Care</td>
                     <td style="width:80%">
                         <span v-for="i in diagnostic.care">{{i}} - </span>
                     </td>
                 </tr>
             </table>
             <v-dialog
                 v-model="accessory.dialog"
                 max-width="290"
             >
                 <v-card>
                     <v-card-title class="text-h5 text-center">
                         Tooth Nr {{accessory.temporary_chosen_tooth.id}}
                     </v-card-title>

                     <v-card-text>
                         <v-row>
                             <v-checkbox
                                 label="Extraction"
                                 color="red"
                                 hide-details
                                 v-model.number="accessory.temporary_chosen_tooth.extraction"
                             >
                             </v-checkbox>
                         </v-row>
                         <v-row>
                             <v-checkbox
                                 label="Cleaning"
                                 color="green"
                                 hide-details
                                 v-model.number="accessory.temporary_chosen_tooth.cleaning"
                             >
                             </v-checkbox>
                         </v-row>
                         <v-row>
                             <v-checkbox
                                 label="Care"
                                 color="blue"
                                 hide-details
                                 v-model="accessory.temporary_chosen_tooth.care"
                             >
                             </v-checkbox>
                         </v-row>
                         <v-row>
                             <v-checkbox
                                 label="Mark as already blank"
                                 color="orange"
                                 hide-details
                                 v-model.number="accessory.temporary_chosen_tooth.already_blank"
                             >
                             </v-checkbox>
                         </v-row>
                     </v-card-text>

                     <v-card-actions>
                         <v-spacer></v-spacer>

                         <v-btn
                             color="green darken-1"
                             text
                             @click="accessory.dialog = false"
                         >
                            Cancel
                         </v-btn>

                         <v-btn
                             color="green darken-1"
                             text
                             @click="save_checkup"
                         >
                             save
                         </v-btn>
                     </v-card-actions>
                 </v-card>
             </v-dialog>
         </v-app>
    </div>
</template>

<script>
export default {
    name: "dental_diagnostic_form",
    data(){
        return{
            first_row:[
                {
                    id:18,
                    treatment:'E',
                    status:'',
                    blank:false
                },
                {
                    id:17,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:16,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:15,
                    treatment:'',
                    status:'',
                    blank:true
                },
                {
                    id:14,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:13,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:12,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:11,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:21,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:22,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:23,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:24,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:25,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:26,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:27,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:28,
                    treatment:'',
                    status:'',
                    blank:false
                }

            ],
            second_row:[
                {
                    id:48,
                    treatment:'E',
                    status:'',
                    blank:false
                },
                {
                    id:47,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:46,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:45,
                    treatment:'',
                    status:'',
                    blank:true
                },
                {
                    id:44,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:43,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:42,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:41,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:31,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:32,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:33,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:34,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:35,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:36,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:37,
                    treatment:'',
                    status:'',
                    blank:false
                },
                {
                    id:38,
                    treatment:'',
                    status:'',
                    blank:false
                }

            ],
            formData:{
                diagnostic:[]
            },
            accessory:{
                dialog:false,
                temporary_row:null,
                temporary_chosen_tooth:{
                    id:'',
                    cleaning:false,
                    care:false,
                    extraction:false,
                    already_blank:false

                }
            }
        }
    },
    methods:{
        process(tooth,i,row){
            this.accessory.dialog=true
            this.accessory.temporary_chosen_tooth.id=tooth.id
            this.accessory.temporary_chosen_tooth.i=i
            this.temporary_row=row
        },
        save_checkup(){
            if(this.temporary_row===1){
                this.first_row[this.accessory.temporary_chosen_tooth.i]=Object.assign({},this.accessory.temporary_chosen_tooth)
            }else{
                this.second_row[this.accessory.temporary_chosen_tooth.i]=Object.assign({},this.accessory.temporary_chosen_tooth)
            }
            this.formData.diagnostic.push(Object.assign({},this.accessory.temporary_chosen_tooth))
            this.accessory.dialog=false
            this.accessory.temporary_chosen_tooth={
                id:'',
                cleaning:false,
                care:false,
                extraction:false,
                already_blank:false
            }
        }
    },
    computed:{
        diagnostic(){
            let extraction=[]
            let care=[]
            let cleaning=[]
            if (this.formData.diagnostic.length>0)this.formData.diagnostic.filter(tooth=>tooth.extraction===true).forEach(tooth=>extraction.push(tooth.id))
            if (this.formData.diagnostic.length>0)this.formData.diagnostic.filter(tooth=>tooth.cleaning===true).forEach(tooth=>cleaning.push(tooth.id))
            if (this.formData.diagnostic.length>0)this.formData.diagnostic.filter(tooth=>tooth.care===true).forEach(tooth=>care.push(tooth.id))
            return{
                extraction:extraction,
                care:care,
                cleaning:cleaning
            }

        }
    }
}
</script>

<style scoped>

</style>
