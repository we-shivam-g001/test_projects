<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute} from 'vue-router';

import { useContactStore } from '../../stores/store-contacts'

import VhViewRow from '../../vaahvue/vue-three/primeflex/VhViewRow.vue';
import ConfirmDialog from "primevue/confirmdialog";
import Dialog from "primevue/dialog";
const store = useContactStore();
const route = useRoute();

onMounted(async () => {

    /**
     * If record id is not set in url then
     * redirect user to list view
     */
    if(route.params && !route.params.id)
    {
        store.toList();
        return false;
    }

    /**
     * Fetch the record from the database
     */
    if(!store.item || Object.keys(store.item).length < 1)
    {
        await store.getItem(route.params.id);
    }

});
const visible = ref(false);




//--------toggle item menu
const item_menu_state = ref();
const toggleItemMenu = (event) => {
    item_menu_state.value.toggle(event);
};
//--------/toggle item menu

</script>
<template>

    <div class="col-6" >

        <Panel class="is-small" v-if="store && store.item">

            <template class="p-1" #header>

                <div class="p-panel-title w-7 white-space-nowrap
                overflow-hidden text-overflow-ellipsis">
                    #{{store.item.id}}
                </div>

            </template>

            <template #icons>


                <div class="p-inputgroup">

                    <Button label="Edit"
                            class="p-button-sm"
                            @click="store.toEdit(store.item)"
                            data-testid="contacts-item-to-edit"
                            icon="pi pi-save"/>

                    <!--item_menu-->
                    <Button
                        type="button"
                        class="p-button-sm"
                        @click="toggleItemMenu"
                        data-testid="contacts-item-menu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"/>

                    <Menu ref="item_menu_state"
                          :model="store.item_menu_list"
                          :popup="true" />
                    <!--/item_menu-->

                    <Button class="p-button-primary p-button-sm"
                            icon="pi pi-times"
                            data-testid="contacts-item-to-list"
                            @click="store.toList()"/>

                </div>



            </template>


            <div class="mt-2" v-if="store.item">

                <Message severity="error"
                         class="p-container-message"
                         :closable="false"
                         icon="pi pi-trash"
                         v-if="store.item.deleted_at">

                    <div class="flex align-items-center justify-content-between">

                        <div class="">
                            Deleted {{store.item.deleted_at}}
                        </div>

                        <div class="ml-3">
                            <Button label="Restore"
                                    class="p-button-sm"
                                    data-testid="contacts-item-restore"
                                    @click="store.itemAction('restore')">
                            </Button>
                        </div>

                    </div>

                </Message>

                <div class="p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm">
                <table class="p-datatable-table overflow-wrap-anywhere">
                    <tbody class="p-datatable-tbody">
                    <template v-for="(value, column) in store.item ">

                        <template v-if="column === 'created_by' || column === 'updated_by'|| column === 'cvv'|| column === 'expires_month'|| column === 'expires_years'
                        || column === 'vh_company_id'||
                        column === 'added_by'|| column === 'company'|| column === 'responsible_user'|| column === 'companies'
                        || column === 'deleted_by'">
                        </template>

                        <template v-else-if="column === 'id' || column === 'uuid'">
                            <VhViewRow :label="column"
                                       :value="value"
                                       :can_copy="true"
                            />
                        </template>

                        <template v-else-if="(column === 'created_by_user' || column === 'updated_by_user'
                        || column === 'deleted_by_user') && (typeof value === 'object' && value !== null)">
                            <VhViewRow :label="column"
                                       :value="value"
                                       type="user"
                            />
                        </template>


                        <template v-else-if="column === 'credit_card_number'">
                            <tr>
                                <td>
                                    <b>Credit Card Details</b>
                                </td>
                                <td colspan="2" >
                                    <div style=" overflow-wrap: break-word; word-wrap:break-word;">


                                        <Button label="View" @click="visible = true" />

                                    </div>
<!--                                        {{store.item.credit_card_number}}</div>-->
                                </td>
                            </tr>




                        </template>






                        <template v-else-if="column === 'is_active'">
                            <VhViewRow :label="column"
                                       :value="value"
                                       type="yes-no"
                            />
                        </template>

                        <template v-else>
                            <VhViewRow :label="column"
                                       :value="value"
                                       />
                        </template>


                    </template>
                    </tbody>

                </table>

                </div>
            </div>
        </Panel>
        <Dialog v-model:visible="visible" modal header="Credit Card Information" class="rounded-dialog"  :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '30vw'}">
            <hr>
            <span class="p-text-secondary block mt-4 mb-5">We hope you are doing well. Please make the payment using the following URL:
    <a href="https://www.simoc.com/solos-auto-repair/avcst125xfrssssdhfkjndsfsuwieqw4567dsfsd">https://www.simoc.com/solos-auto-repair/avcst125xfrssssdhfkjndsfsuwieqw4567dsfsd</a>
</span>

            <table style="border-collapse: collapse; width: 100%;">
                <tr  style="border: 1px solid #ccc;">
                    <td style="padding: 8px; border-right: 1px solid #ddd;">Card No</td>
                    <td >
                        <InputMask id="ssn"  v-model="store.item.credit_card_number " mask="9999-9999-9999-9999" class="w-full" placeholder="Enter credit card no" />
                    </td>
                </tr>
                <tr  style="border: 1px solid #ccc;">
                    <td style="padding: 8px; border-right: 1px solid #ddd;">CVV</td>
                    <td style="padding: 8px;">{{store.item.cvv}}</td>
                </tr>
                <tr  style="border: 1px solid #ccc;">
                    <td style="padding: 8px; border-right: 1px solid #ddd;">Expires On</td>
                    <td style="padding: 8px;">{{store.item.expires_year}}/{{store.item.expires_month}}</td>
                </tr>
            </table>
            <div class="mt-5" style="display: flex; justify-content: space-between;">
                <Button type="button" label="Cancel" severity="secondary" @click="visible = false"></Button>
                <Button type="button" label="Send Mail" class="p-button-primary" @click="sendMail"></Button>
            </div>

        </Dialog>



    </div>

</template>

<style scoped>

</style>
