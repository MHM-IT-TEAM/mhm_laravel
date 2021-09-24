import * as types from './mutation_types'
export default {
    [types.BOOTSTRAP_OUT_LIST](state,src){
        state.out_list.pending=src.pending.data
        populate(src.pending,state.pagination.pending)
        populate(src.delivered,state.pagination.delivered)
        state.out_list.delivered=src.delivered.data
    },
    [types.BOOTSTRAP_OUT_PENDING_LIST](state,src){
        state.out_list.pending=src.data
        state.pagination.pending={
            from:src.from,
            to:src.to,
            current_page: src.current_page,
            per_page:src.per_page,
            total: src.total,
        }
    },
    [types.BOOTSTRAP_OUT_DELIVERED_LIST](state,src){
        state.out_list.delivered=src.data
        state.pagination.delivered={
            from:src.from,
            to:src.to,
            current_page: src.current_page,
            per_page:src.per_page,
            total: src.total,
        }
    },
    [types.INSERT_NEW_PENDING_DATA](state,src){
        populate(src.pending,state.pagination.pending)
        state.out_list.pending=src.pending.data
    },
    [types.INSERT_NEW_DELIVERED_DATA](state,src){
        state.out_list.delivered=[]
        src.data.forEach(item=>{item.status==2?state.out_list.delivered.push(item):''})
        state.pagination.delivered={
            from:src.from,
            to:src.to,
            current_page: src.current_page,
            per_page:src.per_page,
            total: src.total,
        }
    },
    [types.SET_LOADING](state){
        state.loading=true
    },
    [types.UNSET_LOADING](state){
        state.loading=false
    },
    [types.SET_LAST_CODE](state,src){
        state.last_code=src
    },
    [types.DELETE_ORDER](state,id){
        let index= state.out_list.pending.findIndex(list=>list.id===id)
        if(index!==-1)state.out_list.pending.splice(index,1)
        state.pagination.pending.total--

    }

}
function populate(src,target){
    for(let key in src){
        if (target.hasOwnProperty(key)) target[key]=src[key]
    }
}
