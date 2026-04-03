<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Google\Cloud\Firestore\FirestoreClient;

class FirebaseService
{
    protected $firebase;
    protected $firestore;
    protected $database;

    public function __construct()
    {
        $this->firebase = (new Factory)
            ->withServiceAccount(config('firebase.credentials'))
            ->withProjectId(config('firebase.project_id'));

        if (config('firebase.default_database') === 'firestore') {
            $this->firestore = $this->firebase->createFirestore();
        } else {
            $this->database = $this->firebase->createDatabase();
        }
    }

    public function getFirestore()
    {
        return $this->firestore;
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function getFirebase()
    {
        return $this->firebase;
    }
}
