<form method="POST" action="{{ route('customer.login') }}">
    @csrf

    <!-- Email -->
    <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" required>
    </div>

    <!-- Password -->
    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
    </div>

    <button type="submit">Login</button>
</form>
@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif