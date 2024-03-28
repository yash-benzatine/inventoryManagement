@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Category Edit')
@section('content')
<div class="row mt-4 mx-4">
    <div class="container-fluid my-5 py-2">
        <div class="d-flex justify-content-center mb-5">
            <div class="col-lg-9 mt-lg-0 mt-4">

                <div class="card mt-4" id="basic-info">
                    <div class="card-header">
                        <h5>New Category</h5>
                    </div>
                    <div class="card-body pt-0">
                        <form method="POST" action="{{ route('category.update', ['category'=>$category]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Name</label>
                                    <div class="input-group">
                                        <input id="name" name="name" class="form-control" type="text" placeholder="Name" value="{{ $category->name }}" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Description</label>
                                    <div class="input-group">
                                        <input id="description" name="description" class="form-control" type="text" placeholder="Description" value="{{ $category->description }}" onfocus="focused(this)" onfocusout="defocused(this)">

                                    </div>
                                    @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label mt-4">Status</label>
                                    {{-- <div class="col-md-6 align-self-center"> --}}
                                    <div class="choices" data-type="select-one" tabindex="0" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false">
                                        <select class="form-control" name="status">
                                            <option value="">Choose</option>
                                            <option value="1" {{ $category->status == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $category->status == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    {{-- </div> --}}
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
</div>
@endsection
@section('page-script')
@endsection
