import mutations from './mutations'
import * as actions from './actions'
import * as getters from './getters'
const initialState={
    checkup_data:[]
}
export default{
    namespaced: true,
    state:initialState,
    actions:actions,
    getters:getters,
    mutations:mutations
}
