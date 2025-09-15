@extends('layouts.app')


@section('breadcrumb')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Service List</h3>
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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>keyword</th>
                                    <th>Validity</th>
                                    <th>Mode</th>
                                    <th>Charge</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $key => $service)
                                    <tr>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ ucfirst($service->type) }}</td>
                                        <td>{{ $service->keyword }}</td>
                                        <td>{{ ucfirst($service->validity) }}</td>
                                        <td>{{ ucfirst($service->mode) }}</td>
                                        <td>{{ $service->amount ?? '-' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                {{-- Show --}}
                                                <button type="button" class="btn btn-sm btn-outline-success serviceShowBtn"
                                                    data-toggle="modal" data-target="#service-show"
                                                    data-id="{{ $service->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                {{-- Edit --}}
                                                <button type="button" class="btn btn-sm btn-outline-info serviceEditBtn"
                                                    data-toggle="modal" data-target="#service-edit"
                                                    data-id="{{ $service->id }}">
                                                    <i class="fas fa-pen"></i>
                                                </button>

                                                {{-- Delete --}}
                                                <form action="{{ route('service.destroy', $service->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger serviceDeleteBtn"
                                                        onclick="return confirm('Are you sure to delete this service?')">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
