<template>
    <div class="container">
        <form id="patientForm" enctype="multipart/form-data" @submit.prevent="submit">
            <input type="hidden" id="patId" name="patId" value="<?= $patId ?>"/>


            <div class="patient_container">
                <h4>Personal</h4>
                <hr>
                <div class="row perso_detail">
                    <div class="col-4">
                        <label for="firstName" class="pb-0 col-form-label">First Name</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <input class="form-control" name="firstName" id="firstName" v-model="patient.firstName"/>
                            </div>
                        </div>
                        <label for="lastName" class="pb-0 col-form-label">Last Name</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <input class="form-control" name="lastName" id="lastName" v-model="patient.lastName"/>
                            </div>
                        </div>
                        <label for="gender" class="pb-0 col-form-label">Gender</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <select class="form-control" name="gender" id="gender" v-model="patient.gender" required>
                                    <option value=""></option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                        </div>
                        <label for="dob" class="pb-0 col-form-label">DOB</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="date" class="form-control" name="dob" id="dob" v-model="patient.dob" required/>
                            </div>
                        </div>
                    </div><!--personal info-->


                    <div class="col-2">
                        <label for="martialStatus" class="pb-0 col-form-label">Martial Status</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <select class="form-control" name="martialStatus" id="martialStatus" v-model="patient.martialStatus" >
                                    <option value=""></option>
                                    <option value="Single">Single</option>
                                    <option value="Couple">Couple</option>
                                </select>
                            </div>
                        </div>
                        <label for="bloodGroup" class="pb-0 col-form-label">Blood Group</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <input class="form-control" name="bloodGroup" id="bloodGroup" v-model="patient.bloodGroup"/>
                            </div>
                        </div>
                        <label for="occupation" class="pb-0 col-form-label">Occupation</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <input class="form-control" name="occupation" id="occupation" v-model="patient.occupation"/>
                            </div>
                        </div>
                        <label for="education" class="pb-0 col-form-label">Education Level</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <select class="form-control" name="education" id="education" v-model="patient.education">
                                    <option value=""></option>
                                    <option value="illiterate">illiterate</option>
                                    <option value="primary">primary</option>
                                    <option value="secondary">secondary</option>
                                    <option value="university">university</option>
                                </select>
                            </div>
                        </div>
                    </div><!-- more info-->
                    <div class="col-3">
                        <div class="row">
                            <div class="col-12">
                                <label for="Nationality" class="pb-0 col-form-label">Nationality</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input class="form-control" name="nationality" id="nationality" v-model="patient.nationality"/>
                                    </div>
                                </div>
                                <label for="idCard" class="pb-0 col-form-label">ID card</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input class="form-control" name="idCard" id="idCard" v-model="patient.idCard"/>
                                    </div>
                                </div>
                                <label for="idDate" class="pb-0 col-form-label">ID Date</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="date" class="form-control" name="idDate" id="idDate" v-model="patient.idDate"/>
                                    </div>
                                </div>
                                <label for="idPlace" class="pb-0 col-form-label">ID Place</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="idPlace" id="idPlace" v-model="patient.idPlace"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="col-12" id="av">
                            <div class="file-loading " id="avatar_container">
                                <input type="file" name="avatar" id="avatar" class="file" />
                            </div>
                            <!-- <input type="file" id="avat" />	 -->
                        </div>
                        <!-- <div class="col-6 avatar">
                            <i class="fas fa-user  w-100 h-100"></i>
                        </div> -->
                    </div><!--Avatar and Nationality-->
                </div><!--personal detail-->
                <br>
                <h4>Communication Details</h4>
                <hr>
                <div class="row">
                    <div class="col-4">
                        <label for="idDate" class="pb-0 col-form-label">Adress</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="adress" id="adress" v-model="patient.adress" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="tel" class="pb-0 col-form-label">Mobile No</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="tel" id="tel" v-model="patient.tel"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="tel" class="pb-0 col-form-label">Email</label>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="email" class="form-control" name="email" id="email" v-model="patient.email"/>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <h4> Relatives Contact</h4>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <table class="table w-100 table-borderless" >
                            <thead>
                            <tr>
                                <th>Mom</th>
                                <th>Dad</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="mom_name" id="mom_name" v-model="patient.mom_name"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="dad_name" id="dad_name" v-model="patient.dad_name"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-10">
                                <h6 class="text-danger">Emergency Contact</h6>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-sm btn-primary float-right" onclick="add_row()" type="button"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <table id="emergency_table" class="table w-100 table-borderless">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Tel</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="row0">
                                <td>
                                    <input type="text" class="form-control" name="emContact_name[]" id="emContact_name" v-model="patient.emContact_name"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="emContact_tel[]" id="emContact_tel" v-model="patient.emContact_tel"/>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="test">
                    <button type="submit" id="submit" name="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "Patient",
        data(){
            return {
                patient:{
                    patId : "",
                    firstName : "",
                    lastName : "",
                    gender : "",
                    dob : "",
                    martialStatus : "",
                    bloodGroup : "",
                    nationality : "",
                    education : "",
                    occupation : "",
                    idCard : "",
                    idDate : "",
                    idPlace : "",
                    adress : "",
                    tel : "",
                    email : "",
                    mom_name : "",
                    dad_name : "",
                    emContact_name : "",
                    emContact_tel : ""
                },
                isEdit:false,
            }
        },

        computed:{

        },
        created() {

        },
        methods:{
            submit(){
                console.log("ok")
            }
        }
    }
</script>

<style scoped>

</style>
