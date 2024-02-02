@extends('template.temp_admin')

@section('content')
    <div class="modal" role="dialog" id="my_modal_8">
        <form action="/topup-bank" class="modal-box" method="POST">
            @csrf
            <h3 class="font-bold text-lg">Top up</h3>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-4">
                    <span>To:</span>
                    <select class="select" name="users_id" name="users_id">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-4">
                    <span>Rp.</span>
                    <input type="number" name="credit" value="10000" class="input input-bordered">
                </div>
            </div>

            <div class="modal-action">
                <button type="submit" class="btn">Top up</button>
                <a href="#" class="btn">Yay!</a>
            </div>
        </form>
    </div>
    <div class="modal" role="dialog" id="my_modal_wd">
        <form action="/withdraw-bank" class="modal-box" method="POST">
            @csrf
            <h3 class="font-bold text-lg">Withdraw</h3>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-4">
                    <span>To:</span>
                    <select class="select" name="users_id" name="users_id">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-4">
                    <span>Rp.</span>
                    <input type="number" name="debit" value="10000" class="input input-bordered">
                </div>
            </div>

            <div class="modal-action">
                <button type="submit" class="btn">withdraw</button>
                <a href="#" class="btn">Yay!</a>
            </div>
        </form>
    </div>
    @if(session('status'))
        <div class="toast toast-top toast-start">
            <div class="alert alert-success">
              <span>{{ session('status') }}</span>
            </div>
          </div>
    @endif
    <div class="container mx-auto">
        <div class="flex flex-col p-4">
            <div class="flex w-full gap-3 my-4">
                <div class="flex flex-col w-full">
                    <div class="w-full border rounded-lg bg-base-100 p-10 shadow-lg">
                        <h2 class="font-bold text-center text-black text-lg">halo {{ Auth::user()->name }}</h2>
                            <div class="flex items-center justify-center gap-4">
                                <a href="#my_modal_8" class="btn btn-info mt-2 rounded-lg">Top up</a>
                                <a href="#my_modal_wd" class="btn btn-warning mt-2 rounded-lg">withdraw</a>
                            </div>
                    </div>
                </div>
                <div class="flex flex-col w-full">
                    <div class="w-full border rounded-lg p-10 shadow-lg">
                        <h2 class="text-black text-center font-bold text-lg">Nasabah</h2>
                            <div class="flex items-center justify-center">
                                <span class="btn btn-error mt-2 rounded-lg">{{ $users->count() }}</span>
                            </div>
                    </div>
                </div>

            </div>
            <div class="flex flex-col mt-4 lg:flex-row w-full border shadow-lg rounded-lg">
                <div class="flex flex-col w-full p-4">
                    <span class="text-center mb-4 btn border">Request topup</span>
                    @foreach ($walletsBank as $wb)
                        <div class="flex items-center w-full border rounded-lg my-2">
                            <div class="flex flex-col p-4 w-full ">
                                <div class="flex gap-2 w-full">
                                    <span>Rp.{{ number_format($wb->credit) }}</span>
                                    <span class="badge badge-outline">{{ $wb->user->name }}</span>
                                </div>
                                <span class="badge badge-outline text-xs">{{ $wb->status }}</span>
                                <span class="text-xs text-gray-500">{{ $wb->created_at }}</span>
                            </div>
                            <form action="/topup-accept/{{ $wb->id }}" method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success mr-4 rounded-lg">Accept</button>
                            </form>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col w-full p-4">
                    <span class="text-center mb-4 btn">Request Withdraw</span>
                    @foreach ($withdrawBank as $wb)
                        <div class="flex items-center w-full border rounded-lg my-2">
                            <div class="flex flex-col p-4 w-full">
                                <div class="flex gap-2 w-full">
                                    <span>Rp.{{ number_format($wb->debit) }}</span>
                                    <span class="badge badge-outline">{{ $wb->user->name }}</span>
                                </div>
                                <span class="badge badge-outline text-xs">{{ $wb->status }}</span>
                                <span class="text-xs text-gray-500">{{ $wb->created_at }}</span>

                            </div>
                            <form action="/withdraw-accept/{{ $wb->id }}" method="post">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="users_id" value="{{ $wb->user->id }}">
                                <input type="hidden" name="debit" value="{{ $wb->debit }}">
                                <button type="submit" class="btn btn-success mr-4 rounded-lg">Accept</button>
                            </form>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col w-full p-4">
                    <a href="/history-topup-bank" target="_blank" class="text-center mb-4 btn border">History Topup</a>
                    @foreach ($historyTopup as $wb)
                    @if ($wb->credit != 0)
                    <div class="flex items-center w-full border rounded-lg my-2">
                        <div class="flex flex-col p-4 w-full">
                            <div class="flex gap-2 w-full">
                                <span>Rp.{{ number_format($wb->credit) }}</span>
                                <span class="badge badge-outline">{{ $wb->user->name }}</span>

                            </div>
                            <span class="badge badge-outline text-xs">{{ $wb->status }}</span>
                            <span class="text-xs text-gray-500">{{ $wb->created_at }}</span>

                        </div>
                    </div>
                    @endif

                    @endforeach
                </div>
                <div class="flex flex-col w-full p-4">
                    <a href="/history-withdraw-bank" target="_blank" class="text-center mb-4 btn border">History Withdraw</a>
                    @foreach ($historyWithdraw as $wb)
                    @if ($wb->debit != 0)
                    <div class="flex items-center w-full border rounded-lg my-2">
                        <div class="flex flex-col p-4 w-full">
                            <div class="flex gap-2 w-full">
                                <span>Rp.{{ number_format($wb->debit) }}</span>
                                <span class="badge badge-outline">{{ $wb->user->name }}</span>
                            </div>
                            <span class="badge badge-outline text-xs">{{ $wb->status }}</span>
                            <span class="text-xs text-gray-500">{{ $wb->created_at }}</span>

                        </div>
                    </div>
                    @endif

                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
