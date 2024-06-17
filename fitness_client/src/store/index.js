import { createStore } from 'vuex'
import { getCookie } from '@/utils/cookie'
import axios from 'axios';

export default createStore({
	state: {
		isAuth: false,
		type: 'student',
		userInfor: {},
		toast: {
			title: 'DevFast Fitness',
			content: '',
			show: false,
			type: 'success',
			expires: 3500
		},
		notifications: [],
	},
	getters: {
		getIsAuth: state => state.isAuth,
		getType: state => state.type,
		getUserInfor: state => state.userInfor,
		getToast: state => state.toast,
		getNotifications: state => state.notifications,
	},
	mutations: {
		async handleAuthenticated (state) {
			const authToken = getCookie('authToken'); // Get the authentication token from the cookie
		},

		setIsAuth (state) {
			state.isAuth = true;
		},

		async fetchUserProfile (state) {
			const user_Id = getCookie('c_user');
			
			if (user_Id) {
				try {
					const response = await axios.get(`http://127.0.0.1:8000/api/user/${user_Id}`);
					const notification = await axios.get(`user/notifications/get/${user_Id}`);
					state.userInfor = response.data.data;
					state.notifications = notification.data;
					state.isAuth = true;
				} catch (err) {
					console.log(err);
				}
			}
		},

		setToast (state, toast) {
			state.toast = {...state.toast, ...toast};

			if (state.toast.expires > 0) {
				setTimeout(() => {
					state.toast.show = false;
				}, state.toast.expires);
			}
		},

		hideToast (state) {
			state.toast.show = false;
		}
	},
	actions: {
		handleAuthenticated ({commit}) {
			commit('handleAuthenticated');
		},

		setIsAuth ({commit}) {
			commit('setIsAuth');
		},

		fetchUserProfile ({commit}) {
			commit('fetchUserProfile');
		},

		setToast ({commit}, toast) {
			commit('setToast', toast);
		},

		hideToast ({commit}) {
			commit('hideToast');
		},
	}
})
