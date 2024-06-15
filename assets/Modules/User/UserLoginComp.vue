<template>
  <form @submit.prevent="submitLogin">
    <div
      id="loginModal"
      role="dialog"
      class="modal fade"
      tabindex="-1"
      aria-labelledby="loginModalLabel"
      aria-hidden="true"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
    >
      <div
        class="modal-dialog modal-dialog-centered"
        role="document"
      >
        <div class="modal-content border-radius">
          <div class="modal-header justify-content-between border-bottom-0">
            <h3
              id="loginModalLabel"
              class="modal-title"
            >
              Sign in
            </h3>
            <button
              type="button"
              class="btn"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="this.toggleCloseModal"
            >
              <i class="icon-color fs-x-large fa-solid fa-lg fa-xmark" />
            </button>
          </div>
          <div class="modal-body">
            <div class="d-flex flex-column">
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
                      {{ this.errors.email }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="row pt-4">
                <div class="btn-group height-58px ps-5 pe-5">
                  <button
                    type="button"
                    class="active rounded-pill btn"
                    data-bs-target="#modalPassword"
                    data-bs-toggle="modal"
                    data-bs-dismiss="modal"

                  >
                    <b> Continue </b>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer" />
        </div>
      </div>
    </div>

    <div
      id="modalPassword"
      class="modal fade"
      role="dialog"
      aria-hidden="false"
      tabindex="-1"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header d-block border-bottom-0">
            <div class="d-flex align-items-center justify-content-between">
              <button
                type="button"
                class="btn"
                data-bs-target="#loginModal"
                data-bs-toggle="modal"
              >
                <i class="icon-color  fa-solid fs-x-large  fa-arrow-left" />
              </button>

              <button
                type="button"
                class="btn"
                data-bs-dismiss="modal"
              >
                <i class="icon-color  fa-solid fs-x-large fa-xmark" />
              </button>
            </div>
            <h3
              class="modal-title"
            >
              Enter password
            </h3>
            <span class="text-black"> For account <b> {{ this.email }} </b></span>
          </div>
          <div class="modal-body">
            <div class="d-flex flex-column">
              <div class="row">
                <div class="input-group ps-5 pe-5">
                  <div class="form-floating ">
                    <input
                      id="floatingLoginPassword"
                      v-model="this.password"
                      class="form-control border-left-50rem border-color border-end-0"
                      :type="this.showPasswordType"
                      placeholder="Email address"
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
          </div>
          <div class="modal-footer d-block">
            <div class="d-flex flex-column justify-content-center align-items-stretch">
              <div class="row">
                <div class="btn-group height-58px ps-5 pe-5">
                  <button
                    type="submit"
                    class="active rounded-pill btn"
                  >
                    <b> Sign in </b>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import {mapActions, mapStores, mapWritableState} from "pinia";
import {useUserStore} from "../../store/userStore";

export default {
  name: "UserLoginComp",
  data(){
    return {
      errors: {
        email:''
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
  methods:{
    ...mapActions(useUserStore,['logIn']),

    async submitLogin() {
      await this.userStore.logIn()
      this.$router.push({path: '/', replace: true});
      document.querySelector('[data-bs-target="#loginModal"]').modal('dispose');
    },

    toggleCloseModal() {
      this.userStore.$reset();
    },

    passwordToggler() {
      this.showPassword = !this.showPassword;
      this.showPasswordType = this.showPassword? 'text' : 'password'
    },

    validateEmail() {
      if (this.email && !(/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(this.email))) {
        this.errors.email = 'Please enter a valid email address';
        return false;
      } else {
        this.errors.email = '';
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