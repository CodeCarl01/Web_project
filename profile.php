<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Profil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* En-tête et navigation */
        header {
            background-color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 2.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a365d;
            letter-spacing: -0.5px;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 2.5rem;
        }

        nav a {
            text-decoration: none;
            color: #64748b;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
            position: relative;
        }

        nav a:hover {
            color: #3b82f6;
        }

        nav a.active {
            color: #3b82f6;
            font-weight: 600;
        }

        nav a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #3b82f6;
            border-radius: 2px;
        }

        /* Conteneur principal */
        main {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 2rem;
            flex: 1;
            width: 100%;
        }

        .profile-section {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        h2 {
            color: #1a365d;
            margin-bottom: 1.8rem;
            font-weight: 600;
            font-size: 1.8rem;
            position: relative;
            padding-bottom: 0.8rem;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            border-radius: 2px;
        }

        h3 {
            color: #1a365d;
            margin: 2rem 0 1.5rem;
            font-weight: 600;
            font-size: 1.3rem;
            border-bottom: 2px solid #f0f4f8;
            padding-bottom: 0.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
            margin-bottom: 2rem;
        }

        label {
            font-size: 0.95rem;
            color: #475569;
            font-weight: 500;
            margin-bottom: 0.3rem;
            display: block;
        }

        input {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #f8fafc;
            color: #334155;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.2);
            background-color: #fff;
        }

        button {
            margin-top: 1rem;
            padding: 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        button:not(.danger) {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        button:not(.danger):hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
        }

        .danger {
            background: linear-gradient(90deg, #ef4444, #f87171);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            margin-top: 2rem;
        }

        .danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(239, 68, 68, 0.4);
        }

        /* Responsive */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                padding: 1rem;
            }
          
            nav ul {
                margin-top: 1rem;
                justify-content: center;
            }
          
            nav ul li {
                margin: 0 1rem;
            }
          
            main {
                padding: 0 1rem;
            }

            .profile-section {
                padding: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Nexus</div>
            <ul>
                <li><a href="index.html">Dashboard</a></li>
                <li><a href="profile.php" class="active">Profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="profile-section">
            <h2>Gestion du Profil</h2>
            
            <!-- Formulaire de mise à jour des informations -->
            <form action="update_profile.php" method="POST">
                <div>
                    <label for="username">Nom d'utilisateur :</label>
                    <input type="text" id="username" name="username" value="<?= isset($user['email']) ? htmlspecialchars($user['name']) : '' ?>" required placeholder="Votre nom d'utilisateur">
                </div>

                <div>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : '' ?>" required placeholder="votre.email@exemple.com">
                </div>

                <button type="submit">Enregistrer les modifications</button>
            </form>

            <!-- Changement de mot de passe -->
            <form action="update_password.php" method="POST">
                <h3>Changer de mot de passe</h3>
                <div>
                    <label for="old_password">Ancien mot de passe :</label>
                    <input type="password" id="old_password" name="old_password" required placeholder="••••••••">
                </div>

                <div>
                    <label for="new_password">Nouveau mot de passe :</label>
                    <input type="password" id="new_password" name="new_password" required placeholder="••••••••">
                </div>

                <button type="submit">Mettre à jour</button>
            </form>

            <!-- Suppression du compte -->
            <form action="delete_account.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')">
                <button type="submit" class="danger">Supprimer mon compte</button>
            </form>
        </section>
    </main>
</body>
</html>