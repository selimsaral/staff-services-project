@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">İş Güncelle</div>

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

                        <form action="{{ route('job-update', ['job' => $job->id]) }}" method="POST">

                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="İş Başlığı"
                                       value="{{ $job->name }}">
                            </div>

                            <div class="form-group">
                                <input type="text" name="description" class="form-control" placeholder="İş Açıklama"
                                       value="{{ $job->description }}">
                            </div>

                            <div class="form-group">
                                <select name="employee_id" id="" class="form-control">
                                    <option value="">Çalışan Seçiniz</option>
                                    @foreach($employees as $employee)
                                        <option @if($employee->id === $job->employee_id) selected="selected"
                                                @endif value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="city_id" id="" class="form-control city">
                                    <option value="">İl Seçiniz</option>
                                    @foreach($cities as $city)
                                        <option @if($city->id === $job->city_id) selected="selected" @endif
                                        value="{{ $city->id }}">
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="county_id" id="" class="form-control" data-id="{{ $job->county_id }}">
                                    <option value="">İlçe Seçiniz</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" name="address" class="form-control" placeholder="Adres"
                                       value="{{ $job->address }}">
                            </div>

                            <div class="form-group">
                                <input type="date" name="date" class="form-control"
                                       placeholder="Başlangıç Zamanı" value="{{ $job->date }}">
                            </div>

                            <div class="form-group">
                                <select name="period" class="form-control">
                                    <option value="">Period Seçin</option>
                                    <option @if($job->started_at == "09:00:00") selected="selected" @endif value="1">
                                        09:00 - 12:00
                                    </option>
                                    <option @if($job->started_at == "12:00:00") selected="selected" @endif value="2">
                                        12:00 - 18:30
                                    </option>
                                    <option @if($job->started_at == "18:30:00") selected="selected" @endif value="3">
                                        18:30 - 21:00
                                    </option>
                                </select>
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
