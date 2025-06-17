@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Detalles del Producto</h2>

    <div class="card">
        <div class="row g-0">
            <div class="col-md-4">
                @if ($producto->image)
                    <img src="{{ asset('storage/' . $producto->image) }}" alt="{{ $producto->name }}" class="img-fluid rounded-start">
                @else
                    <img src="https://via.placeholder.com/300x300?text=Sin+Imagen" class="img-fluid rounded-start" alt="Sin imagen">
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title">{{ $producto->name }}</h4>
                    <p class="card-text"><strong>Descripción:</strong> {{ $producto->description }}</p>
                    <p class="card-text"><strong>Precio:</strong> ${{ number_format($producto->price, 2) }}</p>
                    <p class="card-text"><strong>Categoría:</strong> {{ $producto->category->name ?? 'Sin categoría' }}</p>
                    <p class="card-text"><strong>Rating promedio:</strong> {{ number_format($producto->averageRating(), 1) ?? 'Sin calificaciones' }}</p>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
