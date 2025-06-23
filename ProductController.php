<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
 

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'image'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ], [
                 'image.required' => 'Please select an image.',
    ]);

     // Get uploaded image name for duplicate check
    $originalImageName = $request->file('image')->getClientOriginalName();

    // Check  duplicate product exists
    $isDuplicate = Product::where('name', $request->name)
        ->where('description', $request->description)
        ->where('image', 'like', "%$originalImageName")
        ->exists();

    if ($isDuplicate) {
        return back()->with('error', 'This product already exists (same name, description, and image).');
    }

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        //  stores file in storage app public  images
    }

            

    Product::create([
        'name'        => $request->name,
        'description' => $request->description,
        'price'       => $request->price,
        'image'       => $imagePath,  
    ]);

    return redirect()->route('products.index')->with('success', 'Product created successfully.');

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
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request , Product $product)
    {
        $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'image'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ], [
        'image.required' => 'Please select an image.',
    ]);
        //   Old PIC EXIST
    if ($request->hasFile('image')) {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // New PIC STORE
        $imagePath = $request->file('image')->store('images', 'public');
        $product->image = $imagePath;
    }

    // REMANING FIELDs
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;

    $product->save();

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Product $product)
    {
    if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }


public function getProducts(Request $request)
{
    if ($request->ajax()) {
        $data = Product::select(['id', 'name', 'description', 'price', 'image']);
        return DataTables::of($data)
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    return '<img src="' . asset('storage/' . $row->image) . '" width="60" height="60" class="rounded shadow"/>';
                }
                return '<span class="text-gray-400 italic">No image</span>';
            })
            ->addColumn('action', function ($row) {
    $editUrl = route('products.edit', $row->id);
    $deleteUrl = route('products.destroy', $row->id);

   $btn = '<div class="flex space-x-2 justify-center items-center">';
$btn .= '<a href="' . $editUrl . '" class="btn-action bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm shadow">Edit</a>';
$btn .= '<form method="POST" action="' . $deleteUrl . '" class="delete-form" style="display:inline;">
            ' . csrf_field() . method_field('DELETE') . '
            <button type="submit" class="btn-action bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm shadow delete-button">
                Delete
            </button>
        </form>';
$btn .= '</div>';


    return $btn;
})


            ->rawColumns(['image', 'action'])
            ->make(true);
    }
}
}
