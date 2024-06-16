<template>
  <div class="container container-color rounded-pill d-flex flex-column">
    <div class="row">
      <h1>
        Personal info
        <button
          class="btn btn-success btn rounded-container rounded-pill"
          @click="this.updateUser"
        >
          <b>
            Update user
            <i
              v-show="this.userStore.isLoading"
              class="fa-solid fa-spinner fa-spin"
            />
            <i
              v-show="!this.userStore.isLoading"
              class="fa-solid fa-floppy-disk"
            />
          </b>
        </button>
      </h1>
    </div>
    <div class="d-flex pt-5">
      <div class="col-8">
        <div class="row">
          <div class="col ps-0">
            <InputComp
              :id="`userProfileFirstName`"
              :model="this.userStore.user.FirstName"
              :label="`First name`"
              :type="`text`"
              @input-value="this.userStore.user.FirstName = $event"
            />
          </div>
          <div class="col pe-3 ">
            <InputComp
              :id="`userProfileLastName`"
              :model="this.userStore.user.LastName"
              :label="`Last name`"
              :type="`text`"
              @input-value="this.userStore.user.LastName = $event"
            />
          </div>
        </div>
        <div class="row pt-4">
          <div class="pe-3 ps-0">
            <InputComp
              :id="`userProfilePhone`"
              :model="this.userStore.user.phone"
              :label="`Phone`"
              :type="`tel`"
              @input-value="this.userStore.user.phone = $event"
            />
          </div>
        </div>
        <div class="row pt-4">
          <div class="col pe-3 ps-0">
            <InputComp
              :id="`userProfileEmail`"
              :model="this.userStore.user.email"
              :label="`Email`"
              :type="`email`"
              @input-value="this.userStore.user.email = $event"
            />
          </div>
        </div>
        <div class="row pt-4">
          <div class="col ps-0">
            <div class="btn-group">
              <button
                type="button"
                class="
         mt-3 mb-3
         active
         btn rounded-container rounded-pill"
              >
                <b><i class="fa-solid fa-language" /> Language  </b>
              </button>
            </div>
          </div>
          <div class="col ">
            <SelectComp
              v-model="this.userStore.user.currency"
              class="select-styles "
              label="Name"
              :clearable="false"
              :options="this.jsonlistStore.currencies"
              placeholder="Please select currency"
            >
              <template #option="{ Name, Symbol }">
                <span>{{ Name }} &nbsp; <i class="fa-solid ">{{ Symbol }}</i> </span>
              </template>
              <template #selected-option="{ Name, Symbol }">
                <span> <b>{{ Name }} &nbsp; <i class="fa-solid ">{{ Symbol }}</i></b>  </span>
              </template>
            </SelectComp>
          </div>
        </div>
      </div>
      <div class="col-4 ps-5">
        <FileUploader
          class=""
          :upload-to="`new_user_avatar`"
          :entity="this.userStore.user"
        />
      </div>
    </div>
    <div v-show="this.updateStatus" id="alertSuccesUpdate">
      <div
        class="alert alert-success alert-dismissible"
        role="alert"
      >
        <div>{{ this.updateStatus }}</div>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="alert"
          aria-label="Close"
        ></button>
      </div>
    </div>
  </div>
</template>
<script>
import {mapStores} from "pinia";
import {useUserStore} from "../../store/userStore";
import {useJSONStore} from "../../store/jsonStore";

export default {
  name: "UserPersonalInfo",
  components: {},
  data(){
    return {
      updateStatus: null,
    }
  },
  computed:{
    ...mapStores(useUserStore, useJSONStore),
  },
  mounted() {
    this.userStore.user.phone = this.formatPhoneNumber(this.userStore.user.phone);
  },
  
  methods:{
     formatPhoneNumber(phoneNumberString) {
        let cleaned = ('' + phoneNumberString).replace(/\D/g, '');
        let match = cleaned.match(/^(\d|)?(\d{3})(\d{3})(\d{4})$/);
        if (match) {
          let intlCode = (match[1] ? +match[1]  : '');
          return [intlCode, ' (', match[2], ') ', match[3], '-', match[4]].join('');
        }
        return '';
    },
    async updateUser() {
       this.userStore.isLoading = true;
       this.updateStatus = await this.userStore.updateUserInfo();
    }

  }
}
</script>


<style>
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