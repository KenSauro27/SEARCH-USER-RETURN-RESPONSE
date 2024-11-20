<?php
// Function to get all professors
function getAllProfessors($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM professors ORDER BY date_applied DESC");
        $stmt->execute();
        return ['querySet' => $stmt->fetchAll(PDO::FETCH_ASSOC), 'message' => 'Professors retrieved successfully.'];
    } catch (PDOException $e) {
        return ['querySet' => [], 'message' => 'Error retrieving professors: ' . $e->getMessage()];
    }
}

function searchProfessors($pdo, $searchTerm) {
    try {
        $query = "SELECT * FROM professors 
                  WHERE first_name LIKE :searchTerm 
                  OR last_name LIKE :searchTerm 
                  OR email LIKE :searchTerm 
                  OR department LIKE :searchTerm 
                  OR field_of_expertise LIKE :searchTerm 
                  OR years_of_experience LIKE :searchTerm 
                  OR education LIKE :searchTerm 
                  ORDER BY date_applied DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
        return ['querySet' => $stmt->fetchAll(PDO::FETCH_ASSOC), 'message' => 'Search successful.'];
    } catch (PDOException $e) {
        return ['querySet' => [], 'message' => 'Search error: ' . $e->getMessage()];
    }
}


// Function to insert a new professor
function insertProfessor($pdo, $data) {
    try {
        $stmt = $pdo->prepare("INSERT INTO professors (first_name, last_name, email, department, field_of_expertise, years_of_experience, education) 
                                VALUES (:first_name, :last_name, :email, :department, :field_of_expertise, :years_of_experience, :education)");
        $stmt->execute($data);
        return ['message' => 'New professor added successfully!'];
    } catch (PDOException $e) {
        return ['message' => 'Error inserting professor: ' . $e->getMessage()];
    }
}

// Function to delete a professor by ID
function deleteProfessor($pdo, $id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM professors WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return ['message' => 'Professor deleted successfully!'];
    } catch (PDOException $e) {
        return ['message' => 'Error deleting professor: ' . $e->getMessage()];
    }
}
?>
