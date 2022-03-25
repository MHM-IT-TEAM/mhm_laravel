<template>
<div class="container-fluid">

        <div class="chart-container" style="position: relative; height:auto; width:auto;">
            <canvas id="graph"></canvas>
        </div>

</div>
</template>

<script>
import {mapGetters,mapActions} from 'vuex'
export default {
    name: "weight_overview",
    props:['source_list'],
    data(){
        return{
            birthDate:'',
            weight_list:'',
            baby_name:'',
            birth_weight:''

        }
    },
    methods:{
        ...mapActions('baby_checkup',['bootstrap_checkup_data']),
        async set(){
            // console.log(this.baby_checkup_data)
            // set the starting weight and date
            // if the birth data (weight, date )is available, then take them if not it is then the first weight in checkups list
            this.birthDate= Date.parse(this.baby_checkup_data.birthDate)
            this.weight_list=this.baby_checkup_data.baby_checkups
            this.baby_name = this.baby_checkup_data.firstName
            this.birth_weight = this.baby_checkup_data?.birth_medical_data[0]?.birth_weight ?? this.baby_checkup_data?.baby_checkups[0]?.weight



            let birth_double = this.birth_weight * 2
            let birth_max = this.birth_weight * 3.5
            let minus_ten = this.birth_weight * 0.9
            let ideal_1 = [
                this.birth_weight,
                this.birth_weight * 0.95,
                this.birth_weight * 0.92,
                this.birth_weight * 0.9,
                this.birth_weight * 0.91,
                this.birth_weight * 0.92,
                this.birth_weight * 0.94,
                this.birth_weight * 0.96,
                this.birth_weight * 0.98
            ]
            let ideal_2 = []
            let ideal_2_bis = []
            let ideal_3 = []
            let ideal_3_bis = []
            let birth_weight_line = []
            let birth_double_line = []
            let minus_ten_line = []
            let label = []
            let n = 1;
            let actual_weight_line = []
//processing the data
            for (let i = 0; i < 82; i++) {
                ideal_2.push(this.birth_weight * n)
                n = n * 1.0086
            }
            n = 1
            for (let i = 0; i < 270; i++) {
                ideal_3.push(birth_double * n)
                n = n * 1.001515
            }
            n = 1
            for (let i = 0; i < 142; i++) {
                ideal_2_bis.push(this.birth_weight * n)
                n = n * 1.00493
            }
            n = 1
            for (let i = 0; i < 210; i++) {
                ideal_3_bis.push(birth_double * n)
                n = n * 1.00195
            }
            let ideal = [...ideal_1, ...ideal_2, ...ideal_3]
            let ideal_bis = [...ideal_1, ...ideal_2_bis, ...ideal_3_bis]

            for (let i = 0; i < ideal.length; i++) {
                birth_weight_line.push(this.birth_weight)
                birth_double_line.push(birth_double)
                label.push(i)
                minus_ten_line.push(minus_ten)
                actual_weight_line.push(null)
            }
            let ac_keys=[]
            let ac_values=[]
            this.weight_list.forEach(list=>{
                let keys=(Date.parse(list.created_at)-this.birthDate)/(1000 * 60 * 60 * 24)
                ac_keys.push(keys)
                ac_values.push(list.weight)
            })
            console.log(ac_keys)
            ac_keys.forEach((key, index) => {
                actual_weight_line.splice(key, 1, ac_values[index])
            })
            // console.log(actual_weight_line)

            var ctx = document.getElementById('graph')
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: label,
                    datasets: [{
                        data: ideal,
                        fill: false,
                        borderColor: 'rgba(123, 239, 178, 1)',
                        label: 'ideal',
                        pointRadius: 0
                    }, {
                        data: ideal_bis,
                        fill: false,
                        borderColor: 'rgba(123, 239, 178, 1)',
                        label: 'doubled_in_5_months',
                        pointRadius: 0
                    },
                        {
                            data: birth_weight_line,
                            fill: false,
                            borderColor: 'green',
                            label: 'birthweight',
                            pointRadius: 0
                        }, {
                            data: minus_ten_line,
                            fill: false,
                            borderColor: 'red',
                            label: '-10%',
                            pointRadius: 0
                        }, {
                            data: actual_weight_line,
                            label: 'actual weight',
                            borderColor: 'blue',
                            backgroundColor: function (val) {
                                var index = val.dataIndex;
                                var value = val.dataset.data[index];
                                return value <= 0 ? 'transparent' : 'blue'
                            },
                            //backgroundColor: 'blue',
                            //spanGaps: false,
                            fill: true,
                        }, {
                            data: birth_double_line,
                            label: 'birth double',
                            borderColor: 'orange',
                            fill: false,
                            pointRadius: 0

                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                max: birth_max,
                                min: 0,
                                stepSize: 1000
                            }
                        }],
                    },
                    title: {
                        display: true,
                        text: this.baby_name
                    }

                }
            })

        }
    },
    computed:{
        ...mapGetters('baby_checkup',['baby_checkup_data'])
    },
    watch:{
        baby_checkup_data:{
            handler(val){
                this.set()
            },
            deep:true
        }
    },

}
</script>

<style scoped>

</style>
