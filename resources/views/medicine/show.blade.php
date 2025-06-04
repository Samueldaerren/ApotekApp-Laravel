@extends ('layouts.layout')
@section('content')

@if (Session::get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ Session::get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
    <form action="{{ route('medicine.show') }}" method="GET" class="d-flex align-items-center">
        <input type="hidden" name="sorting_stock" value="stock">
        <button class="btn btn-outline-success me-3" type="submit">Sort by Stock</button>
        <a href="{{ route('medicine.admin.export') }}" class="btn btn-success">Export Excel</a> 
    </form>
    
    <form action="{{ route('medicine.show') }}" method="GET" class="d-flex">
        <input type="text" class="form-control me-2" name="search_medicine" placeholder="Search Medicines" aria-label="Search">
        <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
    </form>
</div>

<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Medicine List</h3>
        </div>
        <div class="card-body p-4">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($medicines as $index => $item)
                    <tr>
                        <td class="text-center">{{ ($medicines->currentPage() - 1) * $medicines->perPage() + ($index + 1) }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['type'] }}</td>
                        <td>${{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td class="{{ $item['stock'] <= 3 ? 'bg-danger text-white' : '' }} text-center" style="cursor: pointer;" onclick="showModalStock('{{ $item->id }}', '{{ $item->stock }}')">{{ $item['stock'] }}</td>
                        <td class="text-center">
                            <a href="{{ route('medicine.edit', $item['id']) }}" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                            <button class="btn btn-sm btn-outline-danger" onclick="showModal('{{ $item->id }}', '{{ $item['name'] }}')">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No Data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-end">
                {{ $medicines->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-delete-obat" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Medicine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this medicine <span id="nama-obat"></span>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Stock -->
<div class="modal fade" id="modal_edit_stock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form_edit_stock" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Medicine Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="stock_edit" class="form-label">Stock:</label>
                        <input type="number" name="stock" id="stock_edit" class="form-control">
                        @if (Session::get('Failed'))
                        <small class="text-danger">{{ Session::get('Failed') }}</small>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function showModal(id, name) {
        let urlDelete = "{{ route('medicine.destroy', ':id') }}";
        urlDelete = urlDelete.replace(':id', id);
        $('#form-delete-obat').attr('action', urlDelete);
        $('#exampleModal').modal('show');
        $('#nama-obat').text(name);
    }

    function showModalStock(id, stock) {
        let url = "{{ route('medicine.update.stock', ':id') }}";
        url = url.replace(':id', id);
        $('#stock_edit').val(stock);
        $('#form_edit_stock').attr('action', url);
        $('#modal_edit_stock').modal('show');
    }x

    @if (Session::get('Failed'))
    $(document).ready(function() {
        let id = "{{ Session::get('id') }}";
        let stock = "{{ Session::get('stock') }}";
        showModalStock(id, stock);
    });
    @endif
</script>
@endpush
