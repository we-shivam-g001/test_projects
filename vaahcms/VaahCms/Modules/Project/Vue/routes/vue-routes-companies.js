let routes= [];
let routes_list= [];

import List from '../pages/companies/List.vue'
import Form from '../pages/companies/Form.vue'
import Item from '../pages/companies/Item.vue'


routes_list = {

    path: '/companies',
    name: 'companies.index',
    component: List,
    props: true,
    children:[
        {
            path: 'form/:id?',
            name: 'companies.form',
            component: Form,
            props: true,
        },
        {
            path: 'view/:id?',
            name: 'companies.view',
            component: Item,
            props: true,
        },

    ]
};

routes.push(routes_list);

export default routes;

