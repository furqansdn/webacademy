@extends('client.layouts.app')

@section('content-header')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1>Daftar Biaya</h1>
      <p class="lead">Sesuaikan dengan kebutuhan kamu</p>
    </div>
</div>
@endsection

@section('content')
<section class="pricing py-5">
    <div class="container">
      <div class="row">
        <!-- Free Tier -->
        @foreach ($plans as $plan)   
        <div class="col-lg-4">
          <div class="card mb-5 mb-lg-0">
              <h5 class="card-title text-uppercase text-center">{{$plan->name}}</h5>
            <div class="card-body">
              <h5 class="card-price text-center">IDR {{$plan->price/1000}}K</h5>
              <hr>
              <p class="text-center">Dapat {{$plan->month_of_subscription}} Bulan Akses</p>
              <a href="{{ route('client::subscription.invoice', $plan->id) }}" class="btn btn-block text-uppercase btn-subscribe">Subscribe</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
</section>
@endsection

@push('style')
    <style>
      .card .card-body {
        padding: 10px 15px;
        color: #6c5ce7;
      }
      .pricing .card {
        border: none;
        border-radius: 1rem;
        transition: all 0.2s;
        box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        background: #F3F6F7;
      }
      .card .card-title {
        color: #6c5ce7;
        font-size: 30px;
        font-weight: 600;
        padding: 15px 0;
      }
      .card-price {
        font-size: 22px;
        font-weight: 500;
      }

      .card .card-body p {
        font-size: 18px;
        font-weight: 500;
      }

      .btn-subscribe {
        background: #6c5ce7;
        color: #F3F6F7;
        font-weight: 600;
        border: 2px solid transparent;
        font-size: 18px;
        border-radius: 25px;
        transition: all 0.5s ease;
      }

      .btn-subscribe:hover {
        color: #6c5ce7;
        background: #F3F6F7;
        border: 2px solid #6c5ce7;
      }
      /* Hover Effects on Card */

      @media (min-width: 992px) {
        .pricing .card:hover {
          margin-top: -.25rem;
          margin-bottom: .25rem;
          box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.3);
        }
        .pricing .card:hover .btn {
          opacity: 1;
        }
      }
    </style>
@endpush