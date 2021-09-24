import * as types from './mutation_types'


export default{
    [types.BOOTSTRAP_ITEM_LIST] (state,src){
        return state.items.push(src.data)
    },
    [types.BOOTSTRAP_ITEM_UNIT](state,src){
        return state.units=src
    },
    [types.BOOTSTRAP_ITEM_TYPE](state,src){
        return state.types= src
    },
    [types.BOOTSTRAP_ITEM_ADMNISTRATION](state,src){
        return state.administrations=src
    },
    [types.BOOTSTRAP_LOCATION](state,src){
        return state.locations=src
    },
    [types.SET_COUNT_PER_TYPE](state,src){
        return state.count_per_type=src
    }
}
