<?php
$message = '';
$messageClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $result = editVideo($_GET['id'], $_POST['title'], $_POST['director'], $_POST['release_year']);

    if ($result === true) {
        $message = "Video updated successfully.";
        $messageClass = "alert-success";
    } else {
        $message = $result;
        $messageClass = "alert-danger";
    }
}

if (isset($_GET['id'])) {
    $video = getVideoById($_GET['id']);
    if ($video !== null) {
        ?>
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">Edit Video</h3>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $messageClass; ?> m-3"><?php echo $message; ?></div>
            <?php endif; ?>

            <form action="index.php?page=edit&id=<?php echo $video['id']; ?>" method="post">
                <div class="card-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" pattern="[a-zA-Z0-9 ]+"
                            title="Letters, numbers, and spaces only. No special characters."
                            value="<?php echo htmlspecialchars($video['title']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Director</label>
                        <input type="text" class="form-control" name="director" pattern="[a-zA-Z ]+"
                            title="Letters and spaces only. No numbers or special characters."
                            value="<?php echo htmlspecialchars($video['director']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Release Year</label>
                        <input type="text" class="form-control" name="release_year" pattern="\d+" title="Numbers only."
                            max="2026" value="<?php echo htmlspecialchars($video['release_year']); ?>" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="submit" class="btn btn-theme-accent">Update Video</button>
                    <button type="button" class="btn btn-default"
                        onclick="window.location.href='index.php?page=view';">Cancel</button>
                </div>
            </form>
        </div>
        <?php
    } else {
        echo '<div class="alert alert-warning">Video not found.</div>';
    }
} else {
    echo '<div class="alert alert-danger">No video ID specified.</div>';
}
?>