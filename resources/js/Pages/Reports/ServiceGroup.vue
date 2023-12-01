<script setup>
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import { CheckIcon, XMarkIcon } from '@heroicons/vue/24/solid'
import { EnvelopeIcon, PaperAirplaneIcon } from '@heroicons/vue/20/solid'
import ReportDialog from '@/Pages/Reports/Partials/ReportDialog.vue'

const props = defineProps({
  congregation: Object,
  serviceGroup: Object,
})
const showingReportDialog = ref(false)
const activeReport = ref(null)
const showToast = ref(false)
const toastMessage = ref('')

const form = useForm({
  sendEmail: true,
})

function showToastMessage(message) {
  toastMessage.value = message
  showToast.value = true

  setTimeout(() => {
    showToast.value = false
  }, 5000)
}

function sendEmail(id) {
  form.put(route('report.send-email', id), {
    preserveScroll: true,
    onSuccess: () => {
      showToastMessage('page.reports.emailSent')
    },
    onError: () => {
      showToastMessage('page.reports.emailNotSent')
    },
  })
}

function showReportDialog(id) {
  activeReport.value = props.serviceGroup.reports.find(report => report.id === id)
  showingReportDialog.value = true
}

function onCloseModal() {
  showingReportDialog.value = false
}
</script>

<template>
  <Head :title="__('page.reports.serviceGroup.title')" />

  <div class="sm:flex sm:justify-center sm:items-center min-h-screen bg-gray-100 dark:bg-gray-900 dark:text-white">
    <div v-if="showToast" class="toast toast-top toast-end z-50">
      <div class="alert alert-success">
        <span>{{ __(toastMessage) }}</span>
      </div>
    </div>
    <div class="flex flex-col p-8 w-full h-full">
      <div class="flex justify-between">
        <div>
          <h1 class="font-extrabold text-xl">
            {{ __('page.reports.headline') }}
          </h1>
          <p>
            <span>
              {{ __('page.reports.description1') }}
            </span>
            <span v-if="congregation.send_publisher_reports">
              <br>
              {{ __('page.reports.description2') }}
            </span>
            <span v-if="congregation.send_publisher_reports">
              <br>
              {{ __('page.reports.description3') }}
            </span>
          </p>
        </div>
      </div>

      <div class="h-full mt-4">
        <table class="table table-lg table-pin-rows table-pin-cols">
          <thead>
            <tr class="dark:border-b dark:border-sky-900">
              <th />
              <td>{{ __('page.reports.attend') }}</td>
              <td>{{ __('page.reports.studies') }}</td>
              <td>{{ __('page.reports.auxiliary') }}</td>
              <td>{{ __('page.reports.hours') }}</td>
              <td>{{ __('page.reports.remarks') }}</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="report in serviceGroup.reports" :key="report.id" :class="{ 'bg-blue-200 dark:bg-sky-800': report.publisher_status === 'INACTIVE' }" class="cursor-pointer dark:border-b dark:border-sky-900" @click="showReportDialog(report.id)">
              <th class="flex justify-between" :class="{ 'text-blue-500 bg-blue-100 dark:bg-sky-900 dark:text-sky-100': report.publisher_status === 'INACTIVE' }">
                <div class="flex">
                  <div v-if="congregation.send_publisher_reports" class="tooltip tooltip-right" :data-tip="__('page.reports.hasSendEmail')">
                    <EnvelopeIcon v-if="report.send_email" class="h-5 w-5 text-blue-500 mr-2" @click.stop.prevent="sendEmail(report.id)" />
                  </div>
                  <span>
                    {{ report.publisher_name }}
                    <div v-if="report.name !== serviceGroup.month" class="text-xs italic -mt-3"><br>{{ __(`month.${report.name}`) }}</div>
                  </span>
                </div>
                <div v-if="congregation.send_publisher_reports" class="tooltip tooltip-right" :data-tip="__('page.reports.sendEmail')">
                  <PaperAirplaneIcon v-if="report.publisher_email && report.publisher_status !== 'INACTIVE'" class="h-5 w-5 text-blue-500" @click.stop.prevent="sendEmail(report.id)" />
                </div>
              </th>
              <td>
                <CheckIcon v-if="report.has_been_in_service" class="h-6 w-6 text-green-500" />
                <XMarkIcon v-if="report.has_not_been_in_service" class="h-6 w-6 text-red-500" />
              </td>
              <td>{{ report.studies }}</td>
              <td><CheckIcon v-if="report.auxiliary" class="h-6 w-6 text-green-500" /></td>
              <td>{{ report.hours }}</td>
              <td>{{ report.remarks }}</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th>{{ __('page.reports.total') }}</th>
              <td>{{ serviceGroup.reports.reduce((a, b) => a + b.has_been_in_service, 0) }}</td>
              <td>{{ serviceGroup.reports.reduce((a, b) => a + b.studies, 0) }}</td>
              <td>{{ serviceGroup.reports.reduce((a, b) => a + b.auxiliary, 0) }}</td>
              <td>{{ serviceGroup.reports.reduce((a, b) => a + b.hours, 0) }}</td>
              <td />
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    <ReportDialog :can-send-email="congregation.send_publisher_reports" :show="showingReportDialog" :report="activeReport" @close-modal="onCloseModal" />
  </div>
</template>

<style>

</style>
