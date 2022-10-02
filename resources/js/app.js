import { createApp } from 'vue';
import './bootstrap';
import '../css/app.css';
import './admin/accordeon.js';

const app = createApp({});

import HallsManagementComponent from "./components/admin/HallsManagementComponent.vue";
app.component('halls-management-component', HallsManagementComponent);
import ConfigHallsComponent from "./components/admin/ConfigHallsComponent.vue";
app.component('config-hall-component', ConfigHallsComponent);
import ConfigPriceComponent from "./components/admin/ConfigPriceComponent.vue";
app.component('config-price-component', ConfigPriceComponent);
import SettingUpSessionsComponent from "./components/admin/SettingUpSessionsComponent.vue";
app.component('setting-up-sessions', SettingUpSessionsComponent);
import SalesComponent from "./components/admin/SalesComponent.vue";
app.component('sales-component', SalesComponent);

import ClientPageComponent from "./components/client/ClientPageComponent.vue";
app.component('client-page-component', ClientPageComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
