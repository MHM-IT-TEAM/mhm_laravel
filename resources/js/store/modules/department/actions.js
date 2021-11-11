import * as types from './mutation_types'
export const fetch_departments=async({commit})=>{
    await axios.get('/api/v1/inventory_system/department').then(response=>commit(types.BOOTSTRAP_DEPARTMENT,response.data))
}
export const fetch_orderers= async({commit})=>{
    await axios.get('/api/v1/inventory_system/orderers').then(response=>commit(types.BOOTSTRAP_ORDERERS,response.data))
}
