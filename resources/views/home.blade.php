@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                     <form  method="POST" action="{{ route('loadOrders') }}" enctype="multipart/form-data">
                        @csrf
                    {{ __('Import Excel File') }}
                    <div class="custom-file">
                        <input type="file" name="import" class="custom-file-input importorders" id="myFile" accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        <label class="custom-file-label" id="path" for="myFile">
                            Choose file Excel
                        </label>
                        <br>
                    </div>
                    <div class=" text-center mt-3">
                        <button class="btn badge-info">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
