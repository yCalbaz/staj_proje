@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="text-center mb-4">Depo Ekle</h2>

            @include('components.alert')

            <form action="{{ route('store.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Depo Adı</label>
                    <input type="text" name="store_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Maksimum Kapasite</label>
                    <input type="number" name="store_max" class="form-control" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Öncelik </label>
                    <input type="number" name="store_priority" class="form-control" min="1" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Depo Ekle</button>
            </form>
        </div>
    </div>
</div>
@endsection
