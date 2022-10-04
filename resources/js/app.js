import Vue from "vue";
import router from "./routes/index";
import store from "./store/index";
import Swal from 'vue-sweetalert2';

Vue.use(Swal);
Vue.config.debug = true

//select
Vue.component("v-select", vSelect);
import vSelect from "vue-select";

////////////////////////////////////////////
//vue-moment
import VueMoment from 'vue-moment'
Vue.use(VueMoment)
////////////////////////////////////////////
//dropzone-vue
// import DropZone from 'dropzone-vue';
// Vue.use(DropZone)
////////////////////////////////////////////

Vue.mixin({
  methods: {
    moneyFormat: function (num,fixed=2) {
      let val = (num/1).toFixed(fixed).replace('.', '.')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },
  },
})

////////////////////////////////////////////
import { BeatLoader } from 'vue-spinner/dist/vue-spinner.min.js'
Vue.component('beat-loader', BeatLoader)
////////////////////////////////////////////
import VSwitch from 'v-switch-case'
Vue.use(VSwitch)


const app = new Vue({
  el: "#app",
  router,
  store
});
