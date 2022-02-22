<section class="mt-28 mb-10">
    <div class="container px-8 mx-auto grid lg:grid-cols-12 gap-10">
        <main class="w-full space-y-6 lg:col-span-8">
            <div class="aspect-[16/9] overflow-hidden rounded-tl-2xl rounded-br-2xl relative z-10">
                <img src="{{ asset('storage/' . $room->image) }}" class="w-full block hover:scale-110 transition-all duration-300" alt="{{ $room->name }}">
            </div>
            <div class="bg-gray-200 text-sm text-gray-600 flex gap-x-4 gap-y-2 justify-center rounded-tr-lg rounded-bl-lg py-2 px-4">
                <div class="flex items-center gap-1 text-gray-800">
                    <i class='bx bx-show'></i>
                    <span class="text-sm capitalize">{{ $room->views }}</span>
                </div>
                <div class="flex items-center gap-1 text-gray-800">
                    <i class='bx bx-star'></i>
                    <span class="text-sm capitalize">{{ $room->rate }}</span>
                </div>
                <div class="flex items-center gap-1 text-gray-800">
                    <i class='bx bx-chat'></i>
                    <span class="text-sm capitalize">{{ $room->reviews->count() }}</span>
                </div>
                <div class="flex items-center gap-1 text-gray-800">
                    <i class='bx bx-money'></i>
                    <span class="text-sm capitalize">${{ $room->price }}/night</span>
                </div>
            </div>
            <div class="prose sm:prose-base prose max-w-none prose-img:rounded-tr-xl prose-img:rounded-bl-xl prose-img:w-full">
                <h1>{{ $room->name }}</h1>
                <blockquote>
                    {{ $room->description }}
                </blockquote>
                {!! $room->explanation !!}
                <h2>Facilities Obtained</h2>
                <ul>
                    @foreach ($room->facilities as $roomFacility)
                        <li><a href="#{{ $roomFacility->facility->name }}">{{ $roomFacility->facility->name }}</a></li>
                    @endforeach
                </ul>
                @forelse ($room->facilities as $roomFacility)
                    <h3 id="{{ $roomFacility->facility->name }}" class="scroll-mt-20">{{ $roomFacility->facility->name }}</h3>
                    <div class="aspect-[16/9] overflow-hidden rounded-tl-2xl rounded-br-2xl relative z-10 not-prose">
                        <img src="{{ asset('storage/' . $roomFacility->facility->image) }}" class="w-full block hover:scale-110 transition-all duration-300" alt="{{ $roomFacility->facility->name }}">
                    </div>
                    <blockquote>
                        {{ $roomFacility->facility->description }}
                    </blockquote>
                    {!! $roomFacility->facility->explanation !!}
                @empty
                    <p>You don't get special facilities when you book this room.</p>
                @endforelse
            </div>
        </main>
        <aside class="relative lg:col-span-4 space-y-4">
            <div class="space-y-2">
                <h2 class="text-2xl text-gray-800 font-bold">Booking</h2>
                <p class="tracking-wide text-gray-600 sm:text-base text-sm">
                    {{ __("Interested in this room? Hurry up and book before it's too late! ") }}<span class="font-bold">{{ (int) $room->total_rooms -  (int) $room->reservations->count()}}{{ __(' rooms available.') }}</span>
                </p>
            </div>
            <hr>
            @auth
                @if (!auth()->user()->hasRole('user'))
                    <div x-data="{ open: false }">
                        <div class="grid gap-4">
                            <div class="grid lg:grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label for="check_in" class="label">{{ __('Check In') }}</label>
                                    <input class="w-full input" type="date" name="check_in" id="check_in"/>
                                </div>
                                <div class="form-control">
                                    <label for="check_out" class="label">{{ __('Check Out') }}</label>
                                    <input class="w-full input" type="date" name="check_out" id="check_out"/>
                                </div>
                            </div>
                            <div class="form-control">
                                <label for="total_rooms" class="label">{{ __('Total Rooms') }}</label>
                                <input class="w-full input" type="number" name="" id="total_rooms"/>
                            </div>
                            <p class="tracking-wide text-gray-600 sm:text-base text-sm">{{ __('The total amount to be paid is ') }}<span class="font-bold">$400</span>. <span class="font-bold">{{ __('Paid directly at the hotel, not online.') }}</span></p>
                            <button x-on:click="open = true" class="btn">{{ __('Booking') }}</button>
                        </div>
                        <div x-show="open" style="display: none" x-on:keydown.escape.prevent.stop="open = false" role="dialog" aria-modal="true" x-id="['modal-title']" :aria-labelledby="$id('modal-title')" class="fixed inset-0 overflow-y-auto z-50">
                            <div x-show="open" x-transition.duration.300ms.opacity class="fixed inset-0 bg-black/50"></div>
                            <div x-show="open" x-transition.duration.300ms x-on:click="open = false" class="relative min-h-screen flex items-center justify-center p-4">
                                <div x-on:click.stop x-trap.noscroll.inert="open" class="relative max-w-md w-full bg-white rounded-xl p-10 overflow-y-auto space-y-4 text-center">
                                    <i class='bx bx-info-circle text-8xl text-blue-600'></i>
                                    <h2 class="text-3xl font-bold text-gray-800" :id="$id('modal-title')">You Can't Do It</h2>
                                    <p class="tracking-wide text-gray-600 sm:text-base text-sm">
                                        Your role is not a user so you can't place an order!
                                    </p>
                                    <div class="flex space-x-2 justify-center">
                                        <button type="button" x-on:click="open = false" class="btn">
                                            Oh.. Okay
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="grid gap-4">
                        <div class="grid lg:grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label for="check_in" class="label">{{ __('Check In') }}</label>
                                <input class="w-full input" type="date" name="check_in" id="check_in"/>
                            </div>
                            <div class="form-control">
                                <label for="check_out" class="label">{{ __('Check Out') }}</label>
                                <input class="w-full input" type="date" name="check_out" id="check_out"/>
                            </div>
                        </div>
                        <div class="form-control">
                            <label for="total_rooms" class="label">{{ __('Total Rooms') }}</label>
                            <input class="w-full input" type="number" name="" id="total_rooms"/>
                        </div>
                        <p class="tracking-wide text-gray-600 sm:text-base text-sm">{{ __('The total amount to be paid is ') }}<span class="font-bold">$400</span>. <span class="font-bold">{{ __('Paid directly at the hotel, not online.') }}</span></p>
                        <button x-on:click="open: true;" class="btn">{{ __('Booking') }}</button>
                    </div>
                @endif
            @else
                <div x-data="{ open: false }">
                    <div class="grid gap-4">
                        <div class="grid lg:grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label for="check_in" class="label">{{ __('Check In') }}</label>
                                <input class="w-full input" type="date" name="check_in" id="check_in"/>
                            </div>
                            <div class="form-control">
                                <label for="check_out" class="label">{{ __('Check Out') }}</label>
                                <input class="w-full input" type="date" name="check_out" id="check_out"/>
                            </div>
                        </div>
                        <div class="form-control">
                            <label for="total_rooms" class="label">{{ __('Total Rooms') }}</label>
                            <input class="w-full input" type="number" name="total_rooms" id="total_rooms"/>
                        </div>
                        <p class="tracking-wide text-gray-600 sm:text-base text-sm">{{ __('The total amount to be paid is ') }}<span class="font-bold">$400</span>. <span class="font-bold">{{ __('Paid directly at the hotel, not online.') }}</span></p>
                        <button x-on:click="open = true" class="btn">{{ __('Booking') }}</button>
                    </div>
                    <div x-show="open" style="display: none" x-on:keydown.escape.prevent.stop="open = false" role="dialog" aria-modal="true" x-id="['modal-title']" :aria-labelledby="$id('modal-title')" class="fixed inset-0 overflow-y-auto z-50">
                        <div x-show="open" x-transition.duration.300ms.opacity class="fixed inset-0 bg-black/50"></div>
                        <div x-show="open" x-transition.duration.300ms x-on:click="open = false" class="relative min-h-screen flex items-center justify-center p-4">
                            <div x-on:click.stop x-trap.noscroll.inert="open" class="relative max-w-md w-full bg-white rounded-xl p-10 overflow-y-auto space-y-4 text-center">
                                <i class='bx bx-info-circle text-8xl text-blue-600'></i>
                                <h2 class="text-3xl font-bold text-gray-800" :id="$id('modal-title')">Must Login First</h2>
                                <p class="tracking-wide text-gray-600 sm:text-base text-sm">
                                    You must login first before making a reservation!
                                </p>
                                <div class="flex space-x-2 justify-center">
                                    <a href="{{ route('login') }}" class="btn">
                                        Login
                                    </a>
                                    <button type="button" x-on:click="open = false" class="btn btn-outline">
                                        Later
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </aside>
        {{-- <div class="space-y-4 lg:col-span-8 border-t pt-10">
            <h2 class="text-2xl text-gray-800 font-bold">{{ __('Reviews') }}</h2>
            <div class="space-y-6">
                @forelse ($comments as $comment)
                    <div class="bg-gray-100 p-6 rounded-xl space-y-2">
                        <div>
                            @for ($i=1; $i <= $comment->star; $i++)
                                <i class="bx bx-star text-lg text-orange-500"></i>
                            @endfor
                        </div>
                        <p class="tracking-wide text-gray-800">
                            {{ __('"') }}{{ $comment->message }}{{ __('"') }}
                        </p>
                        <div class="flex items-center gap-2">
                            <img class="w-10 h-10 rounded-full" src="{{ asset('storage/' . $comment->user->avatar) }}" alt="">
                            <p class="font-bold text-gray-600 text-sm">
                                {{ $comment->user->name }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 tracking-wide sm:text-base text-sm">Be the first to review this room!</p>
                @endforelse
            </div>
            @if (count($comments->where('user_id', auth()->id())))
                <livewire:room.comment.edit :comment="$comments->firstWhere('user_id', auth()->id())" :room="$room" />
            @else
                <livewire:room.comment.create :room="$room" />
            @endif --}}
        </div>
    </div>
</section>