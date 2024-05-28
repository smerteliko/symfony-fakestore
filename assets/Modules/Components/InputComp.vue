<template>
  <div class="input-group">
    <div class="form-floating">
      <input
        :id="this.id"
        :value="this.model"
        :type="this.type"
        class="form-control border border-right-50rem border-left-50rem border-color"
        @input="$emit('input-value', $event.target.value)"
      >
      <label
        :for="this.id"
        class="text-black"
      >
        {{ this.label }}
      </label>
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
    }
  },
  emits: ['input-value'],
}
</script>

<style scoped>
.border-left-50rem {
  border-top-left-radius: 50rem !important;
  border-bottom-left-radius: 50rem !important;
}

.border-right-50rem {
  border-top-right-radius: 50rem !important;
  border-bottom-right-radius: 50rem !important;
}

.border-color {
  border-color: rgba(13,13,213,1)!important
}
</style>