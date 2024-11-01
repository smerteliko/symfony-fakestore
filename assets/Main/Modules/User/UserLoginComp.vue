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
            <div class="container-fluid">
              <div class="row">
                <div class="ps-5 pe-5">
                  <InputComp
                    :id="`floatingLoginEmail`"
                    :class="`border-color`"
                    :type="`email`"
                    :label="`Email address`"
                    :model="this.email"
                    @input-value="this.email = $event"
                  />
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
                    :disabled="this.errors.email.msg"
                  >
                    <b> Continue </b>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <div class="container-fluid">
              <div class="row pt-4">
                <div class="btn-group height-58px ps-5 pe-5">
                  <button
                    type="button"
                    class="bg-body-secondary rounded-pill btn"
                    data-bs-target="#modalRegister"
                    data-bs-toggle="modal"
                    data-bs-dismiss="modal"
                  >
                    <b> Create an account </b>
                  </button>
                </div>
              </div>
            </div>
          </div>
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
            <div class="container-fluid d-flex flex-column">
              <div class="row">
                <div class=" ps-5 pe-5">
                  <InputComp
                    :id="`floatingLoginPassword`"
                    :class="` border-color border-end-0  border-right-0`"
                    :type="`password`"
                    :label="`Password`"
                    :model="this.password"
                    @input-value="this.password = $event"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer d-block">
            <div class="container-fluid d-flex flex-column justify-content-center align-items-stretch">
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
  <UserRegisterComp />
</template>

<script>
import {mapActions, mapStores, mapWritableState} from "pinia";
import {useUserStore} from "../../../store/userStore";
import UserRegisterComp from "./UserRegisterComp.vue";
import InputComp from "../../../Components/InputComp.vue";

export default {
  name: "UserLoginComp",
  components:{
    InputComp,
    UserRegisterComp
  },
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
  methods:{
    ...mapActions(useUserStore,['logIn']),

    async submitLogin() {
      await this.userStore.logIn();
      this.$router.push({path: '/', replace: true});
      document.querySelector('[data-bs-target="#loginModal"]').modal('dispose');
    },

    toggleCloseModal() {
      this.userStore.$reset();
    },

  }
}
</script>

<style scoped>

.height-58px {
  height: 58px;
}


.bg-none {
  background-color: unset;
}

.fs-x-large {
  font-size: x-large;
}

</style>