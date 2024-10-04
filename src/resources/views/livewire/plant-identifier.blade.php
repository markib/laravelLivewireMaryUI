<div class="max-w-2xl mx-auto p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-3xl font-bold mb-6 text-green-700">Plant Identifier</h2>

    <form wire:submit.prevent="save" class="mb-8">
        <div class="mb-4">
            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Upload a plant photo</label>
            <input type="file" id="photo" wire:model="photo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-green-50 file:text-green-700
                hover:file:bg-green-100
            ">
            @error('photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <button class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
            Identify Plant
        </button>
    </form>

    @if($loading)
    <div class="mt-4 text-center">
        <svg class="animate-spin h-10 w-10 text-green-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="mt-2 text-green-600 font-semibold">Identifying plant...</p>
    </div>
    @endif
    @if($error)
    <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ $error }}</span>
    </div>
    @endif
    @if($result)
    <div class="mt-8 bg-green-50 p-6 rounded-lg">
        @if ($photo)
        Photo Preview:
        <img src="{{ $photo->temporaryUrl() }}">
        @endif
        <h3 class="text-2xl font-semibold mb-4 text-green-800">Identification Result:</h3>
        <p class="text-gray-700 whitespace-pre-line">{{ $result }}</p>
    </div>
    @endif
</div>