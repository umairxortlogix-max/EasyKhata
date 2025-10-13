<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-semibold text-dark mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="alert alert-success mb-0">
                            {{ __("You're logged in!") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
