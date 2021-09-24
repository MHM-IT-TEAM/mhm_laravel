import * as actions from './actions'
import mutations from './mutations'
import * as getters from './getters'
const initialState={
    user:null,
    authenticated:false,
    token:''
}
export default{
    namespaced:true,
    state:initialState,
    mutations,
    getters,
    actions
}
