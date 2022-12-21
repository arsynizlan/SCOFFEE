<?php

use App\Models\User;
use App\Models\Event;
use App\Models\Coffee;
use App\Models\Education;
use Illuminate\Support\Facades\Route;

route::get('/dashboard', function () {
    /** Data Query */
    $coffees = Coffee::get()->count();
    $events = Event::get()->count();
    $educations = Education::get()->count();
    $user = User::get()->count();
    $superAdmin = User::role('SuperAdmin')->get()->count();
    $admin = User::role('Admin')->get()->count();
    $myevents = Event::where('user_id', '=', Auth::user()->id)->get()->count();
    $myeducation = Education::where('user_id', '=', Auth::user()->id)->get()->count();

    return view('dashboard', [
        'coffees' => $coffees,
        'events' => $events,
        'educations' => $educations,
        'user' => $user,
        'superAdmin' => $superAdmin,
        'admin' => $admin,
        'myevents' => $myevents,
        'myeducation' => $myeducation,

    ]);
});