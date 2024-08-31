<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'product_name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string'],
            'description' => ['required', 'string', 'max:100'],
            'quantity' => ['required','integer', 'string'],
            'price' => ['required', 'string'],
            'image' => ['required'],
        ]);
        if($Validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $Validator->errors(),
            ]);
            
        }else{
            $filename = $request->file('image')->getClientOriginalName();
            $newFileName = time(). $filename;
            $uploadPicture = $request->file('image')->storeAs('public/products', $newFileName);
            if($uploadPicture){
                product::create([
                    'product_name' => $request->product_name,
                    'category' => $request->category,
                    'description' => $request->description,
                    'quantity' => $request->quantity,
                    'price' => $request->price,
                    'image' => $newFileName,
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Product created successfully',
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Image not uploaded',
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
