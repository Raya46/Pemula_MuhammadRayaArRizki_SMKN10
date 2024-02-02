@extends('template.temp_base')

@section('content')
    <div class="container mx-auto">
    <div class="flex flex-col p-6 gap-3">
        @if ($params == 'topup')
            @forelse ($wallets as $wallet)
            <div class="card card-body bg-base-100 border border-white">
                <span class="text-lg font-bold text-green-500">Credit: +Rp.{{number_format($wallet->credit)}}</span>
                <span class="text-lg font-bold text-red-500">Debit: -Rp.{{number_format($wallet->debit)}}</span>
                <div class="flex">
                    <span class="badge badge-outline">{{ $wallet->user->name ?? Auth::user()->name }}</span>
                    <span class="badge badge-outline">Status: {{$wallet->status}}</span>
                </div>
                <span class="text-xs text-gray-500">{{$wallet->updated_at}}</span>
            </div>
            @empty
                <span>no data</span>
            @endforelse
        @else
            @forelse ($transactions as $ts)
                <div class="card card-body border border-white">
                    <div class="flex items-center gap-4">
                        <img src="{{ $ts->product->photo }}" alt="none" class="w-24 h-24 object-cover rounded-lg">
                        <div class="flex flex-col gap-2">
                            <span class="text-lg font-bold">{{ $ts->product->name }}</span>
                            <span>Rp.{{ number_format($ts->product->price) }} {{$ts->quantity}}x</span>
                            <div class="flex">
                                <span class="badge badge-outline">{{ $ts->user->name ?? Auth::user()->name }}</span>
                                <span class="badge badge-outline">{{ $ts->status }}</span>
                            </div>
                            <span class="text-xs text-gray-500">{{ $ts->updated_at }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <span>no data</span>
            @endforelse
        @endif
    </div>
    </div>
@endsection
