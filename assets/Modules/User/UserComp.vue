<template>
  <div class="component  container bg-light  container-color vh-100">
    <div class="row mb-2 mt-2">
      <div class="col-3 container-color pt-4">
        <UserMenuProfileMenu :user-store="this.userStore" />
      </div>
      <div class="col-9 container-color pt-4">
        <router-view user-store="this.userStore" />
      </div>
    </div>
  </div>
</template>

<script>

import UserMenuProfileMenu from "./UserProfileMenuComp.vue";
import {mapStores} from "pinia";
import {useUserStore} from "../../store/userStore";

export default {
  name: "UserComp",
  components: {UserMenuProfileMenu},
  computed:{
    ...mapStores(useUserStore)
  }
}
</script>

<style scoped>

</style>