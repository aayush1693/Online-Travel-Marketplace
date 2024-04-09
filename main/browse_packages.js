let b_name = '';
window.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('package').addEventListener('change', function () {
        var selectedOptionText = this.options[this.selectedIndex].text;
        document.querySelector('input[name="package_id"]').value = selectedOptionText;
    });

    // Fetch the packages from the server
    fetch('/api/packages')
        .then(response => response.json())
        .then(packages => {
            const packagesDiv = document.getElementById('packages');

            // Function to display packages
            function displayPackages(packages) {
                // Clear the packages div
                packagesDiv.innerHTML = '';

                // Display the packages
                packages.forEach(package => {
                    const packageCard = document.createElement('div');
                    packageCard.className = 'package-card';
                    packageCard.innerHTML = `
                        <h2>${package.name}</h2>
                        <img src="/uploads/${package.image}" alt="${package.name}" >
                        <p>${package.description}</p>
                        <p>Price: ${package.price}</p>
                        <p>Provider: ${package.business_name}</p>
                        <form class="booking-form">
                            <input type="hidden" name="package" value="${package.name}">
                            <input type="hidden" name="business" value="${package.business_name}">
                            <button type="submit">Book this package</button>
                        </form>
                    `;
                    packagesDiv.appendChild(packageCard);
                });
            }

            // Initially display all packages
            displayPackages(packages.data);

            // Add event listener to search form
            document.getElementById('search-form').addEventListener('submit', function (event) {
                // Prevent form submission
                event.preventDefault();

                // Get search term
                const searchTerm = document.getElementById('search').value.toLowerCase();

                // Filter packages
                const filteredPackages = packages.data.filter(package =>
                    package.name.toLowerCase().includes(searchTerm) ||
                    package.description.toLowerCase().includes(searchTerm) ||
                    package.business_name.toLowerCase().includes(searchTerm)
                );

                // Display filtered packages
                displayPackages(filteredPackages);
            });

           // Add an event listener to each booking form
document.querySelectorAll('.booking-form').forEach(form => {
    form.addEventListener('submit', (event) => {
        event.preventDefault();

        // Get the form data
        const formData = new FormData(form);
        alert('Booking made successfully! Please check your email.');
        // Send the booking to the server using Fetch API
        fetch('/api/bookings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert('Booking made successfully! Please check your email.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

            // Add the packages to the select element in the review form
            const packageSelect = document.getElementById('package');
            packages.data.forEach(package => {
                const option = document.createElement('option');
                option.value = package.id;
                option.textContent = package.name;
                packageSelect.appendChild(option);
            });
        });

    // Add an event listener to the review form
    const reviewForm = document.getElementById('reviewForm');
    reviewForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const formData = new FormData(reviewForm);
        const data = Object.fromEntries(formData);

        // Send the review to the server using XmlHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/reviews', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                console.log(data);
                if (data.success) {
                    alert('Review made successfully! Thank you for sharing your review. Your review helps us improve.');
                }
            } else {
                console.error('Error:', xhr.statusText);
            }
        };
        xhr.onerror = function () {
            console.error('Request failed');
        };
        xhr.send(JSON.stringify(data));
    });
});
