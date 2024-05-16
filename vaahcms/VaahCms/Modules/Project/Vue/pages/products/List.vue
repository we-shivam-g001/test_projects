<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRoute} from 'vue-router';

import {useProductStore} from '../../stores/store-products'
import {useRootStore} from '../../stores/root'

import Actions from "./components/Actions.vue";
import Table from "./components/Table.vue";
import Filters from './components/Filters.vue'

const store = useProductStore();
const root = useRootStore();
const route = useRoute();

import {useConfirm} from "primevue/useconfirm";

const confirm = useConfirm();


onMounted(async () => {
    document.title = 'Products - Project';
    store.item = null;
    /**
     * call onLoad action when List view loads
     */
    await store.onLoad(route);

    /**
     * watch routes to update view, column width
     * and get new item when routes get changed
     */
    await store.watchRoutes(route);

    /**
     * watch states like `query.filter` to
     * call specific actions if a state gets
     * changed
     */
    await store.watchStates();

    /**
     * fetch assets required for the crud
     * operation
     */
    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getList();

    await store.getListCreateMenu();
    // chartData.value = setChartData();
    // store.chartData = store.setChartData();
    //
    // status_data.value = store.setStatusData();
    // store.staked_data = store.setStackedBar();
    //
    // store.chartOptions = store.setChartOptions();
    //
    chartData.value = store.setStakedData();
    chartOptions.value = setChartOptions();
});
const status_data = ref();
const chartData = ref();
const chartOptions = ref();
const create_menu = ref();
const toggleCreateMenu = (event) => {
    create_menu.value.toggle(event);
};
//--------/form_menu

const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--text-color-secondary');
    const surfaceBorder = documentStyle.getPropertyValue('--surface-border');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.8,
        plugins: {
            tooltips: {
                mode: 'index',
                intersect: false
            },
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                stacked: true,
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            },
            y: {
                stacked: true,
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            }
        }
    };
}

</script>
<template>
    <div class="grid justify-content-between " v-if="store.assets">
        <div class="flex gap-8" v-if="store.isViewLarge()">
                <div class="card">
                  <h3 class="ml-2">Created At:</h3>
                  <Chart class="h-20rem" type="bar" :data="store.chartData" :options="store.chartOptions"/>
                </div>
                <div class="card flex justify-content-center">
                  <Chart type="doughnut" :data="store.status_data" :options="store.chartOptionsDonut"
                   class="w-full md:w-15rem"/>
                </div>
                <div class="card"><h3>By Status In Months:</h3>
                 <Chart type="bar" :data="store.staked_data" :options="chartOptions" class="h-15rem"/>
                </div>
        </div>


<!--    <div :class="route.params && route.params.id ? 'col-6' : 'col'">-->
        <div :class="'col-'+store.list_view_width">
        <Panel class="is-small">

            <template class="p-1" #header>

                <div class="flex flex-row">
                    <div>
                        <b class="mr-1">Products</b>
                        <Badge v-if="store.list && store.list.total > 0"
                               :value="store.list.total">
                        </Badge>
                    </div>

                </div>

            </template>

            <template #icons>

                <div class="p-inputgroup">

                    <Button data-testid="products-list-create"
                            class="p-button-sm"
                            @click="store.toForm()">
                        <i class="pi pi-plus mr-1"></i>
                        Create
                    </Button>

                    <Button data-testid="products-list-reload"
                            class="p-button-sm"
                            @click="store.getList()">
                        <i class="pi pi-refresh mr-1"></i>
                    </Button>

                    <!--form_menu-->

                    <Button v-if="root.assets && root.assets.module
                                                && root.assets.module.is_dev"
                            type="button"
                            @click="toggleCreateMenu"
                            class="p-button-sm"
                            data-testid="products-create-menu"
                            icon="pi pi-angle-down"
                            aria-haspopup="true"/>

                    <Menu ref="create_menu"
                          :model="store.list_create_menu"
                          :popup="true"/>

                    <!--/form_menu-->

                </div>

            </template>

            <Actions/>

            <Table/>

        </Panel>
    </div>



    <RouterView/>
    <Filters/>
    </div>
</template>
