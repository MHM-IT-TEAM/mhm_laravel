<template>
    <div class="container-fluid w-75">
        <h3 class="text-center">OUT PATIENT OBSTETRICAL</h3>
        <div class="d-flex justify-content-between">
            <div>
                <h4>I) Family planning</h4>
            </div>
            <div class=" d-flex  justify-content-end">
                <select class="form-control form-control-sm m-2">
                    <option>Year</option>
                    <option v-for="i in year_list">{{i}}</option>
                </select>
                <select class="form-control form-control-sm m-2">
                    <option>Month</option>
                    <option v-for="i in 12">{{i}}</option>
                </select>
            </div>
        </div>
        <table class="table table-sm table-bordered">
            <tr>
                <th rowspan="2" class="vertical-center">Methods</th>
                <th rowspan="2" class="vertical-center">Products</th>
                <th colspan="4" class="text-center">New Users</th>
                <th colspan="4" class="text-center">Regular users</th>
                <th>Total</th>
            </tr>
            <tr>
                <td>[10-14]</td>
                <td>[15-19]</td>
                <td>[20-24]</td>
                <td><25</td>
                <td>[10-14]</td>
                <td>[15-19]</td>
                <td>[20-24]</td>
                <td><25</td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="2" class="vertical-center font-weight-bold">Oral</td>
                <td>Microgynon</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td> Microlut</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="2" class="vertical-center font-weight-bold">Injection</td>
                <td>DMPA-IM</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td> DMPA-SC</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="2" class="vertical-center font-weight-bold">Barrier</td>
                <td>Condom men</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td> Condom Female</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="2" class="vertical-center font-weight-bold">Implants</td>
                <td>Implanon</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Levoplant</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table class="table table-sm table-bordered">
            <tr>
                <th>Methods</th>
                <th>Implanon</th>
                <th>Injection</th>
                <th>Pill</th>
                <th>Condom</th>
                <th>Total</th>
            </tr>
            <tr>
                <td>Ladies who gave birth with MHM and continue to do PF with MHM now</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Ladies who didn't give birth with MHM</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="font-weight-bold">TOTAL</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <h4>II) CPN</h4>
        <table class="table table-sm table-bordered">
            <tr>
                <td>Admission</td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="2">Ultrasound</td>
                <td>Routine</td>
                <td></td>
            </tr>
            <tr>
                <td>Extra</td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="2">CTG</td>
                <td>Routine</td>
                <td></td>
            </tr>
            <tr>
                <td>Extra</td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="2">Followup CPN</td>
                <td>Juste once</td>
                <td></td>
            </tr>
            <tr>
                <td>Continuous</td>
                <td></td>
            </tr>
        </table>
        <h4>III) Postpartum</h4>
        <table class="table table-sm table-bordered">
            <tr>
                <td>Baby</td>
                <td></td>
            </tr>
            <tr>
                <td>Mom</td>
                <td></td>
            </tr>
            <tr>
                <td>Meeting</td>
                <td></td>
            </tr>
            <tr class="font-weight-bold">
                <td>Total</td>
                <td></td>
            </tr>
        </table>
        <h4>IV) Pediatric</h4>
        <table class="table table-sm table-bordered">
            <tr>
                <th>Nature</th>
                <th>Boy</th>
                <th>Girl</th>
            </tr>
            <tr>
                <td>Vaccination</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Checkup</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Sickness</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Injury</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Wound care</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Total</td>
                <td></td>
                <td></td>
            </tr>
        </table>

    </div>
</template>

<script>
export default {
    name: "pink_statistics",
    computed:{
        year_list(){
            let start=2010
            let end=new Date().getFullYear()
            let output=[]
             for(start ;start<=end;start++){
                 output.push(start)
             }
             return output
        }
    }
}
</script>

<style scoped>
.vertical-center{
    vertical-align: middle;
}
</style>
