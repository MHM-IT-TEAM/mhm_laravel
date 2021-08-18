<template>
    <div class="container border">
        <v-app>
            <h4 class="text-center form-title">Consultation</h4>
            <div class="row p-2">
                <div class="col-2 border">

                </div>
                <div class="col-10">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th class="table-title" colspan="3"><v-icon>mdi-account-circle</v-icon> Personal information </th>
                            </tr>
                            <tr>
                                <td style="width:20%"><span class="text-danger">*</span>Id</td>
                                <td style="width:40%">First name</td>
                                <td style="width:40%">Last name</td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-white bg-danger"></p>
                                </td>
                                <td class="required">

                                </td>
                                <td class="required">

                                </td>
                            </tr>
                            <tr>
                                <td>Date of birth</td>
                                <td>Address</td>
                                <td>Tel</td>
                            </tr>
                            <tr>
                                <td class="required"></td>
                                <td class="required"></td>
                                <td class="required"></td>
                            </tr>
                        </table>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th class="table-title" colspan="5"> <v-icon>mdi-stethoscope</v-icon>Medical data</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="text-danger">*</span>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="consultation_type1" name="consultation_type1" class="custom-control-input">
                                        <label class="custom-control-label" for="consultation_type1">New case</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="consultation_type2" name="consultation_type1" class="custom-control-input">
                                        <label class="custom-control-label" for="consultation_type2">Followup</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:10%">Complaint<span class="text-danger">*</span></td>
                                <td><textarea  class="form-control form-control-sm" placeholder="write here the complaint "></textarea></td>
                            </tr>
                            <tr>
                                <td>Finding</td>
                                <td><textarea  class="form-control form-control-sm" placeholder="write here the findings "></textarea></td>
                            </tr>
                            <tr>
                                <td>Test</td>
                                <td>
                                    <strong>Malaria (RDT)</strong>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="malaria1" name="malaria1" class="custom-control-input">
                                        <label class="custom-control-label" for="malaria1">Positive</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="malaria2" name="malaria1" class="custom-control-input">
                                        <label class="custom-control-label" for="malaria2">Negative</label>
                                    </div>
                                    | &nbsp
                                    <strong>Syphilis</strong>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="syphilis1" name="syphilis1" class="custom-control-input">
                                        <label class="custom-control-label" for="syphilis1">Positive</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="syphilis2" name="syphilis1" class="custom-control-input">
                                        <label class="custom-control-label" for="syphilis2">Negative</label>
                                    </div>
                                    |&nbsp
                                    <strong>HIV AIDS</strong>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="hiv1" name="hiv1" class="custom-control-input">
                                        <label class="custom-control-label" for="hiv1">Positive</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="hiv2" name="hiv1" class="custom-control-input">
                                        <label class="custom-control-label" for="hiv2">Negative</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Medical care needed (soin)<span class="text-danger">*</span>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="care1" name="care1" class="custom-control-input">
                                        <label class="custom-control-label" for="care1">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="care2" name="care1" class="custom-control-input">
                                        <label class="custom-control-label" for="care2">No</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Diagnoses<span class="text-danger">*</span></td>
                                <td>
                                    <input type="text" placeholder="type here the diagnose" class="form-control form-control-sm"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Diagnose code<span class="text-danger">*</span></td>
                                <td>

                                </td>
                            </tr>

                            <tr>
                                <td>Details<span class="text-danger">*</span></td>
                                <td><textarea class="form-control"></textarea></td>
                            </tr>
                        </table>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th class="table-title" colspan="5"><v-icon>mdi-pill</v-icon> Medication </th>
                            </tr>
                            <tr>
                                <td>
                                    <select class="form-control form-control-sm">
                                        <option>Choose</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" placeholder="Breakfast" class=" form-control form-control-sm"/>
                                </td>
                                <td>
                                    <input type="number" placeholder="Lunch" class=" form-control form-control-sm"/>
                                </td>
                                <td>
                                    <input type="number" placeholder="Dinner" class=" form-control form-control-sm"/>
                                </td>
                                <td>
                                    <input type="number" placeholder="To give" class=" form-control form-control-sm"/>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-sm table-borderless">

                        </table>
                    </div>
                </div>
            </div>


        </v-app>
    </div>
</template>

<script>
export default {
    name: "generalist_consultation",
    data(){
        return{
            formData:{

            }
        }
    },
    created(){
        console.log(this.$route.params.consultation)
    },
    methods:{
        init(){

        }
    }
}
</script>

<style scoped>
.table-title{
    background-color: #cceff0;
}
.main-container{
    margin-top:5px;
}
</style>
