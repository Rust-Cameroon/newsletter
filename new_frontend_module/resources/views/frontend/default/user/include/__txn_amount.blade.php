<strong
    class="{{$type !== 'subtract' && $type !== 'investment' && $type !== 'send_money' && $type !== 'withdraw' ? 'green-color': 'red-color'}}">{{ ($type !== 'subtract' && $type !== 'investment' && $type !== 'send_money' && $type !== 'withdraw' ? '+': '-' ).$amount.' '.$currency }}</strong>
