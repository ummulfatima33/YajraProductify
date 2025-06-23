@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-3xl font-bold mb-6 text-blue-700 text-center animate-pulse">➕ Add New Product</h2>

    <!-- Global Error Alert -->
    <x-alert-errors />

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-8 rounded-2xl shadow-lg space-y-6 transition-transform duration-300 hover:scale-[1.01]">
        @csrf

        <!-- Name -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full rounded-xl border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 @error('name') border-red-500 @enderror" required>
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full rounded-xl border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Price -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Price <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                   class="w-full rounded-xl border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 @error('price') border-red-500 @enderror" required>
            @error('price')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Image <span class="text-red-500">*</span></label>
            <input type="file" name="image"
                   class="w-full rounded-xl border border-gray-300 px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 @error('image') border-red-500 @enderror">
            @error('image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <div class="text-center">
            <button type="submit"
                    class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold px-8 py-2 rounded-full shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                 Save Product
            </button>
        </div>
    </form>

    <!-- SweetAlert Scripts -->
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

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
            confirmButtonColor: '#3085d6'
        });
    </script>
    @endif
</div>
@endsection
