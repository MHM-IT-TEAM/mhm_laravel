import * as types from './mutation_types'
export default {
    [types.BOOTSTRAP_TYPE_CONSULT](state,type_consult){
         state.type_consult= type_consult
    },
    [types.ADD_CONSULTATION](state,formData){
        state.consultations.unshift(formData)
    },
    [types.BOOTSTRAP_CONSULTATIONS](state,consultations){
        state.consultations=consultations
    }
}
