<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Audit Logs</h2>
    </x-slot>

    <div class="mb-4">
        <form method="GET" class="flex gap-2">
            <input type="text" name="action" value="{{ request('action') }}" placeholder="Action" class="border rounded p-2">
            <input type="text" name="user_id" value="{{ request('user_id') }}" placeholder="User ID" class="border rounded p-2">
            <input type="text" name="model_type" value="{{ request('model_type') }}" placeholder="Model Type" class="border rounded p-2">
            <button class="px-3 py-2 bg-blue-600 text-white rounded">Filter</button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left">
                    <th class="p-2">Time</th>
                    <th class="p-2">User</th>
                    <th class="p-2">Action</th>
                    <th class="p-2">Route</th>
                    <th class="p-2">Method</th>
                    <th class="p-2">IP</th>
                    <th class="p-2">Model</th>
                    <th class="p-2">Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="p-2">{{ $log->created_at }}</td>
                        <td class="p-2">{{ $log->user?->email ?? '-' }}</td>
                        <td class="p-2">{{ $log->action }}</td>
                        <td class="p-2">{{ $log->route }}</td>
                        <td class="p-2">{{ $log->method }}</td>
                        <td class="p-2">{{ $log->ip }}</td>
                        <td class="p-2">{{ $log->model_type }}#{{ $log->model_id }}</td>
                        <td class="p-2"><pre class="whitespace-pre-wrap">{{ json_encode($log->data, JSON_PRETTY_PRINT) }}</pre></td>
                    </tr>
                @empty
                    <tr><td class="p-2" colspan="8">Tidak ada log.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $logs->links() }}</div>
    </div>
</x-app-layout>
