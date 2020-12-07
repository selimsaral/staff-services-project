<option value="">İlçe Seçiniz</option>
@foreach($counties as $county)
    <option value="{{ $county->id }}">{{ $county->name }}</option>
@endforeach
