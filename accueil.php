<?php
require_once 'config.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Récupérer les informations de l'utilisateur
$nom = $_SESSION['user_nom'];
$prenom = $_SESSION['user_prenom'];
$email = $_SESSION['user_email'];

// Obtenir le salut approprié
$salutation = getSalutation();

// Gérer la déconnexion
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: connexion.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
          
            font-family: 'Arial', sans-serif;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 40px;
            text-align: center;
            margin-top: 50px;
        }
        
        .welcome-title {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(45deg, #2196f3, #21cbf3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
        }
        
        .greeting {
            font-size: 1.5rem;
            color: #666;
            margin-bottom: 10px;
        }
        
        .user-name {
            font-size: 2.2rem;
            font-weight: 600;
            color: #2196f3;
            margin-bottom: 30px;
        }
        
        .time-info {
            background: linear-gradient(45deg, #ff9800, #ffc107);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            display: inline-block;
            font-weight: 600;
            margin-bottom: 30px;
        }
        
        .user-info-card {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .btn-logout {
            background: linear-gradient(45deg, #f44336, #ff5722);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(244, 67, 54, 0.4);
            color: white;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #2196f3;
        }
        
        .stats-card {
            background: linear-gradient(135deg, #2196f3, #21cbf3);
            color: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            margin: 10px 0;
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
        }
        
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .floating-shape {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape-1 {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape-2 {
            top: 20%;
            right: 10%;
            animation-delay: 2s;
        }
        
        .shape-3 {
            bottom: 20%;
            left: 15%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .logo {
            color: #2196f3;
            font-weight: bold;
            font-size: 24px;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        
        .dropdown-item {
            border-radius: 5px;
            margin: 2px 5px;
            width: auto;
        }
        
        .dropdown-item:hover {
            background: #e3f2fd;
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg">
        <div class="floating-shape shape-1">
            <i class="fas fa-cloud" style="font-size: 100px; color: #2196f3;"></i>
        </div>
        <div class="floating-shape shape-2">
            <i class="fas fa-laptop" style="font-size: 80px; color: #21cbf3;"></i>
        </div>
        <div class="floating-shape shape-3">
            <i class="fas fa-mobile-alt" style="font-size: 60px; color: #00bcd4;"></i>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-store me-3 text-primary fs-3"></i>
                <span class="logo">BOUTIQUE DIGITALE</span>
            </a>
            
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2 fs-4"></i>
                        <?php echo $prenom . ' ' . $nom; ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="?logout=1"><i class="fas fa-sign-out-alt me-2"></i>Se déconnecter</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Welcome Section -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="welcome-card">
                    <div class="time-info">
                        <i class="fas fa-clock me-2"></i>
                        <?php echo date('H:i'); ?> - <?php echo date('d/m/Y'); ?>
                    </div>
                    
                    <h1 class="welcome-title">Bienvenue!</h1>
                    
                    <div class="greeting">
                        <?php echo $salutation; ?>
                    </div>
                    
                    <div class="user-name">
                        <?php echo $prenom . ' ' . $nom; ?>
                    </div>
                    
                    <div class="user-info-card">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Email:</strong></p>
                                <p class="text-muted"><?php echo $email; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Statut:</strong></p>
                                <span class="badge bg-success fs-6">Connecté</span>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-4">Vous êtes maintenant connecté à votre espace personnel Boutique Digitale.</p>
                    
                    <a href="?logout=1" class="btn btn-logout">
                        <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter
                    </a>
                </div>
            </div>
        </div>
        

        <!-- Features -->
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h4>Nom de Domaine</h4>
                    <p class="text-muted">Réservez votre nom de domaine facilement et rapidement.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <h4>Hébergement</h4>
                    <p class="text-muted">Solutions d'hébergement fiables et performantes.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Sécurité</h4>
                    <p class="text-muted">Protection avancée pour vos données et sites web.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="mt-5" style="background: linear-gradient(135deg, #1976d2, #1565c0); color: white; padding: 40px 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h5 class="text-white mb-3">BOUTIQUE DIGITALE</h5>
                    <p class="text-light">Duis aute irure dolor in reprehenderit in voluptate velit esse eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat, sunt in culpa.</p>
                    <div class="d-flex mt-3">
                        <div style="background: #FF6600; color: white; padding: 10px 15px; border-radius: 5px; font-weight: bold; margin-right: 10px;">
                            Orange Money
                        </div>
                        <div style="background: #FFFF00; color: black; padding: 10px 15px; border-radius: 5px; font-weight: bold; margin-right: 10px;">
                            MTN Money
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h6 class="text-white mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Nom de domaine</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Hébergement</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">À Propos</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Contact</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="text-white mb-3">Contact Us</h6>
                    <p class="text-light">Lorem ipsum dolor sit amet, consectetur elit.</p>
                    <p class="text-light">info@example.com</p>
                    <p class="text-light">+(237)650185717</p>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="row">
                <div class="col-md-8">
                    <p class="text-light mb-0">© 2025 BOUTIQUE DIGITALE. All rights reserved</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <p class="text-light mb-0">Designed by team 1</p>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation d'apparition
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.welcome-card, .feature-card, .stats-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });

        // Mise à jour de l'heure en temps réel
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('fr-FR', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            const dateString = now.toLocaleDateString('fr-FR');
            
            const timeInfo = document.querySelector('.time-info');
            if (timeInfo) {
                timeInfo.innerHTML = `<i class="fas fa-clock me-2"></i>${timeString} - ${dateString}`;
            }
        }

        // Mettre à jour l'heure toutes les minutes
        setInterval(updateTime, 60000);
    </script>
</body>
</html>