<!-- resources/views/profile/edit.blade.php -->
<style>

    /* Custom CSS for Profile Form */
.profile-form {
    max-width: 480px;
    margin: 2rem auto;
    padding: 2rem;
    background: #f1f3f6;
    border-radius: 20px;
    box-shadow: 8px 8px 15px #d1d9e6, -8px -8px 15px #ffffff;
    font-family: 'Poppins', sans-serif;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-input,
.form-input-file {
    width: 100%;
    padding: 0.8rem 1rem;
    border: none;
    border-radius: 12px;
    background: #f1f3f6;
    box-shadow: inset 3px 3px 6px #d1d9e6, inset -3px -3px 6px #ffffff;
    font-size: 1rem;
    color: #333;
    transition: all 0.2s ease;
}

.form-input:focus,
.form-input-file:focus {
    outline: none;
    box-shadow: inset 2px 2px 5px #c8d0e7, inset -2px -2px 5px #ffffff;
}

.image-upload {
    text-align: center;
}

.image-preview img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 1rem;
    box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #ffffff;
}

.btn-save {
    background: #f1f3f6;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    color: #333;
    box-shadow: 6px 6px 12px #d1d9e6, -6px -6px 12px #ffffff;
    transition: all 0.2s ease;
}

.btn-save:hover {
    box-shadow: inset 4px 4px 8px #d1d9e6, inset -4px -4px 8px #ffffff;
}

.error {
    color: #e63946;
    font-size: 0.875rem;
    margin-top: 0.3rem;
}

.success-message {
    margin-top: 1rem;
    color: #16a34a;
    font-weight: 500;
    text-align: center;
}

.form-actions {
    text-align: center;
    margin-top: 2rem;
}

</style>
<form 
    method="POST" 
    action="{{ route('profile.update') }}" 
    enctype="multipart/form-data"
    class="profile-form"
>
    @csrf
    @method('patch')

    <!-- Profile Image -->
    <div class="form-group image-upload">
        <label for="image" class="form-label">Profile Image</label>

        @if ($user->image)
            <div class="image-preview">
                <img src="{{ asset('storage/'.$user->image) }}" alt="Profile Image">
            </div>
        @endif

        <input 
            id="image"
            name="image"
            type="file"
            accept="image/*"
            class="form-input-file"
        >
        <x-input-error class="error" :messages="$errors->get('image')" />
    </div>

    <!-- Name -->
    <div class="form-group">
        <label for="name" class="form-label">Full Name</label>
        <input
            id="name"
            name="name"
            type="text"
            class="form-input"
            value="{{ old('name', $user->name) }}"
            required
        >
        <x-input-error class="error" :messages="$errors->get('name')" />
    </div>

    <!-- Email -->
    <div class="form-group">
        <label for="email" class="form-label">Email Address</label>
        <input
            id="email"
            name="email"
            type="email"
            class="form-input"
            value="{{ old('email', $user->email) }}"
            required
        >
        <x-input-error class="error" :messages="$errors->get('email')" />
    </div>

    <!-- Phone -->
    <div class="form-group">
        <label for="phone" class="form-label">Phone Number</label>
        <input
            id="phone"
            name="phone"
            type="text"
            class="form-input"
            placeholder="+92 300 1234567"
            value="{{ old('phone', $user->phone) }}"
        >
        <x-input-error class="error" :messages="$errors->get('phone')" />
    </div>

    <!-- Submit -->
    <div class="form-actions">
        <button type="submit" class="btn-save">Save Changes</button>

        @if (session('status') === 'profile-updated')
            <p class="success-message">Saved successfully!</p>
        @endif
    </div>
</form>
