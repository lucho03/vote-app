import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

document.addEventListener("DOMContentLoaded", function() {
    const partyData = window.partyCounts;

    const labels = partyData.map(r => r.party);
    const counts = partyData.map(r => r.votes);

    // Chart setup
    const ctx = document.getElementById('partyChart').getContext('2d');
    const partyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Votes',
                data: counts,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            }
        }
    });

    // Export CSV
    document.getElementById('exportCsv').addEventListener('click', () => {
        const rows = [['Party', 'Votes'], ...partyData.map(r => [r.party, r.votes])];
        const csv = rows.map(r => r.map(cell => `"${String(cell).replace(/"/g,'""')}"`).join(',')).join('\n');

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'party-summary.csv';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    });

    async function refreshData() {
        const res = await fetch("/summary/data");
        const data = await res.json();
        // update chart
        partyChart.data.labels = data.map(r => r.party);
        partyChart.data.datasets[0].data = data.map(r => r.votes);
        partyChart.update();
        // update table
        const tbody = document.getElementById('summary-table-body');
        tbody.innerHTML = data.map(r => `<tr class="border-t"><td class="py-2">${r.party}</td><td class="py-2 text-right font-semibold">${r.votes}</td></tr>`).join('');

        return data;
    }
    setInterval(refreshData, 15000);
});