import mutations from './mutations'
import * as actions from './actions'
import * as getters from './getters'

const initialState = {
    patients: [],
    totalPatients: 0,
    selectAllField: false,
    selectedPatients: []
}

export default {
    namespaced: true,

    state: initialState,

    getters: getters,

    actions: actions,

    mutations: mutations
}
