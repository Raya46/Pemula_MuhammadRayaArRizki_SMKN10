@extends('template.temp_admin')

@section('content')
    @php
        $totalBayar = 0;
    @endphp
    @if(session('status'))
    <div class="toast toast-top toast-start">
        <div class="alert alert-success">
          <span>{{ session('status') }}</span>
        </div>
      </div>
    @endif
    <div class="container mx-auto p-4">
        <div class="border rounded-lg shadow-lg flex flex-col justify-center p-6 mt-4 lg:mt-0">
            <span class="text-xl font-bold btn mb-4 ">Cart</span>
            <div class="flex flex-col gap-4">
                @foreach ($transactions as $transaction)
                @php
                    $totalBayar += $transaction->product->price * $transaction->quantity;
                @endphp
                <div class="border bg-base-100 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex gap-2 items-center">
                            <img src="{{ $transaction->product->photo }}" alt="none" class="w-24 h-24 rounded-lg">
                            <div class="flex flex-col">
                                <span class="text-lg font-bold">Rp.{{ number_format($transaction->product->price) }} {{ $transaction->quantity }}x</span>
                                <span class="badge badge-outline">{{ $transaction->product->name }}</span>
                            </div>
                        </div>
                        <form action="/cancel-cart/{{ $transaction->id }}" method="post">
                            @csrf
                            @method('DELETE')
                        <button type="submit" class="btn btn-error rounded-lg">Cancel</button>
                        </form>
                    </div>
                </div>
            @endforeach
            </div>

        </div>
    </div>

    <div class="btm-nav bg-transparent">
    @if ($totalBayar > $saldo_user)
    <div class="flex">
        <span>uang kurang</span>
    </div>
    @elseif($totalBayar == 0)
    <span></span>
    @else
    <div class="flex">
        <form action="/buy-from-cart" method="post">
            @csrf
            @method('PUT')
            <span>Rp.{{ number_format($totalBayar) }}</span>
            <button type="submit" class="btn">Buy</button>
        </form>
    </div>
    @endif


    </div>
@endsection
