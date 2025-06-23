@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-8">
    <h2 class="text-3xl font-bold mb-6 text-indigo-700">✏️ Edit Product</h2>

    <!-- Global Error Alert -->
    <x-alert-errors />

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-8 rounded-2xl shadow-lg space-y-6 transition-transform duration-300 hover:scale-[1.01]">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                   class="w-full rounded-xl border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all @error('name') border-red-500 @enderror" required>
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">Description</label>
            <textarea name="description" rows="3"
                      class="w-full rounded-xl border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Price -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">Price <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                   class="w-full rounded-xl border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all @error('price') border-red-500 @enderror" required>
            @error('price')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Current Image -->
        @if ($product->image)
        <div>
            <label class="block text-sm font-semibold text-gray-700">Current Image</label>
            <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-32 object-cover rounded shadow mt-2">
        </div>
        @endif

        <!-- Replace Image -->
        <div>
            <label class="block text-sm font-semibold text-gray-700">Replace Image <span class="text-red-500">*</span></label>
            <input type="file" name="image"
                   class="w-full rounded-xl border px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all @error('image') border-red-500 @enderror">
            @error('image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <div>
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-xl shadow transition duration-300 transform hover:scale-105">
                Update Product
            </button>
        </div>
    </form>

    <!-- SweetAlert for validation errors -->
    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#d33'
        });
    </script>
    @endif

    <!-- SweetAlert for duplicate check -->
    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Duplicate Product',
            text: '{{ session('error') }}',
            confirmButtonColor: '#3085d6'
        });
    </script>
    @endif
</div>
@endsection
