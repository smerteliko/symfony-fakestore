<template>
  <div class=" component-flex container container-fluid vh-100">
    <div class="row w-100 mt-2 ">
      <div class="col-4 px-sm-2 col-md-4 col-xl-2">
        <admin-menu-comp />
      </div>
      <div class="col-8 col-md-8 col-xl-10">
        <router-view />
      </div>

    </div>
  </div>
</template>


<script>

import AdminMenuComp from "./AdminMenuComp.vue";

export default {
  name: "AdminComp",
  components: {AdminMenuComp},
  created() {
    document.getElementsByTagName("body")[0].classList.add("body");
  }
}
</script>

<style>
  .body{
    background: rgb(65,44,46)!important;
    background: linear-gradient(90deg, rgba(65,44,46,1) 0%, rgba(199,21,21,1) 100%) !important;
  }
</style>