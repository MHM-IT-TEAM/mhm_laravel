import * as actions from './actions'
import * as getters from './getters'
import mutations from "./mutations";
const initialState={
    last_code:'',
    out_list:{
        pending:[],
        delivered:[],
    },
    loading:false,
    pagination:{
        pending:{
            from:null,
            to:null,
            current_page: null,
            limit: null,
            per_page:null,
            total: null,
        },
        delivered:{
            from:null,
            to:null,
            current_page: null,
            limit: null,
            per_page:null,
            total: null,
        }
    }
}
export default{
    namespaced:true,
    state:initialState,
    getters,
    actions,
    mutations
}
