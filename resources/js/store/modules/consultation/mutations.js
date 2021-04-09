import * as types from './mutation_types'
export default {
    [types.BOOTSTRAP_TYPE_CONSULT](state,type_consult){
         state.type_consult= type_consult
    },
    [types.ADD_CONSULTATION](state,formData){
        state.consultations.unshift(formData)
    },
    [types.BOOTSTRAP_CONSULTATIONS](state,consultations){

        let output=[]
        consultations.main_data.forEach(cons=>{
            let adress = cons.patient.adress.toLowerCase().split(' ')
            let arg = ['ambovo', 'rangaina', 'mahazo', 'tanjondroa']
            let check = false
            adress.forEach(ad => {
                if (arg.indexOf(ad) !== -1) {
                    check = true
                }
            })

            let subTotal=0
            let careLine=[]
                cons.patient_care_details.forEach(tot=>{
                    subTotal+= parseInt(tot.total)
                    careLine.push({id:tot.service_prices_id,quantity:tot.qty,price:"",totLine:parseInt(tot.total)})
                })


            let protoType={
                consult_id: cons.id,
                patient:  {
                    id:cons.patient.id,
                    firstName:cons.patient.firstName,
                    lastName:cons.patient.lastName,
                    adress:cons.patient.adress,
                    sector:check,
                    last_due:"",
                },
                careDetails:{
                    type_consult:cons.type_consult.id,
                    priority:cons.priority,
                    status:cons.status,
                    care_line:careLine,
                    itemSubTotal:subTotal,
                    itemTotal:0,
                    vitalSign:{
                        temp:"",
                        pulse:"",
                        taSysto:"",
                        taDia:"",
                        weight:"",
                        remark:""
                    },
                },
            }
                output.push(protoType)
                state.consultations= output


            })


        }
}
