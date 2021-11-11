import * as types from './mutation_types'
export default{
    [types.BOOTSTRAP_DEPARTMENT](state,src){
        return state.departments=src
    },
    [types.BOOTSTRAP_ORDERERS](state,src){
        return state.orderers=src
    }
}
