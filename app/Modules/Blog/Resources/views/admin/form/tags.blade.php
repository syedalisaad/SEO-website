@php
    $tags       = \App\Models\PostTag::getAllTags();
    $old_tags   = (isset($data) && $data->tags->count() ? $data->tags->pluck('tag_name')->toArray() : []);
    $old_tags   = old('post_tags') ?? $old_tags;
@endphp
<div class="row form-group">
    <div class="col-sm-12">
        <div class="input-group">
            <select class="form-control select2" multiple="multiple" name="post_tags[]">
                @if( count($tags) )
                    @foreach( $tags as $tag)
                        <option {{ in_array($tag, $old_tags) ? 'selected' : '' }} value="{{ $tag }}">{{ $tag }}</option>
                    @endforeach
                @endif
            </select>
            @error('post_tags')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
@push('scripts')
<script>
$(function(){
    $(".select2").select2({tags: true});
})
</script>
@endpush
