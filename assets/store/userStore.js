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

			//his.user = JSON.parse(response2.data)
			//emit('user-authenticated', userIri);
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