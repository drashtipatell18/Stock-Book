@extends('layouts.main')

<style>
    .button-container {
        display: flex;
        justify-content: flex-end;
    }

    .card-header {
        display: none;
    }

    .formdata {
        margin-left: 23% !important;
    }

    .timelabel {
        color: red;
    }

    .circus .form-control {
        display: inline;
        height: 12px;
        width: 15px !important;
    }

    #imageLabel {
        display: none;
    }

    .invalid-feedback {
        display: none;
        color: red;
    }
</style>

@section('content')
    <div class="col-md-6 col-sm-6 formdata">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2 mt-3 ">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h3>
                </div>
                <hr>
                <form action="{{ isset($category) ? '/category/update/' . $category->id : '/category/store' }}" method="POST" id="categoryForm">
                    @csrf

                    <div class="form-group mt-5">
                        <label for="category_name" class="control-label mb-1">Category Name</label>
                        <input id="category_name" name="category_name" type="text" value="{{ old('category_name', $category->category_name ?? '') }}"
                            class="form-control @error('category_name') is-invalid @enderror">
                        <span class="invalid-feedback">
                            <strong>The category name may only contain letters.</strong>
                        </span>
                        @error('category_name')
                            <span class="invalid-feedback" style="color: red">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="item form-group mt-5">
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            @if (isset($category))
                                Update
                            @else
                                Save
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        // Custom validation method for alphabetic characters
        $.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || /^[a-zA-Z]+$/.test(value);
        }, "The category name may only contain letters.");

        // Validate the form
        $("#categoryForm").validate({
            rules: {
                category_name: {
                    required: true,
                    alpha: true
                }
            },
            messages: {
                category_name: {
                    required: "The category name field is required.",
                    alpha: "The category name may only contain letters."
                }
            },
            errorPlacement: function(error, element) {
                var feedbackElement = element.siblings(".invalid-feedback");
                feedbackElement.show();
                feedbackElement.text(error.text());
            },
            success: function(label, element) {
                var feedbackElement = $(element).siblings(".invalid-feedback");
                feedbackElement.hide();
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush
