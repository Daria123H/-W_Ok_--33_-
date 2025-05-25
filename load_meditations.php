<?php
header('Content-Type: application/json');
include 'bd.php';

$sql = "SELECT m.*, c.Name AS CategoryName 
        FROM Meditation m 
        LEFT JOIN Category c ON m.CategoryID = c.ID";
$result = $conn->query($sql);

$meditations = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $meditations[] = [
            'id' => $row['ID'],
            'title' => $row['Title'],
            'description' => $row['Description'],
            'duration' => $row['Duration'],
            'difficulty' => $row['DifficultyLevel'],
            'date_added' => $row['DateAdded'],
            'audio_video_link' => $row['AudioVideoLink'],
            'category' => $row['CategoryName'],
            'category_id' => $row['CategoryID']
        ];
    }
}
echo json_encode($meditations);

$conn->close();
?>