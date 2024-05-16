<script setup>
import {computed, onMounted, ref, watch} from "vue";
import {useContactStore} from '../../stores/store-contacts'

import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {useRoute} from 'vue-router';


const store = useContactStore();
const route = useRoute();

onMounted(async () => {
    /**
     * Fetch the record from the database
     */
    if ((!store.item || Object.keys(store.item).length < 1)
        && route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

    await store.getFormMenu();
});
const calculateTotalAmount = computed(() => {
    let totalAmount = parseFloat(store.item.max_discount_amount) || 0;
    let discountAmount = totalAmount * (parseFloat(store.item.discount_percentage) / 100);
    let discountedTotal = totalAmount - discountAmount;
    let taxAmount = discountedTotal * (parseFloat(store.item.tax_rate) / 100);
    let total = discountedTotal + taxAmount;
    return total.toFixed(2);
});

const updateTotalAmount = () => {
    store.item.total_amount = calculateTotalAmount.value;
};

watch(() => [store.item.max_discount_amount, store.item.discount_percentage, store.item.tax_rate], () => {
    updateTotalAmount();
});



const restrictInput = (event) => {
    const inputField = document.querySelector('#numbers-only');
    if (isNaN(event.key) && event.key !== 'Backspace') {
        event.preventDefault();
    }
};

//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu

</script>

<style scoped>

</style>
<template>

    <div class="col-6">

        <Panel class="is-small">

            <template class="p-1" #header>


                <div class="flex flex-row">
                    <div class="p-panel-title">
                        <span v-if="store.item && store.item.id">
                            Update
                        </span>
                        <span v-else>
                            Create
                        </span>
                    </div>

                </div>


            </template>

            <template #icons>


                <div class="p-inputgroup">

                    <Button class="p-button-sm"
                            v-tooltip.left="'View'"
                            v-if="store.item && store.item.id"
                            data-testid="contacts-view_item"
                            @click="store.toView(store.item)"
                            icon="pi pi-eye"/>

                    <Button label="Save"
                            class="p-button-sm"
                            v-if="store.item && store.item.id"
                            data-testid="contacts-save"
                            @click="store.itemAction('save')"
                            icon="pi pi-save"/>

                    <Button label="Create & New"
                            v-else
                            @click="store.itemAction('create-and-new')"
                            class="p-button-sm"
                            data-testid="contacts-create-and-new"
                            icon="pi pi-save"/>


                    <!--form_menu-->
                    <Button
                        type="button"
                        @click="toggleFormMenu"
                        class="p-button-sm"
                        data-testid="contacts-form-menu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"/>

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true"/>
                    <!--/form_menu-->


                    <Button class="p-button-primary p-button-sm"
                            icon="pi pi-times"
                            data-testid="contacts-to-list"
                            @click="store.toList()">
                    </Button>
                </div>


            </template>


            <div v-if="store.item" class="mt-2">

                <Message severity="error"
                         class="p-container-message mb-3"
                         :closable="false"
                         icon="pi pi-trash"
                         v-if="store.item.deleted_at">

                    <div class="flex align-items-center justify-content-between">

                        <div class="">
                            Deleted {{ store.item.deleted_at }}
                        </div>

                        <div class="ml-3">
                            <Button label="Restore"
                                    class="p-button-sm"
                                    data-testid="articles-item-restore"
                                    @click="store.itemAction('restore')">
                            </Button>
                        </div>

                    </div>

                </Message>


                <VhField label="First Name*">
                    <InputText class="w-full"
                               v-model="store.item.first_name"
                               name="contact-first_name"
                               placeholder="Enter first name"
                               data-testid="contact-first_name"
                    />
                </VhField>
                <VhField label="Middle Name">
                    <InputText class="w-full"
                               v-model="store.item.middle_name"
                               placeholder="Enter middle name"
                               name="contact-middle_name"
                               data-testid="contact-middle_name"
                    />
                </VhField>
                <VhField label="Last Name*">
                    <InputText class="w-full"
                               v-model="store.item.last_name"
                               name="contact-last_name"
                               placeholder="Enter last name"
                               data-testid="contact-last_name"
                    />
                </VhField>
                <VhField label="Email*">
                    <InputText :class="'w-full '+ store.email_error.class"
                               v-model="store.item.email"
                               @input="store.validateEmail"
                               name="contact-email"
                               data-testid="contact-email"
                               placeholder="Enter email"
                               type="email"
                               aria-describedby="email-error"
                    />
                    <small id="email-error" class="p-error">{{ store.email_error.msg }}</small>
                </VhField>
                <VhField label="Phone*">

                    <InputNumber id="number-input"
                                 name="contact-phone"
                                 :useGrouping="false"
                                 data-testid="contact-phone"
                                 v-model="store.item.phone"
                                 placeholder="Enter phone"
                                 class="w-full"/>
                </VhField>
                <VhField label="Fax Number">
                    <div class="p-inputgroup">
                        <InputText class="w-full"
                                   placeholder="Enter fax number"
                                   v-model="store.item.fax_number"
                                   name="contact-fax"
                                   data-testid="contact-fax"
                        />
                    </div>
                </VhField>
                <VhField label="Street">
                    <div class="p-inputgroup">
                        <InputText class="w-full"
                                   placeholder="Enter street"
                                   v-model="store.item.street"
                                   name="contact-street"
                                   data-testid="contact-street"
                        />
                    </div>
                </VhField>
                <VhField label="City">
                    <div class="p-inputgroup">
                        <InputText class="w-full"
                                   name="contact-city"
                                   data-testid="contact-city"
                                   placeholder="Enter city"
                                   v-model="store.item.city"/>
                    </div>
                </VhField>

                <VhField label="Zip Code">
                    <div class="p-inputgroup">


                        <InputText class="w-full"

                                   v-model="store.item.zip_code"
                                   name="contact-zip_code"
                                   placeholder="Enter zip code"
                                   data-testid="contact-zip_code"
                        />
                    </div>
                </VhField>
                <VhField label="Suite">
                    <div class="p-inputgroup">
                        <InputText class="w-full"
                                   name="contact-suite"
                                   data-testid="contact-suite"
                                   placeholder="Enter suite"
                                   v-model="store.item.suite"/>
                    </div>
                </VhField>
                <VhField label="State">
                    <InputText class="w-full"
                               name="contacts-state"
                               data-testid="contacts-state"
                               placeholder="Enter state"
                               v-model="store.item.state"/>
                </VhField>
                <VhField label="Country*">

                    <Dropdown class="w-full"
                              v-model="store.item.country"
                              :options="store.countries"
                              :editable="true"
                              optionLabel="name"
                              optionValue="name"
                              placeholder="Select country"
                              id="calling_code"
                              name="contact-country_calling_code"
                              data-testid="contact-country_calling_code"
                    />
                </VhField>


                    <VhField label="Credit Limit">
                        <InputNumber
                            :step="0.01"
                            :minFractionDigits="2"
                            :useGrouping="false"
                            class="w-full"
                            name="contact-credit_limit"
                            data-testid="contact-credit_limit"
                            placeholder="Enter credit limit"
                            v-model="store.item.credit_limit"
                        />

                    </VhField>
                    <VhField label="Sales Tax %">
                        <InputNumber v-model="store.item.tax_rate" class="w-full"
                                     :max="100"
                                     @input="updateTotalAmount"
                                     :step="0.01"
                                     :minFractionDigits="2"
                                     :useGrouping="false" placeholder="Enter tax" inputId="percent" />
                    </VhField>

                <VhField label="Discount Percent" class="flex w-full">
                    <div class="flex items-center">
                        <InputGroup class="flex  w-full">
                            <span class="p-inputgroup-addon w-1rem">%</span>
                            <InputNumber
                                name="contacts-discount-percent"
                                data-testid="contacts-discount-percent"
                                placeholder="Enter discount"
                                v-model="store.item.discount_percentage"
                                :max="100"
                                :step="0.01"
                                @input="updateTotalAmount"
                                :minFractionDigits="2"
                                :useGrouping="false"
                            />
                        </InputGroup>
                        <div class="flex items-center w-full">
                            <div class="flex mt-2 mr-4">Maximum</div>
                            <InputGroup class="flex ">
                                <span class="p-inputgroup-addon w-1rem ">$</span>
                                <InputNumber
                                    @input="updateTotalAmount"
                                    :step="0.01"
                                    :minFractionDigits="2"
                                    :useGrouping="false"
                                    name="contacts-discount-amount"
                                    data-testid="contacts-discount-amount"
                                    placeholder="Enter amount"
                                    v-model="store.item.max_discount_amount"
                                />
                            </InputGroup>
                        </div>
                    </div>

                </VhField>




                <VhField label=" Tax Payer">
                    <div class="flex flex-row">
                        <div >
                            <div class="p-selectbutton p-buttonset p-component" role="group" aria-labelledby="single"
                                 style="box-shadow: none;">
                                <div role="radio" class="p-button p-component"
                                     :class="store.item.is_tax_payer == 0 ? 'bg-green-400 text-white' : ''">
                                    <span data-testid="contact-is_tax_payer" name="contact-is_tax_payer"
                                          class="p-button-label" @click="store.item.is_tax_payer = 0">No</span>
                                    <span class="p-ink" role="presentation" aria-hidden="true"></span>
                                </div>
                                <div role="radio" class="p-button p-component"
                                     :class="store.item.is_tax_payer == 1 ? 'bg-green-400 p-highlight' : ''">
                                    <span data-testid="contact-is_tax_payer" name="contact-is_tax_payer"
                                          class="p-button-label" @click="store.item.is_tax_payer = 1">Yes</span>
                                    <span class="p-ink" role="presentation" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </VhField>




                <VhField label="Tax id">
                    <InputText class="w-full"
                               type="number"
                               v-model="store.item.tax_id"
                               name="contact-tax_id"
                               placeholder="Enter tax id"
                               data-testid="contact-tax_id"
                    />
                </VhField>


                <VhField label="Validation Date

">
                    <Calendar class="w-full"
                              id="dob"
                              inputId="basic"
                              v-model="store.item.validation_date"
                              autocomplete="off"
                              name="contact-validation_date"
                              placeholder="Enter validation date"
                              data-testid="contact-validation_date"
                              dateFormat="yy-mm-dd"
                              :showTime="false"
                    />
                </VhField>
                <VhField label="Validated By">

                    <AutoComplete
                        value="id"
                        v-model="store.item.added_by_user"
                        @change="store.setAddedBy($event)"
                        class="w-full"
                        name="contact-added_by"
                        id="added_by"
                        data-testid="contact-added_by"
                        :suggestions="store.active_users_list"
                        @complete="store.searchAddedBy($event)"
                        placeholder="Validated by"
                        :dropdown="true"
                        optionLabel="first_name"
                        forceSelection>
                    </AutoComplete>

                </VhField>
                <VhField label="Payment Terms*">
                    <InputText v-model="store.item.payment_terms"
                               data-testid="contacts-payment_terms"
                               :autoResize="true"
                               rows="3" class="w-full"
                               placeholder="Enter payment note"/>
                </VhField>
                <VhField label="Comments">
                    <Textarea v-model="store.item.comments"
                              data-testid="contacts-comments"
                              :autoResize="true"
                              rows="2" class="w-full"
                              placeholder="Enter comment"/>
                </VhField>
                <VhField label="Credit Card No">
                    <InputMask id="ssn"  v-model="store.item.credit_card_number " mask="9999-9999-9999-9999" class="w-full" placeholder="Enter credit card no" />
                </VhField>


                <VhField label="Expiry Date" >

                    <div class="flex ">

                        <div class="flex mr-2 w-full mt-0">

                            <Dropdown v-model="store.item.expires_month" :options="store.months" optionLabel="name"
                                      optionValue="code" placeholder="--MM--" class="mr-1  " style="height: 30px"/>
                            <Dropdown v-model="store.item.expires_year" :options="store.years"
                                      placeholder="--year--" style="height: 30px"/>

                        </div>

                        <label class="mt-2">CVV</label>
                        <VhField class="w-full">
                        <InputText id="numbers-only"

                                   v-model="store.item.cvv"
                                   name="contacts-cvv"
                                   placeholder="Enter cvv"
                                   data-testid="vendors-name"
                                   @keydown="restrictInput"
                                   type="password"
                        />
                        </VhField>

                    </div>
                </VhField>






                <VhField label="Attach a company">
                    <AutoComplete v-model="store.item.companies"
                                  value="id"
                                  class="w-full"
                                  @change="store.setCcompany($event)"
                                  option-label="name"
                                  data-testid="contacts-company"
                                  :suggestions="store.company_suggestions"
                                  @complete="store.searchCompanies($event)"
                                  placeholder="Search from existing company"
                                  forceSelection/>



                </VhField>
                <VhField>
                <Button rounded class="">
                    <i @click="store.createCompany()" class="pi pi-plus"></i>
                </Button>
                </VhField>


                <VhField label="Is Active">
                    <InputSwitch v-bind:false-value="0"
                                 v-bind:true-value="1"
                                 class="p-inputswitch-sm"
                                 name="contacts-active"
                                 data-testid="contacts-active"
                                 v-model="store.item.is_active"/>
                </VhField>

            </div>
        </Panel>

    </div>

</template>
