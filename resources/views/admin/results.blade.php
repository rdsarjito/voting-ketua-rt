<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Hasil Voting</h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
        <canvas id="resultsChart" height="120"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const results = @json($results->map(fn($r) => [
            'label' => $r->candidate->name.' ('.$r->candidate->category->name.')',
            'total' => (int) $r->total,
        ]));
        const ctx = document.getElementById('resultsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: results.map(r => r.label),
                datasets: [{
                    label: 'Total Suara',
                    data: results.map(r => r.total),
                    backgroundColor: 'rgba(59, 130, 246, 0.6)'
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</x-app-layout>


