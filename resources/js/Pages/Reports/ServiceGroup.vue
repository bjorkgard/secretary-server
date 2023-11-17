<script setup>
    import { ref } from 'vue';
    import { Head } from '@inertiajs/vue3';
    import { CheckIcon, XMarkIcon } from '@heroicons/vue/24/solid'
    import ReportDialog from '@/Pages/Reports/Partials/ReportDialog.vue';

    const showingReportDialog = ref(false);
    const activeReport = ref(null);

    const props = defineProps({
        congregation: Object,
        serviceGroup: Object,
    });

    const showReportDialog = (id) => {
        activeReport.value = props.serviceGroup.reports.find(report => report.id === id)
        showingReportDialog.value = true
    }

    const onCloseModal = () => {
        showingReportDialog.value = false;
    };
</script>

<template>
    <Head :title="__('page.reports.serviceGroup.title')" />

    <div class="sm:flex sm:justify-center sm:items-center min-h-screen bg-gray-100 dark:bg-gray-900 dark:text-white">
        <div class="flex flex-col p-8 w-full h-full">

            <div class="flex justify-between">
                <div>
                    <h1 class="font-extrabold text-xl">{{__('page.reports.headline')}}</h1>
                    <p>{{__('page.reports.description')}}</p>
                </div>

            </div>

            <div class="h-full mt-4">
                <table class="table table-lg table-pin-rows table-pin-cols">
                    <thead>
                        <tr class="dark:border-b dark:border-sky-900">
                            <th></th>
                            <td>{{__('page.reports.attend')}}</td>
                            <td>{{__('page.reports.studies')}}</td>
                            <td>{{__('page.reports.auxiliary')}}</td>
                            <td>{{__('page.reports.hours')}}</td>
                            <td>{{__('page.reports.remarks')}}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="report in serviceGroup.reports" :class="{'bg-blue-200 dark:bg-sky-800':report.publisher_status === 'INACTIVE'}" class="cursor-pointer dark:border-b dark:border-sky-900" @click="showReportDialog(report.id)">
                            <th :class="{'text-blue-500 bg-blue-100 dark:bg-sky-900 dark:text-sky-100':report.publisher_status === 'INACTIVE'}">{{report.publisher_name}}</th>
                            <td>
                                <CheckIcon v-if="report.has_been_in_service" class="h-6 w-6 text-green-500" />
                                <XMarkIcon v-if="report.has_not_been_in_service" class="h-6 w-6 text-red-500" />
                            </td>
                            <td>{{report.studies}}</td>
                            <td><CheckIcon v-if="report.auxiliary" class="h-6 w-6 text-green-500" /></td>
                            <td>{{report.hours}}</td>
                            <td>{{report.remarks}}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{__('page.reports.total')}}</th>
                            <td>{{serviceGroup.reports.reduce((a, b) => a + b.has_been_in_service, 0)}}</td>
                            <td>{{serviceGroup.reports.reduce((a, b) => a + b.studies, 0)}}</td>
                            <td>{{serviceGroup.reports.reduce((a, b) => a + b.auxiliary, 0)}}</td>
                            <td>{{serviceGroup.reports.reduce((a, b) => a + b.hours, 0)}}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <ReportDialog :show="showingReportDialog" :report="activeReport" @closeModal="onCloseModal" />
    </div>
</template>

<style>

</style>
