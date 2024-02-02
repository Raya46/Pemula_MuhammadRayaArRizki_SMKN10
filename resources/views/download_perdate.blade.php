@extends('template.temp_base')

@section('content')
    @php
        $totalBayar = 0;
    @endphp
    <div class="container mx-auto p-4">
        <span class="text-2xl font-bold ">{{ $code }}</span>
        @forelse ($reports as $report)
            @php
                $totalBayar += $report->product->price * $report->quantity;
            @endphp
            <div class="card bg-base-100">
                <div class="flex justify-between items-center mt-2">
                    <div class="flex flex-col justify-center gap-1">
                        <span class="text-lg font-bold">{{ $report->product->name }}</span>
                        <div class="flex gap-4">
                            <span>Rp. {{ $report->product->price }}</span>
                            <span>{{ $report->quantity }}x</span>
                        </div>
                        <span>{{ $report->created_at }}</span>
                        <span class="badge badge-outline">{{ $report->user->name }}</span>
                    </div>
                </div>
            </div>
        @empty
            <span>no data</span>
            {{ $code }}
        @endforelse
        <span class="badge badge-outline mt-5">Total Bayar Rp. {{ $totalBayar }}</span>
    </div>
@endsection
