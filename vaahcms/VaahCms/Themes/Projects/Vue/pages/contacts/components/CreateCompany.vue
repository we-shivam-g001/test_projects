<script setup>
import {useContactStore} from "../../../stores/store-contacts";
import {vaah} from "../../../vaahvue/pinia/vaah";
import {useCompanyStore} from "../../../stores/store-companies";

const store = useContactStore();
const useVaah = vaah();
const store_2 = useCompanyStore();
</script>




<template>
    <Sidebar v-model:visible="store.show_create_company"  header="Create Company" position="right" style="width:480px;">



        <template #header>
            <h2 style="font-weight: bold;" >Create Company</h2>
        </template>
        <div v-if="store && store.item_company && store.contact_id !== null">
            <table class="mb-6 mt-2"  style="width: 100%;">

                <tbody class="p-datatable-tbody">
                <tr style="background-color: #f2f2f2; height: 60px">
                    <td >Attach A Company</td>
                    <td class="mb-5">
                        <AutoComplete v-model="store.item_company.companies"
                                      value="id"
                                      class="w-full"

                                      @change="store.setCcompany($event)"
                                      option-label = "name"
                                      data-testid="company-companies"
                                      :suggestions="store.company_suggestions"
                                      @complete="store.searchCompanies($event)"
                                      placeholder="Search from existing contacts"
                                      forceSelection />
                    </td>
                    <td>
                    <Button class="text-right" @click="store.saveExistingCompany(store.item_company.companies, 'abcd')">Attach</Button>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>



        <hr>
        <div v-if="store.item_company " class=" mt-4 p-datatable p-component p-datatable-responsive-scroll p-datatable-striped p-datatable-sm overflow-auto" >
<!--            <div class="col-5">-->
            <table   v-if="store.item_company ">

                <tbody class="p-datatable-tbody">
                <tr >
                    <td>Name*</td>
                    <td>
                        <InputText class="w-full"
                                   placeholder="Enter company name"
                                   name="companies-name"
                                   data-testid="companies-name"

                                   v-model="store.item_company.name" required/>
                        <div class="required-field hidden"></div>
                    </td>

                </tr>




                <tr >
                    <td>Email*</td>
                    <td>

                        <InputText class="w-full "
                                   v-model="store.item_company.email"
                                   @input="store.validateEmail"
                                   placeholder="Enter Email"
                                   name="companies-email"
                                   data-testid="companies-email"
                                   type="email"
                                   aria-describedby="email-error"
                        />
                        <div class="required-field hidden"></div>

                        <small id="email-error" class="p-error">{{ store.email_error.msg }}</small>
                    </td>

                </tr> <tr >
                    <td>Phone</td>
                    <td>
                        <InputNumber id="number-input"
                                     name="companies-phone"
                                     :useGrouping="false"
                                     data-testid="companies-phone"
                                     v-model="store.item_company.phone"
                                     placeholder="Enter Phone"
                                     class="w-full"/>
                    </td>

                </tr> <tr >
                    <td>Fax Number</td>
                    <td>
                        <InputText class="w-full"
                                   placeholder="Enter Fax Number"
                                   v-model="store.item_company.fax_number"
                                   name="companies-fax"
                                   data-testid="companies-fax"
                        />
                    </td>

                </tr> <tr >
                    <td>Street</td>
                    <td>
                        <InputText class="w-full"
                                   placeholder="Enter Street"
                                   v-model="store.item_company.street"
                                   name="companies-street"
                                   data-testid="companies-street"
                        />
                    </td>

                </tr> <tr >
                    <td>City</td>
                    <td>
                        <InputText
                            name="companies-city"
                            data-testid="companies-city"
                            placeholder="Enter City"
                            class="w-full"
                            v-model="store.item_company.city"/>
                    </td>

                </tr> <tr >
                    <td>Zip  Code</td>
                    <td>
                        <InputText class="w-full"

                                   v-model="store.item_company.zip_code"
                                   name="companies-zip_code"
                                   placeholder="Enter zip Code"
                                   data-testid="companies-zip_code"
                        />
                    </td>

                </tr> <tr >
                    <td>Suite</td>
                    <td>
                        <InputText class="w-full"
                                   name="companies-suite"
                                   data-testid="companies-suite"
                                   placeholder="Enter suite"
                                   v-model="store.item_company.suit"/>
                    </td>

                </tr>
                <tr >
                    <td>Country*</td>
                    <td>

                        <Dropdown
                                  v-model="store.item_company.country"
                                  :options="store.countries"
                                  :editable="true"
                                  optionLabel="name"
                                  optionValue="name"
                                  class="w-full"
                                  id="calling_code"
                                  placeholder="Select country"
                                  name="account-country_calling_code"
                                  data-testid="account-country_calling_code"
                        />
                    </td>

                </tr><tr >
                    <td>Attach a contact</td>
                    <td>
                        <AutoComplete v-model="store.item_company.contacts"
                                      value="id"
                                      class="w-full"

                                      option-label = "first_name"
                                      data-testid="warehouses-country"
                                      :suggestions="store_2.contact_suggestions"
                                      @complete="store_2.searchContacts($event)"

                                      placeholder="Search from existing contacts"
                                      forceSelection />
                    </td>

                </tr>
                <tr >
                    <td>Is Active</td>
                    <td>
                        <div class="flex flex-row">
                            <div >
                                <div class="p-selectbutton p-buttonset p-component" role="group" aria-labelledby="single" style="box-shadow: none;">
                                    <div role="radio" class="p-button p-component" :class="store.item_company.is_active == 0 ? 'bg-green-400 text-white' : ''">
                                        <span data-testid="productvendors-can_update" name="productvendors-can_update" class="p-button-label" @click="store.item_company.is_active = 0">No</span>
                                        <span class="p-ink" role="presentation" aria-hidden="true"></span>
                                    </div>
                                    <div role="radio" class="p-button p-component"  :class="store.item_company.is_active == 1 ? 'bg-green-400 p-highlight' : ''">
                                        <span data-testid="productvendors-can_update" name="productvendors-can_update" class="p-button-label" @click="store.item_company.is_active = 1">Yes</span>
                                        <span class="p-ink" role="presentation" aria-hidden="true"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
                </tbody>
            </table>
<!--            </div>-->
        </div>



<!--        <div v-if="!store.item.companies || store.item.companies.length === 0">-->
            <div style="display: flex; justify-content: flex-end;">
                <Button class="text-right" @click="store.saveCompany(store.item_company)">Create</Button>
            </div>
<!--        </div>-->

    </Sidebar>
</template>



<style scoped>

</style>
