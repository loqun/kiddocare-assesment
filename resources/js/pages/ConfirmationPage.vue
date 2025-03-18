<template>
    <div class="mx-auto max-w-4xl py-8 space-y-8">
        <LoginComponent></LoginComponent>

        <!-- Booking Confirmation -->
        <div v-if="isSubmitForm" class="rounded-lg bg-white p-6 shadow-lg">
            <h1 class="text-center text-3xl font-semibold text-gray-800">Booking Confirmation</h1>

            <!-- Success Message -->
            <div class="mt-4 text-center">
                <p class="font-semibold text-green-600 text-lg">Your booking has been confirmed!</p>
            </div>

            <!-- Booking Details -->
            <div class="mt-6 space-y-3 text-gray-700">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Your Booking Details</h2>
                <p><strong>Booking Number:</strong> {{ booking.booking_no }}</p>
                <p><strong>Address:</strong> {{ booking.street_address }}</p>
                <p><strong>City:</strong> {{ booking.city }}</p>
                <p><strong>Zip Code:</strong> {{ booking.zip_code }}</p>
                <p><strong>State:</strong> {{ booking.state }}</p>
                <p><strong>Booking Time:</strong> {{ formattedTime(booking.reservation_datetime) }}</p>
                
                <!-- Children Information -->
                <div class="mt-4">
                    <h3 class="text-lg font-semibold text-gray-800">Children Information</h3>
                    <ul v-if="booking.children?.length" class="list-disc pl-5 space-y-1">
                        <li v-for="child in booking.children" :key="child.id">
                            {{ child.name }} ({{ child.age }} year {{ child.month }} month)
                        </li>
                    </ul>
                    <p v-else class="text-gray-500">No children added.</p>
                </div>
            </div>
        </div>

        <!-- History Bookings -->
        <div class="rounded-lg bg-white p-6 shadow-lg">
            <h1 class="text-center text-3xl font-semibold text-gray-800">History Booking</h1>

            <div v-if="allBookings" class="mt-6 space-y-6">

                <div v-for="pastBooking in allBookings" :key="pastBooking.booking_no" class="border  text-gray-800 rounded-lg p-4 shadow-sm">
                    <h2 class="text-xl font-semibold border-b pb-2">Booking #{{ pastBooking.booking_no }}</h2>
                    <p><strong>Address:</strong> {{ pastBooking.street_address }}</p>
                    <p><strong>City:</strong> {{ pastBooking.city }}</p>
                    <p><strong>Zip Code:</strong> {{ pastBooking.zip_code }}</p>
                    <p><strong>State:</strong> {{ pastBooking.state }}</p>
                    <p><strong>Booking Time:</strong> {{ formattedTime(pastBooking.reservation_datetime) }}</p>
                    
                    <!-- Children Information -->
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-800">Children Information</h3>
                        <ul v-if="pastBooking.children?.length" class="list-disc pl-5 space-y-1">
                            <li v-for="child in pastBooking.children" :key="child.id">
                                {{ child.name }} ({{ child.age }} year {{ child.month }} month)
                            </li>
                        </ul>
                        <p v-else class="text-gray-500">No children added.</p>
                    </div>
                </div>
            </div>

            <p v-else class="text-center text-gray-500 mt-4">No previous bookings found.</p>
        </div>
    </div>
</template>

<script setup lang="ts">
import LoginComponent from '@/components/LoginComponent.vue';
import { computed, onMounted , defineProps, PropType} from 'vue';
import { Booking } from '@/types';

// Props
const props = defineProps({
    booking: {
        type: Object,
        required: false,
    },
    allBookings: {
        type: Object as PropType<Booking[]>, // Specify `allBookings` as an array of `Booking`
            required: true,
    },
    submitForm: {
        type: Boolean,
        required: false,
    },
});

// Computed Properties
const formattedTime = (datetime:string) => {
    return new Date(datetime).toLocaleString();
};

const isSubmitForm = computed(() => props.submitForm);

onMounted(() => {
});
</script>

<style scoped>
/* Additional custom styling if needed */
</style>
