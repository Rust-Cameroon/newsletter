<strong
    class="{{ $type !== 'subtract' && $type !== 'investment' && $type !==  'withdraw' && $type !==  'send_money' ? 'green-color': 'red-color'}}">{{
    ($type !== 'subtract' && $type !== 'investment' && $type !== 'withdraw' && $type !== 'send_money' ? '+': '-'
    ).$amount.' '.$currency }}</strong>