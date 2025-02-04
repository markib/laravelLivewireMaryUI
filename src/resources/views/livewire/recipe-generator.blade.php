<div class="max-w-2xl mx-auto p-6">
    <form wire:submit.prevent="generateRecipes" class="space-y-4">
        <label for="query" class="block text-sm font-medium text-gray-700">What would you like to cook?</label>
        <input
            type="text"
            id="query"
            wire:model.defer="query"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="Enter ingredients or dish name"
            @disabled($isLoading)>
        @error('query')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        <button class="mt-4  bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit"

            wire:loading.attr="disabled"
            wire:loading.class="opacity-50">
            <span wire:loading.remove wire:target="generateRecipes">
                Generate Recipe
            </span>
        </button>


        <div wire:loading wire:target="generateRecipes">
            Generating recipe...


        </div>
        <div wire:stream="recipes" class="whitespace-pre-wrap font-mono text-sm bg-gray-50 p-4 rounded-lg"></div>
        @if($recipes)
        <div class="whitespace-pre-wrap font-mono text-sm bg-gray-50 p-4 rounded-lg">{{ $recipes }}</div>
        @endif
    </form>
</div>