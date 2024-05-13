<template>
    <nav class=" container navbar  navbar-expand-lg navbar-light bg-light mt-5">
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
                              <p class="mb-0"><small>Categories</small></p>
                          </RouterLink>
                          <div class="dropdown-menu"
                               aria-labelledby="navbarDropdownMenuLink"
                          >

                              <div class="dropend dropdown-item"
                                   v-for="categ in this.getCategoryList" >
                                  <RouterLink  :key="`header-category-`+categ.Name"
                                               :to="{name: 'CategoryComp', params:{catID: categ.id}}"
                                               type="button"
                                               class="dropdown-toggle nav-link "
                                               data-toggle="dropdown"
                                               aria-haspopup="true"
                                               aria-expanded="false">

                                      <h6 class=""><i :class="getIcon(categ.id)"></i> {{categ.Name}} </h6>
                                  </RouterLink>
                                  <div class="dropdown-menu">
                                      <div class="dropdown-item" v-for="subCat in categ.subCategories">
                                          <RouterLink :key="`header-category-`+categ.Name+`-subcategory-`+subCat.Name"
                                                      :to="{name: 'CategoryCompBuSub', params:{catID: categ.id, subID:subCat.id}}"
                                                      class="nav-link">
                                              <h6 class=""> {{subCat.Name}} </h6>
                                          </RouterLink>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </div>
                  <div class="nav-item align-content-lg-center  d-lg-flex m-auto me-2">
                      <RouterLink class="nav-link link-primary me-lg-3 position-relative" to="/cart" >
                          <h3 class="text-lg-center mb-0">
                              <i class="fa-solid fa-cart-shopping"></i>
                          </h3>
                          <p class="mb-0"><small>Cart</small></p>
                          <span class="position-absolute badge-fs top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                v-text="this.getCartTotalItems">

                          </span>

                      </RouterLink>
<!--                      <RouterLink class="nav-link link-primary ms-lg-3" to="/cart">-->
<!--                          <h3 class="text-lg-center mb-0">-->
<!--                              <i class="fa-solid fa-house-user"></i>-->
<!--                          </h3>-->
<!--                          <p class="mb-0"><small>User</small></p>-->
<!--                      </RouterLink>-->
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
        this.$store.dispatch('updateCartListFromLS');
        this.cartList = this.$store.getters.getCartItems;
    },
    computed: {
        ...mapGetters([
            'getCategoryList',
            'getCartItems',
            'getCartTotal',
            'getCartTotalItems'
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

  .dropdown:hover>.dropdown-menu,
  .dropend:hover>.dropdown-menu {
      display: block;
      margin-top: 0.125em;
  }

  .dropend:hover > .dropdown-menu {
      position: absolute;
      top: 0;
      left: 100%;
  }



  .dropdown-toggle::after {
      content:none;
  }

/*  .dropdown>.dropdown-toggle:active {
      !*Without this, clicking will make it sticky*!
      pointer-events: none;
  }*/

  .badge-fs {
      font-size: 0.6rem !important;
  }

</style>