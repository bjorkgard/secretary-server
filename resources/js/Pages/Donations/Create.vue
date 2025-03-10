<script setup>
import { Link, router, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import ActionMessage from '@/Components/ActionMessage.vue'
import FormSection from '@/Components/FormSection.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'

const form = useForm({
  _method:     'POST',
  date:        '',
  type:        'COST',
  description: '',
  amount:      0,
})

function storeDonation() {
  form.post(route('donation.store'), {
    errorBag:       'storeDonationData',
    preserveScroll: true,
  })
}
</script>

<template>
  <AppLayout title="Donationer">
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Lägg till donation/kostnad
      </h2>
    </template>
    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <FormSection @submitted="storeDonation">
          <template #title>
            Donation/Kostnad
          </template>

          <template #description>
            Fyll i formuläret och klicka på Lägg till för att spara.
          </template>

          <template #form>
            <!-- Date -->
            <div class="col-span-6 sm:col-span-3">
              <InputLabel for="date" value="Datum" />
              <input
                id="date"
                v-model="form.date"
                type="date"
                class="input input-bordered mt-1 block w-full"
                required
              >
              <InputError :message="form.errors.date" class="mt-2" />
            </div>

            <!-- Type -->
            <div class="col-span-6 sm:col-span-3">
              <InputLabel for="type" value="Typ" />
              <select
                id="type"
                v-model="form.type"
                class="input input-bordered mt-1 block w-full"
                required
              >
                <option value="COST">
                  Kostnad
                </option>
                <option value="DONATION">
                  Donation
                </option>
              </select>
              <InputError :message="form.errors.type" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="col-span-6 sm:col-span-3">
              <InputLabel for="description" value="Beskrivning" />
              <input
                id="description"
                v-model="form.description"
                class="input input-bordered mt-1 block w-full"
                required
              >
              <InputError :message="form.errors.description" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="col-span-6 sm:col-span-3">
              <InputLabel for="amount" value="Belopp" />
              <input
                id="amount"
                v-model="form.amount"
                type="number"
                class="input input-bordered mt-1 block w-full"
                required
              >
              <InputError :message="form.errors.amount" class="mt-2" />
            </div>
          </template>

          <template #actions>
            <Link type="button" class="btn btn-secondary" :href="route('donations')">
              Avbryt
            </Link>

            <ActionMessage :on="form.recentlySuccessful" class="me-3">
              Sparat
            </ActionMessage>

            <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Lägg till
            </button>
          </template>
        </FormSection>
      </div>
    </div>
  </AppLayout>
</template>
