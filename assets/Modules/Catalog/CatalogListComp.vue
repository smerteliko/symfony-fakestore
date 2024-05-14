
<template>
  <div class="component container bg-light component-flex">
    <div class="row mb-2  justify-content-center">
      <div
        v-for="categ in getShuffledArray(getCategoryList)"
        :key="`categ-`+categ.Name"
        class="col-3 mt-5"
      >
        <div class="card bg-body-secondary w-rem18">
          <div class="card-header">
            <h5 class="card-title">
              <i :class="getIcon(categ.id)" />
              {{ categ.Name }}
            </h5>
          </div>
          <div class="card-body bg-body-secondary">
            <ul
              v-for="subCat in getShuffledArray(categ.subCategories)"
              :key="subCat.Name"
              class="list-group list-group-flush bg-body-secondary"
            >
              <li
                class="list-group-item
                                        bg-body-secondary
                                        list-group-item-action
                                        list-group-item-secondary"
              >
                <RouterLink
                  :key="`sub-category-`+subCat.Name"
                  class="link-dark link-underline-opacity-0 "
                  :to="{name: 'CategoryCompBuSub', params:{catID: categ.id, subID:subCat.id}}"
                />
                {{ subCat.Name }}
              </li>
            </ul>
          </div>
          <div class="card-footer">
            <RouterLink
              :key="`category-`+categ.Name"
              :to="{name: 'CategoryComp', params:{catID: categ.id}}"
              class="btn btn-primary"
            >
              Go to {{ categ.Name }}
            </RouterLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: 'CatalogListComp',
    computed: {
        ...mapGetters([
            'getCategoryList'
        ]),
    },
    methods: {
        getShuffledArray(array) {
            return array.map(value => ({ value, sort: Math.random() }))
                        .sort((a, b) => a.sort - b.sort)
                        .map(({ value }) => value).slice(0,5)
        },

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
    }
}
</script>

<style scoped>
.w-rem18 {
    width: 18rem;
}
</style>