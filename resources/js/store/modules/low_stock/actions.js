import * as types from './mutation-types'

export const fetch_low_stock_list= async({commit})=>{
    await axios.get('/api/v1/inventory_system/low_stock').then(response=>{
       commit(types.BOOTSTRAP_LIST, response.data.data)
    })
}

