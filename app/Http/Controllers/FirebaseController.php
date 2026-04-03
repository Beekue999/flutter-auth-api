<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;

class FirebaseController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function showDatabase()
    {
        $firestore = $this->firebaseService->getFirestore();

        if (!$firestore) {
            return response()->json(['error' => 'Firestore not configured'], 500);
        }

        // List all collections
        $collections = [];
        $collectionRefs = $firestore->collections();

        foreach ($collectionRefs as $collectionRef) {
            $collections[] = $collectionRef->id();
        }

        return response()->json([
            'database' => 'Firestore',
            'collections' => $collections
        ]);
    }

    public function showCollection($collection)
    {
        $firestore = $this->firebaseService->getFirestore();

        if (!$firestore) {
            return response()->json(['error' => 'Firestore not configured'], 500);
        }

        $collectionRef = $firestore->collection($collection);
        $documents = $collectionRef->documents();

        $data = [];
        foreach ($documents as $document) {
            $data[] = [
                'id' => $document->id(),
                'data' => $document->data()
            ];
        }

        return response()->json([
            'collection' => $collection,
            'documents' => $data
        ]);
    }
}
