import mutations from './mutations'
import * as actions from './actions'
import * as getters from './getters'

const initialState = {
    patients: [],
    totalPatients: 0,
    selectAllField: false,
    selectedPatients: [],
    selectedPatient:null,
    created_patient:null
}

export default {
    namespaced: true,

    state: initialState,

    getters: getters,

    actions: actions,

    mutations: mutations
}
