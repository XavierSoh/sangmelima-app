<?php
/**
 * Générateur d'icônes PWA pour SangMeLima
 * Génère automatiquement toutes les icônes nécessaires en SVG
 */

// Icône SVG de base (croix stylisée)
function generateIcon($size) {
    $halfSize = $size / 2;
    $crossWidth = $size * 0.15;
    $crossHeight = $size * 0.5;

    $svg = <<<SVG
<svg width="{$size}" height="{$size}" viewBox="0 0 {$size} {$size}" xmlns="http://www.w3.org/2000/svg">
    <!-- Fond circulaire avec dégradé -->
    <defs>
        <linearGradient id="bgGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#D4AF37;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#8B4513;stop-opacity:1" />
        </linearGradient>
        <filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
            <feDropShadow dx="2" dy="2" stdDeviation="3" flood-opacity="0.3"/>
        </filter>
    </defs>

    <!-- Cercle de fond -->
    <circle cx="{$halfSize}" cy="{$halfSize}" r="{$halfSize}" fill="url(#bgGradient)"/>

    <!-- Croix blanche au centre -->
    <g transform="translate({$halfSize}, {$halfSize})" filter="url(#shadow)">
        <!-- Barre verticale -->
        <rect x="-{$crossWidth}" y="-{$crossHeight}"
              width="{$crossWidth}0" height="{$crossHeight}0"
              fill="white" rx="3" opacity="0.95"/>
        <!-- Barre horizontale -->
        <rect x="-{$crossHeight}" y="-{$crossWidth}"
              width="{$crossHeight}0" height="{$crossWidth}0"
              fill="white" rx="3" opacity="0.95"/>
    </g>

    <!-- Texte SML pour grandes icônes -->
SVG;

    if ($size >= 192) {
        $fontSize = $size * 0.08;
        $textY = $size * 0.85;
        $svg .= <<<SVG
    <text x="{$halfSize}" y="{$textY}"
          font-family="Arial, sans-serif"
          font-size="{$fontSize}"
          font-weight="bold"
          fill="white"
          text-anchor="middle"
          opacity="0.9">SML</text>
SVG;
    }

    $svg .= "\n</svg>";
    return $svg;
}

// Créer le dossier images s'il n'existe pas
$imagesDir = __DIR__ . '/assets/images';
if (!file_exists($imagesDir)) {
    mkdir($imagesDir, 0755, true);
}

// Tailles d'icônes nécessaires pour PWA
$sizes = [32, 72, 96, 128, 144, 152, 180, 192, 384, 512];

// Générer chaque icône
foreach ($sizes as $size) {
    $filename = $imagesDir . '/icon-' . $size . '.svg';
    $svgContent = generateIcon($size);
    file_put_contents($filename, $svgContent);
    echo "✓ Icône générée : icon-{$size}.svg\n";
}

