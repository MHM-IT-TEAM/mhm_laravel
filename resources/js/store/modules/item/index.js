import * as actions from './actions'
import * as getters from './getters'
import mutations from "./mutations";
const initialState={
    items:[],
    units:[],
    types:[],
    administrations:[],
    locations:[],
    count_per_type:null
}
export default {
    namespaced:true,
    state:initialState,
    getters:getters,
    actions:actions,
    mutations:mutations
}
