<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\FormInput;
use App\Mail\FormInputEmail;
use Illuminate\Support\Facades\Mail;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/submit-form', function (Request $request) {
    // 1. Process the incoming request
    // 2. Validate the data
    $validatedData = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string',
        'message' => 'nullable|string|max:500',
        'imageUploaded' => 'nullable|image|max:2048' // Assuming you handle image upload
    ]);

    if ($request->hasFile('imageUploaded')) {
        $file = $request->file('imageUploaded');

        // Yes I know this is a bit pedantic, but let me be
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = time() . '_' . $originalName . '.' . $file->getClientOriginalExtension();
        
        
        $path = $request->file('imageUploaded')->storeAs('uploads', $fileName);
        $validatedData['imgUrl'] = $path;
    }


    FormInput::create($validatedData);

    Log::info("message");

    Mail::to($validatedData['email'])->send(new FormInputEmail($validatedData));

    return response()->json(['message' => 'Form submitted successfully!']);
});
