<strong
    class="{{ $txnType !== 'subtract' && $txnType !== 'investment' && $txnType !==  'withdraw' && $txnType !==  'send_money' ? 'green-color': 'red-color'}}">{{ ($txnType !== 'subtract' && $txnType !== 'investment' && $txnType !==  'withdraw' && $txnType !==  'send_money' ? '+': '-' ).$amount.' '.$currency }}</strong>
