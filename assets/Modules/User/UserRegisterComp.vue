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
              >{{ this.userStore.errors.response.data.message }}</p>
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
                >{{ message }}</p>
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
                <div class="input-group ps-5 pe-5">
                  <div class="form-floating ">
                    <input
                      id="registerEmail"
                      v-model="this.email"
                      class="form-control border-left-50rem border-right-50rem border-color"
                      placeholder="Email address"
                      type="email"
                      aria-describedby="validationEmail"
                      required
                    >
                    <label
                      for="registerEmail"
                      class="text-black"
                    >
                      Email
                    </label>
                    <span
                      v-show="this.errors.email"
                      id="validationEmail"
                      class="text-danger text-center"
                    >
                      {{ this.errors.email }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="row pt-2">
                <div class="input-group ps-5 pe-5">
                  <div class="form-floating ">
                    <input
                      id="registerPhone"
                      v-model="this.phone"
                      class="form-control border-left-50rem border-right-50rem border-color"
                      placeholder="Phone"
                      type="tel"
                      aria-describedby="validationPhone"
                      required
                    >
                    <label
                      for="registerPhone"
                      class="text-black"
                    >
                      Phone
                    </label>
                    <span
                      v-show="this.errors.phone"
                      id="validationPhone"
                      class="text-danger text-center"
                    >
                      {{ this.errors.phone }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="row pt-2">
                <div class="input-group ps-5 pe-5">
                  <div class="form-floating ">
                    <input
                      id="registerPassword"
                      v-model="this.password"
                      class="form-control border-left-50rem border-right-50rem border-color"
                      placeholder="Password"
                      aria-describedby="validationPassword"
                      type="password"
                      required
                    >
                    <label
                      for="registerPassword"
                      class="text-black"
                    >
                      Password
                    </label>
                    <div
                      v-show="this.password.length !== 0"
                      id="validationPassword"
                      class="bg-info-subtle p-1 ps-4 pe-4 mt-2 border-radius"
                    >
                      <p class="m-0"><small>Password must contain the following:</small></p>
                      <p
                        id="letter"
                        class="m-0"
                        :class="{
                          'text-danger' : this.errors.password.lowerCase,
                          'text-success' : !this.errors.password.lowerCase,
                          'text-dark': this.password.length === 0
                        }"
                      >
                        <i
                          :class="{
                            'fa-xmark' : this.errors.password.lowerCase,
                            'fa-check' : !this.errors.password.lowerCase,
                          }"
                          class="  fa-solid "
                        />
                        <small> A <b>lowercase</b> letter </small>
                      </p>
                      <p
                        id="capital"
                        class="m-0"
                        :class="{
                          'text-danger' : this.errors.password.upperCase,
                          'text-success' : !this.errors.password.upperCase,
                          'text-dark': this.password.length === 0
                        }"
                      >
                        <i
                          :class="{
                            'fa-xmark' : this.errors.password.upperCase,
                            'fa-check' : !this.errors.password.upperCase,
                          }"
                          class="  fa-solid "
                        />
                        <small> A <b>capital (uppercase)</b> letter </small>
                      </p>
                      <p
                        id="number"
                        class="m-0"
                        :class="{
                          'text-danger' : this.errors.password.number,
                          'text-success' : !this.errors.password.number,
                          'text-dark': this.password.length === 0
                        }"
                      >
                        <i
                          :class="{
                            'fa-xmark' : this.errors.password.number,
                            'fa-check' : !this.errors.password.number,
                          }"
                          class="  fa-solid "
                        />
                        <small> A <b>number</b> </small>
                      </p>
                      <p
                        id="special"
                        class="m-0"
                        :class="{
                          'text-danger' : this.errors.password.special,
                          'text-success' : !this.errors.password.special,
                          'text-dark': this.password.length === 0
                        }"
                      >
                        <i
                          :class="{
                            'fa-xmark' : this.errors.password.special,
                            'fa-check' : !this.errors.password.special,
                          }"
                          class="  fa-solid "
                        />
                        <small> A <b> special character</b> </small>
                      </p>
                      <p
                        id="length"
                        class="m-0"
                        :class="{
                          'text-danger' : this.errors.password.length,
                          'text-success' : !this.errors.password.length,
                          'text-dark': this.password.length === 0
                        }"
                      >
                        <i
                          :class="{
                            'fa-xmark' : this.errors.password.length,
                            'fa-check' : !this.errors.password.length,
                          }"
                          class="  fa-solid "
                        />
                        <small> Minimum <b>6 characters</b> </small>
                      </p>
                    </div>
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
import {useUserStore} from "../../store/userStore";

export default {
  name: "UserRegisterComp",
  data() {
    return {
      errors: {
        email: false,
        phone:false,
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
      responseMessages: null
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
      if(this.errors.email || this.email.length === 0) {
        return true;
      }
      if(this.errors.phone || this.phone.length === 0) {
       return true;
      }
      return false
    }
  },
  watch: {
    email(newVal) {
      this.validateEmail(newVal)
    },
    phone(newVal) {
      this.validatePhone(newVal)
    },
    password(newVal) {
      this.validatePassword(newVal)
    },
    response(newVal) {
    }
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
    validatePhone(newVal) {
      this.errors.phone = newVal.length === 0 ? 'Please fill in phone number':false
    },
    validateEmail() {
      if (this.email && !(/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(this.email))) {
        this.errors.email = 'Please enter a valid email address';
      } else {
        this.errors.email = false;
      }
    },
    validatePassword(pw) {
      this.errors.password.upperCase = !(/(?=.*[A-Z])/.test(pw));
      this.errors.password.lowerCase = !(/(?=.*[a-z])/.test(pw));
      this.errors.password.number = !(/(?=.*\d)/.test(pw));
      this.errors.password.special = !(/(?=.*(\W|_))/.test(pw));
      this.errors.password.length = pw.length < 6;
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