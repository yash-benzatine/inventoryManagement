@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Supplier Edit')
@section('content')
<div class="row mt-4 mx-4">
    <div class="container-fluid my-5 py-2">
        <div class="d-flex justify-content-center mb-5">
            <div class="col-lg-9 mt-lg-0 mt-4">

                <div class="card mt-4" id="basic-info">
                    <div class="card-header">
                        <h5>Edit Supplier</h5>
                    </div>
                    <div class="card-body pt-0">
                        <form method="post" action="{{ route('supplier.update', ['supplier'=> $supplier]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="name" class="form-label">Name <span>*</span></label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $supplier->name }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $supplier->email }}">

                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="phone" class="form-label">Phone <span>*</span></label>
                                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $supplier->phone }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="address" class="form-label">Address <span>*</span></label>
                                    <textarea type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror">{{ $supplier->address }}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="discount_percentage" class="form-label">Discount Percentage</label>
                                    <input type="number" id="discount_percentage" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{ $supplier->discount }}">
                                    @error('discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="status" class="form-label">status</label>
                                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" {{ $supplier->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $supplier->status == 0 ? 'selected' : '' }}>Deactive</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="customFileLang" lang="en">
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="col-md-5 form-control-label">Gender</label>
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="gender" class="custom-control-input" id="customRadio5" type="radio" value="m" {{ $supplier->gender == 'm' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customRadio5">Male</label>
                                        <input name="gender" class="custom-control-input" id="customRadio5" type="radio" value="f" {{ $supplier->gender == 'f' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customRadio5">Female</label>
                                    </div>
                                    @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ url()->previous() }}" class="btn btn-light m-0">Back</a>
                                    <button type="submit" class="btn bg-gradient-primary m-0 ms-2">Save</button>
                                </div>

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
