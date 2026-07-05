<?php
$message = '';
$messageClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $result = addVideo($_POST['title'], $_POST['director'], $_POST['release_year']);

    if ($result === true) {
        $message = "Video added successfully.";
        $messageClass = "alert-success";
    } else {
        $message = $result; // Catches exact rule breach reasons
        $messageClass = "alert-danger";
    }
}
?>

<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">Add New Video</h3>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert <?php echo $messageClass; ?> m-3"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="index.php?page=add" method="post">
        <div class="card-body">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" name="title" pattern="[a-zA-Z0-9 ]+"
                    title="Letters, numbers, and spaces only. No special characters." placeholder="Enter video title"
                    required>
            </div>
            <div class="form-group">
                <label>Director</label>
                <input type="text" class="form-control" name="director" pattern="[a-zA-Z ]+"
                    title="Letters and spaces only. No numbers or special characters." placeholder="Enter director name"
                    required>
            </div>
            <div class="form-group">
                <label>Release Year</label>
                <input type="text" class="form-control" name="release_year" pattern="\d+" title="Numbers only."
                    max="2026" placeholder="e.g. 2024" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-theme-accent">Save Video</button>
            <button type="button" class="btn btn-default"
                onclick="window.location.href='index.php?page=view';">Cancel</button>
        </div>
    </form>
</div>