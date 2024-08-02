<!--
<template>
  <div class="height-34px">
    <vSelect

      v-model="selected" 
      :options="[1,2,3,4,5]"
    />
  </div>
</template>

<script>

export default {
  name: "SelectComp",
  props:{
    selectModel: {
      type: [String,Object],
      default: '',
      required: true
    },
    options:{
      type: Array,
      default: ()=>{
        return []
      },
      required: true
    },
    multiple: {
      type: Boolean,
      default: false,
      required: true
    },
    label: {
      type: String,
      default: '',
      required: true
    }
  },
  data(){
    return {
      selected:''
    }
  }
}
</script>



<style scoped>


.height-38px {
  height: 38px;
}
</style>-->
