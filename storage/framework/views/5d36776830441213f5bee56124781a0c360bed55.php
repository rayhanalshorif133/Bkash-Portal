<?php $__env->startSection('breadcrumb'); ?>
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Service List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>




<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-hammer mr-1"></i>
                            Service List
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#serviceCreate">Add New</button>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="serviceTableId">
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
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="serviceCreate" tabindex="-1" aria-labelledby="serviceCreateLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="serviceCreateLabel">Add New Service</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('service.create')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('POST'); ?>
                        <div class="modal-body">
                            <div class="px-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="required">Service Name</label>
                                            <input type="text" name="name" id="name" required=""
                                                class="form-control" placeholder="Enter Service Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type" class="required">Service Type</label>
                                            <select class="form-control" name="type" required="" id="type">
                                                <option value="" selected="" disabled="">Select type</option>
                                                <option value="subscription">Subscription</option>
                                                <option value="on-demand">On Demand</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="validity" class="required">Service validity</label>
                                            <select class="form-control" name="validity" required="" id="validity">
                                                <option value="" selected="" disabled="">Select validity
                                                </option>
                                                <option value="1D">Daily (P1D)</option>
                                                <option value="7D">Weekly (P7D)</option>
                                                <option value="30D">Monthly (P30D)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mode" class="required">Mode</label>
                                            <select class="form-control" name="mode" required="" id="mode">
                                                <option value="" selected="" disabled="">Select mode
                                                </option>
                                                <option value="sandbox">Sandbox</option>
                                                <option value="app">App in App</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="amount" class="required">Service amount</label>
                                            <input type="number" name="amount" id="amount" required=""
                                                class="form-control" placeholder="Enter Service amount">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="keyword" class="required">Keyword</label>
                                            <input type="text" name="keyword" id="keyword" required=""
                                                class="form-control" placeholder="Enter Keyword Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="redirect_url" class="required">Redirect URL</label>
                                            <input type="text" name="redirect_url" id="redirect_url" required=""
                                                class="form-control" placeholder="Enter Redirect URL">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="portal_link" class="optional">Portal Link</label>
                                            <input type="text" name="portal_link" id="portal_link"
                                                class="form-control" placeholder="Enter portal link">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="service-show" tabindex="-1" aria-labelledby="service-showLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="service-showLabel">Update Service</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('service.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="id" id="serviceId">
                        <div class="modal-body">
                            <div class="px-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updateName" class="required">Service Name</label>
                                            <input type="text" name="name" id="updateName" required
                                                class="form-control" placeholder="Enter Service Name">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updateType" class="required">Service Type</label>
                                            <select class="form-control" name="type" required id="updateType">
                                                <option value="" selected disabled>Select type</option>
                                                <option value="subscription">Subscription</option>
                                                <option value="on-demand">On Demand</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updateValidity" class="required">Service Validity</label>
                                            <select class="form-control" name="validity" required id="updateValidity">
                                                <option value="" selected disabled>Select validity</option>
                                                <option value="1D">Daily (P1D)</option>
                                                <option value="7D">Weekly (P7D)</option>
                                                <option value="30D">Monthly (P30D)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updateMode" class="required">Mode</label>
                                            <select class="form-control" name="mode" required id="updateMode">
                                                <option value="" selected disabled>Select mode</option>
                                                <option value="sandbox">Sandbox</option>
                                                <option value="app">App in App</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updateAmount" class="required">Service Amount</label>
                                            <input type="number" name="amount" id="updateAmount" required
                                                class="form-control" placeholder="Enter Service Amount">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updateKeyword" class="required">Keyword</label>
                                            <input type="text" name="keyword" id="updateKeyword" required
                                                class="form-control" placeholder="Enter Keyword Name">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="updateRedirectUrl" class="required">Redirect URL</label>
                                            <input type="text" name="redirect_url" id="updateRedirectUrl" required
                                                class="form-control" placeholder="Enter Redirect URL">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="updatePortalLink" class="optional">Portal Link</label>
                                            <input type="text" name="portal_link" id="updatePortalLink"
                                                class="form-control" placeholder="Enter Portal Link">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
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
                ajax: "<?php echo e(route('service.index')); ?>",
                columns: [{
                        render: function(data, type, row) {
                            return row.name;
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
                            return row.keyword;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return row.validity;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return row.mode;
                        },
                        targets: 0,
                    }, {
                        render: function(data, type, row) {
                            return row.amount;
                        },
                        targets: 0,
                    }, {
                        render: function(data, type, row) {
                            return `
                            <div class="btn-group" id="${row.id}">
                                        <button type="button"   class="btn btn-sm btn-outline-success serviceShowBtn">
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
        };

        $(document).on('click', '.serviceShowBtn', function() {
            let id = $(this).parent().attr('id');

            axios.get(`/service/${id}/fetch`)
                .then(res => {
                    let data = res.data;
                    $('#service-show #serviceId').val(data.id);
                    $('#service-show #updateName').val(data.name);
                    $('#service-show #updateType').val(data.type);
                    $('#service-show #updateValidity').val(data.validity);
                    $('#service-show #updateMode').val(data.mode);
                    $('#service-show #updateAmount').val(data.amount);
                    $('#service-show #updateKeyword').val(data.keyword);
                    $('#service-show #updateRedirectUrl').val(data.redirect_url);
                    $('#service-show #updatePortalLink').val(data.portal_link);

                    $('#service-show').modal('show');


                })
                .catch(err => {
                    console.log(err);
                });
        });


        // serviceDeleteBtn
        $(document).on('click', '.serviceDeleteBtn', function() {
            let id = $(this).parent().attr('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/service/${id}/delete`)
                        .then(res => {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            });
                            table.ajax.reload();
                        })
                        .catch(err => {
                            console.log(err);
                        });

                }
            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Rayhan\Development\Bkash-Portal\resources\views/service.blade.php ENDPATH**/ ?>