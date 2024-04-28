<template>
    <nav class="container navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">

          <ul class="navbar-nav">
              <li class="nav-item">
                  <RouterLink class="nav-link" to="/">Home</RouterLink>
              </li>

              <li class="nav-item dropdown">
                  <RouterLink
                      class="nav-link dropdown-toggle"
                      :to="{name:'CatalogListComp'}"
                      id="navbarDropdownMenuLink"
                      data-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false">
                      Categories
                  </RouterLink>
                  <div class="dropdown-menu"
                       aria-labelledby="navbarDropdownMenuLink"

                  >
                      <div v-for="categ in this.getCategoryList">
                          <RouterLink class="dropdown-item" :to="{name: 'CategoryComp', params:{id: categ.id}}">
                              <span v-text="categ.Name"></span>
                          </RouterLink>
                      </div>

                  </div>
              </li>
              <li class="nav-item">
                  <RouterLink to=""></RouterLink>
              </li>
          </ul>
      </div>
    </nav>
</template>

<script>
import {mapGetters,mapActions} from "vuex";

export default {
    name: 'FakestoreHeader',
    beforeCreate() {
        this.$store.dispatch("fetchCatList");
    },
    computed: {
        ...mapGetters([
            'getCategoryList'
        ]),
    },
    watch: {}
}
</script>

<style scoped>
  .site-head{
    background-color: rgba(0, 0, 0, .85);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    backdrop-filter: saturate(180%) blur(20px);
  }

  .dropdown:hover>.dropdown-menu {
      display: block;
  }

/*  .dropdown>.dropdown-toggle:active {
      !*Without this, clicking will make it sticky*!
      pointer-events: ;
  }*/
</style>