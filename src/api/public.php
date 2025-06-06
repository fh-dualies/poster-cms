<?php
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../shared/response-status-enum.php';
require_once __DIR__ . '/../lib/config.php';

function fetchAllPosters(PDO $pdo): array
{
  $sql = 'SELECT id, user_id, author, creation_date, headline, meta_data FROM posters ORDER BY id ASC';
  $stmt = $pdo->query($sql);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($rows as &$r) {
    $r['id'] = (int) $r['id'];
    $r['user_id'] = (int) $r['user_id'];
  }

  unset($r);
  return $rows;
}

function fetchPosterById(PDO $pdo, int $id): ?array
{
  $query = '
        SELECT
            p.id            AS poster_id,
            p.user_id       AS user_id,
            p.author        AS author,
            p.creation_date AS creation_date,
            p.headline      AS headline,
            p.meta_data     AS meta_data,
            s.id            AS section_id,
            s.headline      AS section_headline,
            s.text          AS section_text,
            m.id            AS media_id,
            m.type          AS media_type,
            m.path          AS media_path,
            m.alt           AS media_alt
        FROM posters AS p
        LEFT JOIN sections AS s ON s.poster_id = p.id
        LEFT JOIN medias   AS m ON s.media_id  = m.id
        WHERE p.id = :id
        ORDER BY s.section_index ASC
    ';

  $stmt = $pdo->prepare($query);
  $stmt->execute([':id' => $id]);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (!$rows) {
    return null;
  }

  $poster = [
    'id' => (int) $rows[0]['poster_id'],
    'user_id' => (int) $rows[0]['user_id'],
    'author' => $rows[0]['author'],
    'creation_date' => $rows[0]['creation_date'],
    'headline' => $rows[0]['headline'],
    'meta_data' => $rows[0]['meta_data'],
    'sections' => [],
  ];

  foreach ($rows as $row) {
    if ($row['section_id'] === null) {
      continue;
    }

    $poster['sections'][] = [
      'id' => (int) $row['section_id'],
      'headline' => $row['section_headline'],
      'text' => $row['section_text'],
      'media' =>
        $row['media_id'] !== null
          ? [
            'id' => (int) $row['media_id'],
            'type' => $row['media_type'],
            'path' => $row['media_path'],
            'alt' => $row['media_alt'],
          ]
          : null,
    ];
  }

  return $poster;
}

try {
  $config = new Config();
  $pdo = $config->get_pdo();
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode([
    'error' => 'Database connection failed',
    'details' => $e->getMessage(),
  ]);
  exit();
}

$idParam = isset($_GET['id']) ? trim($_GET['id']) : null;

try {
  if ($idParam !== null && $idParam !== '') {
    if (!ctype_digit($idParam) || (int) $idParam <= 0) {
      http_response_code(400);
      echo json_encode(['error' => 'Invalid id parameter']);
      exit();
    }

    $poster = fetchPosterById($pdo, (int) $idParam);

    if ($poster === null) {
      http_response_code(404);
      echo json_encode(['error' => 'Poster not found']);
      exit();
    }

    echo json_encode($poster);
  } else {
    $allPosters = fetchAllPosters($pdo);
    echo json_encode($allPosters);
  }
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode([
    'error' => 'Query failed',
    'details' => $e->getMessage(),
  ]);
  exit();
}
