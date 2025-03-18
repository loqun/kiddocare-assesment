<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


beforeEach(function () {
    $this->now = Carbon::now();
    Carbon::setTestNow($this->now);
});

afterEach(function () {
    Carbon::setTestNow();
});

function getValidBookingData(): array
{
    $childId = 1;
    
    return [
        // 'timezone' => config('app.timezone', 'Asia/Kuala_Lumpur'),
        // 'test' => now()->copy()->addHours(7)->format('Y-m-d\TH:i'),
        'reservation_date' => now()->copy()->timezone('Asia/Kuala_Lumpur')->addHours(7)->format('Y-m-d\TH:i'),
        'address' => fake()->streetAddress(),
        'city' => fake()->city(),
        'state' => fake()->state(),
        'zipCode' => fake()->postcode(),
        'childName' => [
            $childId => fake()->firstName()
        ],
        'childAge' => [
            $childId => 5
        ],
        'childMonth' => [
            $childId => 6
        ],
        'timezone' => 'Asia/Kuala_Lumpur'
    ];
}

// test('guest can create a booking', function () {
//     $data = getValidBookingData();
    
//     $response = $this->postJson('/booking', $data);
    
//     $response->assertStatus(201)
//              ->assertJson(fn (AssertableJson $json) => 
//                 $json->has('message')
//                      ->has('booking')
//                      ->has('booking.id')
//                      ->where('booking.reservation_date', $data['reservation_date'])
//                      ->where('booking.address', $data['address'])
//                      ->etc()
//              );
// });

// test('authenticated user can create a booking', function () {
//     $user = User::factory()->create();
    
//     $data = getValidBookingData();
    
//     $response = $this->actingAs($user)
//                      ->postJson('/booking', $data);
    
//     $response->assertStatus(201)
//              ->assertJson(fn (AssertableJson $json) => 
//                 $json->has('message')
//                      ->has('booking')
//                      ->has('booking.id')
//                      ->where('booking.user_id', $user->id)
//                      ->where('booking.reservation_date', $data['reservation_date'])
//                      ->where('booking.address', $data['address'])
//                      ->etc()
//              );
// });

test('booking fails with invalid data', function () {
    $data = getValidBookingData();
    $data['reservation_date'] = now()->copy()->addHours(5)->format('Y-m-d\TH:i'); // Invalid: less than 6 hours from now
    
    $response = $this->postJson('/booking', $data);
    
    $response->assertStatus(422)
             ->assertJsonValidationErrors(['reservation_date']);
});

    test('booking fails with too many children', function () {
        $data = getValidBookingData();
        
        // Add 4 children (total 5, which exceeds limit)
        for ($i = 1; $i <= 4; $i++) {
            $id = time() + $i;
            $data['childName'][$id] = fake()->firstName();
            $data['childAge'][$id] = 5;
            $data['childMonth'][$id] = 0;
        }
        
        $response = $this->postJson('/booking', $data);
        
        $response->assertStatus(422)
                ->assertJsonValidationErrors(['childName']);
    });

test('booking fails with child under one month old', function () {
    $data = getValidBookingData();
    $childId = array_key_first($data['childName']);
    
    $data['childAge'][$childId] = 0;
    $data['childMonth'][$childId] = 0;
    
    $response = $this->postJson('/booking', $data);
    
    $response->assertStatus(422)
             ->assertJsonValidationErrors(["childMonth.{$childId}"]);
});

test('can get validation error messages', function () {
    $data = getValidBookingData();
    // Create multiple validation errors
    $data['reservation_date'] = now()->copy()->addHours(5)->format('Y-m-d\TH:i');
    $childId = array_key_first($data['childName']);
    $data['childAge'][$childId] = 0;
    $data['childMonth'][$childId] = 0;
    
    $response = $this->postJson('/booking', $data);
    $jsonResponse = $response->json();
    $response->assertStatus(422)
             ->assertJsonValidationErrors(['reservation_date', "childMonth.{$childId}"])
             ->assertJsonPath('errors.reservation_date.0', 'Reservation must be at least 6 hours from now.');
         
            $this->assertEquals('Child must be at least 1 month old.', $jsonResponse['errors']["childMonth.{$childId}"][0]);


});

test('missing required fields returns validation errors', function ($field) {
    $data = getValidBookingData();
    unset($data[$field]);
    
    $response = $this->postJson('/booking', $data);
    
    $response->assertStatus(422)
             ->assertJsonValidationErrors([$field]);
})->with([
    'reservation_date', 'address', 'city', 'state', 'zipCode',
    'childName', 'childAge', 'childMonth'
]);

test('booking fails with child exceed age limit', function () {
    $data = getValidBookingData();
    $childId = array_key_first($data['childName']);
    
    $data['childAge'][$childId] = 13;
    $data['childMonth'][$childId] = 0;
    
    $response = $this->postJson('/booking', $data);
    
    $response->assertStatus(422)
             ->assertJsonValidationErrors(["childAge.{$childId}"]);

    $jsonResponse = $response->json();

    // dd($jsonResponse, $data);
    $this->assertEquals("The childAge.{$childId} field must not be greater than 12.", $jsonResponse['errors']["childAge.{$childId}"][0]);


});

test('booking success', function () {
    $data = getValidBookingData();
    $childId = array_key_first($data['childName']);
    
    $data['childAge'][$childId] = 12;
    $data['childMonth'][$childId] = 11;
    
    $response = $this->postJson('/booking', $data);
    
    $response->assertStatus(200);
    //          ->assertJsonValidationErrors(["childAge.{$childId}"]);

    // $jsonResponse = $response->json();

    // // dd($jsonResponse, $data);
    // $this->assertEquals("The childAge.{$childId} field must not be greater than 12.", $jsonResponse['errors']["childAge.{$childId}"][0]);


});