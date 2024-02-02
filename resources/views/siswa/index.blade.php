@extends('template.temp_admin')

@section('content')
<div class="modal" role="dialog" id="my_modal_8">
    <form action="/topup-user" class="modal-box" method="POST">
        @csrf
        <h3 class="font-bold text-lg">Topup</h3>
        <input type="number" name="credit" value="10000" class="input input-bordered">
        <div class="modal-action">
            <button type="submit" class="btn btn-success rounded-lg">Topup</button>
            <a href="#" class="btn">Yay!</a>
        </div>
    </form>
</div>
<div class="modal" role="dialog" id="my_modal_wd">
    <form action="/withdraw-user" class="modal-box" method="POST">
        @csrf
        <h3 class="font-bold text-lg">Withdraw</h3>
        <input type="number" name="debit" value="10000" class="input input-bordered">
        <div class="modal-action">
            <button type="submit" class="btn btn-success rounded-lg">withdraw</button>
            <a href="#" class="btn">Yay!</a>
        </div>
    </form>
</div>
    <div class="container mx-auto">
        @if(session('status'))
        <div class="toast toast-top toast-start">
            <div class="alert alert-success">
              <span>{{ session('status') }}</span>
            </div>
          </div>
        @endif
        <div class="flex flex-col p-3">
            <div class="flex flex-col my-8">
                <div class="w-full bg-base-100 shadow-xl p-10">
                        <h2 class="card-title text-black mb-4">halo {{ Auth::user()->name }}</h2>
                        <div class="flex items-center gap-4">
                            <span class="text-black">Rp.{{ number_format($saldo_user) }}</span>
                            <a href="#my_modal_8" class="btn btn-info rounded-lg">Topup</a>
                            <a href="#my_modal_wd" class="btn btn-warning rounded-lg">withdraw</a>
                        </div>
                </div>
            </div>
            <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                @foreach ($products as $product)
                    <div class="flex flex-col justify-center w-[18rem] bg-base-100 shadow-xl p-6">
                        <figure><img src="{{ $product->photo }}"
                                alt="Shoes" class="object-cover w-56 h-56 rounded-lg mt-2" /></figure>
                            <h2 class="card-title my-2">
                                {{ $product->name }}
                                <div class="shadow-inner border p-3 text-base rounded-full">{{ $product->stock == 0 ? 'x' : $product->stock }}</div>
                            </h2>
                            <p>Rp.{{ number_format($product->price) }}</p>
                            <p>{{ $product->description }}</p>
                            <div class="card-actions my-2">
                                <div class="badge badge-outline">{{ $product->category->name }}</div>
                                <div class="badge badge-outline">By: {{ $product->stand }}</div>
                            </div>
                            <div class="flex justify-between">
                                <form action="/buy-now" method="post">
                                    @csrf
                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                    <input type="hidden" name="products_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button class="btn btn-success rounded-lg" type="submit">Buy</button>
                                </form>
                                <form action="/add-to-cart" method="post">
                                    @csrf
                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                    <input type="hidden" name="products_id" value="{{ $product->id }}">
                                    <input type="number" name="quantity" value="1" min="1"
                                        class="input input-bordered w-20">
                                    <button class="btn btn-primary rounded-lg" type="submit">Cart</button>
                                </form>
                            </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
