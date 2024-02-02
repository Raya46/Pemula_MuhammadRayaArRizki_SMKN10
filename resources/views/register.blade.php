@extends('template.temp_unknown')

@section('content')
<div class="hero min-h-screen bg-base-200">
    <div class="hero-content flex-col lg:flex-row-reverse">
      <div class="text-center lg:text-left">
        <h1 class="text-5xl font-bold">Register now!</h1>
        <p class="py-6">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem quasi. In deleniti eaque aut repudiandae et a id nisi.</p>
      </div>
      <div class="card shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
        <form class="card-body" action="/post-register" method="POST">
            @csrf
          <div class="form-control">
            <label class="label">
              <span class="label-text">Name</span>
            </label>
            <input type="text" name="name" placeholder="Name" class="input input-bordered" required />
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text">Password</span>
            </label>
            <input type="password" name="password" placeholder="password" class="input input-bordered" required />
            <label class="label">
              <a href="/login" class="label-text-alt link link-hover">Already have account?</a>
            </label>
          </div>
          <div class="form-control mt-6">
            <button class="btn btn-primary">Register</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
