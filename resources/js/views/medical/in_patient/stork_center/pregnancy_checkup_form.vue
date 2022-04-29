<template>
<div class="container w-75">
    <h3 class="mb-4">Pregnancy Checkup Form</h3>
    <section id="form" class="mb-4 border shadow p-2" >
        <div class="row">
            <div class="col-2">
                BDCF:
            </div>
            <div class="col">
                <input type="text" class="form-control form-control-sm"/>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                CTG:
            </div>
            <div class="col">
                <input type="text" class="form-control form-control-sm"/>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                Belly size <small>(cm)</small>:
            </div>
            <div class="col">
                <input type="text" class="form-control form-control-sm"/>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                HU <small>(cm)</small>:
            </div>
            <div class="col">
                <input type="text" class="form-control form-control-sm"/>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                Weight:
            </div>
            <div class="col">
                <input type="text" class="form-control form-control-sm"/>
            </div>
        </div>
        <button class="btn btn-sm btn-primary mt-2">Submit</button>
    </section>
    <hr>
    <div class="table-responsive">
        <table class="table table-sm">
            <tr>
                <td>Date</td>
                <td>BDCF</td>
                <td>Belly size</td>
                <td>HU</td>
                <td>Weight</td>
            </tr>
        </table>
    </div>
</div>
</template>

<script>
export default {
    name: "pregnancy_checkup_form"
}
</script>

<style scoped>

</style>
