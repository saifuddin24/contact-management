import { createStore } from 'vuex'
import axios, {get_user, isLoggedIn, set_token, set_user} from "./axios";

export default createStore({
  state: {
    isLoggedIn: isLoggedIn( ),
    user: get_user( ),
  },
  mutations: {
    setIsLoggedIn( state, userData ){
      state.isLoggedIn = true;
      state.user = userData.user;

      set_token ( userData.token );
      set_user( userData.user );

      console.log( userData)
    }
  },
  actions: {
    async login({commit, state}, params ){
      params = params || {};
      return await axios().post( 'user/login', params.data )
          .then( ( { data } ) => {
            commit( 'setIsLoggedIn', data )
             if(typeof params.success == 'function') {
               params.success(data)
             }
          })
          .catch( ({ response }) => {
             if(typeof params.error == 'function') {
               params.error( response )
             }
          })
    }
  },
  modules: {
  }
})
