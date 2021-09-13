import { createApp } from 'vue';
import App           from './Search.vue';
import InstantSearch from 'vue-instantsearch/vue3/es';


const app = createApp(App);
app.use(InstantSearch);
app.mount('#search');
