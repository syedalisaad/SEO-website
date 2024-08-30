{{--<div class="row form-group">--}}
{{--    <select name="hospital_id" class="select2 @error('hospital_id') is-invalid @enderror" style="width: 100%;">--}}
{{--        @php $hospitals     = App\Models\Hospital::getLists(); @endphp--}}
{{--        @php $hospital_id   = old('hospital_id', $data->detail->hospital_id ?? null); @endphp--}}
{{--        @if( count($hospitals) )--}}
{{--            @foreach($hospitals as $key => $value )--}}
{{--                <option {{ $hospital_id == $key ? 'selected' : '' }} value="{{ $key }}"> {{ $value }} </option>--}}
{{--            @endforeach--}}
{{--        @endif--}}
{{--    </select>--}}
{{--    @error('hospital_id')<span class="error invalid-feedback">{{ $message }}</span>@enderror--}}
{{--</div>--}}

{{--<div class="row form-group">--}}
{{--    <div class="col-sm-2">--}}
{{--        @php $is_hospital = old('is_hospital_approved', $data->detail->is_hospital_approved ?? 0 ); @endphp--}}
{{--        <div class="form-group">--}}
{{--            <label class="cust-label">Approved <strong style="color:#c00">*</strong></label>--}}
{{--            <div class="custom-control custom-switch">--}}
{{--                <input type="checkbox" name="is_hospital_approved" {{ $is_hospital == 1 ? 'checked' : '' }} class="custom-control-input" id="isHospital" value="1">--}}
{{--                <label class="custom-control-label" for="isHospital">Visibilty</label>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
