<template>
  <div class="container-fluid">
    <div class="row">
      <div class="input-group ps-5 pe-5">
        <div class="form-floating ">
          <input
            id="floatingLoginEmail"
            v-model="this.email"
            class="form-control border border-right-50rem border-left-50rem border-color"
            :class="this.validateEmail() ? '' : 'is-invalid'"
            type="email"
            placeholder="Email address"
            aria-describedby="validationEmail"
            autocomplete="email"
          >
          <label
            for="floatingLoginEmail"
            class="text-black"
          >
            Email address
          </label>
          <span
            id="validationEmail"
            class="invalid-feedback text-center"
          >
            {{ this.errors.email.msg }}
          </span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="input-group ps-5 pe-5">
        <div class="form-floating ">
          <input
            id="floatingLoginPassword"
            v-model="this.password"
            class="form-control border-left-50rem border-color border-end-0"
            :type="this.showPasswordType"
            autocomplete="current-password"
            placeholder="Password"
            aria-describedby="ValidationPassword"
          >
          <label
            for="floatingLoginPassword"
            class="text-black"
          >
            Password
          </label>
        </div>
        <div class="input-group-text pe-3  bg-none border-color border-right-50rem">
          <button
            type="button"
            class="btn icon-color form-control"
            @click="this.passwordToggler"
          >
            <i
              class="fa fa-eye-slash"
              :class="this.showPassword ? 'fa-eye' : 'fa-eye-slash'"
            />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {mapActions, mapStores, mapWritableState} from "pinia";
import {useUserStore} from "../../../store/userStore";

export default {
  name: "AdminUserLoginComp",
  data(){
    return {
      errors: {
        email:'',
        credentials: ''
      },
      showPassword: false,
      showPasswordType: 'password'
    }
  },
  computed: {
    ...mapStores(useUserStore),
    ...mapWritableState(useUserStore, ['email', "password"]),
  },
  mounted() {
  },
  methods: {
    ...mapActions(useUserStore, ['logIn']),

    async submitLogin() {
      await this.userStore.logIn();
      this.$router.push({path: '/', replace: true});
      document.querySelector('[data-bs-target="#loginModal"]').modal('dispose');
    },

    toggleCloseModal() {
      this.userStore.$reset();
    },

    passwordToggler() {
      this.showPassword = !this.showPassword;
      this.showPasswordType = this.showPassword ? 'text' : 'password'
    },

    validateEmail() {
      if (this.email && !(/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(this.email))) {
        this.errors.email.msg = 'Please enter a valid email address';
        return false;
      } else {
        this.errors.email = {};
        return true;
      }
    }
  }
}
</script>



<style scoped>
.border-color {
  border-color: rgba(13,13,213,1)!important
}

.height-58px {
  height: 58px;
}

.border-left-50rem {
  border-top-left-radius: 50rem !important;
  border-bottom-left-radius: 50rem !important;
}

.border-right-50rem {
  border-top-right-radius: 50rem !important;
  border-bottom-right-radius: 50rem !important;
}

.bg-none {
  background-color: unset;
}

.fs-x-large {
  font-size: x-large;
}

button:focus {
  border: none;
  outline: none;
}
</style>