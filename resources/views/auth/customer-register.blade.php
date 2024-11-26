<form method="POST" action="{{ route('customer-registration') }}" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="name">Name</label>
        <input id="name" type="text" name="name" required>
    </div>
    <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" required>
    </div>
    <div>
        <label for="mobile">Mobile</label>
        <input id="mobile" type="text" name="mobile" required>
    </div>
    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
    </div>
    <div>
        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>
    </div>
    <button type="submit">Register</button>
</form>
