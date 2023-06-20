<script>
    document.addEventListener("DOMContentLoaded", function() {
        const heartIcon = document.getElementById('heartIcon');
        let isFavorited = <?php echo $favorited ? 'true' : 'false'; ?>;

        // Function to update the heart icon image source based on the favorite status
        function updateHeartIcon() {
            heartIcon.src = isFavorited ? "../images/heart.png" : "../images/nheart.png";
        }

        // Function to handle adding or removing favorites
        function toggleFavorite() {
            if (isFavorited) {
                // If already favorited, remove from favorites
                let xhr = new XMLHttpRequest();
                xhr.open("GET", "fav.php?id_client=<?php echo $id_client; ?>&id_plant=<?php echo $id_plant; ?>&action=remove", true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        isFavorited = false;
                        updateHeartIcon(); // Update the heart icon after removing from favorites
                    }
                };
                xhr.send();
            } else {
                // If not favorited, add to favorites
                let xhr = new XMLHttpRequest();
                xhr.open("GET", "fav.php?id_client=<?php echo $id_client; ?>&id_plant=<?php echo $id_plant; ?>&action=add", true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        isFavorited = true;
                        updateHeartIcon(); // Update the heart icon after adding to favorites
                    }
                };
                xhr.send();
            }
        }

        // Add click event listener to toggle favorite
        heartIcon.addEventListener('click', toggleFavorite);

        // Initially update the heart icon based on the favorite status
        updateHeartIcon();
    });
</script>
