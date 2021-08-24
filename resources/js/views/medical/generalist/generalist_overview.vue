<template>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-sm border">
                <thead>
                    <th>Date</th>
                    <th>Case</th>
                    <th>Diag Code</th>
                    <th>Diagnose</th>
                    <th>Complaint</th>
                    <th>Finding</th>
                    <th>Details</th>
                </thead>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "generalist_overview",
    props:['patient_id'],
    data(){
        return{

        }
    },
    mounted(){
        console.log(this.patient_id)
    }
}
</script>

<style scoped>

</style>
