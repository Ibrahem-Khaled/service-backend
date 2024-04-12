@extends('layouts.master')
@section('css')

@section('title')
Gallery
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">Galleries</h4>
        </div>
        <!-- <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item">
                    <div>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" style="font-size: 18px; font-family:Amiri;line-height: 1.2;"><i class="fa fa-user"></i> -
                            Add New Providers
                        </button>
                    </div>
                </li>
            </ol>
        </div> -->
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- errors -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!-- end errors -->


<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered p-0" style="text-align:center">
                        <thead>
                            <tr>
                                <th>image</th>
                                <th>user id</th>
                                <th>first name</th>
                                <th>last name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($galleries as $image)
                            <tr>
                                <td>
                                <img src="{{ asset($image->image) }}" style="width:40px;height:40px" alt="">
                                </td>
                                <td>{{$image->provider->id}}</td>
                                <td>{{$image->provider->first_name}}</td>
                                <td>{{$image->provider->last_name}}</td>
                                <td>
                                    <!-- Button trigger modal delete -->
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$image->id}}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="modal fade" id="delete{{$image->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Gallerry</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('deleteGallery',$image->id)}}" method="post">
                                                    @csrf
                                                    <h4 class="modal-body">
                                                        Are you sure you want to delete this Gallery?
                                                    </h4>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Button trigger modal show -->
                                    <!-- <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#show">
                          <i class="fa fa-eye"></i>
                          </button>
                 -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')

@endsection