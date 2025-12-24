// Initialize variables first
let clickX = [];
let clickY = [];
let clickDrag = [];
let clickColor = []; // Store color for each point
let clickSize = []; // Store size for each point
let history = []; // Store drawing history for undo
let paint = false;
let currentColor = '#000000'; // Track current color without system picker
let currentSize = 5; // Track current brush size
let selectedHue = 0;
let selectedSaturation = 0;
let selectedBrightness = 100;

// Color picker functions
function rgbToHex(r, g, b) {
    return '#' + [r, g, b].map(x => {
        const hex = x.toString(16);
        return hex.length === 1 ? '0' + hex : hex;
    }).join('');
}

function hexToRgb(hex) {
    const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

function hslToRgb(h, s, l) {
    s /= 100;
    l /= 100;
    const k = n => (n + h / 30) % 12;
    const a = s * Math.min(l, 1 - l);
    const f = n => l - a * Math.max(-1, Math.min(k(n) - 3, Math.min(9 - k(n), 1)));
    return {
        r: Math.round(255 * f(0)),
        g: Math.round(255 * f(8)),
        b: Math.round(255 * f(4))
    };
}

function rgbToHsl(r, g, b) {
    r /= 255;
    g /= 255;
    b /= 255;
    const max = Math.max(r, g, b);
    const min = Math.min(r, g, b);
    let h, s, l = (max + min) / 2;

    if (max === min) {
        h = s = 0;
    } else {
        const d = max - min;
        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
        switch (max) {
            case r: h = ((g - b) / d + (g < b ? 6 : 0)) / 6; break;
            case g: h = ((b - r) / d + 2) / 6; break;
            case b: h = ((r - g) / d + 4) / 6; break;
        }
    }

    return {
        h: Math.round(h * 360),
        s: Math.round(s * 100),
        l: Math.round(l * 100)
    };
}

function drawColorPicker() {
    const canvas = document.getElementById('colorCanvas');
    const ctx = canvas.getContext('2d');
    const width = canvas.width;
    const height = canvas.height;

    // Draw hue/saturation gradient
    for (let y = 0; y < height; y++) {
        for (let x = 0; x < width; x++) {
            const hue = (x / width) * 360;
            const saturation = 100 - (y / height) * 100;
            const rgb = hslToRgb(hue, saturation, 50);
            ctx.fillStyle = `rgb(${rgb.r}, ${rgb.g}, ${rgb.b})`;
            ctx.fillRect(x, y, 1, 1);
        }
    }
}

function updateColorFromPicker() {
    const rgb = hslToRgb(selectedHue, selectedSaturation, selectedBrightness);
    currentColor = rgbToHex(rgb.r, rgb.g, rgb.b);
    document.getElementById('hexInput').value = currentColor;
    document.getElementById('colorPreview').style.backgroundColor = currentColor;
    
    // Update cursor position
    const canvas = document.getElementById('colorCanvas');
    const cursor = document.getElementById('colorCursor');
    const x = (selectedHue / 360) * canvas.width;
    const y = ((100 - selectedSaturation) / 100) * canvas.height;
    cursor.style.left = x + 'px';
    cursor.style.top = y + 'px';
}

function updateColorFromHex() {
    const hex = document.getElementById('hexInput').value;
    if (!/^#[0-9A-F]{6}$/i.test(hex)) return;
    
    const rgb = hexToRgb(hex);
    if (rgb) {
        currentColor = hex;
        document.getElementById('colorPreview').style.backgroundColor = hex;
        
        const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
        selectedHue = hsl.h;
        selectedSaturation = hsl.s;
        selectedBrightness = hsl.l;
        document.getElementById('brightnessSlider').value = selectedBrightness;
        
        updateColorFromPicker();
    }
}

function setColor(color) {
    currentColor = color;
    document.getElementById('hexInput').value = color;
    document.getElementById('colorPreview').style.backgroundColor = color;
    
    const rgb = hexToRgb(color);
    if (rgb) {
        const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
        selectedHue = hsl.h;
        selectedSaturation = hsl.s;
        selectedBrightness = hsl.l;
        document.getElementById('brightnessSlider').value = selectedBrightness;
        updateColorFromPicker();
    }
}

// Get canvas element and context
const canvasElement = document.getElementById('myCanvas');
if (!canvasElement) {
    console.error('Canvas element not found');
} else {
    const canvas = canvasElement.getContext('2d');
    
    // Set canvas internal resolution
    function setCanvasSize() {
        const rect = canvasElement.getBoundingClientRect();
        const dpr = window.devicePixelRatio || 1;
        
        // Set internal canvas size
        canvasElement.width = rect.width * dpr;
        canvasElement.height = rect.height * dpr;
        
        // Scale context to match device pixel ratio
        canvas.scale(dpr, dpr);
        
        // Redraw existing content
        redraw();
    }
    
    // Initialize canvas size
    setCanvasSize();
    
    // Handle window resize
    window.addEventListener('resize', setCanvasSize);

    // Set up color picker event listeners
    const colorCanvas = document.getElementById('colorCanvas');
    const colorCursor = document.getElementById('colorCursor');
    
    // Initialize color picker
    drawColorPicker();
    
    // Canvas mouse events
    colorCanvas.addEventListener('mousedown', function(e) {
        const rect = colorCanvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        selectedHue = (x / colorCanvas.width) * 360;
        selectedSaturation = 100 - (y / colorCanvas.height) * 100;
        updateColorFromPicker();
    });
    
    colorCanvas.addEventListener('mousemove', function(e) {
        if (e.buttons === 1) { // Left mouse button is pressed
            const rect = colorCanvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            selectedHue = (x / colorCanvas.width) * 360;
            selectedSaturation = 100 - (y / colorCanvas.height) * 100;
            updateColorFromPicker();
        }
    });
    
    // Brightness slider
    document.getElementById('brightnessSlider').addEventListener('input', function(e) {
        selectedBrightness = parseInt(e.target.value);
        updateColorFromPicker();
    });
    
    // Hex input
    document.getElementById('hexInput').addEventListener('input', updateColorFromHex);
    
    // Size slider
    const sizeSlider = document.getElementById('sizeSlider');
    const sizeValue = document.getElementById('sizeValue');
    
    sizeSlider.addEventListener('input', function(e) {
        currentSize = parseInt(e.target.value);
        sizeValue.textContent = currentSize;
    });
    
    // Clear button
    document.getElementById('clearBtn').addEventListener('click', function() {
        saveState(); // Save state before clearing
        clickX = [];
        clickY = [];
        clickDrag = [];
        clickColor = [];
        clickSize = [];
        redraw();
    });
    
    // Undo button
    document.getElementById('undoBtn').addEventListener('click', undo);
    
    // Save button
    document.getElementById('saveBtn').addEventListener('click', function() {
        const canvas = document.getElementById('myCanvas');
        const tempCanvas = document.createElement('canvas');
        const tempCtx = tempCanvas.getContext('2d');
        
        // Set temp canvas size to match display canvas
        const rect = canvas.getBoundingClientRect();
        tempCanvas.width = rect.width;
        tempCanvas.height = rect.height;
        
        // Fill with white background
        tempCtx.fillStyle = 'white';
        tempCtx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);
        
        // Draw the original canvas content on top
        tempCtx.drawImage(canvas, 0, 0, rect.width, rect.height);
        
        // Save the composite image
        const link = document.createElement('a');
        link.download = 'drawing.png';
        link.href = tempCanvas.toDataURL();
        link.click();
    });
    
    // Send button - save to database
    document.getElementById('sendBtn').addEventListener('click', function() {
        const canvas = document.getElementById('myCanvas');
        const tempCanvas = document.createElement('canvas');
        const tempCtx = tempCanvas.getContext('2d');
        
        // Set temp canvas size to match display canvas
        const rect = canvas.getBoundingClientRect();
        tempCanvas.width = rect.width;
        tempCanvas.height = rect.height;
        
        // Fill with white background
        tempCtx.fillStyle = 'white';
        tempCtx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);
        
        // Draw the original canvas content on top
        tempCtx.drawImage(canvas, 0, 0, rect.width, rect.height);
        
        // Get base64 data
        const imageData = tempCanvas.toDataURL('image/png');
        
        // Send to database
        fetch('http://localhost:8000/save_drawing.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'imageData=' + encodeURIComponent(imageData) + '&title=Drawing_' + new Date().getTime()
        })
        .then(response => {
            // Get response as text first to debug
            return response.text();
        })
        .then(text => {
            console.log('Raw response:', text);
            try {
                const data = JSON.parse(text);
                const messageDiv = document.getElementById('message');
                
                // Create a temporary message element
                const tempMessage = document.createElement('div');
                if (data.success) {
                    tempMessage.className = 'message-success';
                    tempMessage.textContent = data.message;
                } else {
                    tempMessage.className = 'message-error';
                    tempMessage.textContent = data.message;
                }
                
                // Insert the message at the beginning of the message div
                messageDiv.insertBefore(tempMessage, messageDiv.firstChild);
                
                // Remove the temporary message after 3 seconds
                setTimeout(() => {
                    if (tempMessage.parentNode) {
                        tempMessage.parentNode.removeChild(tempMessage);
                    }
                }, 3000);
            } catch (e) {
                console.error('JSON parse error:', e);
                console.error('Response text:', text);
                const messageDiv = document.getElementById('message');
                
                const tempMessage = document.createElement('div');
                tempMessage.className = 'message-error';
                tempMessage.textContent = 'Respuesta inválida del servidor';
                
                messageDiv.insertBefore(tempMessage, messageDiv.firstChild);
                
                setTimeout(() => {
                    if (tempMessage.parentNode) {
                        tempMessage.parentNode.removeChild(tempMessage);
                    }
                }, 3000);
            }
        })
        .catch(error => {
            const messageDiv = document.getElementById('message');
            
            const tempMessage = document.createElement('div');
            tempMessage.className = 'message-error';
            tempMessage.textContent = 'Error al guardar dibujo: ' + error.message;
            
            messageDiv.insertBefore(tempMessage, messageDiv.firstChild);
            
            setTimeout(() => {
                if (tempMessage.parentNode) {
                    tempMessage.parentNode.removeChild(tempMessage);
                }
            }, 3000);
        });
    });
    
    // Set up preset color functionality
    const presetColors = document.querySelectorAll('.preset-color');
    
    presetColors.forEach(preset => {
        preset.addEventListener('click', function() {
            const color = this.getAttribute('data-color');
            setColor(color);
            
            // Update active state
            presetColors.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Mouse event handlers for drawing canvas
    canvasElement.addEventListener('mousedown', function(e) {
        const rect = canvasElement.getBoundingClientRect();
        const mouseX = e.clientX - rect.left;
        const mouseY = e.clientY - rect.top;
        
        paint = true;
        saveState(); // Save state before drawing
        addClick(mouseX, mouseY);
        redraw();
    });

    canvasElement.addEventListener('mousemove', function(e) {
        if (paint) {
            const rect = canvasElement.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const mouseY = e.clientY - rect.top;
            addClick(mouseX, mouseY, true);
            redraw();
        }
    });

    canvasElement.addEventListener('mouseup', function() {
        paint = false;
    });

    canvasElement.addEventListener('mouseleave', function() {
        paint = false;
    });
    
    // Initialize with black as default
    setColor('#000000');
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl+Z for undo
    if (e.ctrlKey && e.key === 'z') {
        e.preventDefault(); // Prevent browser's default undo
        undo();
    }
});

function saveState() {
    // Save current state to history
    history.push({
        clickX: [...clickX],
        clickY: [...clickY],
        clickDrag: [...clickDrag],
        clickColor: [...clickColor],
        clickSize: [...clickSize]
    });
    
    // Limit history to 50 states to prevent memory issues
    if (history.length > 50) {
        history.shift();
    }
}

function undo() {
    if (history.length > 0) {
        const previousState = history.pop();
        clickX = previousState.clickX;
        clickY = previousState.clickY;
        clickDrag = previousState.clickDrag;
        clickColor = previousState.clickColor;
        clickSize = previousState.clickSize;
        redraw();
    }
}

function addClick(x, y, dragging) {
    clickX.push(x);
    clickY.push(y);
    clickDrag.push(dragging);
    clickColor.push(currentColor); // Store current color with this point
    clickSize.push(currentSize); // Store current size with this point
}

function redraw(){
    const canvasElement = document.getElementById('myCanvas');
    if (!canvasElement) return;
    
    const canvas = canvasElement.getContext('2d');
    canvas.clearRect(0, 0, canvasElement.width, canvasElement.height);
    
    for(let i = 0; i < clickX.length; i++) {
        canvas.beginPath();
        canvas.strokeStyle = clickColor[i]; // Use individual point color
        canvas.lineWidth = clickSize[i]; // Use individual point size
        canvas.lineCap = 'round';
        canvas.lineJoin = 'round';
        
        if (i === 0 || !clickDrag[i]) {
            canvas.moveTo(clickX[i], clickY[i]);
            canvas.lineTo(clickX[i], clickY[i]); // Draw a point for standalone clicks
        } else {
            canvas.moveTo(clickX[i-1], clickY[i-1]);
            canvas.lineTo(clickX[i], clickY[i]);
        }
        
        canvas.stroke();
    }
}