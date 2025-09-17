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
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Illum ea provident tenetur laudantium esse doloribus iure,
        temporibus dolores reiciendis tempora rem, obcaecati ex est placeat dolore beatae porro nemo blanditiis.
    </div>
@endsection


@push('script')
    <script>
        $(document).on('click', "#bKash_button", function() {
            countClick++;

            if (countClick == 1) {
                $(this).click();
            }

            window.sessionStorage.setItem('button-text', $(this).text());

            setTimeout(function() {
                $("#bKash_button").text('Lodding...');
            }, 200);

            const msisdn = $("#auth_phone_number").val();
            const keyword = $("#keyword").val();
            var paymentID = '';


            const ROOT_URL = window.location.origin;




            try {
                bKash.init({
                    paymentMode: 'checkout',
                    paymentRequest: {
                        amount: '01',
                        intent: 'sale'
                    },
                    createRequest: function(
                        request
                    ) {
                        try {
                            $.ajax({
                                url: `${ROOT_URL}/api/payment?keyword=${keyword}&msisdn=${msisdn}`,
                                type: 'GET',
                                contentType: 'application/json',
                                success: function(data) {
                                    $(this).text('Play Now');
                                    console.log(data);
                                    if (data && data.paymentID != null) {
                                        paymentID = data.paymentID;
                                        window.sessionStorage.setItem('paymentID',
                                            paymentID);
                                        bKash.create().onSuccess(data);
                                    } else {
                                        bKash.create().onError();
                                    }
                                },
                                error: function() {
                                    $('#bKash_button').html(
                                        `<i class="fas fa-play"></i> Play Now!`);
                                    toastr.error('Payment Api Fetching Failed');
                                }
                            });
                        } catch (error) {
                            toastr.error('Payment Api Fetching Failed');
                        }
                    },
                    executeRequestOnAuthorization: function() {
                        const paymentID = window.sessionStorage.getItem('paymentID');
                        const url =
                            `${ROOT_URL}/payment/execute/${msisdn}/${paymentID}`;
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
