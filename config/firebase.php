<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Firebase Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Firebase project credentials. You can find
    | these credentials in your Firebase project's settings.
    |
    */

    'project_id' => env('FIREBASE_PROJECT_ID'),

    'credentials' => storage_path('app/firebase/credentials.json'),

    /*
    |--------------------------------------------------------------------------
    | Default Database
    |--------------------------------------------------------------------------
    |
    | This option controls the default database connection that gets used while
    | using Firebase. You may use Firestore or Realtime Database.
    |
    */

    'default_database' => env('FIREBASE_DEFAULT_DATABASE', 'firestore'),
];
