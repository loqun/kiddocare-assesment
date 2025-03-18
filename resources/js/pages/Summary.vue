<template>
    <div v-show="showSummary" class="rounded-lg bg-accent p-6 text-center">
        <div class="mx-auto max-w-2xl rounded-lg border border-border bg-card p-4 shadow-md">
            <h2 class="mb-8 text-center text-3xl font-semibold">Summary Page</h2>

            <!-- Reservation Date -->
            <div class="mb-6">
                <p class="text-lg"><strong>Reservation Date:</strong> {{ computedDate }}</p>
            </div>

            <!-- Address Information -->
            <div class="mb-6">
                <h3 class="mb-3 text-xl font-medium">Address Information</h3>
                <p><strong>Street:</strong> {{ props.address }}</p>
                <p><strong>City:</strong> {{ props.city }}</p>
                <p><strong>State:</strong> {{ props.state }}</p>
                <p><strong>Zip:</strong> {{ props.zipCode }}</p>
            </div>

            <!-- Children Information -->
            <div class="mb-6">
                <h3 class="mb-3 text-xl font-medium">Children Information</h3>
                <ul class="space-y-2">
                    <li v-for="(child, index) in props.children" :key="index" class="rounded-md text-black bg-gray-100 p-3">
                        <span class="font-semibold">{{ child.name }}</span> ({{ child.year }} years {{ child.month }} month)
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-between">
                <button @click="submitReservation" class="rounded-lg bg-blue-600 px-6 py-2 text-white transition hover:bg-blue-700">
                    Submit Reservation
                </button>
                <button @click="goBackToForm" class="rounded-lg bg-gray-500 px-6 py-2 text-white transition hover:bg-gray-600">Back to Form</button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import LoginComponent from '@/components/LoginComponent.vue';
import { SummaryPageProps } from '@/types';
import { computed } from 'vue';

const emit = defineEmits<{
    (e: 'submit'): void;
    (e: 'back'):void
}>();
// computed locale string
const computedDate = computed(() => {
    const date = new Date(props.reservationDateTime);
    return date.toLocaleString();
});

// Define props using the interface
const props = defineProps<SummaryPageProps>();

// Methods
const submitReservation = () => {
    // Logic for submitting reservation
    console.log('Reservation Submitted');
    emit('submit')
};

const goBackToForm = () => {
    // Logic for navigating back to the form
    emit('back')

    console.log('Going back to form');
};



</script>

<style scoped>
/* Add any scoped styles here */
</style>
