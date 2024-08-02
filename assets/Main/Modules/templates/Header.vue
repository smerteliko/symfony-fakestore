<template>
  <nav
    :class="{'change-color': scrollPosition > 50}"
    class=" container navbar sticky-top navbar-expand-lg navbar-light mt-5 container-color"
  >
    <div class="container-fluid">
      <div class="navbar-brand  align-content-start me-lg-5">
        <RouterLink
          class="nav-link  link-primary"
          to="/"
          replace
        >
          <h3 class="text-lg-center mb-lg-0 ">
            Home
          </h3>
        </RouterLink>
      </div>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#collapsibleNavbar"
      >
        <span class="navbar-toggler-icon" />
      </button>
      <div
        id="collapsibleNavbar"
        class="collapse navbar-collapse"
      >
        <div class="nav-item dropdown align-content-lg-center ms-lg-5">
          <button
            id="navbarDropdownMenuLink"
            class="nav-link dropdown-toggle link-primary"
            data-toggle="dropdown"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <h3 class="text-lg-center mb-0">
              <i class="fa-solid fa-book-open" />
            </h3>
            <p class="mb-0">
              <small>Categories</small>
            </p>
          </button>
          <div
            class="dropdown-menu dropdown-own"
            aria-labelledby="navbarDropdownMenuLink"
          >
            <div
              v-for="categ in this.categoryStore.getCategoryList"
              :key="categ.id"
              class="dropend dropdown-item"
            >
              <RouterLink
                :key="`header-category-`+categ.Name"
                :to="{name: 'CategoryComp', params:{catID: categ.id}}"
                type="button"
                class="dropdown-toggle nav-link "
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <h6 class="">
                  <i :class="getIcon(categ.id)" /> {{ categ.Name }}
                </h6>
              </RouterLink>
              <div class="dropdown-menu">
                <div
                  v-for="subCat in categ.subCategories"
                  :key="subCat.id"
                  class="dropdown-item"
                >
                  <RouterLink
                    :key="`header-category-`+categ.Name+`-subcategory-`+subCat.Name"
                    :to="{name: 'CategoryCompBuSub', params:{catID: categ.id, subID:subCat.id}}"
                    class="nav-link"
                    replace
                  >
                    <h6 class="">
                      {{ subCat.Name }}
                    </h6>
                  </RouterLink>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="nav-item align-content-lg-center  d-lg-flex m-auto me-2">
          <RouterLink
            type="button"
            class="nav-link link-primary me-lg-3 position-relative"
            to="/cart"
            replace
          >
            <h3 class="text-lg-center mb-0">
              <i class="fa-solid fa-cart-shopping" />
            </h3>
            <p class="mb-0">
              <small>Cart</small>
            </p>
            <span
              class="position-absolute badge-fs top-0 start-100 translate-middle badge rounded-pill bg-danger"
              v-text="this.cartStore.getCartTotalItems"
            />
          </RouterLink>
          <RouterLink
            v-if="this.userStore.isAuthed === true"
            class="nav-link link-primary ms-lg-3"
            to="/user/profile/personal_info" replace
          >
            <div v-if="!this.userStore.user.Images">
              <h3 class="text-lg-center mb-0">
                <i class="fa-solid fa-house-user" />
              </h3>
              <p class="mb-0">
                <small>Profile</small>
              </p>
            </div>
            <div v-else>
              <img
                class=" border-color img-size rounded-container obj-fit"
                :src="this.getImage()"
                alt=""
              >
            </div>
          </RouterLink>
          <div v-else>
            <a
              role="button"
              type="button"
              class=" nav-link link-primary text-decoration-none position-relative"
              data-bs-toggle="modal"
              data-bs-target="#loginModal"
            >
              <h3 class="text-lg-center mb-0">
                <i class="fa-solid fa-house-user" />
              </h3>
              <p class="mb-0">
                <small>User</small>
              </p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>

import {mapActions, mapStores,} from "pinia";
import {useCategoryStore} from "../../store/categoryStore";
import {useCartStore} from "../../store/cartStore";
import {useUserStore} from "../../../store/userStore";
import {useJSONStore} from "../../../store/jsonStore";

export default {
    name: 'FakestoreHeader',
    components:{},
    data() {
        return {
          scrollPosition: null,
        }
    },
    computed: {
      ...mapStores(
        useCategoryStore,
        useCartStore,
        useUserStore,
        useJSONStore
      )
    },
    async beforeMount() {
      await this.fetchCurrencyList();
      await this.fetchCatList();
      this.updateCartListFromLS();
    },
    mounted() {
      window.addEventListener('scroll', this.updateScroll);
    },
    methods: {
      ...mapActions(useCategoryStore,["fetchCatList"]),
      ...mapActions(useCartStore,["updateCartListFromLS"]),
      ...mapActions(useJSONStore,["fetchCurrencyList"]),


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
        },
        getImage() {
          return require('../../../img/uploads/'+this.userStore.user.Images.file.FileName)
        },
        updateScroll() {
          this.scrollPosition = window.scrollY
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

  .dropdown-own .dropdown:hover>.dropdown-menu,
  .dropdown-own .dropend:hover>.dropdown-menu {
      display: block;
      margin-top: 0.125em;
  }

  .dropdown-own .dropend:hover > .dropdown-menu {
      position: absolute;
      top: 0;
      left: 100%;
  }

  .dropdown-toggle::after{
    content:none;
  }

  .dropdown-own .dropdown-toggle::after {
      content:none;
  }

  .dropdown-own .dropdown>.dropdown-toggle:active {
      /*Without this, clicking will make it sticky*/
      pointer-events: none;
  }

.img-size {
    width: 57px;
  height: 57px;
  }

.obj-fit{
  object-fit: cover;
}

  .badge-fs {
      font-size: 0.6rem !important;
  }
.border-color {
  border: 3px solid;
  border-color: rgba(13,13,213,1)!important
}
.container-color.scrolled {
  background-color: whitesmoke;
}
.change-color{
  background-color: #b3c6d3 !important;
}
</style>