import * as actions from './actions'
import * as getters from './getters'
import mutations from "./mutations";
const initialState={
    departments:[],
    orderers:[]
}
export default {
    namespaced:true,
    state:initialState,
    getters:getters,
    actions:actions,
    mutations:mutations
}
