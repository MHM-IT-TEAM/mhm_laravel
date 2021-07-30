<template>
    <div class="page-container">
        <letter_head/>
        <h4 class="text-center page-title">Patient Discharge</h4>
        <h6 style="margin-left:5px">Patient Information</h6>
        <div class="table-container">
            <table class="table table-borderless table-sm">
                <tr>
                    <td>Patient ID:</td>
                    <td><input type="number" style="width:50px"/></td>
                    <td>Full name:</td>
                    <td><input type="text" style="width:300px"/></td>
                    <td>DOB:</td>
                    <td>10-01-2021</td>
                </tr>
                <tr>
                    <td>Date of Admission</td>
                    <td>2022-05-15</td>
                    <td>Date of discharge</td>
                    <td><input type="date"/></td>
                    <td>Time:</td>
                    <td><input type="time"/></td>
                </tr>
            </table>
        </div>
        <div class="body">
            <div class="form-group row">
                <label>Reason for Admittance </label>
                <textarea class="form-control"></textarea>
            </div>
            <div class="form-group row">
                <label>Discharge Diagnosis </label>
                <textarea class="form-control"></textarea>
            </div>
            <div class="row">Vital signs</div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Temp</label>
                        <input type="text"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Pulse</label>
                        <input type="number"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>SPO2</label>
                        <input type="number"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>BP</label>
                        <input type="text"/>
                    </div>
                </div>
            </div>
            <div class="form-check-inline row mt-4">
                Discharged to: &nbsp
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="discharge">Home</label>
                    &nbsp
                    <input
                        class="form-check-input"
                        type="radio"
                        name="discharge"
                    />
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="discharge">Other</label>
                    &nbsp
                    <input
                        class="form-check-input"
                        type="radio"
                        name="discharge"
                    />
                </div>
                <input type="text" style="width:300px"/>
            </div>
            <div class="form-group row mt-4">
                Transport needed:&nbsp
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="transport">Yes</label>
                    &nbsp
                    <input
                        class="form-check-input"
                        type="radio"
                        name="transport_needed"
                    />
                </div> &nbsp
                <div class="form-check form-check-inline ml-2">
                    <label class="form-check-label" for="transport">No</label>
                    &nbsp
                    <input
                        class="form-check-input"
                        type="radio"
                        name="transport_needed"
                    />
                </div>
                <select>
                    <option>Choose</option>
                </select>
            </div>
            <div class="form-group row mt-4">
                Appointment for checkup:
                <input type="date"/>
            </div>
            <hr/>
            <div class="form-group row">
                Midwife responsible:
                <input type="text" style="width:350px"/>
            </div>
            <div class="signature d-none d-print-block row">
                <div class="col text-left">
                    MHM Responsible
                </div>
                <div class="col text-right">
                    Patient or relative
                </div>
            </div>
        </div>
        <v-btn text color="indigo" outlined class="submit">Submit</v-btn>
    </div>

</template>

<script>
import Letter_head from "../../../components/templates/letter_head";
export default {
    name: "maternity_discharge",
    components: {Letter_head}
}
</script>

<style scoped>
.page-container{
    margin-left:150px;
    width:210mm;
    height:297mm;
    padding:10px;
    border: black solid 1px;
    font-size: 11px;
    position: relative;
}
.table-container{
    border:#00537f solid 0.5px;
}
.page-title{
    font-weight: bold;
    /*font-family: "Arial Black";*/
}
.body{
    padding:15px;
}
.signature{
    margin-top: 50px;
    margin-left:-20px;
}
.submit{
    position:absolute;
    bottom: 10px;
    right:10px;
}
@media print{
    .page-container{
        margin-left:0;
        margin-top: 60px;
        border:none;
        transform:scale(1.5)
    }

    input,textarea{
        border:none;
        outline: transparent;
    }
}

</style>
