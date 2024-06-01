<script setup>
import { watchEffect } from 'vue'
import { useForm } from '@inertiajs/vue3'
import DialogModal from '@/Components/DialogModal.vue'

const props = defineProps({
  show:         Boolean,
  report:       Object,
  canSendEmail: Boolean,
})

const emit = defineEmits(['closeModal'])

const form = useForm({
  id:         null,
  attend:     null,
  studies:    null,
  auxiliary:  false,
  hours:      null,
  remarks:    null,
  send_email: false,
})

function saveReport() {
  form.put(route('report-update', { id: form.id }), {
    preserveScroll: true,
    onSuccess:      () => closeModal(),
  })
}

function closeModal() {
  form.reset()
  emit('closeModal')
}

watchEffect(() => {
  if (props.show && props.report) {
    form.id = props.report.id
    form.attend = props.report.has_been_in_service ? 'YES' : props.report.has_not_been_in_service ? 'NO' : null
    form.studies = props.report.studies
    form.auxiliary = props.report.auxiliary
    form.hours = props.report.hours
    form.remarks = props.report.remarks
    form.send_email = props.report.send_email
  }
})
</script>

<template>
  <DialogModal :show="show" @close="closeModal">
    <template #title>
      {{ __('page.reports.form.headline') }}: {{ report.publisher_name }}
    </template>

    <template #content>
      {{ __('page.reports.form.description') }}

      <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
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

        <div class="form-control w-full">
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

        <div class="form-control w-full sm:col-span-2">
          <label for="remarks" class="label">
            <span class="label-text">{{ __('page.reports.remarks') }}</span>
          </label>
          <input id="remarks" v-model="form.remarks" type="text" class="input input-bordered w-full" :disabled="!form.attend">
        </div>

        <div v-if="canSendEmail" class="form-control self-end sm:col-span-2">
          <label class="label cursor-pointer justify-normal">
            <input v-model="form.send_email" type="checkbox" checked="checked" class="checkbox" :disabled="!report.publisher_email || report.publisher_status === 'INACTIVE'">
            <span class="label-text ml-4">{{ __('common.sendEmail') }}</span>
          </label>
        </div>
      </div>
    </template>

    <template #footer>
      <button class="btn btn-accent" @click="closeModal">
        {{ __('common.cancel') }}
      </button>
      <button class="ms-3 btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing || !form.attend" @click="saveReport">
        {{ __('common.save') }}
      </button>
    </template>
  </DialogModal>
</template>
