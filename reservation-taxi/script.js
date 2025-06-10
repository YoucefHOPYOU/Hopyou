document.addEventListener('DOMContentLoaded', () => {
    const mapDiv = document.getElementById('map');
    let map;

    function initMap() {
        if (!mapDiv) return;

        // Services Google Maps
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer();

        // Champs d'adresses
        const originInput = document.getElementById('origin');
        const destinationInput = document.getElementById('destination');

        // Autocomplete Google Places
        const autocompleteOrigin = new google.maps.places.Autocomplete(originInput);
        const autocompleteDestination = new google.maps.places.Autocomplete(destinationInput);

        // Configuration de la carte
        const mapOptions = {
            center: { lat: 48.8566, lng: 2.3522 },
            zoom: 13,
        };

        // Initialisation de la carte
        map = new google.maps.Map(mapDiv, mapOptions);
        directionsRenderer.setMap(map);

        // Tarification par type de véhicule
        const pricing = {
            berline: { ratePerKm: 2.5, minPrice: 60 },
            eco: { ratePerKm: 1.9, minPrice: 44 },
            van: { ratePerKm: 2.8, minPrice: 70 },
        };

        // Fonction de calcul du prix
        function calculatePrice(distanceKm, vehicleType) {
            const selected = pricing[vehicleType];
            const totalPrice = Math.max(selected.minPrice, distanceKm * selected.ratePerKm);
            return totalPrice.toFixed(2);
        }

        // Met à jour l'affichage + champ caché
        function updatePriceDisplay() {
            const distanceText = document.getElementById('distance')?.textContent || '0';
            const vehicleType = document.getElementById('vehicleType').value;
            const displayEl = document.getElementById('displayTotalPrice');
            const hiddenInput = document.getElementById('totalPrice');

            if (distanceText && !isNaN(parseFloat(distanceText))) {
                const price = calculatePrice(parseFloat(distanceText), vehicleType);
                if (displayEl) displayEl.textContent = `${price} €`;     // Affichage visible
                if (hiddenInput) hiddenInput.value = price;       // Champ caché
            } else {
                if (displayEl) displayEl.textContent = '0.00 €';
                if (hiddenInput) hiddenInput.value = '0.00';
            }
        }

        // Calcul du trajet au clic
        document.getElementById('calculateRoute')?.addEventListener('click', () => {
            const origin = originInput.value;
            const destination = destinationInput.value;

            if (!origin || !destination) {
                alert('Veuillez saisir une adresse de départ et d’arrivée.');
                return;
            }

            directionsService.route(
                {
                    origin: origin,
                    destination: destination,
                    travelMode: 'DRIVING',
                },
                (result, status) => {
                    if (status === 'OK') {
                        directionsRenderer.setDirections(result);

                        const route = result.routes[0];
                        const leg = route.legs[0];

                        const distanceKm = (leg.distance.value / 1000).toFixed(2);
                        const durationText = leg.duration.text;

                        document.getElementById('distance').textContent = distanceKm;
                        document.getElementById('duration').textContent = durationText;

                        updatePriceDisplay(); // Mets à jour le prix affiché
                        document.getElementById('routeDetails').classList.remove('hidden');
                    } else {
                        alert(`Impossible de calculer le trajet : ${status}`);
                    }
                }
            );
        });

        // Recalcule le prix si on change de catégorie de véhicule
        document.getElementById('vehicleType')?.addEventListener('change', updatePriceDisplay);

        // Bloque la soumission si le prix n’est pas calculé
        document.getElementById('reservationForm')?.addEventListener('submit', (e) => {
            const price = document.getElementById('displayTotalPrice')?.textContent || '';
            if (!price || parseFloat(price) <= 0) {
                e.preventDefault();
                alert("Veuillez calculer un trajet avant de confirmer.");
            }
        });
    }

    window.initMap = initMap;
});