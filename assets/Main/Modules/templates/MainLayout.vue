<template>
  <FakestoreHeader />
  <RouterView class="vh-100 mh-100" />
  <UserLoginComp />
</template>

<script>
import FakestoreHeader from "./Header.vue";
import UserLoginComp from "../User/UserLoginComp.vue";

export default {
  name: "MainLayout",
  components: {UserLoginComp, FakestoreHeader}
}
</script>


<style scoped>

</style>