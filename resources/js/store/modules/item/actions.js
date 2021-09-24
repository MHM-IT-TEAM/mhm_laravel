import * as types from './mutation_types'
//get count per types
export const fetch_count_per_type= async({commit})=>{
    await axios.get('/api/v1/inventory_system/item/count_per_type').then(response=>commit(types.SET_COUNT_PER_TYPE,response.data))
}
//fetch all item units
export const fetch_item_units= async({commit})=>{
    await axios.get('/api/v1/inventory_system/item_unit')
        .then(response=>commit(types.BOOTSTRAP_ITEM_UNIT,response.data))
}
//fetch all item types
export const fetch_item_type= async ({commit})=>{
    await axios.get('/api/v1/inventory_system/item_type')
        .then(response=>commit(types.BOOTSTRAP_ITEM_TYPE,response.data))
}
// fetch all item administrations
export const fetch_item_administration= async ({commit})=>{
    await axios.get('/api/v1/inventory_system/item_administration')
        .then(response=>commit(types.BOOTSTRAP_ITEM_ADMNISTRATION,response.data))
}
//fetch all locations list
export const fetch_location= async ({commit})=>{
    await axios.get('/api/v1/inventory_system/location')
        .then(response=>commit(types.BOOTSTRAP_LOCATION,response.data))
}
//fetch list of items
export const  fetch_items_list= async ({commit},page)=>{
    let fetch=await axios.get("/api/v1/inventory_system/item?page=" + page)
     commit(types.BOOTSTRAP_ITEM_LIST,fetch.data)
}
