@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Category'])
<div class="container-fluid my-5 py-2">
    <div class="d-flex justify-content-center mb-5">
        <div class="col-lg-9 mt-lg-0 mt-4">

            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Edit Category</h5>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{ route('category.update', ['category'=> $category]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Category Name</label>
                                <div class="input-group">
                                    <input id="name" name="name" class="form-control" type="text" placeholder="Name" value="{{ $category->name }}" onfocus="focused(this)" onfocusout="defocused(this)">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Description</label>
                                <div class="input-group">
                                    <input id="description" name="description" class="form-control" type="text" placeholder="Description" value="{{ $category->description }}" onfocus="focused(this)" onfocusout="defocused(this)">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="form-label mt-4">Status</label>
                            <div class="col-md-6 align-self-center">
                                <div class="choices" data-type="select-one" tabindex="0" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false">
                                    <select class="form-control" name="status">
                                        <option value="{{ $category->status }}" {{ $category->status == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="{{ $category->status }}" {{ $category->status == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <a href="https://argon-dashboard-pro-laravel.creative-tim.com/user-management" class="btn btn-light m-0">Back</a>
                            <button type="submit" class="btn bg-gradient-primary m-0 ms-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://argon-dashboard-pro-laravel.creative-tim.com/assets/js/plugins/choices.min.js"></script>
@endsection
