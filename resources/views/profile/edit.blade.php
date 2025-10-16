<x-app-layout>
    <style>

        .profile-container {
    display: flex;
    gap: 30px;
    justify-content: center;
    align-items: flex-start;
    padding: 40px;
    background: #f9fafb;
    min-height: 100vh;
}

.profile-column {
    flex: 1;
    max-width: 600px;
}

.profile-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 25px;
    margin-bottom: 30px;
}

.profile-card h3 {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    border-bottom: 1px solid #eee;
    margin-bottom: 20px;
    padding-bottom: 8px;
}

.delete-card {
    border: 1px solid #fca5a5;
    background: #fff5f5;
}

/* Responsive layout */
@media (max-width: 992px) {
    .profile-container {
        flex-direction: column;
        align-items: center;
    }

    .profile-column {
        max-width: 100%;
    }
}

    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="profile-container">
        <div class="profile-column">
            <div class="profile-card">
                <h3>Profile Information</h3>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="profile-column">
            <div class="profile-card">
                <h3>Change Password</h3>
                @include('profile.partials.update-password-form')
            </div>

            <div class="profile-card delete-card">
                <h3>Delete Account</h3>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
