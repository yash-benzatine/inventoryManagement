@extends('admin.layout.master')
@section('title', 'Sub Category Edit')
@section('content')
<div class="container-fluid my-5 py-2">
    <div class="d-flex justify-content-center mb-5">
        <div class="col-lg-9 mt-lg-0 mt-4">

            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Edit Sub Category</h5>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{ route('category.update', ['category'=> $category]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <div class="choices" data-type="select-one" tabindex="0" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false">
                                    <select class="form-control @error('cat_id') is-invalid @enderror" name="cat_id">
                                        <option value="">Choose</option>
                                        @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id == $category->cat_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cat_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Name</label>
                                <div class="input-group">
                                    <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Name" value="{{ $category->name }}" onfocus="focused(this)" onfocusout="defocused(this)">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6">
                                <label class="form-label">Description</label>
                                <div class="input-group">
                                    <input id="description" name="description" class="form-control @error('description') is-invalid @enderror" type="text" placeholder="Description" value="{{ $category->description }}" onfocus="focused(this)" onfocusout="defocused(this)">
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Status</label>
                                <div class="choices" data-type="select-one" tabindex="0" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false">
                                    <select class="form-control @error('status') is-invalid @enderror" name="status">
                                        <option value="1" {{ $category->status == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $category->status == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn bg-gradient-primary m-0 ms-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-script')
@endsection
