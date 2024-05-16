<script setup>
import {onMounted, ref, watch} from "vue";
import { useCompanyStore } from '../../stores/store-companies'

import VhField from './../../vaahvue/vue-three/primeflex/VhField.vue'
import {useRoute} from 'vue-router';


const store = useCompanyStore();
const route = useRoute();

onMounted(async () => {
    /**
     * Fetch the record from the database
     */
    if((!store.item || Object.keys(store.item).length < 1)
            && route.params && route.params.id)
    {
    }

    await store.getFormMenu();
});

//--------form_menu
const form_menu = ref();
const toggleFormMenu = (event) => {
    form_menu.value.toggle(event);
};
//--------/form_menu

</script>
<template>

    <div class="col-6" >

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
                            data-testid="companies-view_item"
                            @click="store.toView(store.item)"
                            icon="pi pi-eye"/>

                    <Button label="Save"
                            class="p-button-sm"
                            v-if="store.item && store.item.id"
                            data-testid="companies-save"
                            @click="store.itemAction('save')"
                            icon="pi pi-save"/>

                    <Button label="Create & New"
                            v-else
                            @click="store.itemAction('create-and-new')"
                            class="p-button-sm"
                            data-testid="companies-create-and-new"
                            icon="pi pi-save"/>


                    <!--form_menu-->
                    <Button
                        type="button"
                        @click="toggleFormMenu"
                        class="p-button-sm"
                        data-testid="companies-form-menu"
                        icon="pi pi-angle-down"
                        aria-haspopup="true"/>

                    <Menu ref="form_menu"
                          :model="store.form_menu_list"
                          :popup="true" />
                    <!--/form_menu-->


                    <Button class="p-button-primary p-button-sm"
                            icon="pi pi-times"
                            data-testid="companies-to-list"
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
                            Deleted {{store.item.deleted_at}}
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


                <VhField label="Name*">
                    <div class="p-inputgroup">
                        <InputText class="w-full"
                                   placeholder="Enter the company name"
                                   name="companies-name"
                                   data-testid="companies-name"
                                   @update:modelValue="store.watchItem"
                                   v-model="store.item.name" required/>
<!--                        <div class="required-field hidden"></div>-->
                    </div>
                </VhField>

                <VhField label="Email Address*">
                    <div class="p-inputgroup">
                    <InputText class="w-full"
                               v-model="store.item.email"
                               @input="store.validateEmail"
                               placeholder="Enter email"
                               name="companies-email"
                               data-testid="companies-email"
                               type="email"
                               aria-describedby="email-error"
                    />
                    <div class="required-field hidden"></div>
                    </div>
                    <small id="email-error" class="p-error">{{ store.email_error.msg }}</small>
                </VhField>
                <VhField label="Phone*">

                        <InputNumber id="number-input"
                                     name="companies-phone"
                                     :useGrouping="false"
                                     data-testid="companies-phone"
                                     v-model="store.item.phone"
                                     placeholder="Enter phone"
                                     class="w-full"/>
                </VhField>

                <VhField label="Fax Number" >
                    <div class="p-inputgroup">
                    <InputText class="w-full"
                               placeholder="Enter fax number"
                               v-model="store.item.fax_number"
                               name="companies-fax"
                               data-testid="companies-fax"
                    />
                    </div>
                </VhField>
                <VhField label="Street" >
                    <div class="p-inputgroup">
                    <InputText class="w-full"
                               placeholder="Enter street"
                               v-model="store.item.street"
                               name="companies-street"
                               data-testid="companies-street"
                    />
                    </div>
                </VhField>
                <VhField label="City">
                    <div class="p-inputgroup">
                    <InputText class="w-full"
                               name="companies-city"
                               data-testid="companies-city"
                               placeholder="Enter city"
                               v-model="store.item.city"/>
                    </div>
                </VhField>

                <VhField label="Zip Code">
                    <div class="p-inputgroup">


                        <InputText class="w-full"

                                   v-model="store.item.zip_code"
                                   name="companies-zip_code"
                                   placeholder="Enter zip code"
                                   data-testid="companies-zip_code"
                        />
                    </div>
                </VhField>

                <VhField label="Suite">
                    <div class="p-inputgroup">
                        <InputText class="w-full"
                                   name="companies-suite"
                                   data-testid="companies-suite"
                                   placeholder="Enter suite"
                                   v-model="store.item.suit"/>
                    </div>
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
                              name="companies-country_calling_code"
                              data-testid="companies-country_calling_code"
                    />
                </VhField>


                <VhField label="Attach a contact">
                    <AutoComplete v-model="store.item.contacts"
                                  value="id"
                                  class="w-full"
                                  @change="store.setContact($event)"
                                  option-label = "first_name"
                                  data-testid="companies-contact"
                                  :suggestions="store.contact_suggestions"
                                  @complete="store.searchContacts($event)"

                                  placeholder="Search from existing contacts"
                                  forceSelection />
                </VhField>





                <VhField label="Is Active">
                    <div class="flex flex-row">
                        <div class="col-4">
                            <div class="p-selectbutton p-buttonset p-component" role="group" aria-labelledby="single" style="box-shadow: none;">
                                <div role="radio" class="p-button p-component" :class="store.item.is_active == 0 ? 'bg-green-400 text-white' : ''">
                                    <span data-testid="companies-can_update" name="companies-can_update" class="p-button-label" @click="store.item.is_active = 0">No</span>
                                    <span class="p-ink" role="presentation" aria-hidden="true"></span>
                                </div>
                                <div role="radio" class="p-button p-component"  :class="store.item.is_active == 1 ? 'bg-green-400 p-highlight' : ''">
                                    <span data-testid="companies-can_update" name="companies-can_update" class="p-button-label" @click="store.item.is_active = 1">Yes</span>
                                    <span class="p-ink" role="presentation" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </VhField>


            </div>
        </Panel>

    </div>

</template>
