import { createStore } from 'vuex'
import { getCookie } from '@/utils/cookie'

export default createStore({
	state: {
		authCheck: false,
	},
	getters: {
		getIsAuth: state => state.authCheck,

	},
	mutations: {
		async handleAuthenticated (state) {
			const adminToken = getCookie('adminToken'); // Get the authentication token from the cookie

			if (adminToken) {
				try {
					const response = await axios.get('http://127.0.0.1:8000/api/admin/verify_token', {
						headers: {
							'Authorization': `Bearer ${adminToken}`
						}
					});
			
					if (!response.data.error) {
						state.authCheck = true;
					}
				} catch (error) {
					console.error(error.response.data.error); // In ra lỗi từ phía server
				}
			}
		},
		setIsAuth (state) {
			state.authCheck = true;
		},
	},
	actions: {
		setIsAuth ({commit}) {
			commit('setIsAuth');
		},
		handleAuthenticated ({commit}) {
			commit('handleAuthenticated');
		},
	},
	modules: {
	}
})
