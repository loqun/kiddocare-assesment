<template>
    <div class="mx-auto max-w-4xl py-8">
        <!-- Confirmation Title -->
        <h1 class="text-white-800 text-center text-3xl font-semibold">Booking Confirmation</h1>

        <!-- Booking Confirmation Details -->
        <div class="mt-6 rounded-lg bg-white p-6 shadow-lg">
            <h2 class="text-xl font-semibold text-gray-800">Your Booking Details</h2>

            <!-- Booking Information -->
            <div class="mt-4 text-gray-700">
                <p><strong>Booking Number:</strong> {{ booking.booking_no }}</p>

                <!-- <p><strong>Customer Name:</strong> {{ booking.customer_name }}</p> -->
                <!-- <p><strong>Email:</strong> {{ booking.customer_email }}</p> -->
                <p><strong>Phone:</strong> {{ booking.customer_phone }}</p>
                <!-- <p><strong>Booking Date:</strong> {{ formattedDate }}</p> -->
                <p><strong>Address:</strong> {{ booking.street_address }}</p>
                <p><strong>City:</strong> {{ booking.city }}</p>
                <p><strong>Zip Code:</strong> {{ booking.zip_code }}</p>
                <p><strong>State:</strong> {{ booking.state }}</p>
                <p><strong>Booking Time:</strong> {{ formattedTime }}</p>

                <br />
                <div>
                    <strong>Children Information</strong>

                    




                </div>

                <!-- <p><strong>Location:</strong> {{ booking.location }}</p> -->
            </div>

            <!-- Special Instructions (if available) -->
            <!-- <div v-if="booking.special_instructions" class="mt-4">
          <h3 class="text-lg font-semibold text-gray-800">Special Instructions</h3>
          <p class="text-gray-700">{{ booking.special_instructions }}</p>
        </div> -->
        </div>

        <!-- Success Message -->
        <div class="mt-6 text-center">
            <p class="font-semibold text-green-600">Your booking has been confirmed!</p>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';

// Props definition
const props = defineProps({
    booking: {
        type: Object,
        required: true,
    },
    allBooking: {
        type: Object,
        required: false,
    },
});

// Computed property to format the booking date
const formattedDate = computed(() => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(props.booking.reservation_datetime).toLocaleDateString(undefined, options);
});

const formattedTime = computed(() => {
    const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: true };
    return new Date(props.booking.reservation_datetime).toLocaleDateString(undefined, optionsTime);
});

onMounted(() => {
    console.log(props);
});
</script>

<style scoped>
/* Add custom styles if needed */
</style>
