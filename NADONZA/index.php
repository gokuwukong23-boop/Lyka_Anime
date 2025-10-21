<?php
$anime_list = [
    ["title" => "K-On!", "desc" => "A fun story about high school girls forming a music band.", "img" => "KOH.jpg", "genre" => "Slice of Life, Comedy"],
    ["title" => "Cardcaptor Sakura", "desc" => "Follow Sakura on her magical adventures collecting cards.", "img" => "KAH.jpg", "genre" => "Fantasy, Adventure"],
    ["title" => "Lucky Star", "desc" => "Slice-of-life comedy with cute schoolgirl antics.", "img" => "KBH.jpg", "genre" => "Slice of Life, Comedy"],
    ["title" => "Toradora!", "desc" => "A sweet romantic comedy with lovable characters.", "img" => "KCH.jpg", "genre" => "Romance, Comedy"],
    ["title" => "My Youth Romantic Comedy Is Wrong, As I Expected", "desc" => "Quirky high school life and charming character interactions.", "img" => "KDH.jpg", "genre" => "Romance, Comedy"],
    ["title" => "Is the Order a Rabbit?", "desc" => "Cute girls running a café with adorable animals.", "img" => "KEH.jpg", "genre" => "Slice of Life, Comedy"],
    ["title" => "Clannad", "desc" => "Emotional slice-of-life story with heartwarming moments.", "img" => "KFH.jpg", "genre" => "Drama, Romance"],
    ["title" => "Nyan Koi!", "desc" => "Romantic comedy featuring cats and high school shenanigans.", "img" => "KHI.jpg", "genre" => "Romance, Comedy"],
    ["title" => "Himouto! Umaru-chan", "desc" => "A cute and funny story about a double life at home and school.", "img" => "KGH.jpg", "genre" => "Slice of Life, Comedy"],
    ["title" => "Yuru Yuri", "desc" => "Comedy and friendship of cute middle school girls.", "img" => "KII.jpg", "genre" => "Slice of Life, Comedy"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 10 Cute Anime Recommendations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700&family=Quicksand:wght@400;600&display=swap');
        * { box-sizing: border-box; }
        body { 
            font-family: 'Quicksand', sans-serif; 
            background: linear-gradient(135deg, #fce4ec, #f3e5f5, #e1bee7); 
            margin: 0; 
            padding: 0; 
            color: #333; 
            overflow-x: hidden;
        }
        .header-container { 
            position: fixed; 
            top: 0; 
            width: 100%; 
            background: linear-gradient(90deg, #f48fb1, #ec407a); 
            z-index: 1000; 
            padding: 20px 0; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.2); 
            animation: slideDown 0.5s ease-out;
        }
        @keyframes slideDown { from { transform: translateY(-100%); } to { transform: translateY(0); } }
        .header-inner { 
            max-width: 1200px; 
            margin: 0 auto; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 0 20px;
        }
        .center-content { 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            text-align: center;
        }
        h1 { 
            margin: 0 0 15px 0; 
            font-size: 2.5em; 
            color: white; 
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3); 
            font-family: 'Baloo 2', cursive;
        }
        .signup-btn { 
            background: linear-gradient(45deg, #ff6b9d, #c44569); 
            color: white; 
            border: none; 
            padding: 12px 24px; 
            border-radius: 50px; 
            font-size: 1em; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); 
            box-shadow: 0 4px 15px rgba(0,0,0,0.2); 
            position: relative; 
            overflow: hidden;
        }
        .signup-btn::before { 
            content: ''; 
            position: absolute; 
            top: 0; 
            left: -100%; 
            width: 100%; 
            height: 100%; 
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); 
            transition: left 0.5s; 
        }
        .signup-btn:hover::before { left: 100%; }
        .signup-btn:hover { 
            transform: translateY(-3px) scale(1.05); 
            box-shadow: 0 8px 25px rgba(0,0,0,0.3); 
            background: linear-gradient(45deg, #c44569, #ff6b9d);
        }
        .signup-btn:active { 
            transform: translateY(0) scale(0.98); 
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .search-container { 
            position: relative; 
            width: 80%; 
            max-width: 400px;
        }
        #searchInput { 
            padding: 12px 40px 12px 15px; 
            width: 100%; 
            border-radius: 50px; 
            border: 2px solid #f06292; 
            outline: none; 
            font-size: 1em; 
            transition: all 0.3s ease; 
            background: rgba(255,255,255,0.9);
        }
        #searchInput:focus { 
            box-shadow: 0 0 15px rgba(240,98,146,0.6); 
            border-color: #ec407a; 
            background: white;
        }
        .search-icon { 
            position: absolute; 
            right: 15px; 
            top: 50%; 
            transform: translateY(-50%); 
            color: #f06292; 
            font-size: 1.2em;
        }
        .anime-list { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
            gap: 30px; 
            padding: 220px 20px 40px 20px; 
            max-width: 1200px; 
            margin: 0 auto;
        }
        .card { 
            background: linear-gradient(145deg, #fff, #f8f9fa); 
            border-radius: 20px; 
            padding: 20px; 
            box-shadow: 0 8px 20px rgba(0,0,0,0.1); 
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); 
            cursor: pointer; 
            text-align: center; 
            position: relative; 
            overflow: hidden; 
            opacity: 0; 
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .card:nth-child(odd) { animation-delay: 0.1s; }
        .card:nth-child(even) { animation-delay: 0.2s; }
        @keyframes fadeInUp { 
            from { opacity: 0; transform: translateY(30px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        .card:hover { 
            transform: translateY(-15px) scale(1.03); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.2); 
        }
        .card::before { 
            content: ''; 
            position: absolute; 
            top: 0; 
            left: -100%; 
            width: 100%; 
            height: 100%; 
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); 
            transition: left 0.5s; 
        }
        .card:hover::before { left: 100%; }
        .card img { 
            width: 100%; 
            height: 200px; 
            object-fit: cover; 
            border-radius: 15px; 
            margin-bottom: 15px; 
            transition: transform 0.3s ease, filter 0.3s ease; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .card img:hover { 
            transform: scale(1.1) rotate(2deg); 
            filter: brightness(1.1);
        }
        .card h2 { 
            font-size: 1.5em; 
            margin: 10px 0 5px; 
            color: #ad1457; 
            font-family: 'Baloo 2', cursive;
        }
        .card p { 
            font-size: 1em; 
            color: #555; 
            line-height: 1.5; 
            margin-bottom: 10px;
        }
        .genre { 
            font-size: 0.9em; 
            color: #ec407a; 
            font-weight: 600; 
            margin-top: 10px;
        }
        .favorite-btn { 
            position: absolute; 
            top: 10px; 
            right: 10px; 
            background: rgba(255,255,255,0.8); 
            border: none; 
            border-radius: 50%; 
            width: 35px; 
            height: 35px; 
            cursor: pointer; 
            transition: all 0.3s; 
            display: flex; 
            align-items: center; 
            justify-content: center;
        }
        .favorite-btn:hover { 
            background: #ec407a; 
            color: white; 
            transform: scale(1.1);
        }
        .modal { 
            display: none; 
            position: fixed; 
            z-index: 2000; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            background-color: rgba(0,0,0,0.8); 
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .modal-content { 
            background: white; 
            margin: 10% auto; 
            padding: 20px; 
            border-radius: 20px; 
            width: 80%; 
            max-width: 500px; 
            text-align: center; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .close { 
            color: #aaa; 
            float: right; 
            font-size: 28px; 
            font-weight: bold; 
            cursor: pointer;
        }
        .close:hover { color: #000; }
        .back-to-top { 
            position: fixed; 
            bottom: 20px; 
            right: 20px; 
            background: #ec407a; 
            color: white; 
            border: none; 
            border-radius: 50%; 
            width: 50px; 
            height: 50px; 
            cursor: pointer; 
            display: none; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.2); 
            transition: all 0.3s;
        }
        .back-to-top:hover { 
            background: #ad1457; 
            transform: scale(1.1);
        }
        footer { 
            background: #f48fb1; 
            color: white; 
            text-align: center; 
            padding: 20px; 
            margin-top: 40px;
        }
        @media (max-width: 768px) { 
            .anime-list { grid-template-columns: 1fr; padding-top: 250px; } 
            h1 { font-size: 2em; } 
            .card { padding: 15px; }
            .header-inner { flex-direction: column; align-items: center; }
            .center-content { margin-bottom: 15px; }
            .signup-btn { margin-top: 10px; }
        }
        .logout-btn {
    background: linear-gradient(45deg, #ff6b9d, #c44569);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 50px;
    font-size: 1em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    position: relative;
    overflow: hidden;
    margin-left: 10px; /* Add some space between buttons */
}

.logout-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.logout-btn:hover::before {
    left: 100%;
}

.logout-btn:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

.logout-btn:active {
    transform: translateY(0) scale(0.98);
}

    </style>
</head>
<body>
    <div class="header-container">
        <div class="header-inner">
            <div class="center-content">
                <h1><i class="fas fa-heart"></i> Top 10 Cute Anime Recommendations <i class="fas fa-heart"></i></h1>
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search anime by title or description...">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>
            <button class="signup-btn" onclick="window.location.href='signup.php'">Sign Up</button>
            <button class="logout-btn" onclick="logout()">Log Out</button>
            <script>
                 function logout() {
    if (confirm("Are you sure you want to log out?")) {
        window.location.href = 'logout.php'; // This actually logs the user out
    }
    }
                </script>
        </div>
    </div>

    <section class="anime-list" id="animeList">
        <?php foreach($anime_list as $index => $anime): ?>
            <div class="card" data-title="<?php echo strtolower($anime['title']); ?>" data-desc="<?php echo strtolower($anime['desc']); ?>">
                <button class="favorite-btn" onclick="toggleFavorite(this)"><i class="far fa-heart"></i></button>
                <img src="<?php echo $anime['img']; ?>" alt="<?php echo $anime['title']; ?>" onclick="openModal('<?php echo $anime['title']; ?>', '<?php echo $anime['desc']; ?>', '<?php echo $anime['genre']; ?>', '<?php echo $anime['img']; ?>')">
                <h2><?php echo $anime['title']; ?></h2>
                <p><?php echo $anime['desc']; ?></p>
                <div class="genre"><?php echo $anime['genre']; ?></div>
            </div>
        <?php endforeach; ?>
    </section>

    <button class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i></button>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <img id="modalImg" src="" alt="" style="width:100%; border-radius:15px; margin-bottom:15px;">
            <h2 id="modalTitle"></h2>
            <p id="modalDesc"></p>
            <div class="genre" id="modalGenre"></div>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Cute Anime Hub. Made with <i class="fas fa-heart" style="color: #ec407a;"></i> for anime lovers.</p>
    </footer>

    <script>
        const searchInput = document.getElementById('searchInput');
        const animeList = document.getElementById('animeList');
        const backToTop = document.getElementById('backToTop');
        const modal = document.getElementById('modal');
        const modalImg = document.getElementById('modalImg');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');
        const modalGenre = document.getElementById('modalGenre');

        // Enhanced search functionality
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const cards = animeList.getElementsByClassName('card');
            Array.from(cards).forEach(card => {
                const title = card.dataset.title;
                const desc = card.dataset.desc;
                card.style.display = (title.includes(filter) || desc.includes(filter)) ? '' : 'none';
            });
        });

        // Back to top button
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTop.style.display = 'block';
            } else {
                backToTop.style.display = 'none';
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });


        // Modal functions
        function openModal(title, desc, genre, img) {
            modalImg.src = img;
            modalTitle.textContent = title;
            modalDesc.textContent = desc;
            modalGenre.textContent = genre;
            modal.style.display = 'block';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        // Close modal on outside click
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }

        // Favorite button toggle
        function toggleFavorite(btn) {
            const icon = btn.querySelector('i');
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                btn.style.color = '#ec407a';
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                btn.style.color = '';
            }
        }

        // Add loading animation