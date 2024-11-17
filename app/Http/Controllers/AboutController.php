<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        $team = collect([
            [
                'gender' => 'Female',
                'name' => 'Regine Asuncion',
                'role' => 'Researcher',
                'image' => 'images/team/researcher.png',
                'social' => [
                    'facebook' => 'https://facebook.com/reginegamido.asuncion',
                    'google' => 'mailto:regine@example.com'
                ]
            ],
            [
                'gender' => 'Female',
                'name' => 'Franchelle Cabagay',
                'role' => 'Designer',
                'image' => 'images/team/designer2.png',
                'social' => [
                    'facebook' => 'https://facebook.com/chellekim.cabagay',
                    'google' => 'mailto:franchelle@example.com'
                ]
            ],
            [
                'gender' => 'Female',
                'name' => 'Ylyssa Cepriano',
                'role' => 'Leader/Paper',
                'image' => 'images/team/leader.png',
                'social' => [
                    'facebook' => 'https://facebook.com/ylyssakaye14.cepriano',
                    'google' => 'mailto:ylyssa@example.com'
                ]
            ],
            [
                'gender' => 'Male',
                'name' => 'Dale Decain',
                'role' => 'Programmer',
                'image' => 'images/team/programmer.png',
                'social' => [
                    'github' => 'https://github.com/your-profile',
                    'facebook' => 'https://facebook.com/dale.decain.5',
                    'google' => 'mailto:dale@example.com'
                ]
            ],
            [
                'gender' => 'Male',
                'name' => 'John Psychon Roldan',
                'role' => 'Designer',
                'image' => 'images/team/designer1.png',
                'social' => [
                    'facebook' => 'https://facebook.com/John.Psychon.Roldan.07',
                    'google' => 'mailto:john@example.com'
                ]
            ],
        ]);

        return view('about-us', compact('team'));
    }
}

