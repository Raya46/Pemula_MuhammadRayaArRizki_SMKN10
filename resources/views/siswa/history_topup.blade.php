@extends('template.temp_admin')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col p-3">
                <div class="flex flex-col ">
                    <div class="flex items-center justify-center text-2xl gap-3">
                        <span class="border shadow-lg bg-base-100 p-4 rounded-lg">History Topup</span>
                        <a href="/history" class="shadow-lg border bg-base-100 p-4 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="fill-black" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5m14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5" />
                            </svg>
                        </a>
                    </div>
                    <div class="flex my-4 gap-4">
                        <div class="flex flex-col gap-2 bg-white rounded-lg p-6 shadow-lg w-full">
                            <span class="text-lg font-bold">Pemasukan</span>
                            <span class="badge badge-outline text-green-500">Rp.{{ number_format($credit) }}</span>
                        </div>
                        <div class="flex flex-col gap-2 bg-white rounded-lg p-6 shadow-lg w-full">
                            <span class="text-lg font-bold">Pengeluaran</span>
                            <span class="badge badge-outline text-red-500">Rp.{{ number_format($debit) }}</span>
                        </div>
                    </div>
                    @foreach ($wallets as $wallet)
                        @if ($wallet->credit != 0)
                            <div class="shadow-lg border bg-base-100 p-6 mt-4">
                                <div class="flex justify-between items-center">
                                    <div class="flex flex-col">
                                        <span class="card-title font-bold">
                                            Rp. {{ number_format($wallet->credit) }}
                                        </span>
                                        <span class="text-sm text-gray-500">{{ $wallet->updated_at }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="badge badge-outline p-3">{{ $wallet->status }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>

        </div>
    </div>

    <div class="fixed bottom-0 flex justify-center w-full">
        <a href="/download?type=topup" target="_blank" class="btn">Download All</a>
    </div>
@endsection
