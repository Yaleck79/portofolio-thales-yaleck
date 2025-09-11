<?php
// Traitement du formulaire
$message = '';
$message_type = '';

if ($_POST) {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $sujet = htmlspecialchars(trim($_POST['sujet']));
    $message_content = htmlspecialchars(trim($_POST['message']));
    $date = date('Y-m-d H:i:s');
    
    // Validation
    if (empty($nom) || empty($email) || empty($sujet) || empty($message_content)) {
        $message = 'Tous les champs sont obligatoires.';
        $message_type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Adresse email invalide.';
        $message_type = 'error';
    } else {
        // Formatage du message pour le fichier
        $message_data = "=== NOUVEAU MESSAGE ===\n";
        $message_data .= "Date: $date\n";
        $message_data .= "Nom: $nom\n";
        $message_data .= "Email: $email\n";
        $message_data .= "Sujet: $sujet\n";
        $message_data .= "Message: $message_content\n";
        $message_data .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
        $message_data .= "User Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\n";
        $message_data .= "========================\n\n";
        
        // Sauvegarde dans messages.txt
        if (file_put_contents('messages.txt', $message_data, FILE_APPEND | LOCK_EX)) {
            $message = 'Votre message a été envoyé avec succès !';
            $message_type = 'success';
            
            // Optionnel: Envoi par email
            $to = 'thalesyaleckmiracle@gmail.com';
            $subject = "Nouveau message de $nom - $sujet";
            $body = "Nouveau message reçu de votre portfolio :\n\n";
            $body .= "Nom: $nom\n";
            $body .= "Email: $email\n";
            $body .= "Sujet: $sujet\n\n";
            $body .= "Message:\n$message_content\n\n";
            $body .= "---\nDate: $date";
            
            $headers = "From: noreply@votresite.com\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            
            // Décommenter la ligne suivante pour activer l'envoi d'email
            // mail($to, $subject, $body, $headers);
            
        } else {
            $message = 'Erreur lors de l\'envoi du message. Veuillez réessayer.';
            $message_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Thalès Yaleck</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            border: none;
            outline: none;
            scroll-behavior: smooth;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --bg-color: #ffffff;
            --second-bg-color: #f8f9ff;
            --text-color: #2c3e50;
            --main-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --gradient-5: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --shadow-color: rgba(0, 0, 0, 0.1);
            --shadow-hover: rgba(0, 0, 0, 0.2);
        }

        html {
            font-size: 62.5%;
        }

        body {
            background: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            font-size: 1.6rem;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 2rem 9%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            box-shadow: 0 5px 30px var(--shadow-color);
        }

        .logo {
            font-size: 3.5rem;
            font-weight: 800;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            cursor: default;
        }

        .back-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--text-color);
            font-size: 1.6rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: var(--main-color);
            transform: translateX(-5px);
        }

        .back-link i {
            font-size: 2rem;
        }

        /* Main Content */
        .contact-page {
            min-height: 100vh;
            padding: 12rem 9% 5rem;
            background: var(--gradient-3);
            position: relative;
            overflow: hidden;
        }

        .contact-page::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1516387938699-a93567ec168e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            opacity: 0.1;
            z-index: -1;
        }

        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6rem;
            align-items: start;
        }

        .contact-info {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            padding: 5rem 4rem;
            border-radius: 30px;
            box-shadow: 0 20px 60px var(--shadow-color);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .contact-form {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            padding: 5rem 4rem;
            border-radius: 30px;
            box-shadow: 0 20px 60px var(--shadow-color);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .section-title {
            font-size: 4.5rem;
            font-weight: 900;
            text-align: center;
            margin-bottom: 5rem;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .contact-info h3 {
            font-size: 3rem;
            margin-bottom: 3rem;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 3rem;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 20px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .info-item:hover {
            transform: translateX(10px);
            border-color: var(--main-color);
            box-shadow: 0 10px 30px var(--shadow-hover);
        }

        .info-icon {
            width: 6rem;
            height: 6rem;
            background: var(--gradient-3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            flex-shrink: 0;
        }

        .info-details h4 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .info-details p {
            font-size: 1.5rem;
            color: var(--text-color);
            opacity: 0.8;
        }

        .info-details a {
            color: var(--main-color);
            transition: color 0.3s ease;
        }

        .info-details a:hover {
            color: var(--accent-color);
        }

        .social-links {
            display: flex;
            gap: 2rem;
            margin-top: 3rem;
            justify-content: center;
        }

        .social-links a {
            width: 5.5rem;
            height: 5.5rem;
            background: var(--gradient-5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            transform: translateY(-8px) scale(1.1);
            box-shadow: 0 15px 40px rgba(250, 112, 154, 0.4);
        }

        .contact-form h3 {
            font-size: 3rem;
            margin-bottom: 3rem;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 3rem;
        }

        .form-group label {
            display: block;
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1.8rem 2rem;
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(52, 152, 219, 0.2);
            border-radius: 15px;
            font-size: 1.5rem;
            color: var(--text-color);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--main-color);
            box-shadow: 0 0 20px rgba(52, 152, 219, 0.2);
            background: rgba(255, 255, 255, 0.95);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        .btn-submit {
            width: 100%;
            padding: 2rem;
            background: var(--gradient-2);
            color: white;
            border-radius: 50px;
            font-size: 1.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.4s ease;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(240, 147, 251, 0.5);
        }

        .btn-submit:active {
            transform: translateY(-2px);
        }

        /* Messages d'alerte */
        .message {
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 3rem;
            font-size: 1.6rem;
            font-weight: 600;
            text-align: center;
            animation: slideDown 0.5s ease;
        }

        .message.success {
            background: rgba(39, 174, 96, 0.1);
            border: 2px solid var(--success-color);
            color: var(--success-color);
        }

        .message.error {
            background: rgba(231, 76, 60, 0.1);
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .header {
                padding: 2rem 5%;
            }

            .contact-page {
                padding: 12rem 5% 5rem;
            }

            .contact-container {
                grid-template-columns: 1fr;
                gap: 4rem;
            }

            .contact-info,
            .contact-form {
                padding: 4rem 3rem;
            }

            .section-title {
                font-size: 3.5rem;
            }
        }

        @media (max-width: 617px) {
            html {
                font-size: 50%;
            }

            .contact-info,
            .contact-form {
                padding: 3rem 2rem;
            }

            .info-item {
                flex-direction: column;
                text-align: center;
            }

            .social-links {
                flex-wrap: wrap;
            }
        }

        /* Animations d'entrée */
        .fade-in {
            animation: fadeInUp 0.8s ease forwards;
        }

        .fade-in:nth-child(1) { animation-delay: 0.1s; }
        .fade-in:nth-child(2) { animation-delay: 0.2s; }
        .fade-in:nth-child(3) { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading effect pour le bouton */
        .btn-submit.loading {
            position: relative;
            color: transparent;
        }

        .btn-submit.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <a href="index.html" class="logo">TY.</a>
        <a href="index.html" class="back-link">
            <i class='bx bx-arrow-back'></i>
            <span>Retour au Portfolio</span>
        </a>
    </header>

    <!-- Contact Page -->
    <section class="contact-page">
        <h2 class="section-title">Contactez-Moi</h2>
        
        <div class="contact-container">
            <!-- Informations de Contact -->
            <div class="contact-info fade-in">
                <h3>Parlons de Votre Projet</h3>
                <p style="font-size: 1.6rem; margin-bottom: 3rem; opacity: 0.8;">
                    Vous avez un projet en tête ? Une idée à développer ? Je serais ravi de discuter avec vous et de transformer votre vision en réalité digitale.
                </p>

                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-envelope'></i>
                    </div>
                    <div class="info-details">
                        <h4>Email</h4>
                        <p><a href="mailto:thalesyaleckmiracle@gmail.com">thalesyaleckmiracle@gmail.com</a></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-phone'></i>
                    </div>
                    <div class="info-details">
                        <h4>Téléphone</h4>
                        <p><a href="tel:+2290140851046">+229 01 40 85 10 46</a></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-map'></i>
                    </div>
                    <div class="info-details">
                        <h4>Localisation</h4>
                        <p>Cotonou, Littoral, Bénin</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-time'></i>
                    </div>
                    <div class="info-details">
                        <h4>Disponibilité</h4>
                        <p>Lun - Sam: 8h00 - 18h00</p>
                    </div>
                </div>

                <div class="social-links">
                    <a href="https://www.facebook.com/profile.php?id=61577926646539" target="_blank" title="Facebook">
                        <i class='bx bxl-facebook'></i>
                    </a>
                    <a href="https://wa.me/2290140851046" target="_blank" title="WhatsApp">
                        <i class='bx bxl-whatsapp'></i>
                    </a>
                    <a href="https://linkedin.com/in/yaleck-thales" target="_blank" title="LinkedIn">
                        <i class='bx bxl-linkedin'></i>
                    </a>
                    <a href="https://github.com/Yaleck79" target="_blank" title="GitHub">
                        <i class='bx bxl-github'></i>
                    </a>
                </div>
            </div>

            <!-- Formulaire de Contact -->
            <div class="contact-form fade-in">
                <h3>Envoyez-moi un Message</h3>
                
                <?php if (!empty($message)): ?>
                    <div class="message <?php echo $message_type; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" id="contactForm">
                    <div class="form-group">
                        <label for="nom">Nom Complet *</label>
                        <input type="text" id="nom" name="nom" required placeholder="Votre nom complet">
                    </div>

                    <div class="form-group">
                        <label for="email">Adresse Email *</label>
                        <input type="email" id="email" name="email" required placeholder="votre.email@example.com">
                    </div>

                    <div class="form-group">
                        <label for="sujet">Sujet *</label>
                        <input type="text" id="sujet" name="sujet" required placeholder="Objet de votre message">
                    </div>

                    <div class="form-group">
                        <label for="message">Votre Message *</label>
                        <textarea id="message" name="message" required placeholder="Décrivez votre projet, vos besoins ou posez votre question..."></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>Envoyer le Message</span>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Animation au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(50px)';
            el.style.transition = 'all 0.8s ease';
            observer.observe(el);
        });

        // Animation du bouton de soumission
        document.getElementById('contactForm').addEventListener('submit', function() {
            const btn = document.querySelector('.btn-submit');
            btn.classList.add('loading');
            btn.disabled = true;
        });

        // Auto-resize textarea
        const textarea = document.getElementById('message');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });

        // Validation en temps réel
        const inputs = document.querySelectorAll('input[required], textarea[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.style.borderColor = '#e74c3c';
                } else {
                    this.style.borderColor = '#27ae60';
                }
            });
        });
    </script>
</body>
</html>