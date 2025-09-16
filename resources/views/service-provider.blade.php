@extends('layouts.app')


@section('breadcrumb')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Service Provider List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection


{{--

--}}

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Service List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="serviceTableId">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Type</th>
                                    <th>app_key</th>
                                    <th>password</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showServiceProviderModal" tabindex="-1" aria-labelledby="showServiceProviderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="showServiceProviderModalLabel">
                        Service Provider Show & Update
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateServiceProviderForm" method="POST" action="#">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label"><b>Username</b></label>
                                <input type="text" name="username" class="form-control"
                                    value="{{ $serviceProvider->username ?? '' }}" required>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label"><b>Password</b></label>
                                <input type="text" name="password" class="form-control"
                                    value="{{ $serviceProvider->password ?? '' }}" required>
                            </div>


                            <div class="mb-3 col-md-6">
                                <label class="form-label required"><b>App Key</b></label>
                                <input type="text" name="app_key" class="form-control"
                                    value="{{ $serviceProvider->app_key ?? '' }}" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label"><b>Type</b></label>
                                <input type="text" name="type" class="form-control"
                                    value="{{ $serviceProvider->type ?? '' }}" required>
                            </div>

                            <div class="mb-3 col-12">
                                <label class="form-label"><b>App Secret</b></label>
                                <input type="text" name="app_secret" class="form-control"
                                    value="{{ $serviceProvider->app_secret ?? '' }}" required>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="form-label required"><b>Base URL</b></label>
                                <input type="text" name="base_url" class="form-control"
                                    value="{{ $serviceProvider->base_url ?? '' }}" required>
                            </div>




                        </div>


                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(() => {
            handleDataTable();
        });


        const handleDataTable = () => {
            table = $('#serviceTableId').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('service.provider') }}",
                columns: [{
                        render: function(data, type, row) {
                            return row.username;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return row.type;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return row.app_key;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return row.password;
                        },
                        targets: 0,
                    }, {
                        render: function(data, type, row) {
                            return `
                            <div class="btn-group" id="${row.id}">
                                        <button type="button" class="btn btn-sm btn-outline-success serviceProviderShowBtn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger serviceDeleteBtn">
                                        <i class="fa-solid fa-trash"></i>
                                        </button>
                            </div>
                            `;
                        },
                        targets: 0,
                    },
                ]
            });
            handleButtons();
        };

        const handleButtons = () => {
            $(document).on("click", ".serviceProviderShowBtn", function() {
                var myModal = new bootstrap.Modal(document.getElementById('showServiceProviderModal'));
                myModal.show();




                const id = $(this).parent().attr('id');
                axios.get(`/service/provider/${id}/fetch`)
                    .then((response) => {
                        let data = response.data.data;

                        let updateUrl = `/service/provider-update/${data.id}`;
                        $('#updateServiceProviderForm').attr('action', updateUrl);

                        $('#updateServiceProviderForm input[name="base_url"]').val(data.base_url);
                        $('#updateServiceProviderForm input[name="app_key"]').val(data.app_key);
                        $('#updateServiceProviderForm input[name="app_secret"]').val(data.app_secret);
                        $('#updateServiceProviderForm input[name="username"]').val(data.username);
                        $('#updateServiceProviderForm input[name="password"]').val(data.password);
                        $('#updateServiceProviderForm input[name="type"]').val(data.type);
                    });
            });
        };
    </script>
@endpush
