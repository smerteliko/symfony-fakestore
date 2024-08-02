<template>
  <div class="  px-0 bg-dark">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
      <RouterLink
        to="/admin/main"
        class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none"
        @mouseenter="this.measureTimeStart"
        @mouseleave=" this.measureTimeStop"
      >
        <span class="fs-5 d-none d-sm-inline">Menu</span>
        <span
          class="ps-2"
          :class="this.measureColorClass"
        >
          {{ this.measuredTime }} ms </span>
      </RouterLink>
      <ul
        id="menu"
        class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
      >
        <li class="nav-item">
          <RouterLink
            to="/admin/entities"
            class="nav-link align-middle px-0"
          >
            <i class="fa-solid fa-house" /> <span class="ms-1 d-none d-sm-inline">Entities</span>
          </RouterLink>
        </li>
        <li>
          <a
            href="#submenu1"
            data-bs-toggle="collapse"
            class="nav-link px-0 align-middle"
          >
            <i class="fa-solid fa-heart-pulse" /><span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
        </li>
      </ul>
      <hr>
      <div class="dropdown pb-4">
        <a
          id="dropdownUser1"
          href="#"
          class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
        </a>
      </div>
    </div>
  </div>
</template>

<script>

import axios from "axios";

export default {
  name: "AdminMenuComp",
  data() {
    return {
      measureTimes: [],
      measureTime: null,
      measuredTime: null,
      measureColorClass: this.getColorClass('FFF'),
      colorScale: [
        '63ff00',
        '8cff00',
        'b0ff00',
        'd3ff00',
        'f5fe00',
        'ffe800',
        'ffcf00',
        'ffb100',
        'ff8d00',
        'ff6100',
        'ff3400',
        'fc0d03',
        'd82121',
        'b63d3d',
        'bd0b0b',
        'a2a1a1'
      ]
    }
  },
  mounted() {
    this.measureServerResponseTime();
  },
  methods: {
    measureTimeStart() {
      this.measureServerResponseTime('START');
    },
    measureTimeStop() {
      this.measureServerResponseTime('STOP');
    },
    getAvgResponseTime() {
      let sum    = 0;
      let count  = 0;
      this.measureTimes = this.measureTimes.slice(-10);
      for (let i = 0; i < this.measureTimes.length; ++i) {
        if (typeof this.measureTimes[i] !== 'undefined') {
          sum += this.measureTimes[i];
          ++count;
        }
      }
      return count ? parseInt(sum / count) : 0;
    },


    measureServerResponseTime(command) {
      let startTime = (new Date()).getTime();


      if (command === 'START' || !this.measureTime) {
        clearInterval(this.measureTime);
        this.measureTime = setInterval(this.measureServerResponseTime,10000 /*10 seconds*/);
      }
      this.measuredTime = this.getAvgResponseTime();

      if (command === 'STOP') {
        clearInterval(this.measureTime);
        return;
      }

      const deadEnd = 450;
      let deadEndIndex = this.colorScale.length-1;
      let step = parseInt(deadEnd/deadEndIndex);

        axios.get('/admin/api/ping')
             .then(response => {
                this.measureTimes.push((new Date()).getTime() - startTime);
                this.measureColorClass = this.getColorClass(this.colorScale[Math.min(parseInt(this.getAvgResponseTime()/step), deadEndIndex)])
            })
    },
    getColorClass(color) {
      return 'color-'+color;
    }
  }
}
</script>

<style scoped>
  .color-63ff00 {
    color: #63ff00 !important;
  }
  .color-8cff00 {
    color: #8cff00!important;
  }
  .color-b0ff00 {
    color: #b0ff00!important;
  }
  .color-d3ff00 {
    color: #d3ff00!important;
  }
  .color-f5fe00 {
    color: #f5fe00!important;
  }
  .color-ffe800 {
    color: #ffe800!important;
  }
  .color-ffcf00 {
    color: #ffcf00!important;
  }
  .color-ffb100 {
    color: #ffb100!important;
  }
  .color-ff8d00 {
    color: #ff8d00!important;
  }
  .color-ff6100 {
    color: #ff6100!important;
  }
  .color-ff6100 {
    color: #ff6100!important;
  }
  .color-ff3400 {
    color: #ff3400!important;
  }
  .color-fc0d03 {
    color: #fc0d03!important;
  }
  .color-d82121 {
    color: #d82121!important;
  }
  .color-b63d3d {
    color: #b63d3d!important;
  }
  .color-bd0b0b {
    color: #bd0b0b!important;
  }
  .color-63ff00 {
    color: #a2a1a1!important;
  }
  .color-FFF {
    color: #FFF!important;
  }

</style>