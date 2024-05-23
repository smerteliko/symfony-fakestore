<template>
  <ul
    class=" pt-2 pb-5 pe-2 ps-2
      list-group list-group-flush
      border-1-solid-white border-left-panel
      mb-2 mt-2 rounded-container"
  >
    <RouterLink
      class="active
       mt-1 mb-3
       list-group-item list-group-item-action
       btn rounded-container rounded-pill"
      :to="{name:'UserPersonalInfo'}"
    >
      <b class="text-white"><i class="fa-solid fa-gear" /> Personal info  </b>
    </RouterLink>
    <button
      type="button"
      class="
       mt-3 mb-3
       list-group-item list-group-item-action
       btn rounded-container rounded-pill"
    >
      <b><i class="fa-solid fa-language" /> Language  </b>
    </button>
    <button
      type="button"
      class="mt-3 mb-3
       list-group-item list-group-item-action
       btn rounded-container rounded-pill"
    >
      <b><i class="fa-solid fa-money-bill-wave"></i>  Currency  </b>
    </button>
    <button
      type="button"
      class="mt-3 mb-3
       list-group-item list-group-item-action
       btn rounded-container rounded-pill"
      @click="this.userStore.logout"
    >
      <b><i class="fa-solid fa-right-from-bracket"></i> Logout </b>
    </button>
  </ul>
</template>

<script>
export default {
  name: "UserProfileMenu",
  props: {
    userStore: {
      type: Object,
      default() {
        return {}
      }
    }
  },
  data(){
    return {

    };
  },
  computed: {
    // ...mapStores
  },
  methods: {
  }
}
</script>


<style scoped>

</style>