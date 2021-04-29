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
              <input type="date" />
            </td>
            <td>
              <input type="text" />
            </td>
            <td>
              <input type="text" />
            </td>
            <td colspan="3" rowspan="2" class="border">
              <table class="table table-borderless">
                <tr>
                  <td>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">Intrauterine</label> &nbsp
                      <input type="checkbox" class="form-check-input" />
                    </div>
                  </td>
                  <td>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">Embryo visible</label>
                      &nbsp
                      <input type="checkbox" class="form-check-input" />
                    </div>
                  </td>
                  <td>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">Heart beating</label>
                      &nbsp
                      <input type="checkbox" class="form-check-input" />
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="form-group">
                      <label>Position</label>
                      [&nbsp
                      <select>
                        <option>Choose</option>
                      </select>
                      &nbsp]
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <label>Presentation</label>
                      [&nbsp
                      <select>
                        <option>Choose</option>
                      </select>
                      &nbsp]
                    </div>
                  </td>
                </tr>
              </table>
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
