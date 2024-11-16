<template>
  <div class="container container-color rounded-pill d-flex flex-column">
    <div class="row">
      <h1> Account verification </h1>
    </div>
    <div class="row mt-3">
      <h5 class="text-center">
        To your email <b>{{ this.userStore.email }}</b> were sent the verification code.
      </h5>
      <h6 class="text-center">
        Please enter code bellow:
      </h6>
    </div>
    <div class="row justify-content-center">
      <div class="col-4 needs-validation">
        <InputComp
          :id="`userProfileVerificationCode`"
          :model="this.verification"
          :label="`Verification code:`"
          :type="`text`"
          :class="this.codeError ? 'is-invalid':'is-valid'"
          aria-describedby="validationCode"
          @input-value="this.verification = $event"
        />
        <span
          v-show="this.codeError"
          id="validationCode"
          class="text-danger text-center"
        >
          Verification code is incorrect
        </span>
      </div>
    </div>
    <div class="row mt-3 justify-content-center">
      <div class="col-4 btn-group">
        <button
          class="btn btn-success btn rounded-container rounded-pill"
          :disabled="this.codeError || this.verification.length === 0"
          @click="this.userStore.verify()"
        >
          <b>
            Verify
            <i
              v-show="this.userStore.isLoading"
              class="fa-solid fa-spinner fa-spin"
            />
            <i
              v-show="!this.userStore.isLoading"
              class="fa-solid fa-file-signature"
            />
          </b>
        </button>
      </div>
    </div>
    <div class="row mt-3 justify-content-center">
      <h6 class="text-center">
        If you didn't get the code, you can resend it!
      </h6>
      <div class="col-4 btn-group">
        <button
          class="btn active btn rounded-container rounded-pill"
          @click="this.resendCode()"
        >
          <b>
            Resend
            <i
              v-show="this.resendLoading"
              class="fa-solid fa-spinner fa-spin"
            />
            <i
              v-show="!this.resendLoading"
              class="fa-solid fa-envelope"
            />
          </b>
        </button>
      </div>
    </div>
    <div class="mt-3 row justify-content-center">
      <div
        v-if="this.userStore.response.data"
        class="alert alert-success text-center col-4"
        role="alert"
      >
        <p
          v-if="this.userStore.response.data"
          class="m-0"
        >
          {{ this.userStore.response.data.message }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import {mapStores, mapWritableState} from "pinia";
import {useUserStore} from "../../../store/userStore";
import InputComp from "../../../Components/InputComp.vue";

export default {
  name: "UserVerificationComp",
  components: {InputComp},
  data() {
    return {
      codeError: undefined,
      resendLoading: false
    }
  },
  computed:{
    ...mapStores(useUserStore),
    ...mapWritableState(useUserStore,['verification']),
  },
  watch:{
    verification(newVal) {
      this.codeError = !(/(?=.*[A-Z])/.test(newVal));
      this.codeError = !(/(?=.*[a-z])/.test(newVal));
      this.codeError = !(/(?=.*\d)/.test(newVal));
      this.codeError = newVal.length !== 8;
    }
  },
  methods: {
    async resendCode() {
      await this.userStore.resendVerificationCode();
    }
  }
}
</script>


<style scoped>

</style>