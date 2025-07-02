<?php
$uploadDir = __DIR__ . '/uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['skin'])) {
    $file = $_FILES['skin'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if ($ext !== 'png') {
        echo json_encode(['success' => false, 'error' => 'Only .png files are allowed.']);
        exit;
    }

    $filename = uniqid("skin_", true) . ".png";
    $path = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $path)) {
        $protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $url = "$protocol://$host/uploads/$filename";
        echo json_encode(['success' => true, 'url' => $url]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No file uploaded.']);
}
?>
