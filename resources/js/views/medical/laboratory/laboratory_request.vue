<template>
    <div class="request-container" id="request-container">
        <letter_head_a5/>
        <h5 class="text-center font-weight-bold">Demande d'analyse</h5>
        <div class="text-center">
            <span class="text-center text-decoration-underline">Partenariat entre l'ONG MHM et le </span> <select><option>choose</option></select>
        </div>
        <table class="table table-sm dataTable">
            <tr>
                <td>Id:</td>
                <td>15475</td>
            </tr>
            <tr>
                <td>Nom:</td>
                <td>RASOANAMEF TIANA FRANSC</td>
            </tr>
            <tr>
                <td>Date de naissance</td>
                <td>10-04-2021</td>
            </tr>
            <tr>
                <td>Raison médicale:</td>
                <td><input type="text" style="width:100%"/></td>
            </tr>
        </table>
        <h5 class="text-center">Analyse(s) demandée</h5>
        <div class="d-print-none">
            Analyse: <input type="text" style="width:350px"/>
        </div>
        <div class="analyse-list">
            <ul class="ml-4">
                <li>NFS</li>
                <li>Albumine</li>
            </ul>
        </div>
        <p class="text-right">Date du <input type="date"/></p>
        <div class="row p-2">
            <div class="col text-left text-decoration-underline">
                Présidente de l'ONG
            </div>
            <div class="col text-right text-decoration-underline">
                Le responsable médicale
            </div>
        </div>
        <v-btn text small color="indigo" outlined class="d-print-none submit" @click="print">submit</v-btn>
    </div>
</template>

<script>

import Letter_head_a5 from "../../../components/templates/letter_head_a5";
export default {
    name: "laboratory_request",
    components: {Letter_head_a5},
    methods:{
        async print(){
        }
    }
}
</script>
<style scoped>
.request-container{
    border:black solid 1px;
    width:148mm;
    height:795px;
    position:relative;
}
.table{
    font-size: 11px;
}
.submit{
    position: absolute;
    bottom: 10px;
    right: 10px;
}
@media print{
    .request-container{
        position:absolute;
        top:145px;
        left:-50px;
        transform:scale(1.5);
        border:none;
    }

    .dataTable{
        max-width: 90%;
        margin-left: 10px;
        margin-top: 25px;
    }
}
</style>
