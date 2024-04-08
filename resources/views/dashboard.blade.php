@extends('layouts.master')
@section('css')
@section('title')
dashboard
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> Home </h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item" class="default-color">Home</li>
                <li class="breadcrumb-item active">Dashboard </li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row mb-30">
    <a href="{{route('getServices')}}" class="col-md-4 mb-4">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fa fa-cogs"></i> Services </h5>
                <p class="card-text text-dark">
                    We provide you with a unique opportunity to have full control over all services easily and smoothly
                </p>
            </div>
        </div>
    </a>
    <a href="{{route('getCountry')}}" class="col-md-4 mb-4">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fa fa-flag "></i> Countries </h5>
                <p class="card-text text-dark">
                    We provide you with a unique opportunity to have full control over all countries easily and smoothly
                </p>
            </div>
        </div>
    </a>
    <a href="{{route('getLocation')}}" class="col-md-4 mb-4">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fa fa-map-marker"></i> Locations </h5>
                <p class="card-text text-dark">
                    We provide you with a unique opportunity to have full control over all locations easily and smoothly
                </p>
            </div>
        </div>
    </a>
    <a href="{{route('admin.users.index')}}" class="col-md-4 mb-4">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fa fa-users"></i> Users </h5>
                <p class="card-text text-dark">
                    We provide you with a unique opportunity to have full control over all users easily and smoothly
                </p>
            </div>
        </div>
    </a>
    <a href="{{route('admin.providers.index')}}" class="col-md-4 mb-4">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fa fa-briefcase"></i> Professionals </h5>
                <p class="card-text text-dark">
                    We provide you with a unique opportunity to have full control over all professionals easily and smoothly
                </p>
            </div>
        </div>
    </a>
    <a href="#" class="col-md-4 mb-4">
        <div class="card text-center bg-light">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fa fa-picture-o"></i> Image Gallery </h5>
                <p class="card-text text-dark">
                    We provide you with a unique opportunity to have full control over all images for professionals easily and smoothly
                </p>
            </div>
        </div>
    </a>

</div>


<!-- row closed -->
@endsection
@section('js')

@endsection 
