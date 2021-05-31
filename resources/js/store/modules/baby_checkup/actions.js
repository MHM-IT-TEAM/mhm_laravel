import * as types from './mutation_types'

export const bootstrap_checkup_data= async ({commit},id)=>{
    let src=await axios.get(`/api/obstetrics/baby_checkup/${id}`)
    commit(types.BOOTSTRAP_CHECKUP_DATA,src.data)
}
export const insert_checkup_data= async ({commit,dispatch},data)=>{
    await axios.post('/api/obstetrics/baby_checkup',data)
}
