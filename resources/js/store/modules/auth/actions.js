import * as types from './mutation-types'
export const login= async({commit},data)=>{
    await axios.post('/login',data).then(response=>{
        commit(types.SET_LOGGED_IN_USER,response.data.user)
        commit(types.SET_USER_TOKEN,response.data.token)
    })
}
export const logout= async({commit})=>{
    await axios.get('/logout')
    commit(types.UNSET_USER)
    commit(types.UNSET_USER_TOKEN)
}
