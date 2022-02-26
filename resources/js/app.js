require("./bootstrap");

window.Vue = require("vue").default;

Vue.component(
    "stats-component",
    require("./components/StatsComponent.vue").default
);

const app = new Vue({
    el: "#app",
});
