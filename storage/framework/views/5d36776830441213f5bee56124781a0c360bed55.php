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
                        <h3 class="card-title">Service List</h3>
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
                    },{
                        render: function(data, type, row) {
                            return row.amount;
                        },
                        targets: 0,
                    },{
                        render: function(data, type, row) {
                            return `
                            <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-success serviceShowBtn" data-toggle="modal" data-target="#service-show">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-info serviceEditBtn" data-toggle="modal" data-target="#service-edit">
                                        <i class="fas fa-pen"></i>
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
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Rayhan\Development\Bkash-Portal\resources\views/service.blade.php ENDPATH**/ ?>