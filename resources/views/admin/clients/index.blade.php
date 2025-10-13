<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">Clients</h2>
    </x-slot>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h5>All Clients</h5>
            <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">+ Add Client</a>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>
                        {{ $client->expiry_date ? \Carbon\Carbon::parse($client->expiry_date)->format('d M Y') : 'N/A' }}
                    </td>
                    <td>
                        @if($client->expiry_date && Carbon\Carbon::parse($client->expiry_date )->isFuture())
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $client->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.clients.edit',$client) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.clients.destroy',$client) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this client?')" class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No clients found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $clients->links() }}
        </div>
    </div>
</x-app-layout>
