<?php

$data = [
	['Иванов', 'Математика', 5],
	['Иванов', 'Математика', 4],
	['Иванов', 'Математика', 5],
	['Петров', 'Математика', 5],
	['Сидоров', 'Физика', 4],
	['Иванов', 'Физика', 4],
	['Петров', 'ОБЖ', 4],
];

$scores = [];


foreach ($data as $entry) {
	list($student, $subject, $score) = $entry;
	if (!isset($scores[$student])) {
		$scores[$student] = [];
	}
	if (!isset($scores[$student][$subject])) {
        $scores[$student][$subject] = 0;
    }
    $scores[$student][$subject] += $score;
}

$subjects = [];
foreach ($scores as $studentScores) {
    $subjects = array_merge($subjects, array_keys($studentScores));
}
$subjects = array_unique($subjects);
sort($subjects);

// Сортируем учеников по алфавиту
ksort($scores);

// Построение HTML таблицы
echo "<table border='1'>\n";
echo "<tr><th>Школьник</th>";
foreach ($subjects as $subject) {
    echo "<th>$subject</th>";
}
echo "</tr>\n";

foreach ($scores as $student => $studentScores) {
    echo "<tr><td>$student</td>";
    foreach ($subjects as $subject) {
        $score = isset($studentScores[$subject]) ? $studentScores[$subject] : 0;
        echo "<td>$score</td>";
    }
    echo "</tr>\n";
}

echo "</table>\n";