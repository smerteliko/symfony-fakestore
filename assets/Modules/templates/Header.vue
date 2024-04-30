<template>
    <nav class=" container navbar  navbar-expand-lg navbar-light bg-light ">
        <div class="container-fluid">
            <div class="navbar-brand  align-content-start me-lg-5">
                <RouterLink class="nav-link  link-primary" to="/">
                    <h3 class="text-lg-center mb-lg-0 ">
                        Home
                    </h3>
                </RouterLink>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
              <div class="collapse navbar-collapse" id="collapsibleNavbar">
                      <div class="nav-item dropdown align-content-lg-center ms-lg-5">
                          <RouterLink
                              class="nav-link dropdown-toggle link-primary"
                              :to="{name:'CatalogListComp'}"
                              id="navbarDropdownMenuLink"
                              data-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false">
                              <h3 class="text-lg-center mb-0">
                                  <i class="fa-solid fa-book-open"></i>
                              </h3>
                              <p><small>Categories</small></p>
                          </RouterLink>
                          <div class="dropdown-menu"
                               aria-labelledby="navbarDropdownMenuLink"

                          >
                              <div v-for="categ in this.getCategoryList">
                                  <RouterLink class="dropdown-item" :to="{name: 'CategoryComp', params:{id: categ.id}}">
                                      <i :class="getIcon(categ.id)"></i>
                                      <span v-text="categ.Name"></span>
                                      <hr class="dropdown-divider">
                                  </RouterLink>

                              </div>

                          </div>
                      </div>
                  <div class="nav-item align-content-lg-center  d-lg-flex m-auto me-2">
                      <RouterLink class="nav-link link-primary me-lg-3 " to="/cart">
                          <h3 class="text-lg-center mb-0">
                              <i class="fa-solid fa-cart-shopping"></i>
                          </h3>
                          <p><small>Cart</small></p>
                      </RouterLink>
                      <RouterLink class="nav-link link-primary ms-lg-3" to="/cart">
                          <h3 class="text-lg-center mb-0">
                              <i class="fa-solid fa-house-user"></i>
                          </h3>
                          <p><small>User</small></p>
                      </RouterLink>
                  </div>
              </div>
        </div>
    </nav>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: 'FakestoreHeader',
    data() {
        return {
            cartList: {}
        }
    },
    async beforeCreate() {
        await this.$store.dispatch("fetchCatList");
       // this.cartLS = this.$store.getters.getCartItemsLS;
        this.cartList = this.$store.getters.getCartItems;
    },
    computed: {
        ...mapGetters([
            'getCategoryList',
            'getCartItems',
            'getCartTotal'
        ]),
    },
    watch:{
    },
    methods: {
        getIcon(id) {
            if(id === 1) {
                return 'fa-solid fa-shirt'
            }

            if(id === 2) {
                return 'fa-solid fa-shoe-prints'
            }

            if(id === 3) {
                return 'fa-solid fa-ring'
            }

            if(id === 4) {
                return 'fa-solid fa-laptop-code'
            }

            if(id === 5) {
                return 'fa-solid fa-house-chimney'
            }

            return ''
        }
    },
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

  .dropdown-toggle::after {
      content:none;
  }

  .dropdown>.dropdown-toggle:active {
      /*Without this, clicking will make it sticky*/
      pointer-events: ;
  }

</style>