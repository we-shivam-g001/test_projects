<script setup>
import { vaah } from '../../../vaahvue/pinia/vaah'
import { useCompanyStore } from '../../../stores/store-companies'

const store = useCompanyStore();
const useVaah = vaah();


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
    <Sidebar v-model:visible="store.show_contact_panel"  header="Contact Details" position="right" style="width:800px;">
        <template #header>
            <h2 style="font-weight: bold;" v-if="store.item" >{{store.company_name}}</h2>
        </template>
        <DataTable  :value="store.contact_data" style="border: 1px solid #ccc;margin-top:20px;" class="p-datatable-sm p-datatable-hoverable-rows">
            <Column field="name" header="Name" style="border: 1px solid #ccc;">
                <template #body="props">
                    <span style="text-wrap:nowrap" class="underline text-primary hover:text-primary-700 cursor-pointer" @click="store.viewContactDetails(props.data.first_name)">{{props.data.first_name}}</span>
                </template>
            </Column>
            <Column field="phone" header="Phone" style="border: 1px solid #ccc;">
                <template #body="props">
                    {{ getPhoneNumberWithCallingCode(props.data.phone, props.data.country) }}
<!--                    {{props.data.phone}}-->
                </template>
            </Column>
            <Column field="country" header="Country" style="border: 1px solid #ccc;"></Column>
            <Column field="payment_terms" header="Payment Terms" style="border: 1px solid #ccc;"></Column>
            <Column field="credit_limit" header="Credit Limit" style="border: 1px solid #ccc;">
                <template #body="prop">
        <span>
            {{ prop.data.credit_limit !== null ? prop.data.credit_limit.toLocaleString('en-US', { style: 'currency', currency: 'USD' }) : '$0.00' }}
        </span>
                </template>
            </Column>
            <Column field="tax_rate" header="Tax Rate" style="border: 1px solid #ccc;">
                <template #body="props">
<!--                    <span v-if="props.data.tax_rate">{{props.data.tax_rate}}%</span>-->
                    {{ props.data.tax_rate !== null ? props.data.tax_rate + '%' : '0.00%' }}
                </template>
            </Column>
            <Column field="status" header="Status" style="border: 1px solid #ccc;">
                <template #body="props">
                    <span v-if="props.data.is_active === 1" style="color:green;">Active</span>
                    <span v-else style="color:black;">Inactive</span>
                </template>
            </Column>

            <template #empty="prop">

                <div  style="text-align: center;font-size: 12px; color: #888;">No records found.</div>

            </template>
        </DataTable>
    </Sidebar>
</template>


<style scoped>

</style>
