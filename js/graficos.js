


fetch(`../php5/obtener_estadisticas.php?id=${idArtista}`)
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('graficoLineal').getContext('2d');
        const config = {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                datasets: [{
                    label: 'Visitas',
                    data: data.visitas,
                    fill: true,
                    borderColor: '#F694C7',
                    backgroundColor: 'rgba(250, 189, 221, 0.2)',
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        new Chart(ctx, config);
    });
