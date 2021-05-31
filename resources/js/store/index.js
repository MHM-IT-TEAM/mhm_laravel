import Vue from 'vue'
import Vuex from 'vuex'

import * as getters from './getters'
import mutations from './mutations'
import actions from './actions'
/** modules**/
import patient from "./modules/patient";
import consultation from "./modules/consultation";
import baby_checkup from "./modules/baby_checkup"

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
        baby_checkup
    }
})
