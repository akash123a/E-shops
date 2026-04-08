<h2>Who Owes Whom</h2>

@foreach($balances as $debtor => $creditors)
    @foreach($creditors as $creditor => $amount)
        <p>
            User {{ $debtor }} owes User {{ $creditor }} : ₹{{ $amount }}
        </p>
    @endforeach
@endforeach