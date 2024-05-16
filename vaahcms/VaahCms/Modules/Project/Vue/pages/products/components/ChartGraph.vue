<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useProductStore } from '../../../stores/store-products'
import VhField from '../../../vaahvue/vue-three/primeflex/VhField.vue'
import {computed, onMounted, ref} from "vue";
const store = useProductStore();
const useVaah = vaah();

onMounted(async () => {


    /**
     * call onLoad action when List view loads
     */


    /**
     * watch routes to update view, column width
     * and get new item when routes get changed
     */

    await store.getAssets();

    /**
     * fetch list of records
     */
    await store.getList();

    store.chartData = store.setChartData();

    status_data.value = store.setStatusData();
    // store.staked_data = store.setStackedBar();

    store.chartOptions = store.setChartOptions();

    chartData.value = store.setStakedData();
    chartOptions.value = setChartOptions();
});

const status_data = ref();
const chartData = ref();
const chartOptions = ref();

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

const sidebarHeader = computed(() => {
    switch (store.selected_chart) {
        case 'CreatedAt':
            return 'Created At Count:';
        case 'Status':
            return 'Record count By Status:';
        case 'StatusMonth':
            return 'Status count In Months:';
        default:
            return 'All The Charts';
    }
});

</script>




<template>
    <Sidebar v-model:visible="store.show_chart"  :header="sidebarHeader" position="right" style="width:800px;">

        <ul class="chart-buttons">
            <li><Button @click="store.showChartOptions(null)">Show All</Button></li>
            <li><Button @click="store.showChartOptions('StatusMonth')">Status count In Months:</Button></li>
            <li><Button @click="store.showChartOptions('CreatedAt')">Created At Count:</Button></li>
            <li><Button @click="store.showChartOptions('Status')">Record count By Status:</Button></li>

        </ul>
        <div v-if="!store.selected_chart || store.selected_chart === 'CreatedAt'" class="card">
            <h3 class="ml-2">Created At:</h3>
            <Chart class="h-20rem" type="bar" :data="store.chartData" :options="store.chartOptions"/>
        </div>

        <div v-if="!store.selected_chart || store.selected_chart === 'Status'" class="card flex justify-content-center mt-4">
            <h3 class="ml-2">Created At:</h3>
            <Chart type="doughnut" :data="status_data" :options="store.chartOptionsDonut" class="w-full md:w-15rem"/>
        </div>

        <div v-if="!store.selected_chart || store.selected_chart === 'StatusMonth'" class="card"><h3>By Status In Months:</h3>
            <Chart type="bar" :data="chartData" :options="chartOptions" class="h-15rem"/>
        </div>


    </Sidebar>
</template>
<style scoped>
.chart-buttons {
    display: flex;
    list-style-type: none;
    padding: 0;
}

.chart-buttons li {
    margin-right: 10px;
}
</style>
