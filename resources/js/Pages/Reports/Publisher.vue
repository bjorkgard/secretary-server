<script setup>
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps({
  report: Object,
})

const showToast = ref(false)

const form = useForm({
  id: props.report.id,
  attend: props.report.has_been_in_service ? 'YES' : props.report.has_not_been_in_service ? 'NO' : null,
  studies: props.report.studies,
  auxiliary: props.report.auxiliary,
  hours: props.report.hours,
  remarks: props.report.remarks,
})

function showSuccessToast() {
  showToast.value = true

  setTimeout(() => {
    showToast.value = false
  }, 15000)
}

function saveReport() {
  form.put(route('report.update', { id: form.id }), {
    preserveScroll: true,
    onSuccess: () => showSuccessToast(),
  })
}
</script>

<template>
  <Head :title="__('page.reports.publisher.title')" />

  <div class="isolate px-6 py-24 sm:py-32 lg:px-8">
    <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]" aria-hidden="true">
      <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
    </div>

    <div v-if="showToast" class="toast toast-center toast-middle">
      <div class="alert alert-success">
        <span>{{ __('page.reports.form.successfull') }}</span>
      </div>
    </div>

    <div class="mx-auto max-w-2xl text-center">
      <h1 class="text-3xl font-black tracking-tight text-gray-900 sm:text-4xl dark:text-slate-300">
        {{ __('page.reports.form.headline') }}: {{ report.publisher_name }}
      </h1>
      <p class="mt-2 text-lg leading-8 text-gray-600 dark:text-slate-300">
        {{ __('page.reports.form.publisherDescription') }}
      </p>
    </div>
    <div class="mx-auto mt-16 max-w-xl sm:mt-20">
      <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">{{ __('page.reports.attend') }}</span>
          </label>
          <select v-model="form.attend" class="select select-bordered">
            <option disabled :value="null">
              {{ __('common.select') }}
            </option>
            <option value="YES">
              {{ __('common.yes') }}
            </option>
            <option value="NO">
              {{ __('common.no') }}
            </option>
          </select>
        </div>

        <div className="form-control w-full">
          <label for="studies" class="label">
            <span class="label-text">{{ __('page.reports.studies') }}</span>
          </label>
          <input id="studies" v-model="form.studies" type="number" class="input input-bordered w-full" :disabled="form.attend !== 'YES'">
        </div>

        <div class="form-control self-end">
          <label class="label cursor-pointer justify-normal">
            <input v-model="form.auxiliary" type="checkbox" checked="checked" class="checkbox" :disabled="form.attend !== 'YES' || report.type !== 'PUBLISHER'">
            <span class="label-text ml-4">{{ __('common.auxiliary') }}</span>
          </label>
        </div>

        <div class="form-control w-full">
          <label for="hours" class="label">
            <span class="label-text">{{ __('page.reports.hours') }}</span>
          </label>
          <input id="hours" v-model="form.hours" type="number" class="input input-bordered w-full" :disabled="form.attend !== 'YES' || (!form.auxiliary && report.type === 'PUBLISHER')">
        </div>

        <div class="form-control w-full col-span-1 sm:col-span-2">
          <label for="remarks" class="label">
            <span class="label-text">{{ __('page.reports.remarks') }}</span>
          </label>
          <input id="remarks" v-model="form.remarks" type="text" class="input input-bordered w-full" :disabled="!form.attend">
        </div>
      </div>

      <div class="mt-10">
        <button type="button" class="w-full btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing || !form.attend" @click="saveReport">
          {{ __('common.send') }}
        </button>
      </div>
    </div>
  </div>
</template>
