import mutations from './mutations'
import * as actions from './actions'
import * as getters from './getters'

const initialState = {
    consultations: [],
    type_consult:[],
    totalConsultations: 0,
    selectAllField: false,
    selectedConsultations: [],
    selectedConsultation:null
}

export default {
    namespaced: true,

    state: initialState,

    getters: getters,

    actions: actions,

    mutations: mutations
}
