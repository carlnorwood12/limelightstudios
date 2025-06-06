<?php
session_start();
include '../connection.php';
global $dbhandle;

// Check if user is Adult (restrict access)
if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] !== 'Adult') {
    header("Location: ../");
    exit;
}

// Handle movie deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_movie'])) {
    $movie_id = $_POST['movie_id'] ?? 0;
    if ($movie_id > 0) {
        // Use prepared statement for security
        $stmt = mysqli_prepare($dbhandle, "DELETE FROM saved_movies WHERE id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $movie_id);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1");
                exit;
            }
            mysqli_stmt_close($stmt);
        }
    }
}

// Fetch saved movies
$saved_movies_query = "
    SELECT 
        id,
        title,
        poster_url,
        saved_at
    FROM 
        saved_movies
    ORDER BY saved_at DESC
";

$saved_movies_result = mysqli_query($dbhandle, $saved_movies_query) or die('Error querying saved movies: ' . mysqli_error($dbhandle));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Saved Movies</title>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <link rel="stylesheet" href="../css/adult.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="radial-gradient"></div>
    <div class="page">
        <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="navbar-brand py-3">
                    <div class="d-flex align-items-center">
                        <div class="profile-image-container">
                            <img class="profile-image" src="../upload/<?php echo $_SESSION['profile_picture'] ?? 'default_pfp.svg'; ?>" alt="Profile Picture">
                        </div>
                        <div class="profile-info">
                            <h3 class="profile-name"><?=$_SESSION['name'] ?? "Please login" ?></h3>
                            <p class="profile-role"><?= $_SESSION['user_status'] ?? "To view account details" ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="navbar-nav flex-row d-lg-none"></div>
                
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php" >
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <img src="/svg/adminpanel/profile.svg" class="icon" width="20px" />
                                </span>
                                <span class="nav-link-title">Profile</span>
                            </a>
                        </li>
                        <?php if ($_SESSION['user_status'] !== 'Junior'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="bookings.php">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <img src="/svg/adminpanel/bookings.svg" class="icon" width="20px" />
                                    </span>
                                    <span class="nav-link-title">Bookings</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="saved.php" >
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <img src="/svg/adminpanel/saveforlater.svg" class="icon" width="20px" />
                                </span>
                                <span class="nav-link-title">Saved</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        
        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">Saved Movies</h2>
                            <p class="text-muted mt-1">Your personal watchlist of saved movies.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-cards">
                        <div class="col-12">
                            <?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1'): ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <div>Movie was successfully removed from your watchlist.</div>
                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table" style="min-width: 1200px;">
                                        <thead>
                                            <tr>
                                                <th style="width: 200px !important; min-width: 200px !important;" class="poster-cell">Movie Poster</th>
                                                <th class="movie-details-cell">Movie Details</th>
                                                <th class="saved-info-cell">Saved Information</th>
                                                <th class="actions-cell">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($saved_movies_result && mysqli_num_rows($saved_movies_result) > 0): ?>
                                                <?php while ($movie = mysqli_fetch_assoc($saved_movies_result)): ?>
                                                <tr>
                                                    <td style="width: 200px !important; min-width: 200px !important;" class="poster-cell">
                                                        <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>"
                                                            alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                                            class="poster-thumbnail">
                                                    </td>
                                                    <td class="movie-details-cell" data-label="Movie Details">
                                                        <div class="movie-details">
                                                            <div class="movie-title">
                                                                <?php echo htmlspecialchars($movie['title']); ?>
                                                            </div>
                                                            <div class="detail-item">
                                                                <span class="detail-label">Movie ID:</span>
                                                                <span class="detail-value">#<?php echo $movie['id']; ?></span>
                                                            </div>
                                                            <div class="detail-item">
                                                                <span class="detail-label">Status:</span>
                                                                <span class="detail-value">Coming Soon</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="saved-info-cell" data-label="Saved Information">
                                                        <div class="saved-info">
                                                            <div class="detail-item">
                                                                <span class="detail-label">Saved on:</span>
                                                                <span class="detail-value saved-date">
                                                                    <?php echo date('M j, Y', strtotime($movie['saved_at'])); ?>
                                                                </span>
                                                            </div>
                                                            <div class="detail-item">
                                                                <span class="detail-label">Time:</span>
                                                                <span class="detail-value saved-date">
                                                                    <?php echo date('g:i A', strtotime($movie['saved_at'])); ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="actions-cell">
                                                        <div class="action-buttons">
                                                            <button type="button" class="delete-btn"
                                                                onclick="confirmDelete(<?php echo $movie['id']; ?>, '<?php echo htmlspecialchars($movie['title']); ?>')">
                                                                Remove
                                                            </button>
                                                        </div>
                                                        <form id="delete-form-<?php echo $movie['id']; ?>"
                                                            action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                                                            style="display: none;">
                                                            <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                                                            <input type="hidden" name="delete_movie" value="1">
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <p class="text-muted">No saved movies found. Start building your watchlist!</p>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        function confirmDelete(movieId, movieTitle) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to remove "${movieTitle}" from your watchlist. This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7928ca',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${movieId}`).submit();
                }
            });
        }

        $(document).ready(function () {
            $('.poster-cell').css('width', '200px');
            $('.poster-cell').css('min-width', '200px');
        });
    </script>
    <script src="./dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./dist/js/demo.min.js?1692870487" defer></script>
</body>
</html>
<?php
mysqli_close($dbhandle);
?>