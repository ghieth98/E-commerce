@extends('layout')

@section('title', 'Products')

@section('extra-css')

@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shop</span>
    @endcomponent

    <div class="products-section container">
        <div class="sidebar">
            <h3>By Category</h3>
            <ul>
                @foreach($categories as $category )
                    <li><a href="{{route('shop.index', ['category' => $category->slug])}}">{{$category->name}}</a></li>
                @endforeach
            </ul>
        </div> <!-- end sidebar -->
        <div>

            <div>
                <div class="products-header">
                    <h1 class="stylish-heading">{{$categoryName}}</h1>
                    <div>
                        <strong>Price: </strong>
                        <a href="{{route('shop.index', ['category' => request()->category, 'sort' => 'low_high'])}}">Low to high | </a>
                        <a href="{{route('shop.index', ['category' => request()->category, 'sort' => 'high_low'])}}">High to low</a>
                    </div>
                </div>
            </div>

            <div class="products text-center">


                @forelse($products as $product)
                    <div class="product">
                        <a href="{{ route('shop.show', $product->slug) }}">
                            <img src="{{ asset('img/products/'.$product->slug.'.jpg') }}" alt="product">
                        </a>
                        <a href="{{ route('shop.show', $product->slug) }}">
                            <div class="product-name">{{ $product->name }}</div>
                        </a>
                        <div class="product-price">{{ $product->presentPrice() }}</div>
                    </div>
                @empty
                    <div style="text-align: left">No items in found</div>
                @endforelse


            </div> <!-- end products -->
            {{$products->links()}}
        </div>
    </div>


@endsection
