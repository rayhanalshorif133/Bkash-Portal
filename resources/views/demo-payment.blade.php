@extends('layouts.app')

@section('head')
    <script src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>
    {{-- <script src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script> --}}
@endsection

@section('breadcrumb')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Demo Payment</h3>
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
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Make a Payment</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="paymentType" class="form-label">Select Payment Type</label>
                                    <select class="form-select" id="paymentType" required>
                                        <option value="">Choose...</option>
                                        <option value="credit">Credit Card</option>
                                        <option value="paypal">PayPal</option>
                                        <option value="bKash">bKash</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="amount" placeholder="Enter amount"
                                        required min="1">
                                </div>

                                <button type="button" class="btn btn-primary w-100" id="bKash_button">Pay</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.12.2/dist/axios.min.js"></script>
    <script>
        var countClick = 0;
        $(document).on('click', "#bKash_button", function() {
            console.log('button');
            countClick++;

            if (countClick == 1) {
                $(this).click();
            }


            const msisdn = '01923988380';
            const keyword = 'APP-S';
            var paymentID = '';


            const ROOT_URL = window.location.origin;




            try {
                bKash.init({
                    paymentMode: 'checkout',
                    paymentRequest: {
                        amount: '01',
                        intent: 'sale'
                    },
                    createRequest: async function(request) {
                        try {
                            const response = await axios.get(`${ROOT_URL}/api/payment?keyword=${keyword}&msisdn=${msisdn}`, {
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            });
                            const data = response.data;
                            console.log(data);

                            if (data && data.paymentID != null) {
                                const paymentID = data.paymentID;
                                window.sessionStorage.setItem('paymentID', paymentID);
                                bKash.create().onSuccess(data);
                            } else {
                                bKash.create().onError();
                            }

                        } catch (error) {
                            $('#bKash_button').html(`<i class="fas fa-play"></i> Play Now!`);
                            console.error('ERROR 1', error);
                        }
                    },
                    executeRequestOnAuthorization: function() {
                        const paymentID = window.sessionStorage.getItem('paymentID');
                        const url = `${ROOT_URL}/payment/execute/${msisdn}/${paymentID}`;

                        setTimeout(() => {
                            window.location.href = url;
                        }, 1000);
                    },
                    onClose: function() {
                        $(".payment-alert").removeClass('hidden');

                        const buttonText = window.sessionStorage.getItem('button-text');
                        $("#bKash_button").text(buttonText);
                        $("#bKash_button").attr('disabled', true);

                        setTimeout(() => {
                            location.reload();
                        }, 5000);
                    }
                });

            } catch (error) {
                toastr.error('Payment Api Fetching Failed');
            }
        });
    </script>
@endpush
