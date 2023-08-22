<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">
    </style>
</head>

<body>
    <h3 style="text-align: center;">TRACKING PAYMENT REPORT</h3>

    @include('mails.layouts.trackingpayment.header-timegone')

    <div style="display:flex">
        @include('mails.layouts.trackingpayment.gt')
        {{-- @include('mails.layouts.trackingpayment.mt')
        @include('mails.layouts.trackingpayment.total') --}}
    </div>


</body>

</html>
