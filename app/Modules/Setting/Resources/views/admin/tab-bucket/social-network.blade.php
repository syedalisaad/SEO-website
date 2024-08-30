<form action="{{ route('admin.site.save_setting') }}" method="POST">
    @csrf
    <div class="card-body">
        <h4>Social Links Information</h4><br/>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Facebook:</label>
            <div class="col-sm-6">
                <input type="text" name="social_links[facebook]" class="form-control @error('social_links.facebook') is-invalid @enderror" value="{{ old('social_links.facebook')?:$data['social_links']['facebook']??null }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Twitter:</label>
            <div class="col-sm-6">
                <input type="text" name="social_links[twitter]" class="form-control @error('social_links.twitter') is-invalid @enderror" value="{{ old('social_links.twitter')?:$data['social_links']['twitter']??null }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Instagram:</label>
            <div class="col-sm-6">
                <input type="text" name="social_links[instagram]" class="form-control @error('social_links.instagram') is-invalid @enderror" value="{{ old('social_links.instagram')?:$data['social_links']['instagram']??null }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Youtube:</label>
            <div class="col-sm-6">
                <input type="text" name="social_links[youtube]" class="form-control @error('social_links.youtube') is-invalid @enderror" value="{{ old('social_links.youtube')?:$data['social_links']['youtube']??null }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Linkedin:</label>
            <div class="col-sm-6">
                <input type="text" name="social_links[linkedin]" class="form-control @error('social_links.linkedin') is-invalid @enderror" value="{{ old('social_links.linkedin')?:$data['social_links']['linkedin']??null }}">
            </div>
        </div>
    </div>
    <div class="card border-top-0 rounded-0">
        <div class="card-footer">
            <button type="submit" class="btn btn-yarn">Save</button>
        </div>
    </div>
</form>
