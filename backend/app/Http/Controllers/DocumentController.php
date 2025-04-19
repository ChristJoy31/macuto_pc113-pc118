<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function store(Request $request)
    {

        if (!$request->hasFile('document')) {
            return response()->json(['message' => 'No file uploaded'], 422);
        }
        
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $file = $request->file('document');
        $originalName = $file->getClientOriginalName();
        $storedPath = $file->store('documents', 'public'); // Save to storage/app/public/documents

        $document = Document::create([
            'filename' => basename($storedPath),
            'path' => $storedPath,
            'original_name' => $originalName,
        ]);

        return response()->json(['message' => 'Uploaded successfully', 'data' => $document], 200);
    }

    public function index()
    {
        $documents = Document::latest()->get();

        return response()->json($documents);
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id'); // Get the document ID from the request
        $document = Document::findOrFail($id);
    
        // Delete the file from storage
        Storage::disk('public')->delete($document->path);
    
        // Delete from the database
        $document->delete();
    
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
    
}





