<template>
  <div>
    <FakestoreHeader />
    <RouterView class="vh-100 mh-100"/>
  </div>
</template>

<script>
import FakestoreHeader from "./Modules/templates/Header.vue";

export default {
  name: "FakeStore",
  components:{FakestoreHeader},

};
</script>

<style></style>