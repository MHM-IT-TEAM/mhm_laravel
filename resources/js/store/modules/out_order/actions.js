import * as types from './mutation_types'
export const fetch_last_code= async ({commit})=>{
    await axios.get('/api/v1/inventory_system/out/lastCode').then(resp=>commit(types.SET_LAST_CODE,resp.data))
}
export const fetch_out_order= async({commit})=>{
    await axios.get('/api/v1/inventory_system/out').then(response=>commit(types.BOOTSTRAP_OUT_LIST,response.data))
}
export const fetch_pending_order= async({commit},page)=>{
    commit(types.SET_LOADING)
    await axios.get('/api/v1/inventory_system/out/pending?page='+page)
        .then(response=>{commit(types.BOOTSTRAP_OUT_PENDING_LIST,response.data)})
        .then(commit(types.UNSET_LOADING))
}
export const fetch_delivered_order= async({commit},page)=>{
    commit(types.SET_LOADING)
    await axios.get('/api/v1/inventory_system/out/delivered?page='+page)
        .then(response=>{commit(types.BOOTSTRAP_OUT_DELIVERED_LIST,response.data)})
        .then(commit(types.UNSET_LOADING))
}
export const new_out_order= async({commit,dispatch},data)=>{
    try {
        await axios.post('/api/v1/inventory_system/out',data)
            .then(response=>commit(types.INSERT_NEW_PENDING_DATA,response.data))
            .then(await dispatch('fetch_last_code'))
    }
    catch(e){
        console.log('there has been a problem'+e)
    }
}
export const edit_out_order= async({commit,dispatch},data)=>{
    await axios.put(`/api/v1/inventory_system/out/${data.id}`,data)
        .then(response=>commit(types.INSERT_NEW_DELIVERED_DATA,response.data))
        .then(commit(types.DELETE_ORDER,data.id))
}
export const delete_out_order= async({commit,dispatch},id)=>{
    await axios.delete('/api/v1/inventory_system/out/'+id).then(commit(types.DELETE_ORDER,id))
}
