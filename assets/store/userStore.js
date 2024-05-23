import {defineStore} from "pinia";
import axios from "axios";

axios.defaults.withCredentials = true;

export const useUserStore = defineStore('user', {
	state: () => {
		return {
			isAuthed: false,
			email: '',
			password:'',
			id: '',
			token: null,
			isLoading: false,
			user: {},
			errors: {},
		}
	},
	actions: {
		async isAuthorized() {
			if(!this.token) {
				this.token = localStorage.getItem('token')
			}
			await axios.get('/user/is_authorized', { headers: { Authorization: `Bearer ${this.token}` } })
					.then((response)=>{
						this.isAuthed = response.data.is_authenticated;
						this.user = JSON.parse(response.data.user);
						this.email = this.user.email;
						this.id = this.user.id
						this.loading = false;

					})
					.catch((e)=>{
						this.errors = e
						this.loading = false;
					})
		},
		async logIn() {
			this.loading = true;
			const response = await axios.post('/user/login',
					{
						username: this.email,
						password: this.password
					})
					.catch((e)=> {
						this.errors = e;
					});

			if(response.data.token){
				this.token = response.data.token;
				localStorage.setItem('token', this.token);
			}

			if(!this.token){
				return;
			}
			let response2 = await this.isAuthorized();
			window.location.reload();
		},

		async logout() {
			this.loading = true;
			await axios.post('/user/logout');
			localStorage.removeItem('token');

			this.$reset();
			window.history.pushState({},"",'/')
			window.location.reload();

		}
	},
	getters: {
		getAuthStatus() {
			return this.isAuthed
		},
		getToken() {
			return this.token
		},
		getUser() {
			return this.user
		}
	}
})