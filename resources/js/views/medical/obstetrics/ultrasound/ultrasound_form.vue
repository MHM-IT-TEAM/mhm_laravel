<template>
  <div class="container-fluid p-4">
    <v-app class="p-2">
      <div class="table-responsive">
        <h4>Ultrasound examination</h4>
        <!--        <v-row>-->
        <!--            <v-col-->
        <!--                cols="12"-->
        <!--                sm="6"-->
        <!--                md="3"-->
        <!--            >-->
        <!--                <v-text-field-->
        <!--                    label=" Important remark"-->
        <!--                ></v-text-field>-->
        <!--            </v-col>-->
        <!--        </v-row>-->
        <table class="table">
          <tr class="table-active">
            <td>Date</td>
            <td>WOP</td>
            <td>WOP <small>(corrected)</small></td>
            <td colspan="3" align="center">
              <strong>First Screening 8+0 bis 11+6 WOP</strong>
            </td>
            <td>HC</td>
            <td>AC</td>
            <td>FL</td>
            <td>GS</td>
            <td>CRL</td>
            <td>BDCF</td>
          </tr>
          <tr>
            <td>
              <input type="date" v-model="formData.first_screening.created_at"/>
            </td>
            <td>
              <input type="text" v-model="formData.first_screening.wop" />
            </td>
            <td>
              <input type="text" v-model="formData.first_screening.wop_corrected" />
            </td>
            <td colspan="3" rowspan="2" class="border">
              <table class="table table-borderless">
                <tr>
                  <td>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">Intrauterine</label> &nbsp
                      <input type="checkbox" class="form-check-input" v-model="formData.first_screening.intrauterine" />
                    </div>
                  </td>
                  <td>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">Embryo visible</label>
                      &nbsp
                      <input type="checkbox" class="form-check-input" v-model="formData.first_screening.embryo_visible" />
                    </div>
                  </td>
                  <td>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">Heart beating</label>
                      &nbsp
                      <input type="checkbox" class="form-check-input" v-model="formData.first_screening.heart_beat" />
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="form-group">
                      <label>Position</label>
                      [&nbsp
                      <select v-model="formData.first_screening.position_of_baby">
                        <option v-for="item in position_of_baby">{{item.name}}</option>
                      </select>
                      &nbsp]
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <label>Presentation</label>
                      [&nbsp
                      <select v-model="formData.first_screening.presentation_of_baby">
                        <option v-for="item in presentation_of_baby">{{item.name}}</option>
                      </select>
                      &nbsp]
                    </div>
                  </td>
                </tr>
              </table>
            </td>
            <td><input type="text" v-model="formData.first_screening.hc" /></td>
            <td><input type="text" v-model="formData.first_screening.ac" /></td>
            <td><input type="text" v-model="formData.first_screening.fl" /></td>
            <td><input type="text" v-model="formData.first_screening.gs" /></td>
            <td><input type="text" v-model="formData.first_screening.crl" /></td>
            <td><input type="text" v-model="formData.first_screening.bdcf" /></td>
          </tr>
          <tr>
            <td colspan="3">
              <div class="form-inline">
                <label>Other</label>
                <textarea style="width: 100%" class="form-control" v-model="formData.first_screening.other"></textarea>
              </div>
            </td>

            <td colspan="6">
              <div class="form-inline">
                <label>Remark and precautions</label>
                <textarea style="width: 100%" class="form-control" v-model="formData.first_screening.remark"></textarea>
              </div>
            </td>
          </tr>
          <tr class="table-active">
            <td>Date</td>
            <td>WOP</td>
            <td>WOP <small>(corrected)</small></td>
            <td colspan="3" align="center">
              <strong>Second Screening 18+0 bis 21+6 WOP</strong>
            </td>
            <td>HC</td>
            <td>AC</td>
            <td>FL</td>
            <td>GS</td>
            <td>CRL</td>
            <td>BDCF</td>
          </tr>
          <tr>
            <td><input type="date" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td colspan="3" rowspan="2" class="border">
              <tr class="table-borderless">
                <td>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">Growth</label> &nbsp
                    <input type="checkbox" />
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">Heartbeat</label> &nbsp
                    <input type="checkbox" />
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">Placenta Spontaneous</label>
                    &nbsp
                    <input type="checkbox" />
                  </div>
                </td>
              </tr>
              <tr class="table-borderless">
                <td>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label"
                      >Normal amniotic liquid</label
                    >
                    &nbsp
                    <input type="checkbox" />
                  </div>
                </td>
              </tr>
            </td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
          </tr>
          <tr>
            <td colspan="3">
              <div class="form-inline">
                <label>Other</label>
                <textarea style="width: 100%" class="form-control"></textarea>
              </div>
            </td>
            <td colspan="6">
              <div class="form-inline">
                <label>Remark and precautions</label>
                <textarea style="width: 100%" class="form-control"></textarea>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </v-app>
  </div>
</template>

<script>
export default {
  name: "ultrasound_form",
    data:()=>{
      return{
          formData:{
              first_screening:{
                created_at:"",
                  wop:"",
                  wop_corrected:"",
                  hc:"",
                  ac:"",
                  fl:"",
                  gs:"",
                  crl:"",
                  bdcf:"",
                  other:"",
                  intrauterine:false,
                  heart_beat:false,
                  position_of_baby:'',
                  presentation_of_baby:'',
                  embryo_visible:false,
                  remark:""
              },
              second_screening:{

              }

          },
          position_of_baby:[],
          presentation_of_baby:[]
      }
    },
    created(){
        this.init()
    },
    methods:{
      async init(){
          await axios.get('/api/position_of_baby')
          .then(res=>this.position_of_baby=res.data)
          await axios.get('/api/presentation_of_baby')
          .then(res=>this.presentation_of_baby=res.data)
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
td {
  white-space: nowrap !important;
}
</style>
