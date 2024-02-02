@extends('template.temp_admin')

@section('content')
    @if (session('status'))
        <div class="toast toast-top toast-start">
            <div class="alert alert-success">
                <span>{{ session('status') }}</span>
            </div>
        </div>
    @endif
    <main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-6">
        <div class="flex items-center">
            <h1 class="font-semibold text-lg md:text-2xl">Confirm Transaction</h1>
        </div>
        <div class="border shadow-lg rounded-lg">
            <div class="relative w-full overflow-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-lg">Name</th>
                            <th class="text-lg">Status</th>
                            <th class="text-lg">Quantity</th>
                            <th class="text-lg">User</th>
                            <th class="text-lg">Price</th>
                            <th class="text-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $ts)
                            <tr>
                                <td>{{ $ts->product->name }}</td>
                                <td class="flex flex-col justify-center">
                                    <span class="badge badge-outline">{{ $ts->status }}</span>
                                    <span class="text-xs text-gray-500 mt-2">{{ Carbon\Carbon::parse($ts->updated_at)->diffForHumans() }}</span>
                                </td>
                                <td>{{ $ts->quantity }}</td>
                                <td>{{ $ts->user->name }}</td>
                                <td>Rp.{{ number_format($ts->product->price) }}</td>
                                <td>
                                    @if ($ts->status == 'dibayar')
                                        <form action="/confirm-product/{{ $ts->id }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-success">Confirm</button>
                                        </form>
                                    @else
                                        <span class="btn">Confirmed</span>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>
@endsection
