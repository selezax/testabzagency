import './bootstrap';
import 'bootstrap';
import { createApp } from 'vue';
import i18n from '~/front/plugins/i18n';

import UserAdd from '~/front/components/UserAdd.vue';
import UserList from '~/front/components/UserList.vue';

const app = createApp({
    components: {
        'front-useradd': UserAdd,
        'front-userlist': UserList,
    }
});

app.use(i18n);
app.mount('#app');
