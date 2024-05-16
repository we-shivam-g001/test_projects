<script setup>
import {useCompanyStore} from "../../../stores/store-companies";
import {useContactStore} from "../../../stores/store-contacts";
import {vaah} from "../../../vaahvue/pinia/vaah";
import {computed, ref, watch} from "vue";

const store = useCompanyStore();
const store_2=useContactStore();
const useVaah = vaah();

// const password = ref('');
const calculateTotalAmount = computed(() => {
    let totalAmount = parseFloat(store.item_contact.max_discount_amount) || 0;
    let discountAmount = totalAmount * (parseFloat(store.item_contact.discount_percentage) / 100);
    let discountedTotal = totalAmount - discountAmount;
    let taxAmount = discountedTotal * (parseFloat(store.item_contact.tax_rate) / 100);
    let total = discountedTotal + taxAmount;
    return total.toFixed(2);
});

const updateTotalAmount = () => {
    store.item_contact.total_amount = calculateTotalAmount.value;
};

// watch(() => [store.item_contact.max_discount_amount, store.item_contact.discount_percentage, store.item_contact.tax_rate], () => {
//     updateTotalAmount();
// });

watch(() => {
    const { item_contact } = store;
    return item_contact ? [item_contact.max_discount_amount, item_contact.discount_percentage, item_contact.tax_rate] : [];
}, () => {
    updateTotalAmount();
});


const restrictInput = (event) => {
    const inputField = document.querySelector('#numbers-only');
    if (isNaN(event.key) && event.key !== 'Backspace') {
        event.preventDefault();
    }
};
</script>



<template>
    <Sidebar v-model:visible="store.show_create_contact"  header="Create Contact" position="right" style="width:480px;">



        <template #header>
            <h2 style="font-weight: bold;" >Create Contact</h2>
        </template>

        <table v-if="store && store.item_contact" class="mb-6 mt-2" style="width: 100%;">
            <tbody class="p-datatable-tbody" >
            <tr style="background-color: #f2f2f2; height: 60px">
                <td>Attach A Contact</td>
                <td class="mb-5">
                    <AutoComplete v-model="store.item_contact.contacts"
                                  value="id"
                                  class="w-full"
                                  @change="store.setContact($event)"
                                  option-label="first_name"
                                  data-testid="warehouses-country"
                                  :suggestions="store.contact_suggestions"
                                  @complete="store.searchContacts($event)"
                                  placeholder="Search from existing contacts"
                                  forceSelection />
                </td>
                <td>
                    <Button class="text-right" @click="store.saveExistingContact(store.item_contact.contacts)">Attach</Button>
                </td>
            </tr>
            </tbody>
        </table>


        <hr>
        <div v-if="store.item_contact " class=" mt-4 p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm overflow-auto" style="height:600px">

            <table  v-if="store.item_contact ">

                <tbody class="p-datatable-tbody">
                <tr >
                    <td>First Name*</td>
                    <td>
                        <InputText id="contact-first-name"
