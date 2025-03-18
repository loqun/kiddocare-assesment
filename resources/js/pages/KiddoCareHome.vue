<template>
    <div class="mx-auto max-w-3xl p-4 font-sans">
        <h1 class="mb-6 text-center text-2xl font-bold">Reservation Form</h1>

        <Summary
            :showSummary="showSummary"
            :reservationDateTime="reservationDateTime"
            :address="address"
            :city="city"
            :state="state"
            :zipCode="zipCode"
            :children="children"
            @submit="handleSummarySubmit"
            @back="handleBack"
        >
        </Summary>

        <form v-show="!showSummary" @submit.prevent="submitForm" class="space-y-6" ref="formRef">
            <div class="space-y-2">
                <label for="reservationDateTime" class="block font-medium">Reservation Date and Time*</label>
                <input
                    type="datetime-local"
                    id="reservationDateTime"
                    v-model="reservationDateTime"
                    name="reservation_date"
                    required
                    class="w-full rounded-md border border-input px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-ring"
                />
                <span class="validity"></span>

                <p class="text-sm text-muted-foreground">Must be at least 6 hours from now and within 30 days from today.</p>
            </div>

            <div class="rounded-lg border border-border bg-card p-4">
                <h2 class="mb-4 border-b pb-2 text-lg font-semibold text-card-foreground">Address Information</h2>

                <div class="mb-4 space-y-2">
                    <label for="address" class="block font-medium">Street Address*</label>
                    <input
                        type="text"
                        id="address"
                        v-model="address"
                        name="address"
                        required
                        class="w-full rounded-md border border-input px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-ring"
                    />
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="space-y-2">
                        <label for="city" class="block font-medium">City*</label>
                        <input
                            type="text"
                            name="city"
                            id="city"
                            v-model="city"
                            required
                            class="w-full rounded-md border border-input px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-ring"
                        />
                    </div>

                    <div class="space-y-2">
                        <label for="state" class="block font-medium">State*</label>
                        <input
                            type="text"
                            id="state"
                            name="state"
                            v-model="state"
                            required
                            class="w-full rounded-md border border-input px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-ring"
                        />
                    </div>

                    <div class="space-y-2">
                        <label for="zipCode" class="block font-medium">Zip Code*</label>
                        <input
                            type="text"
                            id="zipCode"
                            name="zipCode"
                            v-model="zipCode"
                            required
                            class="w-full rounded-md border border-input px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-ring"
                        />
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-border bg-card p-4">
                <h2 class="mb-4 border-b pb-2 text-lg font-semibold text-card-foreground">Children Information</h2>
                <p class="mb-4 text-sm text-muted-foreground">You can add up to 4 children. Children must be between 1 month and 12 years old.</p>

                <div v-if="children.length === 0" class="mb-4 rounded bg-muted p-4 text-center">
                    <p class="text-muted-foreground">No children added yet. Click the button below to add a child.</p>
                </div>

                <div v-for="child in children" :key="child.id" class="mb-4 rounded-md border border-border bg-background p-4 shadow-sm">
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex-grow space-y-2">
                            <label :for="`childName${child.id}`" class="block font-medium">Child's Name*</label>
                            <input
                                type="text"
                                :id="`childName${child.id}`"
                                v-model="child.name"
                                :name="`childName[${child.id}]`"
                                required
                                class="w-full rounded-md border border-input px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-ring"
                            />
                        </div>

                        <!-- Make Age & Month in one row -->
                        <div class="flex gap-4">
                            <div class="w-24">
                                <label :for="`childAge${child.id}`" class="block font-medium">Year*</label>
                                <input
                                    type="number"
                                    :id="`childAge${child.id}`"
                                    :name="`childAge[${child.id}]`"
                                    v-model="child.year"
                                    min="1"
                                    max="12"
                                    required
                                    class="w-full rounded-md border border-input px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-ring"
                                />
                            </div>

                            <div class="w-24">
                                <label :for="`childMonth${child.id}`" class="block font-medium">Month*</label>
                                <input
                                    type="number"
                                    :id="`childMonth${child.id}`"
                                    :name="`childMonth[${child.id}]`"
                                    v-model="child.month"
                                    min="1"
                                    max="12"
                                    required
                                    class="w-full rounded-md border border-input px-3 py-2 text-black focus:outline-none focus:ring-2 focus:ring-ring"
                                />
                            </div>
                        </div>

                        <button
                            type="button"
                            @click="() => removeChild(child.id)"
                            class="mt-8 rounded-md bg-destructive p-2 font-medium text-destructive-foreground hover:bg-destructive/90"
                            aria-label="Remove child"
                        >
                            ✕
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button
                        type="button"
                        @click="addChild"
                        class="justify-center rounded-md bg-secondary px-4 py-2 font-medium text-secondary-foreground transition-colors hover:bg-secondary/80 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="children.length >= 4"
                    >
                        Add Child
                    </button>
                    <span v-if="children.length >= 4" class="text-sm text-muted-foreground"> Maximum number of children reached (4) </span>
                </div>
            </div>

            <div v-if="formError" class="rounded-md bg-destructive/10 p-4 text-destructive">
                {{ formError }}
            </div>

            <div class="flex justify-center gap-2">
                <button
                    v-if="!showSummary"
                    class="rounded-md bg-primary px-6 py-2 font-medium text-primary-foreground transition-colors hover:bg-primary/90 disabled:cursor-not-allowed disabled:opacity-50"
                    :disabled="!isFormValid"
                    @click="toggleSummary"
                >
                    Next
                </button>

                <button
                    v-else
                    type="submit"
                    class="rounded-md bg-primary px-6 py-2 font-medium text-primary-foreground transition-colors hover:bg-primary/90 disabled:cursor-not-allowed disabled:opacity-50"
                    :disabled="!isFormValid"
                >
                    Submit reservation
                </button>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { Child } from '@/types';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { DateTime } from 'luxon';
