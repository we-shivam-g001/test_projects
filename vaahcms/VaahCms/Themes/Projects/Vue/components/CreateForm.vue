<template>
    <Sidebar v-model:visible="root.show_contact_panel"  header="Contact Details" position="right" style="width:800px;">
        <template #header>
            <h2 style="font-weight: bold;" v-if="root.item ">{{root.company_name}}</h2>
        </template>
<!--        <VhField label="Name">-->
<!--            <div class="p-inputgroup">-->
<!--                <InputText class="w-full"-->
<!--                           placeholder="Enter the name"-->
<!--                           name="companies-name"-->
<!--                           data-testid="companies-name"-->

<!--                           v-model="store.item.name" required/>-->
<!--                <div class="required-field hidden"></div>-->
<!--            </div>-->
<!--        </VhField>-->

<!--        <VhField label="Email Address">-->
<!--            <div class="p-inputgroup">-->
<!--                <InputText class="w-full"-->
<!--                           v-model="store.item.email"-->
<!--                           @input="store.validateEmail"-->
<!--                           placeholder="Enter Email"-->
<!--                           name="companies-email"-->
<!--                           data-testid="companies-email"-->
<!--                           type="email"-->
<!--                           aria-describedby="email-error"-->
<!--                />-->
<!--                <div class="required-field hidden"></div>-->
<!--            </div>-->
<!--            <small id="email-error" class="p-error">{{ store.email_error.msg }}</small>-->
<!--        </VhField>-->
<!--        <VhField label="Phone">-->
<!--            &lt;!&ndash;                    <InputText class="w-full"&ndash;&gt;-->

<!--            &lt;!&ndash;                               v-model="store.item.phone"&ndash;&gt;-->
<!--            &lt;!&ndash;                               name="account-phone"&ndash;&gt;-->
<!--            &lt;!&ndash;                               data-testid="account-phone"&ndash;&gt;-->
<!--            &lt;!&ndash;                    />&ndash;&gt;-->
<!--            <InputNumber id="number-input"-->
<!--                         name="companies-phone"-->
<!--                         :useGrouping="false"-->
<!--                         data-testid="companies-phone"-->
<!--                         v-model="store.item.phone"-->
<!--                         placeholder="Enter Phone"-->
<!--                         class="w-full"/>-->
<!--        </VhField>-->

<!--        <VhField label="Fax Number" >-->
<!--            <div class="p-inputgroup">-->
<!--                <InputText class="w-full"-->
<!--                           placeholder="Enter Fax Number"-->
<!--                           v-model="store.item.fax_number"-->
<!--                           name="companies-fax"-->
<!--                           data-testid="companies-fax"-->
<!--                />-->
<!--            </div>-->
<!--        </VhField>-->
<!--        <VhField label="Street" >-->
<!--            <div class="p-inputgroup">-->
<!--                <InputText class="w-full"-->
<!--                           placeholder="Enter Street"-->
<!--                           v-model="store.item.street"-->
<!--                           name="companies-street"-->
<!--                           data-testid="companies-street"-->
<!--                />-->
<!--            </div>-->
<!--        </VhField>-->
<!--        <VhField label="City">-->
<!--            <div class="p-inputgroup">-->
<!--                <InputText class="w-full"-->
<!--                           name="companies-city"-->
<!--                           data-testid="companies-city"-->
<!--                           placeholder="Enter City"-->
<!--                           v-model="store.item.city"/>-->
<!--            </div>-->
<!--        </VhField>-->

<!--        <VhField label="Zip Code">-->
<!--            <div class="p-inputgroup">-->
<!--                &lt;!&ndash;                    <InputNumber id="number-input"&ndash;&gt;-->
<!--                &lt;!&ndash;                                 name="companies-zip_code"&ndash;&gt;-->
<!--                &lt;!&ndash;                                 :useGrouping="false"&ndash;&gt;-->
<!--                &lt;!&ndash;                                 data-testid="companies-zip_code"&ndash;&gt;-->
<!--                &lt;!&ndash;                                 v-model="store.item.zip_code"&ndash;&gt;-->
<!--                &lt;!&ndash;                                 placeholder="Enter Zip Code"&ndash;&gt;-->
<!--                &lt;!&ndash;                                 class="w-full"/>&ndash;&gt;-->