// Créer aussi les versions PNG en utilisant une image de base
// Pour cela, créons une version HTML qui peut être convertie
$htmlIconGenerator = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Générateur d'icônes SangMeLima</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }
        .icon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .icon-item {
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .icon-item svg {
            max-width: 100%;
            height: auto;
        }
        .icon-label {
            margin-top: 10px;
            font-size: 12px;
            color: #666;
        }
        .instructions {
            background: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        canvas { display: none; }
    </style>
</head>
<body>
    <h1>Icônes PWA SangMeLima</h1>

    <div class="instructions">
        <h3>Instructions pour convertir en PNG :</h3>
        <ol>
            <li>Faites un clic droit sur chaque icône</li>
            <li>Choisissez "Enregistrer l'image sous..."</li>
            <li>Sauvegardez avec le nom indiqué (ex: icon-72.png)</li>
            <li>Ou utilisez un convertisseur SVG vers PNG en ligne</li>
        </ol>
    </div>

    <div class="icon-grid">
HTML;

foreach ($sizes as $size) {
    $svgContent = generateIcon($size);
    // Encoder en base64 pour l'inclure dans le HTML
    $svgBase64 = base64_encode($svgContent);
    $htmlIconGenerator .= <<<HTML
        <div class="icon-item">
            <img src="data:image/svg+xml;base64,{$svgBase64}"
                 width="{$size}" height="{$size}"
                 alt="Icon {$size}x{$size}">
            <div class="icon-label">icon-{$size}.png<br>{$size}x{$size}px</div>
        </div>
HTML;
}

$htmlIconGenerator .= <<<HTML
    </div>

    <script>
        // Script pour télécharger automatiquement en PNG
        function downloadSVGasPNG(svgElement, filename, width, height) {
            const canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');

            const img = new Image();
            img.onload = function() {
                ctx.drawImage(img, 0, 0, width, height);
                canvas.toBlob(function(blob) {
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.download = filename;
                    link.href = url;
                    link.click();
                    URL.revokeObjectURL(url);
                });
            };
            img.src = svgElement.src;
        }

        // Ajouter un bouton de téléchargement pour chaque icône
        document.querySelectorAll('.icon-item').forEach(item => {
            const img = item.querySelector('img');
            const label = item.querySelector('.icon-label').textContent;
            const size = parseInt(label.match(/\d+/)[0]);

            const btn = document.createElement('button');
            btn.textContent = 'Télécharger PNG';
            btn.style.cssText = 'margin-top: 10px; padding: 5px 10px; cursor: pointer;';
            btn.onclick = () => downloadSVGasPNG(img, 'icon-' + size + '.png', size, size);

            item.appendChild(btn);
        });
    </script>
</body>
</html>
HTML;

// Sauvegarder le générateur HTML
file_put_contents($imagesDir . '/icon-generator.html', $htmlIconGenerator);
echo "\n✓ Générateur HTML créé : assets/images/icon-generator.html\n";

// Créer aussi les images screenshot pour le manifest
$screenshotHTML = <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=540">
    <title>SangMeLima App</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            width: 540px;
            height: 720px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #FFF8F0 0%, #FFFFFF 100%);
            overflow: hidden;
        }
        .phone-frame {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .status-bar {
            height: 30px;
            background: #8B4513;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
            color: white;
            font-size: 12px;
        }
        .app-header {
            background: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .app-title {
            color: #8B4513;
            font-size: 24px;
            font-weight: bold;
        }
        .app-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .card h3 {
            color: #8B4513;
            margin-bottom: 10px;
        }
        .card p {
            color: #666;
            line-height: 1.6;
        }
        .prayer-card {
            border-left: 4px solid #D4AF37;
        }
        .bottom-nav {
            height: 60px;
            background: white;
            border-top: 1px solid #E5E5E5;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        .nav-item {
            text-align: center;
            color: #666;
            font-size: 11px;
        }
        .nav-icon {
            font-size: 20px;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>
    <div class="phone-frame">
        <div class="status-bar">
            <span>9:41</span>
            <span>SangMeLima</span>
            <span>100%</span>
        </div>

        <div class="app-header">
            <div class="app-title">✝️ SangMeLima</div>
            <div style="font-size: 12px; color: #999; margin-top: 5px;">
                Votre compagnon spirituel quotidien
            </div>
        </div>

        <div class="app-content">
            <div class="card prayer-card">
                <h3>📖 Évangile du jour</h3>
                <p>Découvrez la parole de Dieu pour aujourd'hui, directement depuis l'API AELF.</p>
            </div>

            <div class="card">
                <h3>🙏 Neuvaine active</h3>
                <p>Jour 3/9 - Neuvaine à Saint Joseph<br>
                <span style="font-size: 12px; color: #D4AF37;">152 participants</span></p>
            </div>

            <div class="card">
                <h3>💬 Rendez-vous spirituel</h3>
                <p>Réservez un accompagnement personnalisé en visioconférence.</p>
            </div>

            <div class="card">
                <h3>❤️ Faire un don</h3>
                <p>Soutenez notre mission d'évangélisation.</p>
            </div>
        </div>

        <div class="bottom-nav">
            <div class="nav-item">
                <div class="nav-icon">🏠</div>
                <div>Accueil</div>
            </div>
            <div class="nav-item">
                <div class="nav-icon">📿</div>
                <div>Prières</div>
            </div>
            <div class="nav-item">
                <div class="nav-icon">👥</div>
                <div>Groupes</div>
            </div>
            <div class="nav-item">
                <div class="nav-icon">📅</div>
                <div>RDV</div>
            </div>
            <div class="nav-item">
                <div class="nav-icon">⚙️</div>
                <div>Plus</div>
            </div>
        </div>
    </div>
</body>
</html>
HTML;

file_put_contents($imagesDir . '/screenshot-generator.html', $screenshotHTML);
echo "✓ Générateur de screenshots créé : assets/images/screenshot-generator.html\n";

echo "\n=== GÉNÉRATION TERMINÉE ===\n";
echo "1. Ouvrez assets/images/icon-generator.html dans un navigateur\n";
echo "2. Téléchargez chaque icône en PNG\n";
echo "3. Ouvrez screenshot-generator.html et faites une capture (540x720px)\n";
?>