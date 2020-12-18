{{-- {{ dd($details) }} --}}
<div class="row">
    @foreach ($details as $key => $photo)
        <div class="col-md-6 img-block">
            <div class="card" id="photo_{{ $key }}">
                <div class="img-holder">
                    <img class="card-img-top img-fluid" src="{{ $photo['path'] . '/' . $photo['name'] }}" alt="image">
                </div>
                <div class="card-body">
                    <input type="text" class="form-control" name="caption[]">
                    <input type="hidden" class="form-control" name="filename[]" value="{{ $photo['name'] }}">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button type="button" data-id="crop" data-image="{{ $photo['name'] }}"
                                data-index="{{ $key }}" class="btn btn-primary mb-2">Crop</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" data-image="{{ $photo['name'] }}" id="delete_{{ $key }}"
                                class="btn btn-danger del-btn">Delete</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</div>
