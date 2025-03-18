<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\BookingChild;
use App\Models\BookingChildren;
use App\Models\Children;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BookingController extends Controller
{
    //

    public function bookingForm(BookingRequest $request)
    {


        //start transaction
        $result = DB::transaction(function () use ($request) {
            //insert into the booking database 
            $booking = Booking::create([
                'booking_no' => 'BK' . now()->format('YmdHis') . rand(1000, 9999),
                'reservation_datetime' => $request->reservation_date,
                'street_address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zipCode
            ]);


            //insert the children details
            $insertBookingChildren = [];
            $insertedChildren = [];
            foreach ($request->childName as $key => $value) {


                $data = [

                    'name' => $value,
                    'age' => $request->childAge[$key],
                    'month' => $request->childMonth[$key],

                ];

                $insertedChildren[] = $data;


                $id = DB::table('children')->insertGetId($data);

                $insertBookingChildren[] = [

                    'booking_id' => $booking->id,
                    'child_id' => $id

                ];
            }


            //insert bridge table
            BookingChild::insert($insertBookingChildren);

            $response['booking'] = $booking;
            $response['children'] = $insertedChildren;


            return $response;
        });


        //return json response 
        return response()->json(['message' => 'Booking was succesfully created', 'result' => $result]);

    }


    public function confirmationPage(Request $request)
    {


        //get the selected data 

        // $allBookings = 
        $allBookings = DB::table('bookings')
        ->leftJoin('booking_child', 'booking_child.booking_id', '=', 'bookings.id')
        ->leftJoin('children', 'booking_child.child_id', '=', 'children.id')
        ->select(
            'bookings.*',
            'bookings.id as booking_id',
            'children.id as child_id',
            'children.name as child_name',
            'children.age as child_age',
            'children.month as child_month'
            
        )
        ->get();

        // Group the result by booking_id
        $bookingsWithChildren = $allBookings->groupBy('booking_id')->map(function ($bookingGroup) {
            $booking = $bookingGroup->first(); // Get the first booking info
        
            // Map the children data, replacing null values with an empty array
            $booking->children = $bookingGroup->map(function ($item) {
        
                // Otherwise, return the child data
                return [
                    'id' => $item->child_id,
                    'name' => $item->child_name,
                    'age' => $item->child_age,
                    'month' => $item->child_month
                ];
            })->filter(function ($child) {
                // Filter out the children where 'name' or other fields are null
                return $child['id']!==null;
            });
        
            //remove the child data 
            unset($booking->child_name);
            unset($booking->child_age);
            unset($booking->child_month);
            unset($booking->child_id);



            return $booking; // Return the booking with children or an empty array
        });
        

        // dd($bookingsWithChildren);

        $latestBooking = $allBookings->last();





        // dd(2123);    
        return Inertia::render('ConfirmationPage', ['booking' => $latestBooking, 'allBooking' => $allBookings]);






    }



}
