<template>
  <div
    :id="`heading-${this.entity.name}`"
    class="card-header"
  >
    <h6 class="accordion-header">
      <button
        class="btn collapsed"
        type="button"
        data-toggle="collapse"
        :data-target="`#collapse-${this.entity.name}`"
        aria-expanded="false"
        :aria-controls="`collapse-${this.entity.name}`"
        @click="this.collapse = !this.collapse"
      >
        <span
          :class="this.mappingStatus?`color-ok`:`color-bad`"
          v-text="this.getStatusText()"
        />
        <span class="ps-2">"{{ this.entity.table.name }}"</span>
        <span class="ps-2">{{ this.entity.name }}</span>

      </button>
    </h6>
  </div>
  <div
    :id="`collapse-${this.entity.name}`"
    class="collapse"
    :class="{show: this.collapse}"
    :aria-labelledby="`heading-${this.entity.name}`"
  >
    <div class="card-body">
      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
    </div>
  </div>
</template>
<script>
export default {
  name: "AdminOneEntityDataComp",
  props: {
    entity: {
      type: Object,
      default() {
        return {
          name: '',
        };
      }
    },
    mappingStatus: {
      type: Boolean,
      default() {
        return true;
      }
    },
    counter: {
      type: Number,
      default() {
        return null
      }
    }
  },
  data(){
    return {
      collapse:false
    }
  },
  methods: {
    getStatusText() {
      return this.mappingStatus? `[ `+`OK`+` ]` : `[ `+`BAD`+` ]`
    }
  }
}
</script>


<style scoped>
  .color-ok {
    color: #63ff00 !important;
  }
  .color-bad {
    color: #d82121!important;
  }
</style>