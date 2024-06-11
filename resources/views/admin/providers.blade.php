@extends('layouts.master')
@section('css')
@section('title')
    Providers
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">Providers</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item">
                    <div>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal"
                            style="font-size: 18px; font-family:Amiri;line-height: 1.2;"><i class="fa fa-user"></i> -
                            Add New Providers
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
<!--  Add Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Provider</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.providers.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" class="form-control" placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="text" name="years_experience" class="form-control"
                            placeholder="Years of Experience">
                    </div>
                    <div class="form-group">
                        <label style="font-size: 13px; font-weight: bold;" class="ml-3">Service</label>
                        <select name="job_id" id="job_id" class="form-control">
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-size: 13px; font-weight: bold;" class="ml-3">SubCategory</label>
                        <select name="sub_category_id" id="sub_category_id" class="form-control">
                            @foreach ($subCategories as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-size: 13px; font-weight: bold;" class="ml-3">Location</label>
                        <select name="location_id" class="form-control">
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-size: 13px; font-weight: bold;" class="ml-3">image (Optional)</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label style="font-size: 13px; font-weight: bold;" class="ml-3">identity_card
                            (Optional)</label>
                        <input type="file" name="identity_card" class="form-control">
                    </div>
                    <div class="form-group">
                        <label style="font-size: 13px; font-weight: bold;" class="ml-3">Status</label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-size: 13px; font-weight: bold;" class="ml-3">Is Featured</label>
                        <select name="is_featured" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-size: 13px; font-weight: bold;" class="ml-3">Type</label>
                        <select name="type" class="form-control">
                            <option value="admin">Admin</option>
                            <option value="seeker">Seeker</option>
                            <option value="provider">Provider</option>
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
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Years of Experience</th>
                                <th>Location </th>
                                <th>Service </th>
                                <th>Avatar</th>
                                <th>identity_card</th>
                                <th>Status</th>
                                <th>is_featured</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($providers as $provider)
                                <tr>
                                    <td>{{ $provider->first_name }}</td>
                                    <td>{{ $provider->last_name }}</td>
                                    <td>{{ $provider->username }}</td>
                                    <td>{{ $provider->phone }}</td>
                                    <td>{{ $provider->years_experience }}</td>
                                    <td>{{ optional($provider->location)->title }}</td>
                                    <td>{{ optional($provider->Jobs)->name }}</td>
                                    <td><img src="{{ asset($provider->image) }}" style="width:40px;height:40px"
                                            alt=""></td>
                                    <td><img src="{{ asset($provider->identity_card) }}"
                                            style="width:40px;height:40px" alt="identity_card"></td>
                                    <td><span
                                            class="bg-{{ $provider->status == 'active' ? 'primary' : 'danger' }} p-1 text-light rounded">{{ $provider->status == 'active' ? 'Active' : 'Inactive' }}</span>
                                    </td>
                                    <td><span
                                            class="bg-{{ $provider->is_featured == 1 ? 'warning' : 'danger' }} p-1 text-light rounded">{{ $provider->is_featured == 1 ? 'futer' : 'no futer' }}</span>
                                    </td>
                                    <td>
                                        <a class="btn {{ $provider->active ? 'btn-primary' : 'btn-dark' }} btn-sm"
                                            href="{{ route('admin.providers.toggle-status', $provider->id) }}">
                                            <i class="fa {{ $provider->active ? 'fa-check' : 'fa-times' }}"></i>
                                        </a>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#edit{{ $provider->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $provider->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="edit{{ $provider->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="editLabel{{ $provider->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editLabel{{ $provider->id }}">Edit
                                                    Provider</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('updateProviders', $provider->id) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <input type="text" name="first_name" class="form-control"
                                                            value="{{ $provider->first_name }}"
                                                            placeholder="First Name">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="last_name" class="form-control"
                                                            value="{{ $provider->last_name }}"
                                                            placeholder="Last Name">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="username" class="form-control"
                                                            value="{{ $provider->username }}" placeholder="Username">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="phone" class="form-control"
                                                            value="{{ $provider->phone }}" placeholder="Phone">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" name="password" class="form-control"
                                                            placeholder="Password (leave blank if not changing)">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="years_experience"
                                                            class="form-control"
                                                            value="{{ $provider->years_experience }}"
                                                            placeholder="Years of Experience">
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 13px; font-weight: bold;"
                                                            class="ml-3">Service</label>
                                                        <select name="job_id" id="edit_job_id{{ $provider->id }}"
                                                            class="form-control">
                                                            @foreach ($services as $service)
                                                                <option value="{{ $service->id }}"
                                                                    {{ $provider->job_id == $service->id ? 'selected' : '' }}>
                                                                    {{ $service->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 13px; font-weight: bold;"
                                                            class="ml-3">SubCategory</label>
                                                        <select name="sub_category_id"
                                                            id="edit_sub_category_id{{ $provider->id }}"
                                                            class="form-control">
                                                            @foreach ($subCategories as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 13px; font-weight: bold;"
                                                            class="ml-3">Location</label>
                                                        <select name="location_id" class="form-control">
                                                            @foreach ($locations as $location)
                                                                <option value="{{ $location->id }}"
                                                                    {{ $provider->location_id == $location->id ? 'selected' : '' }}>
                                                                    {{ $location->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 13px; font-weight: bold;"
                                                            class="ml-3">image (Optional)</label>
                                                        <input type="file" name="image" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 13px; font-weight: bold;"
                                                            class="ml-3">identity_card (Optional)</label>
                                                        <input type="file" name="identity_card"
                                                            class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 13px; font-weight: bold;"
                                                            class="ml-3">Status</label>
                                                        <select name="status" class="form-control">
                                                            <option value="active"
                                                                {{ $provider->status == 'active' ? 'selected' : '' }}>
                                                                Active</option>
                                                            <option value="inactive"
                                                                {{ $provider->status == 'inactive' ? 'selected' : '' }}>
                                                                Inactive</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 13px; font-weight: bold;"
                                                            class="ml-3">Is Featured</label>
                                                        <select name="is_featured" class="form-control">
                                                            <option value="0"
                                                                {{ $provider->is_featured == 0 ? 'selected' : '' }}>No
                                                            </option>
                                                            <option value="1"
                                                                {{ $provider->is_featured == 1 ? 'selected' : '' }}>Yes
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-size: 13px; font-weight: bold;"
                                                            class="ml-3">Type</label>
                                                        <select name="type" class="form-control">
                                                            <option value="admin"
                                                                {{ $provider->type == 'admin' ? 'selected' : '' }}>
                                                                Admin</option>
                                                            <option value="seeker"
                                                                {{ $provider->type == 'seeker' ? 'selected' : '' }}>
                                                                Seeker</option>
                                                            <option value="provider"
                                                                {{ $provider->type == 'provider' ? 'selected' : '' }}>
                                                                Provider</option>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="delete{{ $provider->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteLabel{{ $provider->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteLabel{{ $provider->id }}">Delete
                                                    Provider</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.providers.destroy', $provider->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <p>Are you sure you want to delete this provider?</p>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
<script>
    $(document).ready(function() {
        // Function to fetch subcategories based on the selected category
        function fetchSubCategories(categoryId, subCategorySelectId) {
            $.ajax({
                url: '/api/subcategories/' + categoryId, // Adjust the URL based on your API endpoint
                method: 'GET',
                success: function(data) {
                    var options = '<option value="">Select SubCategory</option>';
                    $.each(data, function(index, subCategory) {
                        options += '<option value="' + subCategory.id + '">' + subCategory
                            .name + '</option>';
                    });
                    $(subCategorySelectId).html(options);
                }
            });
        }

        // Event listener for the service select in the add modal
        $('#job_id').change(function() {
            var categoryId = $(this).val();
            fetchSubCategories(categoryId, '#sub_category_id');
        });

        // Event listener for the service select in the edit modals
        @foreach ($providers as $provider)
            $('#edit_job_id{{ $provider->id }}').change(function() {
                var categoryId = $(this).val();
                fetchSubCategories(categoryId, '#edit_sub_category_id{{ $provider->id }}');
            });

            // Fetch initial subcategories for the edit modal
            var initialCategoryId = $('#edit_job_id{{ $provider->id }}').val();
            fetchSubCategories(initialCategoryId, '#edit_sub_category_id{{ $provider->id }}');
        @endforeach

        // Initialize subcategories for the add modal
        var initialAddCategoryId = $('#job_id').val();
        fetchSubCategories(initialAddCategoryId, '#sub_category_id');
    });
</script>
@endsection
