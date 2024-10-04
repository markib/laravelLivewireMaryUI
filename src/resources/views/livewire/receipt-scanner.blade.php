<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <form wire:submit.prevent="extract" class="mb-8">
        <div class="flex items-center justify-center w-full">
            <label for="receipt" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-500">PNG, JPG or GIF (MAX. 800x400px)</p>
                </div>
                <input id="receipt" type="file" wire:model="receipt" class="hidden" />
            </label>
        </div>
        @error('receipt')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @if($error)
        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ $error }}</span>
        </div>
        @endif
        <button type="submit" class="mt-4 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Extract Data
        </button>
    </form>

    @if($loading)
    <div class="mt-4 text-center">
        <svg class="animate-spin h-10 w-10 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="mt-2 text-blue-600 font-semibold">Extracting data...</p>
    </div>
    @endif

    @if($extractedData)
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Extracted Data:</h2>
        @if(isset($extractedData['error']))
        <p class="text-red-600">{{ $extractedData['error'] }}</p>
        @else
        <dl class="grid grid-cols-2 gap-4">
            <div class="col-span-2 sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Date</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $extractedData['date'] ?? 'Not available' }}</dd>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $extractedData['total_amount'] ?? 'Not available' }}</dd>
            </div>
            <div class="col-span-2">
                <dt class="text-sm font-medium text-gray-500">Merchant Name</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $extractedData['merchant_name'] ?? 'Not available' }}</dd>
            </div>
            <div class="col-span-2">
                <dt class="text-sm font-medium text-gray-500">Items</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    @if(isset($extractedData['items']) && is_array($extractedData['items']))
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($extractedData['items'] as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['name'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['price'] ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    Not available
                    @endif
                </dd>
            </div>
        </dl>
        @endif
    </div>
    @endif
</div>