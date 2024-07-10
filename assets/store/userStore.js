import {defineStore} from "pinia";
import axios from "axios";

axios.defaults.withCredentials = true;

export const useUserStore = defineStore('user', {
	state: () => {
		return {
			isAuthed: false,
			email: '',
			password:'',
			phone:'',
			id: '',
			token: null,
			verification: '',
			user: {},
			currencyID: null,
			isLoading: false,
			errors: {},
			response: {}
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
						this.currencyID = this.user.currency.IsoCode

					})
					.catch((e)=>{
						//this.errors = e
						this.loading = false;
					})
		},
		async logIn() {
			this.loading = true;
			const response = await axios.post('/user/login',
					{
						username: this.email,
						password: this.password
					},
					{
						headers: {
							"Content-Type":'application/json'
						}
					})
					.catch((e)=> {
						//this.errors = e;
					});
			if(response.data.token){
				this.token = response.data.token;
				localStorage.setItem('token', this.token);
			}

			if(!this.token){
				return;
			}
			await this.isAuthorized();
			window.location.reload();
		},

		async logout() {
			this.loading = true;
			await axios.post('/user/logout');
			localStorage.removeItem('token');

			this.$reset();
			window.history.pushState({},"",'/')
			window.location.reload();

		},

		async updateUserInfo() {
			const response = await axios.post('/user/update_info',
					{user: this.user},
					{
						headers: {
							"Content-Type":'application/json',
							Authorization: `Bearer ${this.token}`
						},
			})
			.catch((e)=> {
				//this.errors = e;
			});
			if(response.status === 200) {
				this.isLoading = false;
				return response.data.message;
			}
		},

		async register() {
			this.errors = {};
			const response = await axios.post('/user/register',
					{
						user: {
							email: this.email,
							password: this.password,
							phone: this.phone
						}
					}
					)
					.catch((e)=> {
						this.errors = e;
					});
			if(response && response.status === 201) {
				this.isLoading = false;
				this.response = response;
			}

		},

		async verify() {
			this.errors = {};
			this.isLoading= true;
			const response = await axios.post('/user/verify',
					{
						code: this.verification

					},
					{
						headers: {
							"Content-Type":'application/json',
							Authorization: `Bearer ${this.token}`
						},
					}
			)
					.catch((e)=> {
						//this.errors = e;
					});
			if(response && response.status === 200) {
				this.isLoading = false;
				this.response = response;
			}

		},
		async resendVerificationCode (){
			const response = await axios.post('/user/verify_resend_code',{},
					{
						headers: {
							"Content-Type":'application/json',
							Authorization: `Bearer ${this.token}`
						},
					}
			)
					.catch((e)=> {
						//this.errors = e;
					});
			if(response && response.status === 200) {
				this.response = response;
			}
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