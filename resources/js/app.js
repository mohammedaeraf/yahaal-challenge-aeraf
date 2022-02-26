require("./bootstrap");

window.Vue = require("vue").default;

Vue.component(
    "stats-component",
    require("./components/StatsComponent.vue").default
);

Vue.component(
    "map-component",
    require("./components/MapComponent.vue").default
);

const app = new Vue({
    el: "#app",
});