class="w-full"
                                   v-model="store.item_contact.first_name"
                                   name="contact-first_name"
                                   placeholder="Enter first name"
                                   data-testid="contact-first_name" />
                    </td>

                </tr>

                <tr >
                    <td>Middle Name</td>
                    <td>
                        <InputText
                            class="w-full"
                            v-model="store.item_contact.middle_name"
                            placeholder="Enter middle name"
                            name="contact-middle_name"
                            data-testid="contact-middle_name"
                        />
                    </td>

                </tr>



                <tr >
                    <td>Last Name*</td>
                    <td>
                        <InputText
                            v-model="store.item_contact.last_name"
                            name="contacts-last_name"
                            class="w-full"
                            placeholder="Enter last name"
                            data-testid="contacts-last_name"
                        />
                    </td>

                </tr> <tr >
                    <td>Email*</td>
                    <td>
                        <InputText :class=" store.email_error.class"
                                   v-model="store.item_contact.email"
                                   @input="store.validateEmail"
                                   name="contacts-email"
                                   class="w-full"
                                   data-testid="contacts-email"
                                   placeholder="Enter email"
                                   type="email"
                                   aria-describedby="email-error"
                        />
                        <small id="email-error" class="p-error">{{ store.email_error.msg }}</small>
                    </td>

                </tr> <tr >
                    <td>Phone*</td>
                    <td>
                        <InputNumber id="number-input"
                                     name="contacts-phone"
                                     :useGrouping="false"
                                     class="w-full"
                                     data-testid="contacts-phone"
                                     v-model="store.item_contact.phone"
                                     placeholder="Enter phone"
                        />
                    </td>

                </tr> <tr >
                    <td>Fax Number</td>
                    <td>
                        <InputText
                            placeholder="Enter fax number"
                            v-model="store.item_contact.fax_number"
                            name="contacts-fax"
                            class="w-full"
                            data-testid="contacts-fax"
                        />
                    </td>

                </tr> <tr >
                    <td>Street</td>
                    <td>
                        <InputText
                            placeholder="Enter street"
                            v-model="store.item_contact.street"
                            name="contacts-street"
                            class="w-full"
                            data-testid="contacts-street"
                        />
                    </td>

                </tr> <tr >
                    <td>City</td>
                    <td>
                        <InputText
                            name="contacts-city"
                            class="w-full"
                            data-testid="contacts-city"
                            placeholder="Enter city"
                            v-model="store.item_contact.city"/>
                    </td>

                </tr> <tr >
                    <td>Zip  Code</td>
                    <td>
                        <InputText

                            v-model="store.item_contact.zip_code"
                            name="contacts-zip_code"
                            class="w-full"
                            placeholder="Enter zip code"
                            data-testid="contacts-zip_code"
                        />
                    </td>

                </tr> <tr >
                    <td>Suite</td>
                    <td>
                        <InputText
                            name="contacts-suite"
                            class="w-full"
                            data-testid="contacts-suite"
                            placeholder="Enter suite"
                            v-model="store.item_contact.suit"/>
                    </td>

                </tr> <tr >
                    <td>State</td>
                    <td>
                        <InputText
                            name="contacts-state"
                            class="w-full"
                            data-testid="contacts-state"
                            placeholder="Enter state"
                            v-model="store.item_contact.state"/>
                    </td>

                </tr>

                <tr >
                    <td>Country*</td>
                    <td>
                        <Dropdown
                                  v-model="store.item_contact.country"
                                  :options="store.countries"
                                  :editable="true"
                                  optionLabel="name"
                                  optionValue="name"
                                  id="calling_code"
                                  placeholder="Select country"
                                  class="w-full"
                                  name="contacts-country"
                                  data-testid="contacts-country"
                        />
                    </td>

                </tr>
                <tr >
                    <td>Credit Limit</td>
                    <td>
                        <InputNumber
                            :step="0.01"
                            :minFractionDigits="2"
                            :useGrouping="false"
                            class="w-full"
                            name="warehouses-state"
                            data-testid="warehouses-state"
                            placeholder="Enter credit limit"
                            v-model="store.item_contact.credit_limit"
                        />
                    </td>

                </tr>

                <tr >
                    <td>Sales Tax %</td>
                    <td>
                        <InputText
                            name="contacts-tax_percent"
                            data-testid="contacts-tax_percent"
                            placeholder="Enter tax"
                            class="w-full"
                            @input="updateTotalAmount"
                            v-model="store.item_contact.tax_rate"/>
                    </td>

                </tr>
                <tr >
                    <td>Discount Percent</td>
                    <td>
                        <InputGroup class="flex ">
                            <span class="p-inputgroup-addon w-1rem h-2rem">%</span>
                            <InputNumber
                                name="contacts-discount-percent"
                                @input="updateTotalAmount"
                                data-testid="contacts-discount-percent"
                                placeholder="Enter discount"
                                v-model="store.item_contact.discount_percentage"
                                :max="100"
                                :step="0.01"
                                class="w-full h-2rem"
                                :minFractionDigits="2"
                                :useGrouping="false"
                            />
                        </InputGroup>
                    </td>

                </tr>
                <tr >
                    <td>Maximum Amount</td>
                    <td>
                        <InputGroup class="flex ">
                            <span class="p-inputgroup-addon w-1rem h-2rem">$</span>
                            <InputNumber
                                @input="updateTotalAmount"
                                name="contacts-discount-amount"
                                data-testid="contacts-discount-amount"
                                placeholder="Enter amount" class="w-full h-2rem"
                                v-model="store.item_contact.max_discount_amount"
                            />
                        </InputGroup>
                    </td>

                </tr>

