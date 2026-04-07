<h2>Hisab (Balances)</h2>

@foreach($balances as $user => $amount)
    <p>User {{ $user }} : ₹ {{ $amount }}</p>
@endforeach