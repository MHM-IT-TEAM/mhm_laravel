document.addEventListener('DOMContentLoaded',function(){
    fetch_data()

});

async function fetch_data() {
    let actual= await axios.get(`../../api/obstetrics/baby/weight_overview/31`)
    let baby_name = 'Fitahiana'
    let birth_weight = actual.data.birth_weight
    let birth_double = birth_weight * 2
    let birth_max = birth_weight * 3.5
    let minus_ten = birth_weight * 0.9
    let ideal_1 = [
        birth_weight,
        birth_weight * 0.95,
        birth_weight * 0.92,
        birth_weight * 0.9,
        birth_weight * 0.91,
        birth_weight * 0.92,
        birth_weight * 0.94,
        birth_weight * 0.96,
        birth_weight * 0.98
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
    let actual_weight = {
        1: 3000,
        5: 2800,
        10: 2900,
        14: 3600,
        35: 3800,
        47: 4200,
        60: 5700,
        360: 8890
    }
    let actual_weight_line = []
//processing the data
    for (let i = 0; i < 82; i++) {
        ideal_2.push(birth_weight * n)
        n = n * 1.0086
    }
    n = 1
    for (let i = 0; i < 270; i++) {
        ideal_3.push(birth_double * n)
        n = n * 1.001515
    }
    n = 1
    for (let i = 0; i < 142; i++) {
        ideal_2_bis.push(birth_weight * n)
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
        birth_weight_line.push(birth_weight)
        birth_double_line.push(birth_double)
        label.push(i)
        minus_ten_line.push(minus_ten)
        actual_weight_line.push(null)
    }

    // let ac_keys = Object.keys(actual_weight)
    // let ac_values = Object.values(actual_weight)

    let ac_keys=[]
    let ac_values=[]
    actual.data.checkup.forEach(data=>{
        ac_keys.push(data.day)
        ac_values.push(data.weight)
    })
    ac_keys.forEach((key, index) => {
        actual_weight_line.splice(key, 1, ac_values[index])
    })


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
                    // backgroundColor: function (val) {
                    //     var index = val.dataIndex;
                    //     var value = val.dataset.data[index];
                    //     return value <= 0 ? 'transparent' : 'blue'
                    // },
                    backgroundColor: 'blue',
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
                text: baby_name
            }

        }
    })
}
