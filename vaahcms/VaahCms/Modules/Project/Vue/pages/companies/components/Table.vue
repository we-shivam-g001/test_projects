<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useCompanyStore } from '../../../stores/store-companies'
import ContactList from './ContactList.vue'
import CreateContact from "../components/CreateContact.vue"

import {useRootStore} from "../../../stores/root";
import {useContactStore} from "../../../stores/store-contacts";
const store = useCompanyStore();
const store_2=useContactStore();
const useVaah = vaah();

const root = useRootStore();

const getPhoneNumberWithCallingCode = (phone, country) => {
    const foundCountry = store.countries.find(c => c.name === country);
    if (foundCountry) {
        const callingCode = foundCountry.calling_code;
        return `(+${callingCode}) ${phone}`;
    } else {
        return phone;
    }
};
</script>

<template>

    <div v-if="store.list">
        <!--table-->
         <DataTable :value="store.list.data"
                   dataKey="id"
                   :rowClass="store.setRowClass"
                   class="p-datatable-sm p-datatable-hoverable-rows"
                   :nullSortOrder="-1"
                   v-model:selection="store.action.items"
                   stripedRows
                   responsiveLayout="scroll">

            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()" style="border: 1px solid #ccc;"
                    headerStyle="width: 3em">
            </Column>

            <Column field="id" header="ID" :style="{width: '80px', border: '1px solid #ccc'}" :sortable="true">
            </Column>

            <Column field="name" header="Name"
                    class="overflow-wrap-anywhere"
                    :sortable="true" style="border: 1px solid #ccc;">

                <template #body="prop">
                    <Badge v-if="prop.data.deleted_at"
                           value="Trashed"
                           severity="danger"></Badge>
                    {{prop.data.name}}
                </template>

            </Column>

             <Column field="phone" header="Phone"
                     class="overflow-wrap-anywhere" v-if="store.isViewLarge()"
                     :sortable="true" style="border: 1px solid #ccc;">

                 <template #body="prop">
                     {{ getPhoneNumberWithCallingCode(prop.data.phone, prop.data.country) }}
<!--                     {{// prop.data.phone}}-->
                 </template>

             </Column>
             <Column field="country" header="Country"
                     class="overflow-wrap-anywhere"
                     :sortable="true" style="border: 1px solid #ccc;">

                 <template #body="prop">

                     {{prop.data.country}}
                 </template>

             </Column>




             <Column header="Contacts" :sortable="false" style="border: 1px solid #ccc; width: 100px" >
                 <template #body="prop">
                     <div class="p-inputgroup flex">
            <Button rounded class=" cursor-pointer"
                  v-tooltip.top="'View Contacts'"
                    style="cursor: pointer; color: #ffffff; background-color: #000000; border-radius: 50%; font-size: 12px; padding: 6px;"
                  v-if="(prop.data.contacts && prop.data.contacts.length)"
                  @click="store.toViewContacts(prop.data)">

                {{ prop.data.contacts.length }}
            </Button>
                         <Button style="cursor: pointer; color: #ffffff; background-color: #000000; border-radius: 50%; font-size: 12px; padding: 6px;"  v-else>
                {{ prop.data.contacts ? prop.data.contacts.length : 0 }}
            </Button>
                         <Button @click="store.toContactCreate(prop.data)"
                                 style="cursor: pointer; color: #ffffff; background-color: #888; border-radius: 50%; font-size: 8px; padding: 4px;"
                                 data-testid="vendors-table-product"
                                 :disabled="$route.path.includes('product') && prop.data.id===store.item?.id"
                                 :class="{ 'blurred': $route.path.includes('product') && prop.data.id===store.item?.id }"
                                 v-tooltip.top="'Add contact'"
                                 class="p-button-outlined p-button-secondary">
                             <i class="pi pi-plus"></i>
                         </Button>
                     </div>
                 </template>
             </Column>

             <Column header="Type"
                     class="overflow-wrap-anywhere"
                     :sortable="true" v-if="store.isViewLarge()"
                     style="border: 1px solid #ccc;">

                 <template #body="prop">
                     {{ prop.data.country === 'India' ? 'Local' : 'International' }}
                 </template>

             </Column>


                <Column field="updated_at" header="Updated"
                        v-if="store.isViewLarge()"
                        style="width:150px;border: 1px solid #ccc;"
                        :sortable="true">

                    <template #body="prop">
                        {{useVaah.toLocalTimeShortFormat(prop.data.updated_at)}}
                    </template>

                </Column>



             <Column field="status" header="Status" style="border: 1px solid #ccc;" v-if="store.isViewLarge()">
                 <template #body="props">
                     <span v-if="props.data.is_active === 1" style="color:green;">Active</span>
                     <span v-else style="color:black;">Inactive</span>
                 </template>
             </Column>

            <Column field="actions" style="width:150px;"
                    :style="{ width: store.getActionWidth(), border: '1px solid #ccc' }"
                    :header="store.getActionLabel()" >

                <template #body="prop">
                    <div class="p-inputgroup ">

                        <Button class="p-button-tiny p-button-text"
                                data-testid="companies-table-to-view"
                                v-tooltip.top="'View'"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye" />

                        <Button class="p-button-tiny p-button-text"
                                data-testid="companies-table-to-edit"
                                v-tooltip.top="'Update'"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil" />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                data-testid="companies-table-action-trash"
                                v-if="store.isViewLarge() && !prop.data.deleted_at"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="'Trash'"
                                icon="pi pi-trash" />


                        <Button class="p-button-tiny p-button-success p-button-text"
                                data-testid="companies-table-action-restore"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="'Restore'"
                                icon="pi pi-replay" />


                    </div>

                </template>


            </Column>

             <template #empty>
                 <div class="text-center py-3">
                     No records found.
                 </div>
             </template>

        </DataTable>
        <!--/table-->

        <!--paginator-->
        <Paginator v-if="store.query.rows"
                   v-model:rows="store.query.rows"
                   :totalRecords="store.list.total"
                   :first="((store.query.page??1)-1)*store.query.rows"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   class="bg-white-alpha-0 pt-2">
        </Paginator>
        <!--/paginator-->
<ContactList/>

<CreateContact/>
    </div>

</template>
