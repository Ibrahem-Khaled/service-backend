@extends('layouts.master')
@section('css')
@endsection

@section('title')
    Gallery
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0">Galleries</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addGalleryModal"
                            style="font-size: 18px; font-family:Amiri;line-height: 1.2;">
                            <i class="fa fa-image"></i> - Add New Gallery
                        </button>
                    </li>
                </ol>
            </div>
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

    <!-- Add Gallery Modal -->
    <div class="modal fade" id="addGalleryModal" tabindex="-1" role="dialog" aria-labelledby="addGalleryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGalleryModalLabel">Add Gallery</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('createGallery') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="provider_id">Provider</label>
                            <select name="provider_id" class="form-control" required>
                                @foreach ($providers as $provider)
                                    <option value="{{ $provider->id }}">{{ $provider->first_name }}
                                        {{ $provider->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered p-0" style="text-align:center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>User Provider</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($galleries as $image)
                                    <tr>
                                        <td><img src="{{ asset($image->image) }}" style="width:40px;height:40px"
                                                alt=""></td>
                                        <td>{{ $image->provider->first_name }} {{ $image->provider->last_name }}</td>
                                        <td>
                                            <!-- Delete Button trigger modal -->
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#delete{{ $image->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete{{ $image->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete Gallery
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('admin.galleries.destroy', $image->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this Gallery?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
