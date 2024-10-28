// fix-namespace.php

<?php

// Update the namespace in the published files if necessary
$filesToUpdate = [
    'app/Models/Post.php',
    'app/Models/Category.php',
    'app/Http/Controllers/PostController.php',
    'app/Http/Controllers/QuillUploadController.php',
];

foreach ($filesToUpdate as $filePath) {
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        
        // Replace the namespace here (adjust as necessary)
        $updatedContent = str_replace('Kezeneilhou\\CmsLaravel\\', 'App\\', $content);
        
        // Write the updated content back to the file
        file_put_contents($filePath, $updatedContent);
        echo "Updated namespace in: $filePath\n";
    } else {
        echo "File not found: $filePath\n";
    }
}
