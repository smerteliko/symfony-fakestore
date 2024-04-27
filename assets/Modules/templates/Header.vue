<template>
  <header>
    <div class="site-head sticky-top py-1">
      <div class="container d-flex flex-column flex-md-row justify-content-between">
        <RouterLink to="/">asdfasdf</RouterLink>
        <RouterLink to="/catalog">Каталог</RouterLink>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  name: 'FakestoreHeader'
}
</script>

<style scoped>
  .site-head{
    background-color: rgba(0, 0, 0, .85);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    backdrop-filter: saturate(180%) blur(20px);
  }
</style>