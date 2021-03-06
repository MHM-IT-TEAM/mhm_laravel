import * as types from './mutation_types'
import moment from "moment"
export default {
    [types.BOOTSTRAP_PATIENTS] (state, patients) {
        state.patients = patients
        state.patients.forEach(patient=>{
            return patient.birthDate= moment(patient.birthDate).format('DD-MMM-YYYY')
        })
    },

    [types.SET_TOTAL_PATIENTS] (state, totalPatients) {
        state.totalPatients = totalPatients
    },

    [types.ADD_PATIENT] (state, data) {
        //state.patients.push(data)
        Object.assign(state.patients,data)
    },

    [types.UPDATE_PATIENT] (state, data) {
        let pos = state.patients.findIndex(patient => patient.id === data.patient.id)

        state.patients[pos] = data.patient
    },

    [types.DELETE_PATIENT] (state, id) {
        let index = state.patients.findIndex(patient => patient.id === id)
        state.patients.splice(index, 1)
    },

    [types.DELETE_MULTIPLE_PATIENTS] (state, selectedPatients) {
        selectedPatients.forEach((patient) => {
            let index = state.patients.findIndex(_pat => _pat.id === patient.id)
            state.patients.splice(index, 1)
        })

        state.selectedPatients = []
    },

    [types.SET_SELECTED_PATIENTS] (state, data) {
        state.selectedPatients = data
    },
    [types.SET_SELECTED_PATIENT] (state, data) {
        state.selectedPatient = data
    },

    [types.RESET_SELECTED_PATIENT] (state, data) {
        state.selectedPatient = null
    },

    [types.SET_SELECT_ALL_STATE] (state, data) {
        state.selectAllField = data
    },
    [types.RESET_PATIENT](state){
        state.patients=[]
    }


}
