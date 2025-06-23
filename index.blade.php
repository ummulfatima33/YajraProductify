@extends('layouts.app')

@section('content')

@push('styles')
<style>
    .column-filter {
        width: 100%;
        padding: 6px;
        font-size: 0.875rem;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
</style>
@endpush


<div class="max-w-7xl mx-auto py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-blue-700">🛍️ Products</h1>
        <a href="{{ route('products.create') }}"
           class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold px-5 py-2 rounded-full shadow transition">
           + Add Product
        </a>
    </div>

    <div class="bg-white rounded-xl border border-blue-100 shadow p-4">
        <table id="productTable" class="w-full text-sm table-auto border-collapse">
    <thead class="bg-blue-50 text-blue-800">
    <tr>
        <th class="py-3 px-4">ID</th>
        <th class="py-3 px-4">Name</th>
        <th class="py-3 px-4">Description</th>
        <th class="py-3 px-4">Price</th>
        <th class="py-3 px-4">Image</th>
        <th class="py-3 px-4">Actions</th>
    </tr>
    <tr>
        <th><input type="text" class="column-filter" placeholder="Search ID" /></th>
        <th><input type="text" class="column-filter" placeholder="Search Name" /></th>
        <th><input type="text" class="column-filter" placeholder="Search Desc" /></th>
        <th><input type="text" class="column-filter" placeholder="Search Price" /></th>
        <th></th> <!-- No search for image -->
        <th></th> <!-- No search for actions -->
    </tr>
</thead>

</table>
 </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    let table = $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("products.get") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'price', name: 'price' },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ]
    });

    // 👇 Column filters
    $('#productTable thead tr:eq(1) th').each(function (i) {
        $('input', this).on('keyup change', function () {
            if (table.column(i).search() !== this.value) {
                table.column(i).search(this.value).draw();
            }
        });
    });

    // SweetAlert Delete
    $(document).on('click', '.delete-button', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the product permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    @if (session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif
});
</script>
@endpush
