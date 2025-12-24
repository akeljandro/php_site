<?php
require_once 'auth.php';
requireAuth();
require_once 'layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php renderNavigation(); ?>
    <div class="loading" id="loading" style="display: none;">
        <span>Generando imagen...</span>
    </div>
    <div class="mensajes-container">
        <h1>Mensajes</h1>
        <?php
        require_once 'database.php';
        try{
            $pdo = getDatabaseConnection();
            $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
            $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($mensajes)){
                echo '<div class="msj-grid">';
                foreach($mensajes as $msj){
                    echo '<div class="msj-card" id="card-' . $msj['id'] . '">';
                    echo '<div class="card-content">';
                    echo '<h2>' . htmlspecialchars($msj['message']) . '</h2>';
                    echo '<p>' . htmlspecialchars($msj['created_at']) . '</p>';
                    echo '</div>';
                    echo '<button class="download-btn" onclick="downloadCard(' . $msj['id'] . ')">';
                    echo '<i class="icon-download">↓</i> Descargar';
                    echo '</button>';
                    echo '</div>';
                }
                echo '</div>';
            }else{
                echo '<p>No hay mensajes</p>';
            }
        }catch(PDOException $e){
            echo '<div class="error-message">';
            echo '<strong>Error:</strong> No se pudo conectar a la base de datos. ' . htmlspecialchars($e->getMessage());
            echo '</div>';
        }
        ?>
    </div>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize loading element
        const loading = document.getElementById('loading');
        
        // Function to show loading with message
        function showLoading(message = 'Generando imagen...') {
            loading.querySelector('span').textContent = message;
            loading.style.display = 'flex';
            return loading;
        }
        
        // Function to hide loading
        function hideLoading() {
            loading.style.display = 'none';
        }
        
        // Global function for card download
        window.downloadCard = async function(cardId) {
            const card = document.getElementById('card-' + cardId);
            const btn = card?.querySelector('.download-btn');
            
            if (!card || !btn) {
                console.error('Card or button not found');
                return;
            }
            
            const loading = showLoading();
            
            try {
                // Disable button during generation
                btn.disabled = true;
                
                // Small delay to ensure UI updates
                await new Promise(resolve => setTimeout(resolve, 50));
                
                // Get the background color from the body
                const bodyStyles = window.getComputedStyle(document.body);
                const bgColor = bodyStyles.backgroundColor;
                
                const canvas = await html2canvas(card, {
                    scale: 2,
                    backgroundColor: bgColor || '#ffffff', // Use body background or fallback to white
                    logging: false,
                    useCORS: true,
                    allowTaint: true,
                    onclone: function(clonedDoc) {
                        // Hide the download button in the cloned document
                        const cloneBtn = clonedDoc.getElementById('card-' + cardId)?.querySelector('.download-btn');
                        if (cloneBtn) {
                            cloneBtn.style.visibility = 'hidden';
                        }
                        
                        // Ensure the card has the same visual style as in the page
                        const cloneCard = clonedDoc.getElementById('card-' + cardId);
                        if (cloneCard) {
                            // Force the same background as the original
                            cloneCard.style.background = window.getComputedStyle(card).background;
                            cloneCard.style.backgroundColor = window.getComputedStyle(card).backgroundColor;
                            
                            // Ensure the card is visible in the clone
                            cloneCard.style.opacity = '1';
                            cloneCard.style.visibility = 'visible';
                            cloneCard.style.display = 'block';
                            
                            // Copy all computed styles to ensure consistency
                            const computedStyle = window.getComputedStyle(card);
                            for (let i = 0; i < computedStyle.length; i++) {
                                const prop = computedStyle[i];
                                cloneCard.style[prop] = computedStyle[prop];
                            }
                        }
                    },
                    
                    // Ensure background is captured
                    onrendered: function(cloneCanvas) {
                        // Apply any final canvas adjustments if needed
                        const ctx = cloneCanvas.getContext('2d');
                        // You can add additional canvas manipulations here if needed
                    }
                });
                
                // Create and trigger download
                const link = document.createElement('a');
                link.download = 'mensaje-' + cardId + '.png';
                link.href = canvas.toDataURL('image/png');
                
                // Use a small timeout to ensure the UI is responsive
                setTimeout(() => {
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    hideLoading();
                }, 100);
                
            } catch (error) {
                console.error('Error generating image:', error);
                showLoading('Error al generar la imagen');
                setTimeout(hideLoading, 2000);
            } finally {
                if (btn) {
                    btn.disabled = false;
                } else {
                    hideLoading();
                }
            }
        };
    });
    </script>
</body>
</html>