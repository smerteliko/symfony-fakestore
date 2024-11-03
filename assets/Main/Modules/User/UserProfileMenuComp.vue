<template>
  <ul
    class=" pt-2 pb-5 pe-2 ps-2
      list-group list-group-flush
      border-1-solid-white border-left-panel
      mb-2 mt-2 rounded-container"
  >
    <RouterLink
      class="
       mt-1 mb-3
       list-group-item list-group-item-action
       btn rounded-container rounded-pill"
      :class="{'active text-white': this.$router.currentRoute.value.name === `UserPersonalInfo`}"
      :to="{name:'UserPersonalInfo'}"
    >
      <b><i class="fa-solid fa-gear" /> Personal info  </b>
    </RouterLink>
    <RouterLink
      class="
       mt-1 mb-3
       list-group-item list-group-item-action
       btn rounded-container rounded-pill"
      :disabled="this.userStore.user.isVerified"
      :class="{
        'active text-white': this.$router.currentRoute.value.name === `UserVerification`,
        'disabled' : this.userStore.user.isVerified
      }"
      :to="{name:'UserVerification'}"
    >
      <b><i class="fa-solid fa-file-signature" /> User verification  </b>
    </RouterLink>
    <button
      type="button"
      class="mt-3 mb-3
       list-group-item list-group-item-action
       btn rounded-container rounded-pill"
      @click="this.userStore.logout"
    >
      <b><i class="fa-solid fa-right-from-bracket" /> Logout </b>
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
}
</script>


<style scoped>

</style>