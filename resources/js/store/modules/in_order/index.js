import * as actions from './actions'
import * as getters from './getters'
import mutations from "./mutations";
const initialState= {
  pending:[],
  delivered:[],
}
export default {
    namespaced:true,
    state:initialState,
    getters:getters,
    actions:actions,
    mutations:mutations
}
