
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Resultados de búsqueda para: "{{ $search }}"</h2>
            <p class="text-muted">{{ $products->total() }} productos encontrados</p>
        </div>
    </div>
    
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                        <div class="mt-auto">
                            <p class="card-text"><strong class="text-success">${{ number_format($product->price, 2) }}</strong></p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Ver detalles</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <h4>No se encontraron productos</h4>
                    <p>Intenta con otros términos de búsqueda.</p>
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- Paginación -->
    <div class="row">
        <div class="col-12">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
