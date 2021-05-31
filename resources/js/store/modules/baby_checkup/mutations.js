import * as types from './mutation_types'
export default{
    [types.BOOTSTRAP_CHECKUP_DATA](state,data){
        state.checkup_data=data
    },
    [types.APPEND_CHECKUP_DATA](state,data){
        state.checkup_data.unshift(data)
    }
}
