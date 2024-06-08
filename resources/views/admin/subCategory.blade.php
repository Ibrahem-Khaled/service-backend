@extends('layouts.master')

@section('css')
@endsection

@section('title')
    Sub Categories
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0">Sub Categories</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item">
                        <div>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal"
                                style="font-size: 18px; font-family: Amiri; line-height: 1.2;">
                                <i class="fa fa-cogs"></i> - Add New Sub Category
                            </button>
                        </div>
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

    <!-- Add Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Sub Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sub_categories.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">job</label>
                            <select name="job_id" class="form-control" required>
                                @foreach ($services as $job)
                                    <option value="{{ $job->id }}">{{ $job->name }}</option>
                                @endforeach
                        </div>

                        <div class="form-group">
                            <label for="name">Sub Category Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Sub Category Name"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="image" style="font-size: 13px; font-weight: bold;">Sub Category Image
                                (Optional)</label>
                            <input type="file" name="image" class="form-control">
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
    <!-- end Add Modal -->

    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered p-0" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>Sub Category Name</th>
                                    <th>job Name</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subCategories as $subCategory)
                                    <tr>
                                        <td>{{ $subCategory->name }}</td>
                                        <td>{{ $subCategory?->job?->name }}</td>
                                        <td>
                                            @if ($subCategory->image)
                                                <img src="{{ asset('public/storage/' . $subCategory->image) }}"
                                                    alt="Sub Category Image" width="100">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-info btn-sm">Edit</a>
                                            <form action="{{ route('sub_categories.destroy', $subCategory->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
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
