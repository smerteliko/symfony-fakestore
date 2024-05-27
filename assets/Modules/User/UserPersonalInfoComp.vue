<template>
  <div class="container container-color rounded-pill d-flex flex-column">
    <div class="row">
      <h1>Personal info </h1>
    </div>

    <div class="d-flex pt-5">
      <div class="col-8">
        <div class="row">
          <div class="col ps-0">
            <div class="input-group ">
              <div class="form-floating ">
                <input
                  id="floatingFirstName"
                  v-model="this.userStore.user.FirstName"
                  class="form-control border border-right-50rem border-left-50rem border-color"
                  type="text"
                >
                <label
                  for="floatingFirstName"
                  class="text-black"
                >
                  First name
                </label>
              </div>
            </div>
          </div>
          <div class="col pe-3 ">
            <div class="input-group ">
              <div class="form-floating ">
                <input
                  id="floatingLastName"
                  v-model="this.userStore.user.LastName"
                  class="form-control border border-right-50rem border-left-50rem border-color"
                  type="text"
                >
                <label
                  for="floatingLastName"
                  class="text-black"
                >
                  Last name
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="row pt-4">
          <div class="pe-3 ps-0">
            <div class="input-group">
              <div class="form-floating ">
                <input
                  id="floatingPhone"
                  v-model="this.userStore.user.Phone"
                  class="form-control border border-right-50rem border-left-50rem border-color"
                  type="text"
                >
                <label
                  for="floatingPhone"
                  class="text-black"
                >
                  Phone
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="row pt-4">
          <div class="col pe-3 ps-0">
            <div class="input-group">
              <div class="form-floating ">
                <input
                  id="floatingEmail"
                  v-model="this.userStore.user.email"
                  class="form-control border border-right-50rem border-left-50rem border-color"
                  type="text"
                >
                <label
                  for="floatingEmail"
                  class="text-black"
                >
                  Email
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4 ps-5">
        <FileUploader
          class=""
          :upload-to="`new_user_avatar`"
          :from-entity-id="this.userStore.user.id"
          :entity="this.userStore.user"
        />
      </div>
    </div>
  </div>
</template>
<script>
import {mapStores} from "pinia";
import {useUserStore} from "../../store/userStore";
import FileUploader from "../Components/FileUploader.vue";

export default {
  name: "UserPersonalInfo",
  components:{FileUploader},
  props: {

  },
  computed:{
    ...mapStores(useUserStore)
  }
}
</script>


<style scoped>
.border-left-50rem {
  border-top-left-radius: 50rem !important;
  border-bottom-left-radius: 50rem !important;
}

.border-right-50rem {
  border-top-right-radius: 50rem !important;
  border-bottom-right-radius: 50rem !important;
}

.border-color {
  border-color: rgba(13,13,213,1)!important
}
</style>