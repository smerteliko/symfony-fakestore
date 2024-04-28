
<template>
    <div class="container">
        <div class="row mb-2 mt-5 justify-content-center">
            <div class="col-3 mt-5" v-for="categ in this.getCategoryList">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{categ.Name}}</h5>
                        <p class="card-text">Descr</p>
                        <RouterLink :to="{name: 'CategoryComp', params:{id: categ.id}}" class="btn btn-primary"> Go to</RouterLink>
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
}
</script>

<style scoped>

</style>