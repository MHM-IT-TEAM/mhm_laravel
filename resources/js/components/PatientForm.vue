<template>
    <div>
        <form id="patientForm" enctype="multipart/form-data">
            <input type="hidden" id="patId" name="patId" value="<?= $patId ?>"/>


            <div class="patient_container">
                <div class="row perso_detail">
                    <div class="col-4">
                        <div class="row mt-4">
                            <label for="firstName" class="col-sm-4 col-form-label">First Name</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="firstName" id="firstName" v-model="this.patient.firstname"/>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="lastName" class="col-sm-4 col-form-label">Last Name</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="lastName" id="lastName"/>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="gender" class="col-sm-4 col-form-label">Gender</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value=""></option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="dob" class="col-sm-4 col-form-label">DOB</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dob" id="dob" required/>
                            </div>
                        </div>
                    </div><!--personal info-->


                    <div class="col-3">
                        <div class="row mt-4">
                            <label for="martialStatus" class="col-sm-4 col-form-label">Martial Status</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="martialStatus" id="martialStatus" >
                                    <option value=""></option>
                                    <option value="Single">Single</option>
                                    <option value="Couple">Couple</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="bloodGroup" class="col-sm-4 col-form-label">Blood Group</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="bloodGroup" id="bloodGroup"/>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="occupation" class="col-sm-4 col-form-label">Occupation</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="occupation" id="occupation"/>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="education" class="col-sm-4 col-form-label">Education Level</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="education" id="education">
                                    <option value=""></option>
                                    <option value="illiterate">illiterate</option>
                                    <option value="primary">primary</option>
                                    <option value="secondary">secondary</option>
                                    <option value="university">university</option>
                                </select>
                            </div>
                        </div>
                    </div><!-- more info-->
                    <div class="col-5">
                        <div class="row">
                            <div class="col-6">
                                <div class="row mt-4">
                                    <label for="Nationality" class="col-sm-4 col-form-label">Nationality</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="nationality" id="nationality"/>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <label for="idCard" class="col-sm-4 col-form-label">ID card</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="idCard" id="idCard"/>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <label for="idDate" class="col-sm-4 col-form-label">ID Date</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="idDate" id="idDate"/>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <label for="idPlace" class="col-sm-4 col-form-label">ID Place</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="idPlace" id="idPlace"/>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-6 avatar">
                                <i class="fas fa-user  w-100 h-100"></i>
                            </div> -->
                            <div class="col-6" id="av">
                                <div class="file-loading " id="avatar_container">
                                    <input type="file" name="avatar" id="avatar" class="file"  />
                                </div>
                                <!-- <input type="file" id="avat" />	 -->

                            </div>
                        </div>

                    </div><!--Avatar and Nationality-->
                </div><!--personal detail-->
                <hr>
                <h6>Communication Details</h6>
                <div class="row">
                    <div class="col-4">
                        <div class="row mt-2">
                            <label for="idDate" class="col-sm-4 col-form-label">Adress</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="adress" id="adress" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="row mt-2">
                            <label for="tel" class="col-sm-4 col-form-label">Mobile No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="tel" id="tel"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-5">
                        <div class="row mt-2">
                            <label for="tel" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" id="email"/>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <h6> Relatives Contact</h6>

                <table class="table w-100" >
                    <tr>
                        <td>
                            Mom:
                        </td>
                        <td>
                            <input type="text" class="form-control" name="mom_name" id="mom_name"/>
                        </td>
                        <td>
                            Dad
                        </td>
                        <td>
                            <input type="text" class="form-control" name="dad_name" id="dad_name"/>
                        </td>
                    </tr>
                </table>
                <hr>
                <div class="row">
                    <div class="col-10">
                        <h6 class="text-danger">Emergency Contact</h6>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-sm btn-primary float-right" onclick="add_row()" type="button"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <table id="emergency_table" class="table w-100">
                    <tbody>
                    <tr id="row0">
                        <td>
                            Name
                        </td>
                        <td>
                            <input type="text" class="form-control" name="emContact_name[]" id="emContact_name"/>
                        </td>
                        <td>
                            Tel
                        </td>
                        <td>
                            <input type="text" class="form-control" name="emContact_tel[]" id="emContact_tel"/>
                        </td>
                    </tr>

                    </tbody>
                </table>
                <div id="test">
                    <button type="submit" id="submit" name="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "PatientForm",
        data(){
            return {
                patient:{
                    id:"",
                    firstname:"",
                    lastname:""
                }
            }
        },

        computed:{

        },
        created() {
        },
        methods:{

        }
    }
</script>

<style scoped>

</style>
