<div class="relative overflow-x-auto">
    <div class="flex justify-between items-center">
        <div class="w-4/5">
            <p class="text-white">hasil :{{ $getId }},{{ $getName }} , {{ $getEmail }}</p>
        </div>
        <div class="mb-3 w-1/2">
            {{-- start search for search user --}}
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <x-text-input wire:model.live.debounce.500ms='search' id="search" name="search" type="text"
                    class="mt-1  pl-10 block w-full" autofocus autocomplete="search" placeholder="Search Name..." />
            </div>
            {{-- end search for search user --}}
        </div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody wire:poll>
            @foreach ($users as $user)
                @if ($user->id != auth()->user()->id)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        @if ($getId != $user->id)
                            <td class="px-6 py-4 flex">
                                <div class="flex-shrink-0 mr-3">
                                    <img class="w-10 h-10 rounded-full"
                                        src="https://static.vecteezy.com/system/resources/previews/002/275/847/non_2x/male-avatar-profile-icon-of-smiling-caucasian-man-vector.jpg">
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->email }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($user->isOnline())
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-emerald-600 mr-2"></div>
                                        <p>Online</p>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-rose-600 mr-2"></div>
                                        <p>Offline</p>
                                    </div>
                                @endif

                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <a wire:click='createConversation({{ $user }})'
                                        class=" hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white mr-4">New
                                        Message</a>
                                    <a wire:click='edit({{ $user }})'
                                        class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white mr-2">
                                        Edit User</a>
                                    <a wire:click='delete({{ $user }})'
                                        class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                        Delete User</a>
                                </div>

                            </td>
                        @else
                            <th class="px-6 py-4">
                                <x-text-input wire:model='getName' id="name" name="name" type="text"
                                    class="mt-1 block w-full" required autofocus autocomplete="name" />
                                <div>
                                    @error('name')
                                        <span class="error">{{ $user->name }}</span>
                                    @enderror
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                <x-text-input wire:model='getEmail' id="email" name="email" type="email"
                                    class="mt-1 block w-full" required autocomplete="email" />
                                <div>
                                    @error('email')
                                        <span class="error">{{ $user->email }}</span>
                                    @enderror
                                </div>
                            </td>
                            <td>
                                <x-primary-button wire:click='updateUser({{ $user->id }})'
                                    class="me-3">{{ __('Update') }}</x-primary-button>
                                <x-secondary-button wire:click='cancelUpdate'>{{ __('Cancel') }}</x-secondary-button>
                            </td>
                        @endif

                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <script>
        const options = {
            placement: 'bottom',
            triggerType: 'click',
            delay: 8000,
        };
    </script>
</div>