<!--<tr>-->
<!--    <td>Discount Percent</td>-->
<!--    <td>-->
<!--&lt;!&ndash;        <VhField label="Discount Percent" class="flex">&ndash;&gt;-->
<!--            <div class="flex items-center w-full">-->
<!--                <InputGroup class="flex ">-->
<!--                    <span class="p-inputgroup-addon w-1rem">%</span>-->
<!--                    <InputNumber-->
<!--                        name="contacts-discount-percent"-->
<!--                        @input="updateTotalAmount"-->
<!--                        data-testid="contacts-discount-percent"-->
<!--                        placeholder="Enter discount"-->
<!--                        v-model="store.item_contact.discount_percentage"-->
<!--                        :max="100"-->
<!--                        :step="0.01"-->

<!--                        :minFractionDigits="2"-->
<!--                        :useGrouping="false"-->
<!--                    />-->
<!--                </InputGroup>-->
<!--                <div class="flex items-center w-full">-->
<!--                    <div class="flex mt-2">Maximum</div>-->
<!--                    <InputGroup class="flex ">-->
<!--                        <span class="p-inputgroup-addon w-1rem ml-2">$</span>-->
<!--                        <InputNumber-->
<!--                            @input="updateTotalAmount"-->
<!--                            name="contacts-discount-amount"-->
<!--                            data-testid="contacts-discount-amount"-->
<!--                            placeholder="Enter amount"-->
<!--                            v-model="store.item_contact.max_discount_amount"-->
<!--                        />-->
<!--                    </InputGroup>-->
<!--                </div>-->
<!--            </div>-->
<!--&lt;!&ndash;        </VhField>&ndash;&gt;-->
<!--    </td>-->
<!--</tr>-->




                <tr >
                    <td>Tax Payer</td>
                    <td>
                        <div class="flex flex-row align-items-center">
<!--                            <div class="col-4">-->
                            <div>
                                <div class="p-selectbutton p-buttonset p-component" role="group" aria-labelledby="single" style="box-shadow: none;">
                                    <div role="radio" class="p-button p-component" :class="store.item_contact.is_tax_payer == 0 ? 'bg-green-400 text-white' : ''">
                                        <span data-testid="contacts-is_tax_payer" name="productvendors-can_update" class="p-button-label" @click="store.item_contact.is_tax_payer = 0">No</span>
                                        <span class="p-ink" role="presentation" aria-hidden="true"></span>
                                    </div>
                                    <div role="radio" class="p-button p-component"  :class="store.item_contact.is_tax_payer == 1 ? 'bg-green-400 p-highlight' : ''">
                                        <span data-testid="contacts-is_tax_payer" name="productvendors-can_update" class="p-button-label" @click="store.item_contact.is_tax_payer = 1">Yes</span>
                                        <span class="p-ink" role="presentation" aria-hidden="true"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr><tr >
                    <td>Tax Id</td>
                    <td>
                        <InputText
                            type="number"
                            class="w-full"
                            v-model="store.item_contact.tax_id"
                            name="contacts-tax_id"
                            placeholder="Enter tax id"
                            data-testid="contacts-tax_id"
                        />
                    </td>

                </tr><tr >
                    <td>Validation Date</td>
                    <td>
                        <Calendar
                            id="dob"
                            inputId="basic"
                            class="w-full"
                            v-model="store.item_contact.validation_date"
                            autocomplete="off"
                            name="account-birth"
                            placeholder="Enter validation date"
                            data-testid="contacts-validation_date"
                            dateFormat="yy-mm-dd"
                            :showTime="false"
                        />
                    </td>

                </tr>

                <tr >
                    <td>Validated By</td>
                    <td>
                        <AutoComplete
                            value="id"
                            v-model="store.item_contact.added_by_user"
                            @change="store_2.setAddedBy($event)"
                            class="w-full"
                            name="contact-added_by"
                            id="added_by"
                            data-testid="contacts-added_by"
                            :suggestions="store_2.active_users_list"
                            @complete="store_2.searchAddedBy($event)"
                            placeholder="Validated by"
                            :dropdown="true"
                            optionLabel="first_name"
                            forceSelection>
                        </AutoComplete>
                    </td>

                </tr>

                <tr >
                    <td>Payment Terms*</td>
                    <td>
                        <InputText v-model="store.item_contact.payment_terms"
                                   data-testid="contacts-payment_note"
                                   :autoResize="true"
                                   class="w-full"
                                   placeholder="Enter payment terms"/>
                    </td>

                </tr>
                <tr >
                    <td>Comments</td>
                    <td>
                         <Textarea v-model="store.item_contact.comments"
                                   data-testid="contacts-comment"
                                   :autoResize="true"
                                   rows="3"
                                   class="w-full"
                                   placeholder="Enter comment"/>
                    </td>

                </tr>
                <tr >
                    <td>Credit Card No</td>
                    <td>

                        <InputMask id="ssn"  v-model="store.item_contact.credit_card_number " mask="9999-9999-9999-9999" class="w-full" placeholder="Enter credit card no" />
                    </td>


                </tr>
                <tr >
                    <td>Expiry Date</td>

