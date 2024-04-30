
<template>
    <div class="component container bg-light component-flex">
        <div class="row mb-2  justify-content-center">
            <div class="col-3 mt-5" v-for="categ in getShuffledArray(this.getCategoryList)">
                <div class="card bg-body-secondary" style="width: 18rem;">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i :class="getIcon(categ.id)"></i>
                            {{categ.Name}}
                        </h5>

                    </div>
                    <div class="card-body bg-body-secondary">
                        <ul class="list-group list-group-flush bg-body-secondary"
                            v-for="subCat in getShuffledArray(categ.subCategories)">
                            <li class="list-group-item
                                        bg-body-secondary
                                        list-group-item-action
                                        list-group-item-secondary">
                                <RouterLink
                                    class="link-dark link-underline-opacity-0 "
                                    :to="{name: 'CategoryComp', params:{id: categ.id}}"
                                    v-text="subCat.Name"></RouterLink>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <RouterLink
                            :to="{name: 'CategoryComp', params:{id: categ.id}}"
                            class="btn btn-primary"> Go to {{categ.Name}} </RouterLink>
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

</style>