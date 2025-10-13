<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">Edit Client</h2>
    </x-slot>

    <div class="container">
        <form action="{{ route('admin.clients.update',$client) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name',$client->name) }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email',$client->email) }}">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mobile Number</label>
                <input type="text" name="number" class="form-control" value="{{ old('number',$client->number) }}">
                @error('number') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', $client->expiry_date ? $client->expiry_date->format('Y-m-d') : '') }}">
                @error('expiry_date') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
                    {{ old('is_active', $client->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Active</label>
            </div>

            <div class="mb-3">
                <label class="form-label">Password (leave blank if not changing)</label>
                <input type="password" name="password" class="form-control">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-app-layout>
