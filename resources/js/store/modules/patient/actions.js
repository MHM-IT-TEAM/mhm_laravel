import * as types from './mutation_types'

export const fetchPatients = ({ commit, dispatch, state }, params) => {
    return new Promise((resolve, reject) => {
        window.axios.get(`/api/patients/search`, { params: { query: params } }).then((response) => {
            commit(types.BOOTSTRAP_PATIENTS, response.data)
            //commit(types.SET_TOTAL_PATIENTS, response.data.patients.total)
            //resolve(response)
        }).catch((err) => {
            reject(err)
        })
    })
}

export const fetchPatient = ({ commit, dispatch }, id) => {
    return new Promise((resolve, reject) => {
        window.axios.get(`/api/patients/${id}/edit`).then((response) => {
            commit(types.BOOTSTRAP_PATIENTS,response.data)
            resolve(response.data)
        }).catch((err) => {
            reject(err)
        })
    })
}

export const addPatient = ({ commit, dispatch, state }, data) => {
    return new Promise((resolve, reject) => {
        window.axios.post('/api/patients', data).then((response) => {
            commit(types.ADD_PATIENT, response.data)
            resolve(response.data)
        }).catch((err) => {
            reject(err)
        })
    })
}

export const updatePatient = ({ commit, dispatch, state }, data) => {
    return new Promise((resolve, reject) => {
        window.axios.post(`/api/patients/${data.get("id")}`, data).then((response) => {
            if (response.data.success) {
                //commit(types.UPDATE_PATIENT, response.data)
            }
            resolve(response)
        }).catch((err) => {
            reject(err)
        })
    })
}

export const deletePatient = ({ commit, dispatch, state }, id) => {
    return new Promise((resolve, reject) => {
        window.axios.delete(`/api/patients/${id}`).then((response) => {
            commit(types.DELETE_PATIENT, id)
            resolve(response)
        }).catch((err) => {
            reject(err)
        })
    })
}

export const deleteMultiplePatients = ({ commit, dispatch, state }, id) => {
    return new Promise((resolve, reject) => {
        window.axios.post(`/api/patients/delete`, { 'id': state.selectedPatients }).then((response) => {
            commit(types.DELETE_MULTIPLE_PATIENTS, state.selectedPatients)
            resolve(response)
        }).catch((err) => {
            reject(err)
        })
    })
}

export const setSelectAllState = ({ commit, dispatch, state }, data) => {
    commit(types.SET_SELECT_ALL_STATE, data)
}

export const selectAllPatients = ({ commit, dispatch, state }) => {
    if (state.selectedPatients.length === state.patients.length) {
        commit(types.SET_SELECTED_PATIENTS, [])
        commit(types.SET_SELECT_ALL_STATE, false)
    } else {
        let allCustomerIds = state.patients.map(cust => cust.id)
        commit(types.SET_SELECTED_PATIENTS, allCustomerIds)
        commit(types.SET_SELECT_ALL_STATE, true)
    }
}

export const selectPatients = ({ commit, dispatch, state }, data) => {
    commit(types.SET_SELECTED_PATIENTS, data)
    if (state.selectedPatients.length === state.patients.length) {
        commit(types.SET_SELECT_ALL_STATE, true)
    } else {
        commit(types.SET_SELECT_ALL_STATE, false)
    }
}
export const selectPatient = ({ commit, dispatch, state }, data) => {
    commit(types.SET_SELECTED_PATIENT, data)
    if (state.selectedPatient.length === state.patients.length) {
        commit(types.SET_SELECT_ALL_STATE, true)
    } else {
        commit(types.SET_SELECT_ALL_STATE, false)
    }
}

export const resetSelectedPatient = ({ commit, dispatch, state }, data) => {
    commit(types.RESET_SELECTED_PATIENT)
}
export const resetPatient=({commit,state})=>{
    commit(types.RESET_PATIENT)
}
