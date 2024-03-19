@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'User Setting')
@section('content')
<div class="row mt-4 mx-4">
    <div class="container-fluid my-5 py-2">
        <div class="d-flex justify-content-center mb-5">
            <div class="col-lg-9 mt-lg-0 mt-4">

                <div class="card mt-4" id="basic-info">
                    <div class="card-header">
                        <h5>Company</h5>
                    </div>
                    <div class="card-body pt-0">
                        <form method="post" enctype="multipart/form-data" class="" action="{{ route('setting.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" id="company_name" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ $setting->company_name ?? '' }}">
                                    @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="number" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $setting->phone ?? '' }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $setting->email ?? '' }}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror">{{ $setting->address ?? '' }}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="currency" class="form-label">Currency</label>
                                    <input type="currency" id="phone" name="currency" class="form-control @error('currency') is-invalid @enderror" value="{{ $setting->currency ?? '' }}">
                                    @error('currency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">image</label>
                                    <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if(!empty($setting->image))
                                    <img src="{{ asset('admin/setting/'. $setting->image)}}" class="mt-3" height="100" width="100">
                                    @endif
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
<script>
    $(document).ready(function() {
        // Function to generate random 8-digit number
        function generateRandomNumber() {
            return Math.floor(10000000 + Math.random() * 90000000);
        }

        // Set the generated number to the serial_number input field
        $('#serial_number').val(generateRandomNumber());
    });

</script>


@endsection
