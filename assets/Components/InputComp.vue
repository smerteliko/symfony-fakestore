<template>
  <div class="input-group">
    <div class="form-floating">
      <input
        :id="this.id"
        :value="this.model"
        :type="this.mutableType"
        class="form-control border border-right-50rem border-left-50rem"
        :class="this.class +''+ this.mutableClass"
        :placeholder="this.label"
        :aria-describedby="`validation`+this.id"
        :autocomplete="this.type"
        @input="$emit('input-value', $event.target.value)"
      >
      <label
        :for="this.id"
        class="text-black"
      >
        <b>{{ this.label }}</b>
      </label>
      <span
        v-if="this.errors"
        :id="`validation`+this.id"
        class="invalid-feedback text-center"
      >
        {{ this.errors }}
      </span>
    </div>
    <div
      v-if="this.type===`password`"
      class="input-group-text pe-3 bg-none border-right-50rem bg-light"
      :class="this.passwordToggleClass.borderColor"
    >
      <button
        type="button"
        class="btn  form-control"
        :class="this.passwordToggleClass.textColor"
        @click="this.passwordToggler"
      >
        <i
          :class="{'fa-solid fa-eye': !this.showPassword, 'fa-eye-slash':this.showPassword}"
        />
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "InputComp",
  props: {
    model: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default:  ''
    },
    id: {
      type: String,
      default: 'customInput'
    },
    class: {
      type: String,
      default: ''
    },
    disabled: {
      type: Boolean,
      default: false
    },
    passwordToggleClass: {
      type:Object,
      default: ()=>{
        return {
          borderColor: 'border-color',
          textColor:'icon-color'
        }
      }
    }
  },
  emits: ['input-value'],
  data(){
    return {
      errors: '',
      mutableClass: '',
      mutableType: this.type,
      showPassword: false,
    };
  },
  watch: {
    model() {
      if(this.type === `email`) {
        this.validateEmail();
      }
      if(this.type === `tel`) {
        this.validatePhone();
      }
    }
  },
  methods: {
    validateEmail() {
      if(!(/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(this.model))) {
        this.errors = 'Please enter a valid email address'
        this.mutableClass = 'is-invalid'
      } else {
        this.errors = '';
        this.mutableClass = ''
      }
    },
    validatePhone() {

    },
    passwordToggler() {
      this.showPassword = !this.showPassword;
      this.mutableType = this.showPassword ? 'text' : 'password'
    },
  }
}
</script>

<style scoped>
.border-left-50rem {
  border-top-left-radius: 50rem ;
  border-bottom-left-radius: 50rem;
}

.border-right-50rem {
  border-top-right-radius: 50rem ;
  border-bottom-right-radius: 50rem ;
}

.border-color {
  border-color: rgba(13,13,213,1)!important
}

/*button:focus {
  border: none;
  outline: none;
}*/

.border-right-0 {
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}
</style>