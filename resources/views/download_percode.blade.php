@extends('template.temp_base')

@section('content')
    @php
        $totalBayar = 0;
    @endphp
    @forelse ($reports as $report)
        @php
            $totalBayar += $report->product->price * $report->quantity;
        @endphp
        <div class="card bg-base-100 p-6 mt-4">
            <span class="text-2xl font-bold">
                {{ $report->order_code }}
            </span>

            <div class="flex justify-between items-center mt-2">
                <div class="flex flex-col justify-center gap-1">
                    <span>{{ $report->product->name }}</span>
                    <div class="flex gap-4">
                        <span>Rp. {{ $report->product->price }}</span>
                        <span>{{ $report->quantity }}x</span>
                    </div>
                    <span>{{ $report->updated_at }}</span>
                </div>
            </div>
        </div>
    @empty
        <span>no data</span>
    @endforelse
    <span class="badge badge-outline mx-5">Total Bayar Rp. {{ $totalBayar }}</span>
@endsection
