<template>
    <div class="container">
      <v-app>
          <v-card class="p-2">
              <v-row>
                  <v-container>
                      <h1 class="title">{{title}}</h1>
                      Filter by date
                      <date-picker
                          v-model="today"
                          mode="date"
                          :model-config="dateConfig"
                          :masks="dateConfig.masks"
                          @input="fetch"
                      >
                          <template v-slot="{ inputValue, inputEvents }">
                              <input
                                  class="bg-white border px-2 py-1 rounded"
                                  :value="inputValue"
                                  v-on="inputEvents"
                              />
                          </template>
                      </date-picker>
                  </v-container>
              </v-row>
              <v-card-title>
                  Patients
                  <v-spacer></v-spacer>
                  <v-text-field
                      v-model="search"
                      append-icon="mdi-magnify"
                      label="Search"
                      single-line
                      hide-details
                  ></v-text-field>
              </v-card-title>
              <v-card-text>
                  <v-data-table :headers="headers" :items="items" :search="search" :loading="loading">
                      <template v-slot:item.actions="{ item }">
                          <v-icon small class="mr-2" @click="$emit('edit', item)" >
                              mdi-pencil
                          </v-icon>
                      </template>
                      <template v-slot:item.status="{ item }">
                          <v-chip :color="getColor(item.status)" dark x-small>
                              {{ item.status }}
                          </v-chip>
                      </template>
                      <template v-slot:item.admission_type.code="{ item }">
                          <v-chip :color="getTypeColor(item.admission_type.code)" dark x-small>
                              {{ item.admission_type.code }}
                          </v-chip>
                      </template>
                  </v-data-table>
              </v-card-text>
          </v-card>
      </v-app>
    </div>
</template>

<script>
import moment from "moment";
export default {
    name: "patient_list",
    props:{
        service_id:'',
        service_activity_id:Array,
        headers: Array,
        title:'',
        refresh:Boolean
    },
    data(){
        return{
            search: '',
            items: [],
            loading: false,
            search_date:'',
            dateConfig: {
                type: "string",
                mask: "YYYY-MM-DD",
                masks: {
                    input: "DD/MMM/YYYY",
                },
            },
            today:moment().format("YYYY/MM/DD")
        }
    },
    created(){
        this.fetch()
    },
    watch:{
        refresh:function(val){
            if(val)this.fetch()
        }
    },
    methods:{
        async fetch(){
            this.loading = true;

            let data = await axios.post(`/api/v1/patient_system/admission/list_service_activity_date`,{service_id:this.service_id,service_activity_id:this.service_activity_id,date:this.today})
            this.loading = false;

            this.consultation_id=data.id
            this.items=data.data
        },
        getColor(status) {
            if (status === "RUNNING") return "blue";
            else if (status === "DONE") return "green";
            else if (status === "CANCELLED") return "red";
            else return "green";
        },
        getTypeColor(code) {
            if (code === "A") return "yellow";
            else if (code === "IR") return "orange";
            else return "purple";
        }
    },
}
</script>

<style scoped>
h1 {
    text-align: center;
    color: white;
    text-transform: uppercase;
    padding: 1px;
    font-family: 'Raleway', cursive;
    font-weight: 100;
    position: relative;
    background: rgb(103,103,154);
    background: linear-gradient(90deg, rgba(103,103,154,1) 0%, rgba(19,144,198,1) 67%);
}
h1::before {
    content: "";
    position: absolute;
    left: 50%;
    top: -50px;
    width: 600px;
    margin-left: -300px;
    margin-top: -220px;
    height: 600px;
    /*background: radial-gradient(50% 50%, ellipse closest-side, #444, black);*/
    z-index: -1;
}

</style>