<!--                <InputText class="w-full"-->

<!--                           v-model="store.item.zip_code"-->
<!--                           name="companies-zip_code"-->
<!--                           placeholder="Enter Zip Code"-->
<!--                           data-testid="companies-zip_code"-->
<!--                />-->
<!--            </div>-->
<!--        </VhField>-->

<!--        <VhField label="Suite">-->
<!--            <div class="p-inputgroup">-->
<!--                <InputText class="w-full"-->
<!--                           name="companies-suite"-->
<!--                           data-testid="companies-suite"-->
<!--                           placeholder="Enter Suite"-->
<!--                           v-model="store.item.suit"/>-->
<!--            </div>-->
<!--        </VhField>-->

<!--        <VhField label="Country*">-->
<!--            <AutoComplete v-model="store.item.country"-->
<!--                          value="id"-->
<!--                          class="w-full"-->
<!--                          data-testid="warehouses-country"-->
<!--                          :suggestions="store.country_suggestions"-->
<!--                          @complete="store.searchCountry($event)"-->
<!--                          :dropdown="true"-->
<!--                          placeholder="Select Country"-->
<!--                          forceSelection />-->
<!--        </VhField>-->


<!--        <VhField label="Attach a contact*">-->
<!--            <AutoComplete v-model="store.item.contacts"-->
<!--                          value="id"-->
<!--                          class="w-full"-->
<!--                          @change="store.setContact($event)"-->
<!--                          option-label = "first_name"-->
<!--                          data-testid="warehouses-country"-->
<!--                          :suggestions="store.contact_suggestions"-->
<!--                          @complete="store.searchContacts($event)"-->

<!--                          placeholder="Search from existing contacts"-->
<!--                          forceSelection />-->
<!--        </VhField>-->


<!--        &lt;!&ndash;                <VhField label="Is Active">&ndash;&gt;-->
<!--        &lt;!&ndash;                    <InputSwitch v-bind:false-value="0"&ndash;&gt;-->
<!--        &lt;!&ndash;                                 v-bind:true-value="1"&ndash;&gt;-->
<!--        &lt;!&ndash;                                 class="p-inputswitch-sm"&ndash;&gt;-->
<!--        &lt;!&ndash;                                 name="companies-active"&ndash;&gt;-->
<!--        &lt;!&ndash;                                 data-testid="companies-active"&ndash;&gt;-->
<!--        &lt;!&ndash;                                 v-model="store.item.is_active"/>&ndash;&gt;-->
<!--        &lt;!&ndash;                </VhField>&ndash;&gt;-->


<!--        <VhField label="Is Active">-->
<!--            <div class="flex flex-row">-->
<!--                <div class="col-4">-->
<!--                    <div class="p-selectbutton p-buttonset p-component" role="group" aria-labelledby="single" style="box-shadow: none;">-->
<!--                        <div role="radio" class="p-button p-component" :class="store.item.is_active == 0 ? 'bg-green-400 text-white' : ''">-->
<!--                            <span data-testid="productvendors-can_update" name="productvendors-can_update" class="p-button-label" @click="store.item.is_active = 0">No</span>-->
<!--                            <span class="p-ink" role="presentation" aria-hidden="true"></span>-->
<!--                        </div>-->
<!--                        <div role="radio" class="p-button p-component"  :class="store.item.is_active == 1 ? 'bg-green-400 p-highlight' : ''">-->
<!--                            <span data-testid="productvendors-can_update" name="productvendors-can_update" class="p-button-label" @click="store.item.is_active = 1">Yes</span>-->
<!--                            <span class="p-ink" role="presentation" aria-hidden="true"></span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

<!--        </VhField>-->
    </Sidebar>
</template>

<script setup>
import {useRootStore} from '../stores/root.js'

const root = useRootStore();
</script>

<style scoped>

</style>
