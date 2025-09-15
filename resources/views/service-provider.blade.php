@extends('layouts.app')


@section('breadcrumb')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Service Provider</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
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
            <div class="col-md-6">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        Production Config
                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-navy card-outline">
                    <div class="card-header">
                        <b>Sandbox Config</b>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ route('service.update', 'sandbox') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="base_url" class="required text-semibold">Base URL</label>
                                <input type="text" id="base_url" value="{{ $serviceProviderSandbox->base_url }}" name="base_url" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="app_key" class="required text-semibold">App Key</label>
                                <input type="text" id="app_key" name="app_key" value="{{ $serviceProviderSandbox->app_key }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="app_secret" class="required text-semibold">App Secret</label>
                                <input type="text" id="app_secret" name="app_secret" value="{{ $serviceProviderSandbox->app_secret }}"  class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="username" class="required text-semibold">User Name</label>
                                <input type="text" id="username" name="username" value="{{ $serviceProviderSandbox->username }}"  class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="required text-semibold">User Password</label>
                                <input type="password" id="password" value="{{ $serviceProviderSandbox->password }}"  name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
