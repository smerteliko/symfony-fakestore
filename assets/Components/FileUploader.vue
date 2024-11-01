<template>
  <form @submit.prevent="submitFile">
    <div class="container d-flex flex-column align-items-centers">
      <div class="row  flex-nowrap align-items-center">
        <div class="col d-flex ps-0">
          <div class="position-relative d-flex">
            <img
              id="image"
              width="136px"
              height="136px"
              class="col-4 img-fluid border-color p-0 rounded-container img-size obj-fit d-block"
              :class="this.errors.length > 0 ?'is-invalid' : ''"
              :src="this.file"
              role="button"
              aria-describedby="invalidFile"
              alt=""
              @click="this.chooseImage"
            >
            <button
              class="icon bottom-0 end-0"
              type="button"
              @click="this.chooseImage"
            >
              <i class="fa-solid fa-pen-to-square" />
            </button>

            <input
              id="file"
              ref="file"
              type="file"
              class="d-none"
              @change="handleFileUpload($event)"
            >
          </div>
          <div
            v-if="this.errors.length>0"
            id="invalidFile"
            class="ps-1 col small text-wrap invalid-feedback"
          >
            <small>{{ this.errors }}</small>
          </div>
        </div>
      </div>
      <div class="row pt-1 button-width">
        <button
          class="active rounded-pill btn flex-fill"
          type="submit"
        >
          Save image
        </button>
      </div>
    </div>
  </form>
</template>

<script>
import axios from 'axios'

export default {
  name: "FileUploader",
  props: {
    uploadTo : {
      type: String,
      default: '/new'
    },
    entity : {
      type: Object,
      default() {
        return undefined;
      }
    },
  },
  data() {
    return {
      fileSave:'',
      errors: [],
    };
  },
  computed: {
    file() {
      let entity = this.entity ? this.entity : undefined

      let images = entity.Images ? entity.Images.file : undefined;
      if(entity && images) {
        return require('../img/uploads/' + images.FileName)
      }
      return ''
    }
  },
  methods: {
    async submitFile() {
      let formData = new FormData();

      formData.append('file', this.fileSave);
      formData.append('entity', JSON.stringify(this.entity));
      await axios.post('/file/' + this.uploadTo,
        formData,
        {
          headers: {
            'Content-Type': 'multipart/form-data',
            Authorization: `Bearer ${this.token}`
          },

        }
      ).then((response) => {
        this.fileSave = response.data.fileName;
        window.location.reload();
      }).catch((error) => {
        this.errors = error.response.data.errors
      });
    },

    chooseImage() {
      let output = document.getElementById('file');
      output.click();
    },


    handleFileUpload(event) {
      const files = event.target.files[0];
      let output = document.getElementById('image');
      output.src = URL.createObjectURL(files);
      output.onload = function () {
        URL.revokeObjectURL(output.src) // free memory
      }
      this.errors = [];
      this.fileSave = files;
    },

  }
}
</script>



<style scoped>
  .img-size{
    width: 136px;
    height: 136px;
  }
  .button-width {
    width: 136px;
  }

  .obj-fit {
    object-fit: cover;
  }

  .icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    padding: 0;
    background: none;
    color: rgba(13,13,213,1);
    border: 2px solid rgba(13,13,213,1);
  }
  .icon::after {
    content: '';
    bottom: 0;
  }
  .border-color {
    border: 2px solid;
    border-color: rgba(13,13,213,1)!important
  }
</style>