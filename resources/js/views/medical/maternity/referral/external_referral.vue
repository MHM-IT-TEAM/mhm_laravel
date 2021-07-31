<template>
  <div class="wrap">
      <div class="row">
          <div class="col-6">
              <div class="front-page p-2">
                  <h3>External Referral</h3>
                  <div class="row">
                      <div class="col">
                          <table class="myTable">
                              <tr>
                                  <th rowspan="2">Patient</th>
                                  <th style="border-right: none">Name:</th>
                                  <td style="border-left: none"><input type="text" style="font-size: 9px;width:100%"/></td>
                              </tr>
                              <tr>
                                  <th style="border-right: none">Number:</th>
                                  <td style="border-left: none"><input type="number" name="patId" id="patId" required="true" onchange="fetchPat()" /></td>
                              </tr>
                              <tr>
                                  <th>Referal Nr.</th>
                                  <th colspan="2"><input type="text" name="referedNum" id="referedNum"  required="true" /></th>
                              </tr>
                          </table>
                      </div>
                      <div class="col">
                          <img src="/storage/assets/media/images/system/MHMlogo_PRINT.jpg" alt="" />
                      </div>
                  </div>
                  <div class="row">
                      <div class="col">
                          <table class="myTable1 mb-2 mt-2">
                              <tr>
                                  <th rowspan="2">Leaving MHM</th>
                                  <th style="border-right: none">Date:</th>
                                  <td style="border-left: none"><input type="date" name="refered_date" required="true" /></td>
                              </tr>
                              <tr>
                                  <th style="border-right: none">Hour:</th>
                                  <td style="border-left: none"><input type="time" name="time" required="true" /></td>
                              </tr>
                              <tr>
                                  <th>Arriving at hospital</th>
                                  <th style="border-right: none">Hour:</th>
                                  <td style="border-left: none"><input type="time" name="arrival_time"/></td>
                              </tr>
                          </table>
                      </div>
                      <div class="col">
                          <div class="hospital">

                              <input type="radio" name="hospital" value="psf" id="pavillon" />
                              <label for="hospital">Pavillon Sainte Fleur</label> <br />
                              <input type="radio" name="hospital" value="Befelatanana" id="maternite" />
                              <label for="hospital">Maternite Befelatanana</label><br />
                              <input type="radio" name="hospital" value="chu Anosiala" id="chu" />
                              <label for="hospital">CHU Anosiala</label><br />
                              <input type="radio" name="hospital" value="TPL Ambohibao" id="tpl" />
                              <label for="hospital">TPL Ambohibao</label><br />
                              <input type="radio" name="hospital" value="other" id="other_hosp" />
                              <label for="hospital">Other:</label>

                          </div>
                      </div>
                  </div>
                  <div class="mt-4">
                      <h5>Transportation</h5>
                      <input type="radio" name="transportation" value="ambulance" id="ambulance" />
                      <label for="transportation">Ambulance</label>
                      <input type="radio" name="transportation" value="4x4" id="quatrequatre" />
                      <label for="transportation">4 x 4 car</label>
                      <input type="radio" name="transportation" value="other" id="other_trans" />
                      <label for="transportation">Other:</label>

                  </div>
                  <hr />

                  <div class="mother">
                      <h5>Mother</h5>

                      <span>Alive?</span>
                      <input type="radio" name="mom_alive" value="1"id="yes" />
                      <label for="alive">yes</label>
                      <input type="radio" name="mom_alive" value="0" id="no" />
                      <label for="alive">no</label> <br />
                      <br />
                      <h5>Condition:</h5>
                      <textarea
                          name="mom_condition"
                          id="condition"
                          class="form-control"
                          rows="2"
                      ></textarea>

                  </div>
                  <hr />
                  <div class="baby">
                      <h5>Baby</h5>

                      <span>Alive?</span>
                      <input type="radio" name="baby_alive" value="1" id="yes" />
                      <label for="alive">yes</label>
                      <input type="radio" name="baby_alive" value="0" id="no" />
                      <label for="alive">no</label> <br />
                      <br />
                      <h5>BDCF:</h5>
                      <textarea name="bdcf" id="bdcf"  required="true" rows="2" class="form-control"></textarea>

                  </div>
                  <br />
                  <hr />
                  <h5>Remarks</h5>
                  <textarea name="remarks" id="remarks" rows="2" class="form-control"></textarea>
                  <div class="signature">
                      <p class="left">Signature MHM</p>
                      <p class="right">Signature Hospital</p>
                      <button type="submit" id="submit" onclick="window.print()">Submit</button>
                  </div>
              </div>
          </div>
          <div class="col-6">
              <div class="back-page">
                  <table class="myTable2">
                      <tr>
                          <th rowspan="10" id="blueh">
                              <div class="vertical">Driver Fills out</div>
                          </th>
                          <th colspan="3">Movement of the MHM ambulance car</th>
                      </tr>
                      <tr>
                          <th>Date</th>
                          <td><input type="date" name="date_car"></td>
                          <td></td>
                      </tr>
                      <tr>
                          <th>Driver</th>
                          <th>Km Start</th>
                          <th>Km End</th>
                      </tr>
                      <tr>
                          <td style="height: 15px;"><input type="text" name="driver_name"></td>
                          <td><input type="text" name="km_start"></td>
                          <td><input type="text" name="km_end"></td>
                      </tr>
                      <tr>
                          <th>Time Start Ambovo</th>
                          <th>Time Arrival Hospital</th>
                          <th>Where</th>
                      </tr>
                      <tr>
                          <td style="height: 15px;"><input type="time" name="time_start"></td>
                          <td><input type="time" name="time_arrival"></td>
                          <td><input type="text" name="where"></td>
                      </tr>
                      <tr>
                          <th>Time Departure Hospital</th>
                          <th>Time Back to Ambovo</th>
                          <th>Other</th>
                      </tr>
                      <tr>
                          <td style="height: 15px;"><input type="time" name="time_depart"></td>
                          <td><input type="time" name="time_back"></td>
                          <td><input type="text" name="other"></td>
                      </tr>
                      <tr>
                          <th>Medical Staff I</th>
                          <th>Medical Staff II</th>
                          <th>Medical Staff III</th>
                      </tr>
                      <tr>
                          <td style="height: 15px;"><input type="text" name="staff1"></td>
                          <td><input type="text" name="staff2"></td>
                          <td><input type="text" name="staff3"></td>
                      </tr>
                      <tr>
                          <th rowspan="7" id="purple">
                              <div class="vertical">Driver Fills out</div>
                          </th>
                          <th>Patient Name</th>
                          <td colspan="2"><input type="text" name="pat_name" style="width: 350px;"></td>
                      </tr>
                      <tr>
                          <th>Reason for Transport</th>
                          <td colspan="2"><input type="text" name="pat_name" style="width: 350px;"></td>
                      </tr>
                      <tr>
                          <td style="height: 15px;"></td>
                          <td></td>
                          <td></td>
                      </tr>
                      <tr>
                          <th>Finances Given Out</th>
                          <td>No / Yes --> amount</td>
                          <td><input type="text" name="finances_given"></td>
                      </tr>
                      <tr>
                          <th>CIN taken</th>
                          <td>No / Yes --> amount</td>
                          <td><input type="text" name="cin_taken"></td>
                      </tr>
                      <tr>
                          <th>Contact Family</th>
                          <td colspan="2"><input type="text" name="contact_family"></td>
                      </tr>
                      <tr>
                          <td colspan="3" style="height: 100px">Other / Remarks:
                              <textarea name="other_remarks" id="" cols="75" rows="5"></textarea>
                          </td>
                      </tr>
                  </table>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
