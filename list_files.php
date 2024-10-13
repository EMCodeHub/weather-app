<?php

// Define las rutas que deseas escanear
$paths = [
    'app/Models',
    'app/Http/Controllers',
    'app/Console/Commands',
    'app/Services/Adapters',
    'routes'
];



// Archivo de salida
$outputFile = 'important_files_list.txt';

// Abre el archivo de salida para escribir
$fileHandle = fopen($outputFile, 'w');

// Verifica si se pudo abrir el archivo
if (!$fileHandle) {
    die("No se pudo crear el archivo de salida.");
}

// Función para escanear directorios recursivamente
function scanDirectory($directory, $fileHandle) {
    $items = scandir($directory);
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue; // Ignorar directorios especiales
        }

        $path = $directory . '/' . $item;

        if (is_dir($path)) {
            // Llama recursivamente a la función si es un directorio
            scanDirectory($path, $fileHandle);
        } else {
            // Escribir solo archivos importantes
            if (preg_match('/\.(php|blade\.php)$/', $item)) {
                // Escribir el título del archivo (nombre del archivo)
                fwrite($fileHandle, "=== $path ===\n");
                // Leer y escribir el contenido del archivo
                $content = file_get_contents($path);
                fwrite($fileHandle, $content . "\n\n");
            }
        }
    }
}

// Recorrer los caminos definidos
foreach ($paths as $path) {
    if (is_dir($path)) {
        scanDirectory($path, $fileHandle);
    } else {
        echo "El directorio no existe: $path\n";
    }
}

// Cierra el archivo de salida
fclose($fileHandle);

echo "Se ha generado el archivo: $outputFile\n";
