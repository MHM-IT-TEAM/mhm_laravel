<template>
    <div class="container-fluid w-75 border">
        <div class="row">
            <div class="col-6">
                <div class="table-responsive">
                    <h4>General overview</h4>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <td>Birthday</td>
                            <td></td>
                            <td></td>
                            <td>Days</td>
                            <td>Days</td>
                            <td>Days</td>
                        </tr>
                        <tr>
                            <td>19/02/2022</td>
                            <td></td>
                            <td></td>
                            <td>90</td>
                            <td>150</td>
                            <td>365</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Max Loss</td>
                            <td>Day</td>
                            <td>Month</td>
                            <td>Month</td>
                            <td>Month</td>
                        </tr>
                        <tr>
                            <td>Birth-weight</td>
                            <td>-10%</td>
                            <td>10</td>
                            <td>3</td>
                            <td>5</td>
                            <td>12</td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-control form-control-sm bg-success" v-model.number="weight_input"/>
                            </td>
                            <td>{{weight_input*0.9}}</td>
                            <td>{{weight_input}}</td>
                            <td>{{weight_input*2}}</td>
                            <td>{{weight_input*2}}</td>
                            <td>{{weight_input*3}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Possible now</td>
                            <td>Latest now</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-6">
                <h4>Weight goal baby > 30 days</h4>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr v-for="i in 2">
                            <td v-for="j in 13">-</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td v-for="i in 12">Month</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td v-for="i in 12">{{i}}</td>
                        </tr>
                        <tr>

                            <td>Weight</td>
                            <td v-for="w in weight_chart">{{Math.floor(w)}}</td>
                        </tr>
                        <tr>
                            <td>Weekly gain</td>
                            <td v-for=" wg in weekly_gain">{{Math.floor(wg)}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <td>Today</td>
                            <td colspan="2">
                                {{moment().format("MMM Do YY")}}
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="align-center">Baby's age</td>
                            <td>{{moment().diff(birth_date,'days')}}</td>
                            <td>Days</td>
                        </tr>
                        <tr>
                            <td>{{moment().diff(birth_date,'months')}}</td>
                            <td>Months</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <td>Last weight</td>
                            <td>Today weight</td>
                            <td>last time day</td>
                            <td>Today</td>
                        </tr>
                        <tr>
                            <td>{{last_weight}}</td>
                            <td>{{weight_input}}</td>
                            <td>{{moment(last_time_here).format("MMM Do YY")}}</td>
                            <td>{{moment().format("MMM Do YY")}}</td>
                        </tr>
                        <tr>
                            <td>Gained</td>
                            <td colspan="3" :class="{'bg-success':weight_gain_appreciation==='good','bg-warning':weight_gain_appreciation==='too much','bg-danger':weight_gain_appreciation==='too little'}">
                                {{weight_input-last_weight}}
                                <span>({{weight_gain_appreciation}})</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Minimum gain</td>
                            <td colspan="3">{{minimum_gain}}</td>
                        </tr>
                        <tr>
                            <td>Maximum gain</td>
                            <td colspan="3">{{maximum_gain}}</td>
                        </tr>
                        <tr>
                            <td>Min avg daily</td>
                            <td colspan="3">{{min_avg_daily}}</td>
                        </tr>
                        <tr>
                            <td>Max avg daily</td>
                            <td colspan="3">{{max_avg_daily}}</td>
                        </tr>
                        <tr>
                            <td>Min gain/day</td>
                            <td colspan="3">{{min_gain_per_day}}</td>
                        </tr>
                        <tr>
                            <td>Max gain/day</td>
                            <td colspan="3">{{max_gain_per_day}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment"
export default {
    name: "baby_weight_gain",
    props:['src_data'],
    data(){
        return{
            weight_input:'',
            last_weight:'',
            birth_date: "",
            last_time_here:""
        }
    },
    methods:{
        init(){
            this.last_weight= this.src_data.baby_checkups[this.src_data.baby_checkups.length-1].weight
            this.last_time_here= this.src_data.baby_checkups[this.src_data.baby_checkups.length-1].created_at
            this.birth_date= this.src_data.birthDate
        }
    },
    created(){
        this.init()
    },
    computed:{
        weight_chart(){
            let [wi,wi_2,wi_3]= [this.weight_input,this.weight_input*2,this.weight_input*3]

            let a= wi+((wi_2-wi)/5)
            let b=a+((wi_2-a)/4)
            let c= b+((wi_2-b)/3)
            let d =c+((wi_2-c)/2)
            let e =wi_2
            let f= e+((wi_3-e)/7)
            let g=f+((wi_3-f)/6)
            let h=g+((wi_3-g)/5)
            let i = h+((wi_3-h)/4)
            let j= i+((wi_3-i)/3)
            let k= j+((wi_3-j)/2)
            let l=wi_3
            return [a,b,c,d,e,f,g,h,i,j,k,l]
        },
        weekly_gain(){
            let wc = this.weight_chart
            let wi= this.weight_input
            let a= (wc[0]-wi)/4
            let b =  (wc[1]-wc[0])/4
            let c= (wc[2]-wc[1])/4
            let d =(wc[3]-wc[2])/4
            let e= (wc[4]-wc[3])/4
            let f= (wc[5]-wc[4])/4
            let g= (wc[6]-wc[5])/4
            let h= (wc[7]-wc[6])/4
            let i= (wc[8]-wc[7])/4
            let j= (wc[9]-wc[8])/4
            let k= (wc[10]-wc[9])/4
            let l= (wc[11]-wc[10])/4
            return [a,b,c,d,e,f,g,h,i,j,k,l]
        },
        minimum_gain(){
          return (this.last_weight/1000)* (moment().date()-moment(this.last_time_here).date())*15
        },
        maximum_gain(){
            return (this.last_weight/1000)* (moment().date()-moment(this.last_time_here).date())*20
        },
        min_avg_daily(){
            return this.minimum_gain/(moment().date()-moment(this.last_time_here).date())
        },
        max_avg_daily(){
            return this.maximum_gain/(moment().date()-moment(this.last_time_here).date())
        },
        min_gain_per_day(){
            return (this.weight_input*15)/1000
        },
        max_gain_per_day(){
            return (this.weight_input/1000)*20
        },
        weight_gain_appreciation(){
            let diff=this.weight_input-this.last_weight
            let result=''
            if( diff > this.maximum_gain) result="too much";
            else if( diff < this.minimum_gain) result="too little";
            else if( diff >this.minimum_gain && diff < this.maximum_gain) result="good";
            else result=''
            return result
        }
    }
}
</script>

<style scoped>

</style>