import { computed, ref } from 'vue';
import Summary from './Summary.vue';

const minDateTime = computed(() => {
    const minDate = new Date();

    // Set the time to 6 hours ahead

    // minDate.setHours(minDate.getHours() + 6);
    // minDate.setSeconds(0); // Set secodddd
    // minDate.setMilliseconds(0); // Set milliseconds to 0
    // console.log(DateTime.local().plus({ hours: 6}).toISO().slice(0,16)  )
    // minDate.toISOString().slice(0, 16)
    // Format as YYYY-MM-DDTHH:mm (Only take the first 16 characters of ISO string)
    return DateTime.local().plus({ hours: 6 }).toISO().slice(0, 16); // This will give you the format YYYY-MM-DDTHH:mm
});

const maxDateTime = computed(() => {
    // Get the current date and time
    const maxDate = DateTime.local();

    // Add 30 days to the current date
    const newMaxDate = maxDate.plus({ days: 30 });

    // Set seconds and milliseconds to 0
    const formattedMaxDate = newMaxDate.set({ second: 0, millisecond: 0 });

    // Format as YYYY-MM-DDTHH:mm
    return formattedMaxDate.toISO({ includeOffset: false }).slice(0, 16); // This gives the format YYYY-MM-DDTHH:mm
});

// Form fields
const reservationDateTime = ref('');
const address = ref('');
const city = ref('');
const state = ref('');
const zipCode = ref('');
const children = ref<Child[]>([]);
const formSubmitted = ref(false);
const formError = ref('');
const showSummary = ref(false);
const formRef = ref();

// Add a child
const addChild = () => {
    if (children.value.length < 4) {
        children.value.push({
            id: Date.now(), // Simple unique ID
            name: '',
            year: 0,
            month: 1,
        });
    }
};

// Remove a child
const removeChild = (childId: number) => {
    children.value = children.value.filter((child) => child.id !== childId);
};

// Check if form is valid
const isFormValid = computed(() => {
    // Check if reservation date is valid
    if (!reservationDateTime.value) return false;

    // Check address fields
    if (!address.value || !city.value || !state.value || !zipCode.value) return false;

    // Check if at least one child is added
    if (children.value.length === 0) return false;

    // Check if all children have names and valid ages
    for (const child of children.value) {
        if (!child.name || child.year < 1 || child.year > 12) return false;
    }

    return true;
});

//validate form
const validateForm = () => {
    //just the trigger the browser validation
    formRef.value.checkValidity();
    formRef.value.reportValidity();
    console.log(formRef.value.reportValidity());

    formError.value = '';

    if (!formRef.value.reportValidity()) {
        formError.value = 'Please fill out all required fields correctly.';
        return false;
    }

    // Here you would typically send the data to your backend
    console.log('Form submitted:', {
        reservationDateTime: reservationDateTime.value,
        address: address.value,
        city: city.value,
        state: state.value,
        zipCode: zipCode.value,
        children: children.value,
    });

    return true;
};

const toggleSummary = () => {
    const pass = validateForm();

    if (!pass) {
        console.error('Please enter the required input');
        showSummary.value = false;
    } else {
        showSummary.value = true;
    }
};

// Submit form
const submitForm = () => {
    const pass = validateForm();

    if (!pass) {
        console.error('Please enter the required input');

        return;
    }

    formSubmitted.value = true;
};

// Reset form for new submission
const resetForm = () => {
    reservationDateTime.value = '';
    address.value = '';
    city.value = '';
    state.value = '';
    zipCode.value = '';
    children.value = [];
    formSubmitted.value = false;
    formError.value = '';
};

const handleBack = () => {
    showSummary.value = false;
};

const handleSummarySubmit = async () => {
    if (formRef.value.checkValidity() && formRef.value.reportValidity()) {
        // formRef.value.submit();
        console.log('submit');

        console.log(formRef.value);
        const payload = new FormData(formRef.value);

        // Log form data
        payload.forEach((value, key) => {
            console.log(key, value);
        });
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        payload.append('timezone', timezone);

        try {
            const response = await axios.post('/booking', payload);

            if (response) {
                console.log('success');
                console.log(response.data)
                //redirect to the page
                router.push({
                    url: '/confirmation-page',
                    component: 'ConfirmationPage',
                    props: { data:'test' },
                    clearHistory: false,
                    encryptHistory: false,
                    preserveScroll: false,
                    preserveState: false,
                });
            }
        } catch (error) {
            if (error.status == 422) {
                console.log(error);

                showToast(error.response.data.message, 'error');
            } else if (error.status == 419) {
                await showToast('Expired Session will reload ..');
                window.location.reload();
            }
            console.error(error);
        }
    }
};

async function showToast(message: string, type: string) {
    let color = '#fff';
    if (type === 'error') {
        color = '#FF0000';
    }

    const toast = document.createElement('div');
    toast.style.background = color;
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: ${color};
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        opacity: 0.9;
        transition: opacity 0.5s ease-in-out;
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => document.body.removeChild(toast), 500);
    }, 2000);
}
</script>

<style>
input:invalid + span::after {
    content: 'X';
    padding-left: 5px;
}

input:valid + span::after {
    content: '✓';
    padding-left: 5px;
}
</style>
