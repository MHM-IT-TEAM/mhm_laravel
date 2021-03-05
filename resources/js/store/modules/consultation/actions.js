import * as types from './mutation_types'

export const fetch_type_consult = async ({ commit, state }) => {
    let init = await axios.get("/api/typeConsult")
    commit(types.BOOTSTRAP_TYPE_CONSULT, init.data)
}
export const newConsultation = async ({ commit, state,dispatch }, formData) => {
    await axios.post("/api/consultation/", formData)
    //dispatch('fetchTodayConsultations')
    commit(types.ADD_CONSULTATION,formData)
}
export const fetchTodayConsultations= async({commit})=>{
    let data= await axios.get("/api/consultation")
    commit(types.BOOTSTRAP_CONSULTATIONS,data.data)
}
