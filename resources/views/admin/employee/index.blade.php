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

                        <form action="{{ route('employee-create') }}" method="POST">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Çalışan İsmi">
                            </div>

                            <div class="form-group">
                                <input type="text" name="email" class="form-control" placeholder="Çalışan Email">
                            </div>

                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" placeholder="Çalışan Telefon">
                            </div>

                            <div class="form-group">
                                <input type="text" name="password" class="form-control" placeholder="Uygulama Giriş Şifresi">
                            </div>

                            <button type="submit" class="btn btn-primary">Kaydet</button>
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Çalışan Listesi</div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>İsim</th>
                                <th>Email</th>
                                <th>Telefon</th>
                                <th>Oluşturulma Tarihi</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <a href="{{ route('employee-show',['employee' => $item->id]) }}">Güncelle</a>
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
@endsection
