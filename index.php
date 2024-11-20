<?php
session_start();
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (isset($_GET['searchBtn'])) {
    $searchResult = searchProfessors($pdo, $_GET['searchInput']);
    $professors = $searchResult['querySet'] ?? [];
    $message = $searchResult['message'];
    $searchSuccessMessage = !empty($professors) ? "Search completed successfully! Found " . count($professors) . " result(s)." : "No professors found matching your search.";
} else {
    $allProfessors = getAllProfessors($pdo);
    $professors = $allProfessors['querySet'] ?? [];
    $message = $allProfessors['message'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor Applicant System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">

        <!-- Success Message Display -->
        <?php if (isset($_SESSION['message'])): ?>
            <p class="message success"><?php echo $_SESSION['message']; ?></p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <h1>Professor Applicant System</h1>

        <div class="search-container">
            <form action="index.php" method="GET">
                <input type="text" name="searchInput" placeholder="Search for applicants">
                <button type="submit" name="searchBtn">Search</button>
            </form>
        </div>

        <!-- Additional Links -->
        <p>
            <a class="clear-search" href="index.php">Clear Search</a> | 
            <a href="insert.php">Insert New Professor</a>
        </p>

        <!-- Professors Table -->
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Field of Expertise</th>
                    <th>Years of Experience</th>
                    <th>Education</th>
                    <th>Date Applied</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($professors)) {
                    foreach ($professors as $professor) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($professor['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($professor['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($professor['email']); ?></td>
                            <td><?php echo htmlspecialchars($professor['department']); ?></td>
                            <td><?php echo htmlspecialchars($professor['field_of_expertise']); ?></td>
                            <td><?php echo htmlspecialchars($professor['years_of_experience']); ?> years</td>
                            <td><?php echo htmlspecialchars($professor['education']); ?></td>
                            <td><?php echo htmlspecialchars($professor['date_applied']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $professor['id']; ?>">Edit</a> |
                                <a href="delete.php?id=<?php echo $professor['id']; ?>" onclick="return confirm('Are you sure you want to delete this professor?')">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else {
                    echo '<tr><td colspan="9">No professors found.</td></tr>';
                } ?>
            </tbody>
        </table>

    </div>
</body>
</html>
