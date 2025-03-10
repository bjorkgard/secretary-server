<script setup>
import { ArrowLeftIcon, ArrowRightIcon, PlusIcon, TrashIcon } from '@heroicons/vue/24/solid'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout title="Donationer">
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Donationer
      </h2>
    </template>
    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div>
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
              <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">
                  Donationer/Kostnader {{ $page.props.currentYear }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                  Visar alla donationer och utgifter som varit under året.
                </p>
              </div>
              <div class="h-full flex items-center">
                <Link as="button" :disabled="!$page.props.hasPrevious" :href="route('donations', { year: parseInt($page.props.currentYear) - 1 })" class="ml-2 text-sm text-gray-500 dark:text-gray-400 disabled:cursor-not-allowed disabled:opacity-50" title="Föregående år">
                  <ArrowLeftIcon class="h-6 w-6" />
                </Link>
                <Link as="button" :disabled="!$page.props.hasNext" :href="route('donations', { year: parseInt($page.props.currentYear) + 1 })" class="ml-2 text-sm text-gray-500 dark:text-gray-400 disabled:cursor-not-allowed disabled:opacity-50" title="Nästa år">
                  <ArrowRightIcon class="h-6 w-6" />
                </Link>
              </div>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 w-full">
              <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                  <tr>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Datum
                    </th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Typ
                    </th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right text-xs leading-4 font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Belopp (SEK)
                    </th>
                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right text-xs leading-4 font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider flex justify-end">
                      <Link :href="route('donation.create')" class="text-gray-500 hover:text-indigo-400 dark:text-gray-400 hover:dark:text-indigo-600">
                        <PlusIcon class="h-6 w-6" />
                      </Link>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="donation in $page.props.donations" :key="donation.id">
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500 dark:text-gray-400">
                      {{ donation.date }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500 dark:text-gray-400">
                      {{ donation.description }}
                    </td>
                    <td
                      class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5"
                      :class="{
                        'text-red-500 dark:text-red-700': donation.amount < 0,
                        'text-gray-500 dark:text-gray-400': donation.amount > 0,
                      }"
                    >
                      {{ donation.amount }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium flex justify-end space-x-2">
                      <Link :href="route('donation.destroy', { donation: donation.id })" method="delete" class="text-red-500 hover:text-red-900">
                        <TrashIcon class="h-6 w-6" />
                      </Link>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Totalt
                    </td>
                    <td class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      &nbsp;
                    </td>
                    <td
                      class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right text-xs leading-4 font-bold uppercase tracking-wider"
                      :class="{
                        'text-red-500 dark:text-red-700': $page.props.donations.reduce((acc, donation) => acc + donation.amount, 0) < 0,
                        'text-gray-500 dark:text-gray-400': $page.props.donations.reduce((acc, donation) => acc + donation.amount, 0) > 0,
                      }"
                    >
                      {{ $page.props.donations.reduce((acc, donation) => acc + donation.amount, 0) }}
                    </td>
                    <td class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      &nbsp;
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
