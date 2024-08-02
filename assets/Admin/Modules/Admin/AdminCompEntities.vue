<template>
  <div
    id="accordion"
    class="vh-100 container container-fluid container-color d-flex flex-column"
  >
    <div class="row m-3">
      <h4>Entities metadata</h4>
    </div>
    <div class="container h-50 overflow-auto border-3 border-black ">
      <div
        v-for="(value, index, counter) in this.entities"
        :key="`entity-${index}`"
        class="card"
      >
        <AdminOneEntityDataComp
          :entity="value"
          :counter="counter"
          :mapping-status="this.entitiesMappingErrors[index]"
        />
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import {mapStores} from "pinia";
import {useUserStore} from "../../../store/userStore";
import AdminOneEntityDataComp from "./AdminOneEntityDataComp.vue";

export default {
  name: "AdminCompEntities",
  components: {AdminOneEntityDataComp},
  data() {
    return {
      entities:[],
      entitiesMappingErrors: []
    }
  },
  computed: {
    ...mapStores(useUserStore),
  },
  async beforeMount() {
    await this.getEntities()
  },
  methods: {
    async getEntities() {
       await axios.get(
        '/admin/api/entities',
        {
          headers: { Authorization: `Bearer ${this.userStore.token}` }
        }
      ).then(response => {
        this.entities = response.data.entities;
        this.entitiesMappingErrors = response.data.mappingErrors;
      });
    }
  }
}
</script>


<style scoped>

</style>

