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
			token: null,
			verification: '',
			currencyID: null,
			isLoading: false,
			errors: {},
			response: {},
			isAdmin: false,
			// user data skeleton
			user: {
				email: '',
				phone: '',
				isVerified: false,
				FirstName: '',
				LastName: '',
				Language: '',
				enabled: true,
				userImages:{},
				userCarts:{},
				Currency:{},
			},
		}
	},
	actions: {
		async isAuthorized() {
			if(!this.token) {
				this.token = localStorage.getItem('token')
			}

			await axios.get('/user/is_authorized',{
				headers: { Authorization: `Bearer ${this.token}`}
			}).then((response)=>{
				this.user = JSON.parse(response.data.user);
				this.isAuthed = response.data.is_authenticated;
				this.email = this.user.email;
				this.id = this.user.id
				this.loading = false;
				this.currencyID = this.user.currency.IsoCode
				this.loading = false;

			}).catch((e)=>{
				this.errors = e;
				this.loading = false;
			});
		},

		async logIn() {
			this.loading = true;
			 await axios.post('/user/login',
					{
						username: this.email,
						password: this.password
					},
					{
						headers: {
							"Content-Type":'application/json'
						}
					})
					.then((response)=>{
						this.token = response.data.token;
						localStorage.setItem('token', this.token);
						window.location.reload();
					})
					.catch((e)=> {
						localStorage.removeItem('token');
						this.loading = false;
						this.errors = e;
					});
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
			this.errors = {};
			this.isLoading = true;
			await axios.post('/user/update_info',
					this.user,
					{
						headers: {
							"Content-Type":'application/json',
							Authorization: `Bearer ${this.token}`
						},
			}).then((response)=>{
				this.response = response;
				this.isLoading = false;
			}).catch((e)=> {
				this.errors = e;
				this.isLoading = false;
			});
		},

		async register() {
			this.errors = {};
			this.loading = true;
			await axios.post('/user/register', {
				email: this.email,
				password: this.password,
				phone: this.phone
			}).then((response)=>{
				this.response = response;
				this.loading = false;

			}).catch((e)=> {
				this.errors = e;
				this.loading = false;
			});

		},

		async verify() {
			this.errors = {};
			this.isLoading= true;
			await axios.post('/user/verify',
					{
						code: this.verification
					},
					{
						headers: {
							"Content-Type":'application/json',
							Authorization: `Bearer ${this.token}`
						},
					}
			).then((response)=>{
				this.response = response;
				this.isLoading = false;
			}).catch((e)=> {
				this.errors = e;
			});
		},

		async resendVerificationCode (){
			this.isLoading = true;
			await axios.post('/user/verify_resend_code',{},
				{
					headers: {
						"Content-Type":'application/json',
						Authorization: `Bearer ${this.token}`
					}
				}
			).then((response)=>{
				this.response = response;
				this.isLoading = false;
			}).catch((e)=> {
				this.errors = e;
				this.isLoading = false;
			});
		},
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
		},
		checkAdmin() {
			if(!this.user.roles) {
				return false;
			}

			return this.user.roles.includes('ROLE_SUPER_ADMIN') || false;

		}
	}
})