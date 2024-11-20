<?php
session_start();
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Get the professor details by ID
    $stmt = $pdo->prepare("SELECT * FROM professors WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $professor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$professor) {
        $_SESSION['message'] = 'Professor not found.';
        header('Location: index.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'No professor ID provided.';
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for updates
    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'department' => $_POST['department'],
        'field_of_expertise' => $_POST['field_of_expertise'],
        'years_of_experience' => $_POST['years_of_experience'],
        'education' => $_POST['education'],
        'id' => $id
    ];

    // Update professor in database
    $stmt = $pdo->prepare("UPDATE professors SET first_name = :first_name, last_name = :last_name, email = :email,
                            department = :department, field_of_expertise = :field_of_expertise, years_of_experience = :years_of_experience,
                            education = :education WHERE id = :id");
    $stmt->execute($data);

    $_SESSION['message'] = 'Professor updated successfully!';
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Professor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Edit Professor Details</h1>
    <form method="POST" action="edit.php?id=<?php echo $professor['id']; ?>">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($professor['first_name']); ?>" required>
        
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($professor['last_name']); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($professor['email']); ?>" required>
        
        <label for="department">Department:</label>
        <input type="text" name="department" value="<?php echo htmlspecialchars($professor['department']); ?>" required>
        
        <label for="field_of_expertise">Field of Expertise:</label>
        <input type="text" name="field_of_expertise" value="<?php echo htmlspecialchars($professor['field_of_expertise']); ?>" required>
        
        <label for="years_of_experience">Years of Experience:</label>
        <input type="number" name="years_of_experience" value="<?php echo htmlspecialchars($professor['years_of_experience']); ?>" required>
        
        <label for="education">Education:</label>
        <input type="text" name="education" value="<?php echo htmlspecialchars($professor['education']); ?>" required>

        <button type="submit">Update Professor</button>
    </form>
</body>
</html>
