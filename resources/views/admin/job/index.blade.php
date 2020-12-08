@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">İş Ekle</div>

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

                        <form action="{{ route('job-create') }}" method="POST">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="İş Başlığı">
                            </div>

                            <div class="form-group">
                                <input type="text" name="description" class="form-control" placeholder="İş Açıklama">
                            </div>

                            <div class="form-group">
                                <select name="employee_id" id="" class="form-control">
                                    <option value="">Çalışan Seçiniz</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="city_id" id="" class="form-control city">
                                    <option value="">İl Seçiniz</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="county_id" id="" class="form-control">
                                    <option value="">İlçe Seçiniz</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" name="address" class="form-control" placeholder="Adres">
                            </div>

                            <div class="form-group">
                                <input type="date" name="date" class="form-control"
                                       placeholder="Başlangıç Zamanı">
                            </div>

                            <div class="form-group">
                                <select name="period" class="form-control">
                                    <option value="">Period Seçin</option>
                                    <option value="1">09:00 - 12:00</option>
                                    <option value="2">12:00 - 18:30</option>
                                    <option value="3">18:30 - 21:00</option>
                                </select>
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
                    <div class="card-header">İş Listesi</div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>İş Başlığı</th>
                                <th>Personel</th>
                                <th>Tarih</th>
                                <th>Saat Periodu</th>
                                <th>Öncelik ( 1 : En Öncelikli )</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->employee->name }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ Illuminate\Support\Carbon::parse($item->started_at)->format('H:i') }}
                                        - {{ Illuminate\Support\Carbon::parse($item->finished_at)->format('H:i') }}
                                    </td>
                                    <td>{{ $item->priority }}</td>
                                    <td>
                                        <a href="{{ route('job-show',['job' => $item->id]) }}">Güncelle</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $list->links('vendor.pagination.bootstrap-4') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