<!--                    <VhField label="Expiry Date" class="flex">-->
                        <div class="flex items-center w-full ml-2">
<!--                            <VhField>-->
                                <div class="flex ">
                                <Dropdown v-model="store.item_contact.expires_month" :options="store.months" optionLabel="name"
                                          optionValue="code" placeholder="--mm--"  class="w-7rem" style="margin-left: 3px"/>
                                <Dropdown v-model="store.item_contact.expires_year" :options="store.years"
                                          placeholder="--year--"  class="w-7rem"/>
                            </div>
<!--                            </VhField>-->
<!--                            <VhField>-->
<!--&lt;!&ndash;                            <label class="mt-2">CVV</label>&ndash;&gt;-->
<!--                            <InputText id="numbers-only"-->
<!--                                       v-model="store.item_contact.cvv"-->
<!--                                       name="contacts-cvv"-->
<!--                                       placeholder="Enter cvv" class="w-6rem" style="height: 30px; margin-left:4px"-->
<!--                                       data-testid="contacts-cvv"-->
<!--                                       @keydown="restrictInput"-->
<!--                                       type="password"-->
<!--                            />-->
<!--                            </VhField>-->

                        </div>

<!--                    </VhField>-->

                </tr>

                <tr >
                    <td>Attach A Company</td>
                    <td>
                        <InputText id="numbers-only"
                                   v-model="store.item_contact.cvv"
                                   name="contacts-cvv"
                                   placeholder="Enter cvv" class="full"
                                   data-testid="contacts-cvv"
                                   @keydown="restrictInput"
                                   type="password"
                        />
                    </td>

                </tr>

                <tr >
                    <td>Attach A Company</td>
                    <td>
                        <AutoComplete v-model="store.item_contact.companies"
                                      value="id"
                                      option-label = "name"
                                      class="w-full"
                                      data-testid="contacts-existing_company"
                                      :suggestions="store_2.company_suggestions"
                                      @complete="store_2.searchCompanies($event)"
                                      placeholder="Search from existing company"
                                      forceSelection />
                    </td>

                </tr><tr >
                    <td>Is Active</td>
                    <td>
                        <InputSwitch v-bind:false-value="0"
                                     v-bind:true-value="1"
                                     class="p-inputswitch-sm"
                                     name="contacts-active"
                                     data-testid="contacts-active"
                                     v-model="store.item_contact.is_active"/>
                    </td>

                </tr>

                </tbody>
            </table>

        </div>



<!--        <div v-if="!store.item.contacts || store.item.contacts.length === 0">-->
        <div style="display: flex; justify-content: flex-end;" class="mt-2 mr-1">
            <Button @click="store.createContact(store.item_contact)">Create</Button>
        </div>
<!--        </div>-->
<!--        <div v-else>-->

<!--        </div>-->
    </Sidebar>
</template>



<style scoped>

</style>
