@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Çalışan Ekle</div>

                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                <p>{{ session()->get('success') }}</p>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('employee-update', ['employee' => $employee->id]) }}" method="POST">

                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Çalışan İsmi"
                                       value="{{ $employee->name }}">
                            </div>

                            <div class="form-group">
                                <input type="text" name="email" class="form-control" placeholder="Çalışan Email"
                                       value="{{ $employee->email }}">
                            </div>

                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" placeholder="Çalışan Telefon"
                                       value="{{ $employee->phone }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Güncelle</button>
                            @csrf

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
