import * as types from './mutation-types'
export default{
    [types.SET_LOGGED_IN_USER](state,data){
        state.user=data
        state.authenticated=true
    },
    [types.SET_USER_TOKEN](state,token){
        state.token=token
    },
    [types.UNSET_USER](state){
        state.user={}
        state.authenticated=false
    },
    [types.UNSET_USER_TOKEN](state){
        state.token=''
    }
}
