<style>
    /* Password Section */
    .password-section {
        max-width: 480px;
        margin: 3rem auto;
        padding: 2rem;
        background: #f1f3f6;
        border-radius: 20px;
        box-shadow: 8px 8px 15px #d1d9e6, -8px -8px 15px #ffffff;
        font-family: 'Poppins', sans-serif;
    }

    .section-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
    }

    .section-header p {
        font-size: 0.9rem;
        color: #666;
        margin-top: 0.3rem;
    }

    .password-form {
        margin-top: 1.5rem;
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

    .form-input {
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

    .form-input:focus {
        outline: none;
        box-shadow: inset 2px 2px 5px #c8d0e7, inset -2px -2px 5px #ffffff;
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

    .form-actions {
        text-align: center;
        margin-top: 2rem;
    }

    .success-message {
        margin-top: 1rem;
        color: #16a34a;
        font-weight: 500;
        text-align: center;
    }

    .error {
        color: #e63946;
        font-size: 0.875rem;
        margin-top: 0.3rem;
    }
</style>
<section class="password-section">
    <header class="section-header">
        <h2>Update Password</h2>
        <p>Ensure your account is using a long, random password to stay secure.</p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="password-form">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="form-group">
            <label for="current_password" class="form-label">Current Password</label>
            <input
                id="current_password"
                name="current_password"
                type="password"
                class="form-input"
                autocomplete="current-password"
            >
            <x-input-error class="error" :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <!-- New Password -->
        <div class="form-group">
            <label for="password" class="form-label">New Password</label>
            <input
                id="password"
                name="password"
                type="password"
                class="form-input"
                autocomplete="new-password"
            >
            <x-input-error class="error" :messages="$errors->updatePassword->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-input"
                autocomplete="new-password"
            >
            <x-input-error class="error" :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <!-- Save Button -->
        <div class="form-actions">
            <button type="submit" class="btn-save">Save Changes</button>

            @if (session('status') === 'password-updated')
                <p class="success-message">Password updated successfully!</p>
            @endif
        </div>
    </form>
</section>
