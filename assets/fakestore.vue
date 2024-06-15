<template>
  <div>
    <FakestoreHeader />
    <RouterView class="vh-100 mh-100" />
    <UserLoginComp />
  </div>
</template>

<script>
import FakestoreHeader from "./Modules/templates/Header.vue";
import UserLoginComp from "./Modules/User/UserLoginComp.vue";

export default {
  name: "FakeStore",
  components:{UserLoginComp, FakestoreHeader},

};
</script>

<style></style>