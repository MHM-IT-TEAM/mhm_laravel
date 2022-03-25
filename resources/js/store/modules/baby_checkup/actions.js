import * as types from './mutation_types'

export const bootstrap_checkup_data= async ({commit},id)=>{
    let src=await axios.get(`/api/v1/patient_system/out_patient/obstetrical/baby/checkup/${id}`)
    commit(types.BOOTSTRAP_CHECKUP_DATA,src.data)
}
export const insert_checkup_data= async ({commit,dispatch},data)=>{
    await axios.post(`/api/v1/patient_system/out_patient/obstetrical/baby/checkup`,data)
}
