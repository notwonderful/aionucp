<x-app-layout>
    <div class="space-y-6">
        <div class="grid xl:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-5">
            @forelse($products as $product)
                <div class="card">
                    <div class="card-body rounded-md bg-white dark:bg-slate-800 shadow-base active">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }} {{ __('Image') }}" class="block w-full h-full object-cover rounded-t-md">
                        <div class="items-center p-6 menu-open">
                            <h3 class="card-title text-slate-900 dark:text-white mb-1">{{ $product->name }}</h3>
                            <h6 class="card-subtitle mb-4">{{ $product->category->name }}</h6>
                            <p class="card-text">{{ $product->description }}</p>
                            <div class="card-text h-full menu-open">
                                <div class="mt-4 space-x-4 rtl:space-x-reverse flex items-center justify-between">
                                    <form action="{{ route('shop.buy', $product) }}" method="POST">
                                        @csrf
                                        <label for="player_id">{{ __('Select your character') }}</label>
                                        <select class="form-control mb" id="player_id" name="player_id" required>
                                            <option>{{ __('Select an option') }}</option>
                                            @foreach($players as $player)
                                                <option value="{{ $player->id }}">{{ $player->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('player_id')
                                            {{ $message }}
                                        @enderror
                                        <button
                                            type="submit"
                                           class="btn inline-flex justify-center mx-2 mt-2 btn-danger active">
                                            {{ __('Buy') }}
                                        </button>
                                    </form>
                                    <div class="flex">
                                        {{ $product->toll }} Toll {{ __('for') }} {{ $product->item_qty }} {{ __('pcs') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{ __('Nothing to show') }}
            @endforelse
        </div>
    </div>
</x-app-layout>