export default {
    name: "external_referral"
}
</script>

<style scoped>
.wrap{
    max-width: 85%;
    transform:scale(0.95);
    font-size: 11px;
}
.front-page,.back-page {
    /*min-width: 540px;*/
    border: 1px solid black;
    margin: 0 auto;
    height:1200px
}
.back-page{
    padding:10px;
    width:570px;
}
h3 {
    text-align: center;
    font-size: 150%;
    margin-bottom: 30px;
}
.hospital{
    font-size: 10px;
}
textarea {
    border: none;
}
.myTable,.myTable1 {
    width: 250px !important;
    border-collapse: collapse;
    font-size: 10px;
}

tr th {
    border: 1px solid black;
    padding: 3px;
}
td {
    border: 1px solid black;
    padding: 5px;
}
.vertical {
    writing-mode: vertical-rl;
    transform: rotate(180deg);
    line-height: 15px;
    width:20px;
    text-align: center;
}
#blueh {
    background: rgb(30, 171, 206);
}
#purple {
    background: rgb(227, 108, 238);
}
img {
    width: 150px;
    display: block;
    margin-left: 5px;
    height: 50px;
}
input {
    border-style: hidden;
    margin: 5px;
}
p {
    text-decoration: underline;
    font-weight: 600;
    margin: 20px;
}
p.right {
    float: right;
}
p.left {
    float: left;
}
.signature {
    margin-bottom: 100px;
}
#submit {
    display: block;
    border: none;
    background-color: #047aed;
    border-radius: 5px;
    color: #fff;
    font-size: medium;
    width: 100px;
    height: 40px;
    margin: 0 auto;
    padding: 5px;
}
#submit:hover {
    transform: scale(0.98);
}
@media print {
    .container {
        margin: 0;
        padding: 0;
        border: none;
    }
    #submit{
        display: none;
    }
    table.myTable2 #blueh {
        height: 350px;
    }
    table.myTable2 #purple {
        height: 350px;
    }

}

</style>
