
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.querySelector(".main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.querySelector(".main").style.marginLeft = "0";
        }

        function toggleProfile() {
            var profileDetails = document.getElementById("profileDetails");
            if (profileDetails.style.display === "none" || profileDetails.style.display === "") {
                profileDetails.style.display = "block";
            } else {
                profileDetails.style.display = "none";
            }
        }

        // JavaScript for search functionality
        document.getElementById('search').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const books = document.querySelectorAll('.book-card');

            books.forEach(book => {
                const title = book.querySelector('h3').textContent.toLowerCase();
                const author = book.querySelector('p').textContent.toLowerCase();
                if (title.includes(searchValue) || author.includes(searchValue)) {
                    book.style.display = 'block';
                } else {
                    book.style.display = 'none';
                }
            });
        });
   