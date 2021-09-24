import * as types from './mutation-types';
import * as itemTypes from './modules/item/mutation_types'
import * as departmentTypes from './modules/department/mutation_types'


export default {
    async bootstrap_app({commit,dispatch}){
        commit(types.UPDATE_APP_LOADING_STATUS,true)
        await axios.get('/api/v1/inventory_system/app/bootstrap').then(response=>{
            commit('item/'+itemTypes.BOOTSTRAP_ITEM_UNIT,response.data.item_units)
            commit('item/'+itemTypes.BOOTSTRAP_ITEM_TYPE,response.data.item_type)
            commit('department/'+departmentTypes.BOOTSTRAP_DEPARTMENT,response.data.department)
            commit('item/'+itemTypes.BOOTSTRAP_LOCATION,response.data.location)
            commit('item/'+itemTypes.BOOTSTRAP_ITEM_ADMNISTRATION,response.data.item_administration)
        })
        commit(types.UPDATE_APP_LOADING_STATUS,false)
    }
}
