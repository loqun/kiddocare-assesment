import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

export interface Child {
    id: number;
    name: string;
    year: number;
    month: number;
    age?:number;
}

export interface SummaryPageProps {
    showSummary: boolean;
    reservationDateTime: ISODateString;
    address: string;
    city: string;
    state: string;
    zipCode: string;
    children: Child[];
}

export type Booking = {
    booking_no: string | number;
    street_address: string;
    city: string;
    zip_code: string;
    state: string;
    reservation_datetime: string; // or Date type if it's a Date object
    children: Child[];
};

export interface AllBookings {
    allBookings: Booking[];
}
