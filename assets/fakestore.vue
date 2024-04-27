<template>
  <div>
    <FakestoreHeader></FakestoreHeader>
    <RouterView></RouterView>
  </div>
</template>

<script>
import FakestoreHeader from "./Modules/templates/Header.vue";
export default {
  name: "FakeStore",
  components:{FakestoreHeader}
};
</script>

<style></style>