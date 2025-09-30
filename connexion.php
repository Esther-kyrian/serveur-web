<?php
require_once 'config.php';

// Rediriger vers l'accueil si déjà connecté
if (isset($_SESSION['user_id'])) {
    header('Location: accueil.php');
    exit;
}

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validation
    if (empty($email)) {
        $erreurs[] = "L'email est requis";
    }

    if (empty($password)) {
        $erreurs[] = "Le mot de passe est requis";
    }

    if (empty($erreurs)) {
        // Vérifier l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && verifyPassword($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];
            $_SESSION['user_email'] = $user['email'];
            
            header('Location: accueil.php');
            exit;
        } else {
            $erreurs[] = "Email ou mot de passe incorrect";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Boutique Digitale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
           
            font-family: 'Arial', sans-serif;
            display: flex;
            align-items: center;
        }
        
        .container-auth {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .auth-left {
            background: linear-gradient(135deg, #2196f3, #21cbf3);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .auth-right {
            padding: 60px 40px;
        }
        
        .auth-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            background: linear-gradient(45deg, #2196f3, #21cbf3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .auth-subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }
        
        .form-control {
            border: 2px solid #e3f2fd;
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #2196f3;
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #2196f3, #21cbf3);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.4);
        }
        
        .auth-logo {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .auth-features {
            list-style: none;
            padding: 0;
        }
        
        .auth-features li {
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        
        .auth-features i {
            margin-right: 10px;
            color: #ffeb3b;
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        
        .register-link a {
            color: #2196f3;
            text-decoration: none;
            font-weight: 600;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 20px;
        }
        
        .form-check-input:checked {
            background-color: #2196f3;
            border-color: #2196f3;
        }
        
        .floating-shape {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape-1 {
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }
        
        .shape-2 {
            top: 20%;
            right: 5%;
            animation-delay: 2s;
        }
        
        .shape-3 {
            bottom: 20%;
            left: 10%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .payment-methods {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            justify-content: center;
        }
        
        .payment-methods img {
            height: 40px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="floating-shape shape-1">
        <i class="fas fa-cloud" style="font-size: 100px; color: #2196f3;"></i>
    </div>
    <div class="floating-shape shape-2">
        <i class="fas fa-laptop" style="font-size: 80px; color: #21cbf3;"></i>
    </div>
    <div class="floating-shape shape-3">
        <i class="fas fa-mobile-alt" style="font-size: 60px; color: #00bcd4;"></i>
    </div>

    <div class="container container-auth">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="auth-card">
                    <div class="row g-0">
                        <!-- Left Side - Information -->
                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="auth-left">
                                <div class="text-center">
                                    <i class="fas fa-store auth-logo"></i>
                                    <h2 class="mb-4">BOUTIQUE DIGITALE</h2>
                                    <p class="mb-5">Votre projet en ligne mérite une fondation solide. 
                                        Notre Boutique Digitale est votre guichet unique pour l'enregistrement de noms de domaine,
                                        l'hébergement web ultra-rapide et les solutions serveur sécurisées.</p>

                                    <ul class="auth-features">
                                        <li><i class="fas fa-check-circle"></i> Aucune Carte de Crédit requise</li>
                                        <li><i class="fas fa-check-circle"></i> Support 24/7</li>
                                        <li><i class="fas fa-check-circle"></i> Hébergement sécurisé</li>
                                        <li><i class="fas fa-check-circle"></i> Domaines disponibles</li>
                                    </ul>
                                
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Side - Formulaire -->
                        <div class="col-lg-6">
                            <div class="auth-right">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h1 class="auth-title mb-0">CONNEXION</h1>
                                    <a href="inscription.php" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-user-plus me-1"></i>S'inscrire
                                    </a>
                                </div>
                                
                                <p class="auth-subtitle">Aucune Carte de Crédit n'est requise</p>
                                
                                <?php if (!empty($erreurs)): ?>
                                    <div class="alert alert-danger">
                                        <?php foreach ($erreurs as $erreur): ?>
                                            <p class="mb-1">• <?php echo $erreur; ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <form method="POST" action="">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Entrer votre adresse email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="Entrer votre mot de passe" required>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember">
                                            <label class="form-check-label" for="remember">
                                                Se souvenir de moi
                                            </label>
                                        </div>
                                        <a href="#" class="text-muted text-decoration-none">Mot de passe oublié ?</a>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt me-2"></i>Connexion
                                    </button>
                                </form>
                                
                                <div class="register-link">
                                    <p>Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>
                                </div>
                                
                                <hr class="my-4">
                                
                         
                                
                                <div class="text-center mt-3">
                                    <p class="small text-muted">© 2025 BOUTIQUE DIGITALE.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>