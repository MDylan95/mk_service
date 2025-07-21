<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Admin Connexion</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('back/connexion.css') }}" rel="stylesheet">
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <h3>Connexion Admin</h3>

        @if ($errors->any())
            <div style="color:red; margin-bottom:10px;">
                {{ $errors->first() }}
            </div>
        @endif

        <label for="username">Email</label>
        <input type="email" placeholder="Email" id="username" name="email" required>

        <label for="password">Mot de passe</label>
        <input type="password" placeholder="Mot de passe" id="password" name="password" required>

        <button type="submit">Connexion</button>

        <div class="social">
            <div class="go"><i class="fab fa-google"></i> Google</div>
            <div class="fb"><i class="fab fa-facebook"></i> Facebook</div>
        </div>
    </form>
</body>
</html>
