<template>
    <div>
       <table class="table table-sm">
               <tr>
                   <td colspan="4">
                       <multiselect
                           v-model="accessory.medication.item"
                           label="description"
                           track-by="description"
                           :id="'multiSelect'"
                           open-direction="above"
                           :options="accessory.medicines_temp_list"
                           :searchable="true"
                           :internal-search="false"
                           :clear-on-select="true"
                           :close-on-select="true"
                           :show-no-results="false"
                           :hide-selected="true"
                           @search-change="fetchItem"
                           class="multiSelect"
                           autocomplete="off"
                       >
                       </multiselect>
                   </td>
                   <td>
                       <input type="number" placeholder="Breakfast" class=" form-control " v-model="accessory.medication.breakfast"/>
                   </td>
                   <td>
                       <input type="number" placeholder="Lunch" class=" form-control " v-model="accessory.medication.lunch"/>
                   </td>
                   <td>
                       <input type="number" placeholder="Dinner" class=" form-control " v-model="accessory.medication.dinner"/>
                   </td>
                   <td>
                       <input type="number" placeholder="Nb of days" class=" form-control " v-model="accessory.medication.nb_of_day"/>
                   </td>
                   <td>
                       <v-btn x-small text @click="add_medication" class="table-title">Add</v-btn>
                   </td>
               </tr>
               <tr v-for="(item,i) in formData" class="diag-code-list">
                   <td colspan="4">{{item.item.description}}</td>
                   <td class="text-center">{{item.breakfast}}</td>
                   <td class="text-center">{{item.lunch}}</td>
                   <td class="text-center">{{item.dinner}}</td>
                   <td class="text-center">
                       {{item.nb_of_day}} &nbsp

                       <v-btn
                           class="float-right"
                           x-small
                           icon
                           @click="delete_medication_line(i)"
                       >
                           <v-icon> mdi-delete</v-icon>
                       </v-btn>

                   </td>
               </tr>
           </table>
    </div>
</template>

<script>
export default {
    name: "give_medicine",
    data(){
        return{
            formData:[],
            accessory:{
                medication: {
                    item: null,
                    breakfast: null,
                    lunch: null,
                    dinner: null,
                    nb_of_day:null
                },
                medicines_temp_list: [],
            },

        }
    },
    watch:{
        formData:{
            handler(value){
               this.$emit('get_value',value)
            },
            deep:true
        }
    },
    methods:{
        add_medication(){
            let valid=false
            let arr=(Object.values(this.accessory.medication))
            valid = arr.indexOf(null) === -1;
            console.log(valid)
            if(valid){
                this.accessory.medication.to_give=(parseInt(this.accessory.medication.breakfast) + parseInt(this.accessory.medication.lunch) + parseInt(this.accessory.medication.dinner))* this.accessory.medication.nb_of_day
                this.formData.push(this.accessory.medication)
                this.accessory.medication = {
                    item: null,
                    breakfast: '',
                    lunch: '',
                    dinner: '',
                }
            }
        },
        delete_medication_line(i) {
            this.formData.splice(i, 1)
        },
        async fetchItem(code) {
            this.accessory.medicines_temp_list = [];
            if (code.length > 2) {
                await axios({
                    method: 'GET',
                    url: '/api/v1/inventory_system/item',
                    params: {search_text: code},
                }).then((response) => {
                    this.accessory.medicines_temp_list = response.data.data
                });
            }
        }
    }
}
</script>

<style scoped>

</style>
