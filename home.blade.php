@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10 px-4" 
    x-data="{ activeSlide: 0, products: {{ $products->values()->toJson() }} }"

     x-init="$watch('products', () => activeSlide = 0)">
    
    <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6"> Latest Products</h2>

    <div class="relative bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Card -->
        <template x-for="(product, index) in products" :key="index">
            <div x-show="activeSlide === index" 
                 x-transition 
                 class="p-6 flex flex-col items-center space-y-4 text-center">
                 
                <img :src="'/storage/' + product.image" 
                     class="w-64 h-64 object-cover rounded-xl shadow-lg hover:scale-105 transition duration-300" 
                     :alt="product.name">

                <div>
                    <h3 class="text-xl font-bold text-gray-800 mt-4" x-text="product.name"></h3>
                    <p class="text-gray-600 text-sm mt-1" x-text="product.description"></p>
                    <p class="mt-2 text-lg font-bold text-green-600" x-text="'$' + product.price"></p>
                </div>
            </div>
        </template>

        <!-- Controls -->
        <div class="absolute inset-y-0 left-0 flex items-center px-3">
            <button @click="activeSlide = (activeSlide - 1 + products.length) % products.length"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-full shadow transition">
                ❮
            </button>
        </div>

        <div class="absolute inset-y-0 right-0 flex items-center px-3">
            <button @click="activeSlide = (activeSlide + 1) % products.length"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-full shadow transition">
                ❯
            </button>
        </div>
    </div>

    <!-- Dots -->
    <div class="flex justify-center mt-4 space-x-2">
        <template x-for="(product, index) in products" :key="index">
            <button
                @click="activeSlide = index"
                class="w-3 h-3 rounded-full transition"
                :class="{
                    'bg-indigo-600': activeSlide === index,
                    'bg-gray-300': activeSlide !== index
                }">
            </button>
        </template>
    </div>
</div>
@endsection
