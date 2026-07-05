<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function validateVideoData($title, $director, $release_year)
{
    if (empty(trim($title)) || empty(trim($director)) || empty(trim($release_year))) {
        return "Validation Error: All fields are required and cannot be left empty.";
    }

    if (!preg_match('/^[a-zA-Z0-9 ]+$/', $title)) {
        return "Validation Error: Title cannot contain special characters.";
    }

    if (!preg_match('/^[a-zA-Z ]+$/', $director)) {
        return "Validation Error: Director name can only contain letters and spaces.";
    }

    if (!preg_match('/^\d+$/', $release_year)) {
        return "Validation Error: Release year must contain digits only.";
    }

    $max_year = 2026;
    if ((int) $release_year > $max_year) {
        return "Validation Error: Release year cannot exceed $max_year.";
    }

    $min_year = 1600;
    if ((int) $release_year < $min_year) {
        return "Validation Error: Release year cannot be below $min_year.";
    }

    return true;
}

// Add a video
function addVideo($title, $director, $release_year)
{
    $validation = validateVideoData($title, $director, $release_year);
    if ($validation !== true) {
        return $validation;
    }

    $formatted_title = ucwords(strtolower(trim($title)));
    $formatted_director = ucwords(strtolower(trim($director)));

    if (!isset($_SESSION['videos'])) {
        $_SESSION['videos'] = [];
    }

    $new_id = count($_SESSION['videos']) + 1;
    $_SESSION['videos'][] = [
        'id' => $new_id,
        'title' => $formatted_title,
        'director' => $formatted_director,
        'release_year' => (int) $release_year
    ];
    return true;
}

// Get all videos
function getVideos()
{
    return isset($_SESSION['videos']) ? $_SESSION['videos'] : [];
}

// Get a single video by ID
function getVideoById($id)
{
    if (!isset($_SESSION['videos']))
        return null;
    foreach ($_SESSION['videos'] as $video) {
        if ($video['id'] == $id) {
            return $video;
        }
    }
    return null;
}

// Update a video
function editVideo($id, $title, $director, $release_year)
{
    if (!isset($_SESSION['videos']))
        return "Error: No data context found.";

    $validation = validateVideoData($title, $director, $release_year);
    if ($validation !== true) {
        return $validation;
    }

    $formatted_title = ucwords(strtolower(trim($title)));
    $formatted_director = ucwords(strtolower(trim($director)));

    foreach ($_SESSION['videos'] as $key => $video) {
        if ($video['id'] == $id) {
            $_SESSION['videos'][$key] = [
                'id' => (int) $id,
                'title' => $formatted_title,
                'director' => $formatted_director,
                'release_year' => (int) $release_year
            ];
            return true;
        }
    }
    return "Error: Video ID matching target reference not found.";
}

function deleteVideo($id)
{
    if (!isset($_SESSION['videos']))
        return false;
    foreach ($_SESSION['videos'] as $key => $video) {
        if ($video['id'] == $id) {
            unset($_SESSION['videos'][$key]);
            $_SESSION['videos'] = array_values($_SESSION['videos']);
            return true;
        }
    }
    return false;
}
?>