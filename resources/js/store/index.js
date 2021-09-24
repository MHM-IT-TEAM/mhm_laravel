import Vue from 'vue'
import Vuex from 'vuex'

import * as getters from './getters'
import mutations from './mutations'
import actions from './actions'
/** modules**/
import patient from "./modules/patient";
import consultation from "./modules/consultation";
import baby_checkup from "./modules/baby_checkup"
import auth from "./modules/auth"
import department from "./modules/department"
import in_order from "./modules/in_order"
import item from "./modules/item"
import low_stock from "./modules/low_stock"
import out_order from "./modules/out_order"

Vue.use(Vuex)
const initialState = {
    isAppLoaded: false
}
export default new Vuex.Store({
    state: initialState,
    getters,
    mutations,
    actions,
    modules:{
        patient,
        consultation,
        baby_checkup,
        auth,
        department,
        item,
        low_stock,
        in_order,
        out_order

    }
})
