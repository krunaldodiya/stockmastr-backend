<!doctype html>
<html>
    <head>
        <title>{{ env('APP_NAME') }}</title>
    </head>

    <body style="padding: 0px; margin: 0px">
        <div style="font-family: tahoma">
           @if($order->status == 'success')
            <div style="background: green; padding: 100px; color: white; text-transform: uppercase">success</div>
            <div style="background: white; padding: 0px 100px; margin-top: 20px; color: black">Congratulations, {{ ucfirst($user->name) }},</div>
            <div style="background: white; padding: 0px 100px; margin-top: 20px; color: black">Rs. {{ $order->amount }} is added to your wallet.</div>
           @endif

           @if($order->status == 'failed')
            <div style="background: red; padding: 100px; color: white; text-transform: uppercase">success</div>
            <div style="background: white; padding: 0px 100px; margin-top: 20px; color: black">Hello, {{ $user->name }},</div>            
            <div style="background: white; padding: 0px 100px; margin-top: 20px; color: black">There was some problem during transaction, Please, try again later.</div>
           @endif
        </div>
    </body>
</html>