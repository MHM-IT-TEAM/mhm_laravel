import * as types from './mutation_types'

export const fetch_type_consult= async ({commit,state})=>{
    let init= await axios.get("/api/typeConsult")
    commit(types.BOOTSTRAP_TYPE_CONSULT,init.data)
}
export const newConsultation = async ({commit,state},formData)=>
    await axios.post("/api/consultation/")
    commit (types.ADD_CONSULTATION,formData)

}
