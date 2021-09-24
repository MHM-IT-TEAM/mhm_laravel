import * as types from './mutation-types'

export default{
    [types.BOOTSTRAP_LIST](state,data){
        state.medicines=[]
        state.consumables=[]
        state.equipments=[]
        data.forEach(item=>{
            if (item.type===1) state.medicines.push(item)
            else if (item.type===2) state.consumables.push(item)
            else state.equipments.push(item)
        })
    },
}
