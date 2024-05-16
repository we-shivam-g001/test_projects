let routes= [];
let routes_list= [];

import List from '../pages/contacts/List.vue'
import Form from '../pages/contacts/Form.vue'
import Item from '../pages/contacts/Item.vue'

routes_list = {

    path: '/contacts',
    name: 'contacts.index',
    component: List,
    props: true,
    children:[
        {
            path: 'form/:id?',
            name: 'contacts.form',
            component: Form,
            props: true,
        },
        {
            path: 'view/:id?',
            name: 'contacts.view',
            component: Item,
            props: true,
        }
    ]
};

routes.push(routes_list);

export default routes;

