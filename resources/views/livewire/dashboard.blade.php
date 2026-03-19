@php use Illuminate\Support\Str; @endphp
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                Dashboard
            </h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                Quick overview of your approval workflow activity.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a
                href="{{ route('requests.index') }}"
                wire:navigate
                class="inline-flex items-center justify-center rounded-2xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800"
            >
                View requests
            </a>

            <a
                href="{{ route('requests.create') }}"
                wire:navigate
                class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500"
            >
                New request
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total requests</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ $totalRequests }}
            </p>
        </div>

        <div
            class="rounded-3xl border border-amber-200 bg-amber-50 p-5 shadow-sm dark:border-amber-900/40 dark:bg-amber-950/30">
            <p class="text-sm font-medium text-amber-700 dark:text-amber-300">Pending</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-amber-800 dark:text-amber-200">
                {{ $pendingRequests }}
            </p>
        </div>

        <div
            class="rounded-3xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm dark:border-emerald-900/40 dark:bg-emerald-950/30">
            <p class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Approved</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-emerald-800 dark:text-emerald-200">
                {{ $approvedRequests }}
            </p>
        </div>

        <div
            class="rounded-3xl border border-red-200 bg-red-50 p-5 shadow-sm dark:border-red-900/40 dark:bg-red-950/30">
            <p class="text-sm font-medium text-red-700 dark:text-red-300">Rejected</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-red-800 dark:text-red-200">
                {{ $rejectedRequests }}
            </p>
        </div>
    </div>

    <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="flex items-center justify-between border-b border-zinc-200 px-6 py-4 dark:border-zinc-800">
            <div>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Latest requests
                </h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    A quick snapshot of the most recent activity.
                </p>
            </div>

            <a
                href="{{ route('requests.index') }}"
                wire:navigate
                class="text-sm font-medium text-indigo-600 transition hover:text-indigo-500"
            >
                View all
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                <thead class="bg-zinc-50 dark:bg-zinc-950/50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Request
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Status
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Created by
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Date
                    </th>
                </tr>
                </thead>

                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($latestRequests as $request)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="max-w-xl">
                                <p class="font-medium text-zinc-900 dark:text-white">
                                    {{ $request->title }}
                                </p>

                                @if ($request->description)
                                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ Str::limit($request->description, 90) }}
                                    </p>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $badgeClasses = match ($request->status) {
                                    'approved' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300',
                                    'rejected' => 'bg-red-100 text-red-700 dark:bg-red-950/50 dark:text-red-300',
                                    default => 'bg-amber-100 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300',
                                };
                            @endphp

                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                                    {{ str($request->status)->headline() }}
                                </span>
                        </td>

                        <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-300">
                            {{ $request->creator?->name ?? 'System' }}
                        </td>

                        <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $request->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                            No requests yet. Create your first one to get started.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
