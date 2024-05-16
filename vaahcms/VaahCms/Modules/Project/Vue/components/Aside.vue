<script setup>
import {reactive, ref,watch,onMounted} from 'vue';

import Menu from 'primevue/menu';
import {useRoute} from 'vue-router';
import {useRootStore} from "../stores/root";
const route = useRoute();
const root = useRootStore();
const inputs = {
}
const data = reactive(inputs);
const height = ref(window.innerHeight)

const menu = ref();

const menu_pt = ref({
  menuitem: ({ props }) => ({
    class: route.matched && route.matched[1] &&
    route.matched[1].path === props.item.route ? 'p-focus' : ''
  })
});

const items = ref([
    {
        label: 'Project',
        items: [

            // {
            //     label: 'Contacts',
            //     icon: 'fa-regular fa-chart-bar',
            //     route: "/contacts"
            // },
            // {
            //     label: 'Companies',
            //     icon: 'fa-regular fa-chart-bar',
            //     route: "/companies"
            // },
            {
                label: 'Products',
                icon: 'fa-regular fa-chart-bar',
                route: "/products"
            },
        ]
    },
]);



// const sidebar_menu_items = ref([]);
//
// const updateSidebarMenuItems = (advanced_layout) => {
//     sidebar_menu_items.value = [
//         {
//             label: advanced_layout?.dashboard ?? '',
//             items: [
//                 {
//                     label: advanced_layout?.contacts ?? '',
//                     icon: 'fa-regular fa-chart-bar',
//                     route: "/contacts"
//                 },
//                 {
//                     label: advanced_layout?.companies ?? '',
//                     icon: 'fa-regular fa-chart-bar',
//                     route: "/companies"
//                 },
//                 {
//                     label: products,
//                     icon: 'fa-regular fa-chart-bar',
//                     route: "/products"
//                 },
//
//             ]
//         },
//     ];
// };
//
// watch(() => root.assets?.language_strings?.advanced_layout, updateSidebarMenuItems);
//
// onMounted(async () => {
//
//     updateSidebarMenuItems(root.assets?.language_strings?.advanced_layout ?? {});
// });

</script>
<template>

    <div v-if="height">
      <Menu :model="items"  class="w-full"
            :pt="menu_pt">
        <template #item="{ item, props }">
          <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
            <a v-ripple :href="href" v-bind="props.action" @click="navigate">
              <span :class="item.icon" />
              <span class="ml-2">{{ item.label }}</span>
            </a>
          </router-link>
          <a v-else v-ripple :href="item.url" :target="item.target" v-bind="props.action">
            <span :class="item.icon" />
            <span class="ml-2">{{ item.label }}</span>
          </a>
        </template>
      </Menu>
    </div>

</template>


