<template>
  <form @submit.prevent="submitRegister">
    <div
      id="modalRegister"
      class="modal fade"
      role="dialog"
      tabindex="-1"
      aria-labelledby="modalRegister"
      aria-hidden="true"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header d-block border-bottom-0">
            <div class=" d-flex align-items-center justify-content-between">
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
            <div
              v-if="this.userStore.errors.response"
              class="alert alert-danger text-center"
              role="alert"
            >
              <p
                v-if="this.userStore.errors.response"
                class="m-0"
              >
                {{ this.userStore.errors.response.data.message }}
              </p>
            </div>
            <div
              v-if="this.userStore.response && this.userStore.response.data"
              class="alert alert-success text-center"
              role="alert"
            >
              <div
                v-for="message in this.userStore.response.data.message"
                :key="`response-`+message"
              >
                <p
                  class="m-0"
                >
                  {{ message }}
                </p>
              </div>
            </div>
            <h3
              class="modal-title ms-5 container-fluid"
            >
              Register
            </h3>
          </div>
          <div class="modal-body">
            <div class="container-fluid d-flex flex-column">
              <div class="row">
                <div class="ps-5 pe-5">
                  <InputComp
                    :id="`registerEmail`"
                    :type="`email`"
                    :model="this.email"
                    :label="`Email`"
                    :class="`border-color`"
                    :required="true"
                    @input-value="this.email = $event"
                  />
                </div>
              </div>
              <div class="row pt-2">
                <div class=" ps-5 pe-5">
                  <InputComp
                    :id="`registerPhone`"
                    :type="`tel`"
                    :model="this.phone"
                    :label="`Phone`"
                    :class="`border-color`"
                    :required="true"
                    @input-value="this.phone = $event"
                  />
                </div>
              </div>
              <div class="row pt-2">
                <div class="input-group ps-5 pe-5">
                  <div class="form-floating ">
                    <input
                      id="registerPassword"
                      v-model="this.password"
                      class="form-control border-left-50rem border-color"
                      placeholder="Password"
                      aria-describedby="validationPassword"
                      :type="this.showPasswordType"
                      autocomplete="current-password"
                      required
                    >
                    <label
                      for="registerPassword"
                      class="text-black"
                    >
                      <b> Password: </b>
                    </label>
                  </div>
                  <div class="input-group-text pe-3 bg-none border-start-0 border-right-50rem bg-light border-color">
                    <button
                      type="button"
                      class="btn  form-control"
                      @click="this.passwordToggler"
                    >
                      <i
                        :class="{'fa-solid fa-eye': !this.showPassword, 'fa-eye-slash':this.showPassword}"
                      />
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="container-fluid d-flex flex-column justify-content-center align-items-stretch">
              <div class="row">
                <div class="btn-group height-58px ps-5 pe-5">
                  <button
                    v-if="!this.authorize"
                    type="submit"
                    :disabled="this.disableSubmit"
                    class="active rounded-pill btn"
                  >
                    <b> Create account
                      <i
                        v-show="this.userStore.isLoading"
                        class="fa-solid fa-spinner fa-spin"
                      />
                    </b>
                  </button>
                  <button
                    v-else
                    type="button"
                    class="active rounded-pill btn"
                    @click="this.authorizeClick()"
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
import {mapStores, mapWritableState} from "pinia";
import {useUserStore} from "../../../store/userStore";
import InputComp from "../../../Components/InputComp.vue";

export default {
  name: "UserRegisterComp",
  components: {InputComp},
  data() {
    return {
      errors: {
        password:{
          special: false,
          lowerCase: false,
          upperCase: false,
          number: false,
          length: false
        }
      },
      disable : true,
      authorize: false,
      response: null,
      responseMessages: null,
      showPassword: false,
      showPasswordType: `password`
    }
  },
  computed:{
    ...mapStores(useUserStore),
    ...mapWritableState(useUserStore, ['email', "password", 'phone', 'response']),
    disableSubmit() {
      if(this.errors.password.length || this.password.length === 0) {
        return  true;
      }
      if(this.errors.password.special) {
        return  true;
      }
      if(this.errors.password.number) {
        return  true;
      }
      if(this.errors.password.lowerCase) {
        return true;
      }
      if(this.errors.password.upperCase) {
        return  true;
      }
      return false
    }
  },
  watch: {
    password(newVal) {
      this.validatePassword(newVal)
    },
  },

  methods: {
    async authorizeClick() {
        await this.userStore.logIn()
        this.$router.push({path: '/', replace: true});
    },
    async submitRegister(){
      this.userStore.isLoading = true;
      await this.userStore.register();
      if(this.userStore.response && this.userStore.response.data) {
        this.authorize = true
      }
    },
    validatePassword(pw) {
      this.errors.password.upperCase = this.disable = !(/(?=.*[A-Z])/.test(pw));
      this.errors.password.lowerCase = this.disable =  !(/(?=.*[a-z])/.test(pw));
      this.errors.password.number = this.disable = !(/(?=.*\d)/.test(pw));
      this.errors.password.special = this.disable = !(/(?=.*(\W|_))/.test(pw));
      this.errors.password.length = this.disable = pw.length < 6;
    },
    passwordToggler() {
      this.showPassword = !this.showPassword;
      this.showPasswordType = this.showPassword ? 'text' : 'password'
    },
  }
}
</script>

<style scoped>
.border-color {
  border-color: rgba(13,13,213,1)!important
}
.border-left-50rem {
  border-top-left-radius: 50rem !important;
  border-bottom-left-radius: 50rem !important;
}

.border-right-50rem {
  border-top-right-radius: 50rem !important;
  border-bottom-right-radius: 50rem !important;
}

.fs-x-large {
  font-size: x-large;
}
.height-58px {
  height: 58px;
}
</style>