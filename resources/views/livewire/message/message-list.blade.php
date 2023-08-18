<div class="flex justify-center p-6 h-[500px]">
    <div class="{{ $onAfterClickUser }} w-full lg:w-1/3">
        <div class="mb-3">
            <p class="text-white">conversation id : {{ $getConversationId }} , user id : {{ $getUserId }}</p>
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
        <div class="overflow-y-auto h-[400px]">
            <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 px-2">
                @foreach ($partisipants as $partisipant)
                    <li wire:click='selectConversation({{ $partisipant }})' class="py-3 flex dark:hover:bg-gray-700">
                        <a class="flex">
                            <div class="flex-shrink-0">
                                <img class="w-10 h-10 rounded-full"
                                    src="https://static.vecteezy.com/system/resources/previews/002/275/847/non_2x/male-avatar-profile-icon-of-smiling-caucasian-man-vector.jpg">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $partisipant->user->name }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $partisipant->user->email }}
                                </p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div wire:poll class="{{ $onClickChat }} w-full ms-2 lg:flex lg:flex-col">
        {{-- start user click --}}
        @if ($getUserId != null)
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 mr-2">
                        <img class="w-12 h-12 rounded-full"
                            src="https://static.vecteezy.com/system/resources/previews/002/275/847/non_2x/male-avatar-profile-icon-of-smiling-caucasian-man-vector.jpg">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p id="user_name" class="text-lg font-medium text-gray-900 truncate dark:text-white">
                            {{ $getUserName }}
                        </p>
                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                            {{ $getUserEmail }}
                        </p>
                    </div>
                </div>
                {{-- @if ($screenWidth <= 768) --}}
                    <div class="flex items-center">
                        <button wire:click='onBackClick'>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-8 h-8 text-gray-800 dark:text-gray-200 hover:text-indigo-500">
                                <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M9.00002 15.3802H13.92C15.62 15.3802 17 14.0002 17 12.3002C17 10.6002 15.62 9.22021 13.92 9.22021H7.15002"
                                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8.57 10.7701L7 9.19012L8.57 7.62012" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                {{-- @endif --}}
            </div>
        @endif
        {{-- end user click --}}
        {{-- start message list --}}
        @if ($getUserId == null)
            {{-- start no message --}}
            <div class="flex flex-col justify-center items-center w-full h-[390px]">
                <h5 class="mb-4 text-4xl font-bold tracking-tight leading-none text-gray-900 dark:text-white">
                    No Message Selected</h5>
                <p class="mb-8 text-base font-normal text-gray-500 dark:text-gray-400">
                    Start Chatting With Your Friends Now...</p>
            </div>
            {{-- end no message --}}
        @else
            <div class="overflow-y-auto h-[370px]">
                @forelse ($messages as $message)
                    {{-- start message auth()->user() --}}
                    @if ($message->user_id == auth()->user()->id)
                        {{-- start message auth()->user() --}}
                        <div class="flex items-end justify-end">
                            <div
                                class="flex flex-col my-2 max-w-sm p-2 bg-white border border-gray-200 rounded-tl-lg rounded-tr-lg rounded-bl-lg shadow hover:bg-gray-100 dark:bg-blue-600 dark:border-blue-700 dark:hover:bg-gray-100">
                                <h3
                                    class="mb-1 text-base font-semibold tracking-tight text-gray-900 dark:text-gray-900">
                                    {{ $message->message }}</h3>
                                <p class="flex justify-end text-xs  truncate dark:text-gray-700 text-gray-500">
                                    {{ $message->is_read == 0 ? 'Not Read' : 'Read' }}
                                    <span
                                        class="ms-1">{{ $message->updated_at->format('H:i') . ' ' . ($message->updated_at->format('H') >= 12 ? 'PM' : 'AM') }}</span>
                                </p>
                            </div>
                        </div>
                        {{-- end message auth()->user() --}}
                    @else
                        {{-- start message user 2 --}}
                        <div wire:click='markAsRead({{ $message->id }})' class="flex items-end">
                            <div
                                class="flex flex-col my-2 max-w-sm p-2 bg-white border border-gray-200 rounded-tl-lg rounded-tr-lg rounded-br-lg shadow hover:bg-gray-100 dark:bg-gray-50 dark:border-gray-600 dark:hover:bg-blue-600">
                                <h3
                                    class="mb-1 text-base font-semibold tracking-tight text-gray-900 dark:text-gray-900">
                                    {{ $message->message }}</h3>
                                <p class="flex justify-end text-xs  truncate dark:text-gray-700 text-gray-500">
                                    {{ $message->is_read == 0 ? 'Not Read' : 'Read' }}
                                    <span
                                        class="ms-1">{{ $message->updated_at->format('H:i') . ' ' . ($message->updated_at->format('H') >= 12 ? 'PM' : 'AM') }}</span>
                                </p>
                            </div>
                        </div>
                        {{-- end message user 2 --}}
                    @endif
                    {{-- end message --}}
                @empty
                    {{-- start no message --}}
                    <div class="flex flex-col justify-center items-center w-full h-[390px]">
                        <h5 class="mb-4 text-4xl font-bold tracking-tight leading-none text-gray-900 dark:text-white">
                            Send First Message</h5>
                        <p class="mb-8 text-base font-normal text-gray-500 dark:text-gray-400">
                            Start Chatting With Your Friends Now...</p>
                    </div>
                    {{-- end no message --}}
                @endforelse
            </div>
        @endif
        {{-- end message list --}}
        {{-- start form to send the message --}}
        <div>
            <div class="flex items-center px-3 py-2 rounded-lg bg-sgray-50 dark:bg-gray-700">
                <textarea wire:model='getMessage' id="message" name="message" rows="1"
                    class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Your message..."></textarea>
                <button wire:click='sendMessage' type="submit"
                    class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                    <svg class="w-5 h-5 rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 18 20">
                        <path
                            d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z" />
                    </svg>
                    <span class="sr-only">Send message</span>
                </button>
            </div>
        </div>
        {{-- end form to send the message --}}
    </div>
    {{-- untuk ngetest message --}}
    {{-- <p class="text-white">cek content = {{ $getContent }}</p> --}}
    {{-- <p class="text-white"> width :{{ $screenWidth }}</p> --}}
</div>
