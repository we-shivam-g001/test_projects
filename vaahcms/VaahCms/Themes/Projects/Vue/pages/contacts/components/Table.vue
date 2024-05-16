<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useContactStore } from '../../../stores/store-contacts'
import {useCompanyStore} from "../../../stores/store-companies";
import CreateContact from "../components/CreateCompany.vue"
const store = useContactStore();
const useVaah = vaah();
const store_2 = useCompanyStore();


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
                    {{prop.data.first_name}}
                </template>

            </Column>
             <Column field="company" header="Company Name" class="overflow-wrap-anywhere" :sortable="true" style="border: 1px solid #ccc;">
                 <template #body="prop">
                     <div v-if="prop.data.company !== null" @click="store.viewCompany(prop.data.company)" class="text-primary-700 cursor-pointer">
                         {{ prop.data.company.name }}
                     </div>
                     <Button rounded v-else class="text-primary-700 cursor-pointer">
                         <i @click="store.createCompany(prop.data)" class="pi pi-plus"></i>
                     </Button>
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
             <Column  header="Payment Terms"
                      v-if="store.isViewLarge()"
                     :sortable="true" style="border: 1px solid #ccc;">

                 <template #body="prop">

                     {{prop.data.payment_terms}}
                 </template>

             </Column>
             <Column header="Credit Limit" v-if="store.isViewLarge()"
                     class="overflow-wrap-anywhere"
                     :sortable="true"
                     style="border: 1px solid #ccc;">

                 <template #body="prop">
                     {{ prop.data.credit_limit !== null ? `$${prop.data.credit_limit}` : '$0.00' }}
                 </template>

             </Column>
             <Column field="tax_rate" header="Tax Rate"  v-if="store.isViewLarge()" style="border: 1px solid #ccc;">
                 <template #body="props">
<!--                     <span v-if="props.data.tax_rate">{{props.data.tax_rate}}%</span>-->
                     {{ props.data.tax_rate !== null ? props.data.tax_rate + '%' : '0.00%' }}
                 </template>
             </Column>
             <Column field="added_by" header="Responsible Manager"
                     v-if="store.isViewLarge()"
                     :sortable="true" style="border: 1px solid #ccc;">

                 <template #body="prop">
                     <span v-if="prop.data.added_by == null"
                            value="Trashed"
                            severity="danger"></span>
                     <span v-else>
                     {{prop.data.responsible_user.name}}
                         </span>
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
                    :header="store.getActionLabel()">

                <template #body="prop">
                    <div class="p-inputgroup ">

                        <Button class="p-button-tiny p-button-text"
                                data-testid="contacts-table-to-view"
                                v-tooltip.top="'View'"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye" />

                        <Button class="p-button-tiny p-button-text"
                                data-testid="contacts-table-to-edit"
                                v-tooltip.top="'Update'"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil" />

                        <Button class="p-button-tiny p-button-danger p-button-text"
                                data-testid="contacts-table-action-trash"
                                v-if="store.isViewLarge() && !prop.data.deleted_at"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="'Trash'"
                                icon="pi pi-trash" />


                        <Button class="p-button-tiny p-button-success p-button-text"
                                data-testid="contacts-table-action-restore"
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
<CreateContact/>
    </div>

</template>
