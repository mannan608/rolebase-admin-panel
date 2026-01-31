@php
    use Illuminate\Support\Facades\Storage;
    $user = auth()->user();
    $avatarPath = null;
    if ($user) {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
            $candidate = 'avatars/' . $user->id . '.' . $ext;
            if (Storage::disk('public')->exists($candidate)) {
                $avatarPath = asset('storage/avatars/' . $user->id . '.' . $ext);
                break;
            }
        }
    }
    $avatarUrl = $avatarPath ?? asset('images/user/owner.png');
@endphp

<div class="relative" x-data="{
    dropdownOpen: false,
    toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
    },
    closeDropdown() {
        this.dropdownOpen = false;
    }
}" @click.away="closeDropdown()">
    <!-- User Button -->
    <button class="flex items-center text-gray-700 dark:text-gray-400" @click.prevent="toggleDropdown()" type="button">
        <span class="mr-3 overflow-hidden rounded-full h-11 w-11">
            <img src="{{ $avatarUrl }}" alt="User" />
        </span>

    </button>

    <!-- Dropdown Start -->
    <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-[17px] flex w-[260px] flex-col rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark z-50"
        style="display: none;">
        <!-- User Info -->
        <div>
            <span
                class="block font-medium text-gray-700 text-theme-sm dark:text-gray-400">{{ auth()->user()->name ?? 'Guest' }}</span>
            <span
                class="mt-0.5 block text-theme-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email ?? '' }}</span>
        </div>

        <!-- Menu Items -->
        <ul class="flex flex-col gap-1 pt-4 pb-3 border-b border-gray-200 dark:border-gray-800">
            <li>
                <a href="/profile"
                    class="flex items-center gap-3 px-3 py-2 font-medium text-gray-700 rounded-lg group text-theme-sm hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                    <span class="text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 14.1526 4.3002 16.1184 5.61936 17.616C6.17279 15.3096 8.24852 13.5955 10.7246 13.5955H13.2746C15.7509 13.5955 17.8268 15.31 18.38 17.6167C19.6996 16.119 20.5 14.153 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM17.0246 18.8566V18.8455C17.0246 16.7744 15.3457 15.0955 13.2746 15.0955H10.7246C8.65354 15.0955 6.97461 16.7744 6.97461 18.8455V18.856C8.38223 19.8895 10.1198 20.5 12 20.5C13.8798 20.5 15.6171 19.8898 17.0246 18.8566ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9991 7.25C10.8847 7.25 9.98126 8.15342 9.98126 9.26784C9.98126 10.3823 10.8847 11.2857 11.9991 11.2857C13.1135 11.2857 14.0169 10.3823 14.0169 9.26784C14.0169 8.15342 13.1135 7.25 11.9991 7.25ZM8.48126 9.26784C8.48126 7.32499 10.0563 5.75 11.9991 5.75C13.9419 5.75 15.5169 7.32499 15.5169 9.26784C15.5169 11.2107 13.9419 12.7857 11.9991 12.7857C10.0563 12.7857 8.48126 11.2107 8.48126 9.26784Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                    Profile
                </a>
            </li>
        </ul>

        <!-- Sign Out -->
        <form action="/logout" method="POST" class="inline">
            @csrf
            <button
                class="shadow-theme-xs flex w-full items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.25 2.75C7.25 2.33579 7.58579 2 8 2H12.75C14.5449 2 16 3.45507 16 5.25V12.75C16 14.5449 14.5449 16 12.75 16H8C7.58579 16 7.25 15.6642 7.25 15.25C7.25 14.8358 7.58579 14.5 8 14.5H12.75C13.7165 14.5 14.5 13.7165 14.5 12.75V5.25C14.5 4.2835 13.7165 3.5 12.75 3.5H8C7.58579 3.5 7.25 3.16421 7.25 2.75Z"
                        fill="" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M2.96967 9.53033C2.67678 9.23744 2.67678 8.76256 2.96967 8.46967L5.46967 5.96967C5.76256 5.67678 6.23744 5.67678 6.53033 5.96967C6.82322 6.26256 6.82322 6.73744 6.53033 7.03033L5.56066 8H10C10.4142 8 10.75 8.33579 10.75 8.75C10.75 9.16421 10.4142 9.5 10 9.5H5.56066L6.53033 10.4697C6.82322 10.7626 6.82322 11.2374 6.53033 11.5303C6.23744 11.8232 5.76256 11.8232 5.46967 11.5303L2.96967 9.03033Z"
                        fill="" />
                </svg>
                Sign Out
            </button>
        </form>
    </div>
    <!-- Dropdown End -->
</div>
