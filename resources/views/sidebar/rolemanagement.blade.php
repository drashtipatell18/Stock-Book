@extends('layouts.main')

@section('content')
@csrf
    <div class="col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-header">Role Management Menus</div>
            <div class="card-body">
                <div class="card-title">
                    <div class="button-container text-right mb-2">
                        {{-- <a href="{{ route('sidebar.create') }}">
                            <button type="button" class="btn btn-primary btn-sm mt-1" id="addCategoryBtn"><i class="bi bi-plus-lg"></i> Add New Menu</button>
                        </a> --}}
                    </div>
                </div>
                <div class="row">
                    <select name="role" id="role" class="form-control col-sm-3">
                        <option value="">-- Select Role --</option>
                        @foreach ($returnData['roles'] as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                    {{-- <div class="col-sm-3"></div> --}}
                    <div class="col-sm-3 text-right">
                        <button id="saveSettingBtn" class="btn btn-info">Save Settings</button>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-striped jambo_table bulk_action" id="table">
                        <thead>
                            <tr>
                                <th class="text-center">Permission</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($returnData['sidemenus'] as $sidemenu)
                                <tr>
                                    <td>
                                        <input disabled="true" type="checkbox" class="form-control checkBoxes" data-id="{{ $sidemenu->id }}">
                                    </td>
                                    <td>
                                        {{ $sidemenu->display_name }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="table-responsive mt-3">
                    <table class="table table-striped jambo_table bulk_action" id="table">
                        <thead>
                            <tr class="">
                                <th class="text-center">No</th>
                                <th class="text-center">Class</th>
                                <th class="text-center">Display Name</th>
                                <th class="text-center">Route</th>
                                <th class="text-center"><span class="nobr">Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $index = 1;
                            @endphp
                            @foreach ($siderbars as $sidebar)
                                <tr>
                                    <td class="text-center">{{ $index++ }}</td>
                                    <td class="text-center"><i class="{{ $sidebar->name }}"></i></td>
                                    <td class="text-center">{{ $sidebar->display_name }}</td>
                                    <td class="text-center">{{ $sidebar->route }}</td>
                                    <td class="text-center">
                                        <a href="/sidebar/delete/{{ $sidebar->id }}">
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </a>
                                        <a href="/sidebar/edit/{{ $sidebar->id }}">
                                            <button class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pageLength": 25
            });
        });

        $("#role").change(function(){
            $(".checkBoxes").prop("checked", false)
            if($(this).val())
            {
                let id = $(this).val()
                $(".checkBoxes").prop("disabled", false);
                let token = $("input[name='_token']").val();
                $.ajax({
                    type: "GET",
                    method: "GET",
                    url: "/sidebar/role/"+ id +"/getPermission",
                    success: function(response){
                        $.each(response, function(){
                            if(this.permission == 1)
                            {
                                $(".checkBoxes[data-id='"+ this.siderbar_id +"']").prop("checked", true)
                            }
                        })

                        Swal.hideLoading();
                        Swal.clickConfirm();
                    }
                })
                Swal.showLoading();
            }
            else
            {
                $(".checkBoxes").prop("disabled", true)
            }
        })

        $("#saveSettingBtn").click(function(){
            if($("#role").val())
            {
                let json = {"role_id" : $("#role").val()};
                let data = [];
                $.each($(".checkBoxes"), function(){
                    data.push({"sidebar_id" : $(this).data('id'), "permission" : $(this).prop('checked')})
                })
                json.data = data;
                json._token = $("input[name='_token']").val()
                console.log(json);
                Swal.showLoading();

                $.ajax({
                    url: "/sidebar/roleUpdate",
                    method: "POST",
                    type: "GET",
                    data: json,
                    success: function(response){
                        window.location.reload();
                    }
                })
            }
        })
    </script>
@endpush