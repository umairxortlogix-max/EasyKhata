<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold">Customers</h2>
    </x-slot>

    <div class="container py-5">
        <div class="card shadow border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-dark bg-gradient text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-people-fill me-2"></i> Customer List
                </h5>
                <a href="{{ route('customers.create') }}" class="btn btn-outline-light btn-sm fw-bold px-3">
                    <i class="bi bi-plus-circle me-1"></i> Add Customer
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-dark border-bottom">
                            <tr class="text-center">
                                <th class="py-3">Name</th>
                                <th class="py-3">Phone</th>
                                <th class="py-3">Total</th>
                                <th class="py-3">Paid</th>
                                <th class="py-3">Remaining</th>
                                <th class="py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                                <tr class="text-center table-row-premium">
                                    <td class="fw-semibold text-dark">{{ $customer->name }}</td>
                                    <td class="text-muted">{{ $customer->phone ?? 'N/A' }}</td>
                                    <td class="fw-bold text-primary">{{ number_format($customer->transactions_sum_total ?? 0) }}</td>
                                    <td class="fw-bold text-success">{{ number_format($customer->transactions_sum_paid ?? 0) }}</td>
                                    <td class="fw-bold text-danger">{{ number_format($customer->transactions_sum_remaining ?? 0) }}</td>
                                    <td>
                                        <a href="{{ route('transactions.show', $customer->id) }}" class="btn btn-sm btn-outline-primary me-1" title="View Details">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <button type="button" 
                                            class="btn btn-sm btn-outline-secondary me-1 editBtn"
                                            data-id="{{ $customer->id }}"
                                            data-name="{{ $customer->name }}"
                                            data-phone="{{ $customer->phone }}"
                                            data-address="{{ $customer->address }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCustomerModal"
                                            title="Edit Customer">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this customer and all related transactions?');">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-person-x fs-1 d-block mb-3"></i>
                                        <h6>No customers found.</h6>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Edit Customer Modal --}}
    <div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold" id="editCustomerModalLabel">Edit Customer</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="updateCustomerForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="customer_id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" id="customer_name" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" id="customer_phone" class="form-control rounded-3">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea id="customer_address" class="form-control rounded-3"></textarea>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Custom CSS --}}
    <style>
        .table-row-premium {
            transition: all 0.3s ease-in-out;
        }
        .table-row-premium:hover {
            background: #f8f9fa;
            transform: scale(1.01);
            box-shadow: inset 0 0 8px rgba(0,0,0,0.05);
        }
        .card {
            backdrop-filter: blur(10px);
        }
    </style>

    {{-- ✅ Add jQuery + Bootstrap JS --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ✅ AJAX Script --}}
    <script>
        $(document).ready(function () {
            // Fill modal with existing data
            $('.editBtn').click(function () {
                $('#customer_id').val($(this).data('id'));
                $('#customer_name').val($(this).data('name'));
                $('#customer_phone').val($(this).data('phone'));
                $('#customer_address').val($(this).data('address'));
            });

            // Handle AJAX Update
            $('#updateCustomerForm').on('submit', function (e) {
                e.preventDefault();

                let id = $('#customer_id').val();

                $.ajax({
                    url: `/customers/${id}/update-ajax`,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: $('#customer_name').val(),
                        phone: $('#customer_phone').val(),
                        address: $('#customer_address').val(),
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#editCustomerModal').modal('hide');
                            alert(response.message);
                            location.reload();
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        alert('Something went wrong while updating the customer!');
                    }
                });
            });
        });
    </script>
</x-app-layout>
