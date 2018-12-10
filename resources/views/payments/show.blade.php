@extends('layouts.payment')

@section('content')
<div class="container">
    <form action="{{ route('paytm.process-order') }}" method="POST" style="text-align: center; width: 360px">
        @csrf

        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <div style="padding: 10px">
            <div style="margin-top: 10px">
                <input style="text-align: left; padding: 12px 20px; width: 300px; border-radius: 20px; border: 1px solid #d2d2d2; outline: none" type="number" name="mobile" value="{{ old('mobile', $user->mobile) }}" placeholder="Mobile">

                @if ($errors->has('mobile'))
                    <div style="text-align: left; color: red; margin-top: 10px; margin-left: 25px;">{{ $errors->first('mobile') }}</div>
                @endif
            </div>

            <div style="margin-top: 10px">
                <input style="text-align: left; padding: 12px 20px; width: 300px; border-radius: 20px; border: 1px solid #d2d2d2; outline: none" type="number" name="amount" value="{{ old('amount') }}" placeholder="Amount">

                @if ($errors->has('amount'))
                    <div style="text-align: left; color: red; margin-top: 10px; margin-left: 25px;">{{ $errors->first('amount') }}</div>
                @endif
            </div>

            <div style="margin-top: 20px">
                <button style="text-align: center; padding: 12px; width: 300px; border-radius: 20px; border: none; outline: none; background: skyblue; color: black; font-weight: bold; font-size: 16px" type="submit">Pay using PayTM</button>
            </div>
        </div>
    </form>
</div>
@endsection
